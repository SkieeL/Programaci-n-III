function Saludar() {
    var nombre = $('#nombre').val();
    var perfil = $('#perfil').val();
    var div = $('#divID');

    $.ajax({
        type : "POST",
        url : "../credenciales",
        data : "nombre=" + nombre + "&perfil=" + perfil,
        dataType : "text",
        async : true
    }).done(function(param) {
        div.html(param);
    }).fail(function() {
        alert('Falló todo!');
    });
}