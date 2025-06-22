<?php

use App\Helpers\Functions;

?>
<section>
    <h2>Usuarios Conectados</h2>
    <!-- <table id="users-table" aria-label="Tabla de usuarios conectados">
        <thead>
            <tr>
                <th>Id</th>
                <th>Usuario</th>
                <th>Mac Address</th>
                <th>Dirección IP</th>
                <th>Tiempo Conectado</th>
                <th>Tiempo Restante</th>
                <th>Tráfico Subido (MB)</th>
                <th>Tráfico Bajado (MB)</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <-- Datos cargados por JS --
        </tbody>
    </table> -->
    <?php
    $params = [
        "Id"=>".id",
        "Usuario"=>"user",
        "Mac address"=>"mac-address",
        "Ip"=>"address",
        "Acceso"=>"login-by",
        "Conectado"=>"uptime",
        "Restante"=>"session-time-left",
        "Desconectado"=>"idle-time"
    ];
    Functions::_table(Functions::_getUsersActive(), $params, '/app/dashboard');
    ?>
</section>
<!-- <script>

    const apiURL = '/api/users/actives';

    function usersActives() {
        $.ajax({
            url: apiURL,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                const tbody = $('.tbody');
                tbody.empty();
                if (!data || data.length === 0) {
                    tbody.append('<tr><td colspan="7" style="text-align:center;">No hay usuarios disponibles</td></tr>');
                    return;
                }

                function formatear(bytes) {
                    /**
                     * B
                     */
                    let data = bytes
                    if (bytes > 1024) {
                        /**
                         * Kb
                         */
                        data = (bytes / 1024)
                        if (data > 1024) {
                            /**
                             * Mb
                             */
                            data = (data / 1024)
                            if (data > 1024) {
                                /**
                                 * Gb
                                 */
                                data = (data / 1024)
                                return data.toFixed(2) + " Gb"
                            } else {
                                return data.toFixed(2) + " Mb"
                            }
                        } else {
                            return data.toFixed(2) + " Kb"
                        }
                    } else {
                        return data.toFixed(2) + " B"

                    }
                }

                const unDig = (num)=>{
                    if(num < 10){
                        return "0"+num
                    }else{
                        return num
                    }
                }

                let cont = 1
                data.forEach(user => {
                    const fila = $(`
                    <tr>
                    <td>${unDig(cont)}</td>
                    <td>${user['user']}</td>
                    <td>${user['mac-address']}</td>
                    <td>${user['address']}</td>
                    <td>${user['uptime']}</td>
                    <td>${user['session-time-left']}</td>
                    <td>${formatear(user['bytes-in'])}</td>
                    <td>${formatear(user['bytes-out'])}</td>
                    </tr>
                    `);
                    cont++
                    tbody.append(fila);
                })

                // console.log(data[0]['bytes-in']);

            },
            error: function (xhr, status, error) {
                console.error('Error al consultar la API: ', error)
            }
        })
    }
    usersActives()

    // setInterval(usersActives, 5000);

</script> -->


