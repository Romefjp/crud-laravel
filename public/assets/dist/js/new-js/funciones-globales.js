const alerta = (text='', tipo=1) => {
    switch (tipo) {
        case 1:
            toastr.success(text);
            break;
        case 2:
            toastr.error(text);
            break;
        case 3:
            
            break;
    
        default:
            toastr.success(text);
            break;
    }//end switch
};


// Validar imagen
/*
    Esta funcion recibe como parametro el objeto del imput file o archivo,
    el segundo parametro es el id del botón para fuardar,
    el tercer parametro el url relativo de la imagen base.
    el cuarto y quinto parametro es el alto y ancho de la imagen que se va a subir en el servidor.
 */
const validate_image = (obj, preview, btn, img_base, alto=500, ancho=500) => {
    let uploadFile = obj.files[0];
    let button = document.getElementById(btn);
    if(!(/\.(jpg|png|jpeg)$/i).test(uploadFile.name)) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El formato de este archivo no esta permitido'
        });
        button.disabled = true;
    }//end of ifz
    else{
        let img = new Image();
        img.onload = function() {
            if((this.width.toFixed(0) > alto || this.height.toFixed(0) > ancho) || ((uploadFile.size/1024/1024) > 1)) {
                Swal.fire({
                    title: "¡Aviso!",
                    text: 'El peso de la imagen debe ser menor a 1MB o la imagén excede el tamaño recomendado que es de '+ancho+"x"+alto,
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Aceptar",
                }).then((result) => {
                    if (result.value) {
                        button.disabled = true;
                        document.getElementById(preview).setAttribute('src', img_base);
                    }
                });
            }//end of if
            else {
                if (obj.files && obj.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#'+preview).attr('src', e.target.result);
                        $('#'+preview).hide();
                        $('#'+preview).fadeIn(650);
                    }
                    reader.readAsDataURL(obj.files[0]);
                }
                button.disabled = false;
            }//end of else
        };//end of funcrion
        img.src = URL.createObjectURL(uploadFile);
    }//end of else
};//end of validate_image

const resetear_formulario = (id) => {
    document.getElementById(id).reset();
};

const resetear_imagen = (id_input, url_img) => {
    document.getElementById(id_input).setAttribute('src',url_img);
};

const eliminar = (ruta = "", id=0, titulo='', mensaje='', dataTable) => {

    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: "No, cancelar",
      }).then((result) => {
        if (result.value) {
            $.ajax({
                url: ruta+id,
                method: 'GET',
                success: function (data) {                    
                    if (data === '1') {
                        alerta('Registro eliminado correctamente', 1)
                        dataTable.ajax.reload(null, false);
                    }//end of if
                    else if (data === '2') {
                        alerta('Ocurrió un error al eliminar el registro', 2);
                    }//end of else
                }
            });
        }
    });
}; //end eliminar