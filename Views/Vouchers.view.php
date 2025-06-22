<?php

use App\Helpers\Functions;


?>
<section id="lista-usuarios-section">
    <div class="header">
        <h2>Lista de Usuarios</h2>
        <div class="nav">
            <a href="/app/create/voucher">Generar voucher</a>
        </div>
    </div>
    <input type="search" name="filter" id="filter" placeholder="Buscar...">
    <?php
    Functions::_table(Functions::_getUsers(), ["Id"=>".id", "usuario" => "name", "Plan" => "profile", "Ocupado"=>"uptime", "Duracion"=>"limit-uptime", "Subida"=>"bytes-in","Descarga"=>"bytes-out", "Descativado"=>"disabled"], "/app/vouchers");
    ?>
    <!-- <pre>
        <?php
        echo json_encode(Functions::_getUsers());
        ?>
    </pre> -->
</section>
<!-- <script>


    const apiURL = '/api/users';

    // function usersActives() {
    // $.ajax({
    //     url: apiURL,
    //     method: 'GET',
    //     dataType: 'json',
    //     success: function (data) {
    //         const tbody = $('#list-users');
    //         tbody.empty();
    //         if (!data || data.length === 0) {
    //             tbody.append('<tr><td colspan="7" style="text-align:center;">No hay usuarios disponibles</td></tr>');
    //             return;
    //         }

    //         function formatear(bytes) {
    //             /**
    //              * B
    //              */
    //             let data = bytes
    //             if (bytes > 1024) {
    //                 /**
    //                  * Kb
    //                  */
    //                 data = (bytes / 1024)
    //                 if (data > 1024) {
    //                     /**
    //                      * Mb
    //                      */
    //                     data = (data / 1024)
    //                     if (data > 1024) {
    //                         /**
    //                          * Gb
    //                          */
    //                         data = (data / 1024)
    //                         return data.toFixed(2) + " Gb"
    //                     } else {
    //                         return data.toFixed(2) + " Mb"
    //                     }
    //                 } else {
    //                     return data.toFixed(2) + " Kb"
    //                 }
    //             } else {
    //                 return data.toFixed(2) + " B"

    //             }
    //         }

    //         const unDig = (num) => {
    //             if (num < 10) {
    //                 return "0" + num
    //             } else {
    //                 return num
    //             }
    //         }

    //         let cont = 1
    //         data.forEach(user => {
    //             const fila = $(`
    //             <tr>
    //             <td>${unDig(cont)}</td>
    //             <td>${user['name']}</td>
    //             <td>${user['profile']}</td>
    //             <td>${user['limit-uptime']}</td>
    //             <td>${user['uptime']}</td>
    //             <td>${user['disabled']}</td>
    //             </tr>
    //             `);
    //             cont++
    //             tbody.append(fila);
    //             // console.log(user)
    //         })

    //         // console.log(data[0]['bytes-in']);

    //     },
    //     error: function (xhr, status, error) {
    //         console.error('Error al consultar la API: ', error)
    //     }
    // })

    // $('#list-user').DataTable({
    $.ajax({
    url: apiURL,
    method: 'GET',
    success: function (data) {
        console.log(data); // Imprime la respuesta de la API
        $('#list-user').DataTable({
            data: data, // Usa la respuesta directamente
            columns: [
                { 
                    data: '.id', 
                    title: 'Id',
                    render: function(data, type, row) {
                        return data !== undefined ? data : 'N/A'; // Imprime 'N/A' si no existe
                    }
                },
                { 
                    data: 'name', 
                    title: 'Nombre' 
                },
                { 
                    data: 'uptime', 
                    title: 'Tiempo de actividad' 
                },
                { 
                    data: 'limit-uptime', 
                    title: 'Duración',
                    render: function(data, type, row) {
                        return data !== undefined ? data : 'N/A'; // Imprime 'N/A' si no existe
                    }
                },
                { 
                    data: 'disabled', 
                    title: 'Deshabilitado',
                    render: function(data, type, row) {
                        return data !== undefined ? data : 'No especificado'; // Imprime 'No especificado' si no existe
                    }
                }
            ]
        });
    },
    error: function (err) {
        console.error('Error al obtener los datos:', err);
    }
});


    // });
    // }
    // usersActives()

    // setInterval(usersActives, 5000);

</script> -->

<!-- <script>

$(document).ready(function(){
    
    // funcion para cargar datos
    function loadData(page, query = ''){
        $.ajax({
            url: '/api/users?page='+page+'&search='+query,
            type: 'GET',
            // data: { page: page, search: query },
            success: function(data){
                // const result = JSON.parse(data)
                const result = data
                $('#table').html(result.tabla)
                $('#paginador').html(result.pagination)
            }
        })
    }

    // function loadData (page, query=''){



    // }
    
    // Evento de busqueda
    $('#filter').on('keyup', function(){
        const query = $(this).val()
        loadData(1, query) // Carga la primera pagina con el filtro
    })
    
    // Delegar evento de paginacion
    $(document).on('click', '.page-link', function(){
        const page = $(this).data('page')
        const query = $('#filter').val()
        console.log(page)
        
        loadData(page, query)
    })
    loadData(1)
})

</script> -->


