<?php

use App\Controllers\ApiController;

$class = new ApiController;

$server = $class->forVoucher()['server'];
$plans = $class->forVoucher()['plan'];

?>

<section id="formulario-usuarios">
    <h2>Generar nuevos vouchers</h2>
    <form action="/app/voucher/create" method="post" id="usuario-form">
        <div class="form-group">
            <label for="formato">Formato del código</label>
            <select name="formato" id="formato" required>
                <option value="" selected disabled>Seleccione una opcion</option>
                <option value="numero">Número</option>
                <option value="letras">Letras</option>
                <option value="alfanumerico">Alfanumérico</option>
            </select>
        </div>
        <div class="form-group">
            <label for="server">Servidor</label>
            <select name="server" id="server" required>
                <option value="" selected disabled>Selecciona un hotspot</option>
                <?php
                foreach ($server as $serv) {
                    echo "<option value='" . $serv['name'] . "'>" . $serv['dns-name'] . "</option>";
                }
                ?>
                <option value="all">Todos</option>
            </select>
        </div>
        <div class="form-group">
            <label for="profile">Plan</label>
            <select name="profile" id="profile" required>
                <option value="" selected disabled>Selecciona un plan</option>
                <?php
                foreach ($plans as $plan) {
                    echo "<option value='" . $plan['name'] . "'>" . $plan['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <!-- <div class="form-group">
            <label for="pre-fix">Prefijo</label>
            <input type="checkbox" name="pre-fix" id="pre-fix">
            <input type="text" name="prefix" id="prefix" placeholder="xyz-(voucher)" style="display:none" value=""
                min="1" max="3">
        </div> -->
        <div class="form-group">
            <label for="longitud">Longitud de código</label>
            <input type="number" name="longitud" title="(min: 6 - max: 10)" min="6" max="10" value="6" id="longitud"
                required>
            <span>(6 - 10)</span>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" title="(1 - 500)" min="1" max="500" value="63" required>
            <span>(1 - 500)</span>
        </div>
        <input type="hidden" name="duracion" value="0" id="duracion">
        <div class="form-group">
            <label for="precio">Precio unitario</label>
            <input type="number" name="precio" id="precio" title="Precio unitario" value="1" required>
            <span>MXN</span>
        </div>
        <div class="form-group">
            <label for="host">Host</label>
            <select name="ssl" id="ssl" title="method">
                <option value="http" selected>http://</option>
                <option value="https">https://</option>
            </select>
            <input type="text" name="host" id="host" placeholder="my-host.net" readonly required>
            <span id="host-def"></span>
        </div>
        <button type="submit">Agregar Usuario</button>
    </form>
    <div class="mensaje" id="mensaje-form"></div>
</section>

<script>

    $(document).ready(() => {

        const datos = <?php echo json_encode([$server, $plans]) ?>

        const server = datos[0]
        const plan = datos[1]

        console.log(plan[1])

        const $server = $('#server'), $pre_fix = $('#pre-fix'), $prefix = $('#prefix'), $host = $('#host')
        const $host_def = $('#host-def').hide()
        const $profile = $('#profile'), $duracion = $('#duracion')
        const $cantidad = $('#cantidad')

        const getTimeout = () => {
            if ($server.is(':selected') !== "") {
                let valSelected = $('#profile :selected').val()
                plan.forEach(plans => {

                    if (plans['name'] === 'default') {
                        $duracion.val('0:0:0')
                    } else {
                        if (plans['name'] === valSelected) {
                            $duracion.val(plans['session-timeout'])
                        }
                        if (valSelected === "6H_pausado") {
                            $cantidad.val(24)
                        }else{
                            $cantidad.val(30)
                        }
                    }
                });
            } else {
                console.log('no esta selected');
            }
        }

        const getServer = () => {
            const valServer = $server.val()
            if (valServer === "all") {
                $host.removeAttr('readonly')
                $host.val('')
                $host.attr('placeholder', 'Ingresa el dns-name default')
                $host.show()
                $host_def.hide()
            } else {
                $host.val($('#server :selected').text())
                $host.hide()
                $host_def.text($('#server :selected').text())
                $host_def.show()
            }
        }



        function subfijo() {
            let check = document.getElementById('pre-fix')
            if ($pre_fix.is(':checked')) {
                $prefix.removeAttr('style')
                $prefix.attr('required', true)

            } else {
                $prefix.css('display', 'none')
                $prefix.removeAttr('required')

            }
        }
        
        $server.change(getServer)
        $profile.change(getTimeout)

        // $pre_fix.on('click', subfijo)
        $pre_fix.click(subfijo)
    })

</script>