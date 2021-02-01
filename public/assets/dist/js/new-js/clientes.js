$(function () {
    let clientesTable = $("#clientes").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        'ajax': { "url": "./api/clientes" },
        "columns": [
            {"data": "total"},
            {"data": "foto"},
            {"data": "nombre"},
            {"data": "fecha_nacimiento"},
            {"data": "genero"},
            {"data": "editar"},
            {"data": "eliminar"}
        ],
        "language": {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 to 0 of 0 registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });

    //Agregar
    document.getElementById('form-nuevo-cliente').addEventListener('submit', (event) => {
        event.preventDefault();
        event.stopImmediatePropagation();

        $.ajax({
            type: 'POST',
            url: './clientes/agregar',
            data: new FormData(document.getElementById('form-nuevo-cliente')),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                document.getElementById('btn-enviar').setAttribute('disabled','disabled');
            },//End beforeSend
            success: function(respuesta){
                if (respuesta === '1') {
                    resetear_formulario('form-nuevo-cliente');
                    resetear_imagen('vista_previa', './assets/dist/img/sinimagen.jpg');
                    $('#nuevo').modal('hide')
                    alerta('Cliente agregado correctamente', 1);
                    clientesTable.ajax.reload(null, false);
                }//end if
                else {
                    alerta('Ocurrió un error al registrar al cliente', 2);
                }//end else
                document.getElementById('btn-enviar').removeAttribute('disabled','disabled');
            }//End success
        });//End ajax
    });

    //Editar
    document.getElementById('form-editar-cliente').addEventListener('submit', (event) => {
        event.preventDefault();
        event.stopImmediatePropagation();

        $.ajax({
            type: 'POST',
            url: './clientes/editar',
            data: new FormData(document.getElementById('form-editar-cliente')),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                document.getElementById('btn-enviar2').setAttribute('disabled','disabled');
            },//End beforeSend
            success: function(respuesta){
                if (respuesta === '1') {
                    resetear_formulario('form-editar-cliente');
                    resetear_imagen('vista_previa2', './assets/dist/img/sinimagen.jpg');
                    $('#editar').modal('hide')
                    alerta('La información del cliente ha sido actualizada', 1);
                    clientesTable.ajax.reload(null, false);
                }//end if
                else {
                    alerta('Ocurrió un error al actualizar la información del cliente', 2);
                }//end else
                document.getElementById('btn-enviar2').removeAttribute('disabled','disabled');
            }//End success
        });//End ajax
    });

    $(document).on('click', '.eliminar', function() {
        eliminar("./clientes/eliminar/", $(this).attr('id'), '¿Estás seguro de eliminar a este cliente?', 'Esta acción es permanente', clientesTable);
    });
    
});

const cargar_datos_modal_cliente = (id) => {
    $.ajax({
        type: 'GET',
        url: './clientes/obtener_datos/'+id,
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            let res = JSON.parse(data);
            document.getElementById('id').value = res.id;
            document.getElementById('nombre').value = res.nombre;
            document.getElementById('ap').value = res.ap;
            document.getElementById('am').value = res.am;
            document.getElementById('fecha_nacimiento').value = res.fecha_nacimiento;
            document.getElementById('genero').value = res.genero;
            document.getElementById('vista_previa2').setAttribute('src', res.src_cliente);
            document.getElementById('imagen_anterior').value = res.imagen_anterior;
        }
    });
};