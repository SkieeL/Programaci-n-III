function Enviar() {
    var nombre = $('#nombre').val();
    var clave = $('#clave').val();
    var div = $('#divID');

    $.ajax({
        type : "POST",
        url : "../credenciales",
        data : "nombre=" + nombre + "&clave=" + clave,
        dataType : "text",
        async : true
    }).done(function(param) {
        div.html(param);
    }).fail(function() {
        alert('Falló todo!');
    });
}