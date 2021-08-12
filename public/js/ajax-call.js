
function deleteItem(id, action){

    if(action == 'Category'){
        msgConfirm = "¿Está seguro de eliminar ésta categoría?";
    }else{
        msgConfirm = "¿Está seguro de eliminar éste producto?";
    }

    var res = confirm (msgConfirm);

    if(res){

        var Ruta = Routing.generate('delete' + action);
        $.ajax({
            type: 'POST',
            url: Ruta,
            data: ({id: id}),
            async: true,
            dataType: "json",
            success: function (data) {
                window.location.reload();
            }
        });

    }

}

