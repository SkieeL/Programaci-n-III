"use strict";
/// <reference path="node_modules/@types/jquery/index.d.ts" />
var Manejador = /** @class */ (function () {
    function Manejador() {
    }
    Manejador.AgregarUsuario = function () {
        var nombre = $("#nombre").val();
        var mail = $("#mail").val();
        var clave = $("#clave").val();
        var clave2 = $("#claveComparar").val();
        var foto = document.getElementById("foto");
        var apellido = $("#apellido").val();
        var perfil = $("#perfil").val();
        var legajo = $("#legajo").val();
        var form = new FormData();
        if (clave == clave2) {
            form.append("nombre", nombre);
            form.append("mail", mail);
            form.append("clave", clave);
            form.append("foto", foto.files[0]);
            form.append("perfil", perfil);
            form.append("apellido", apellido);
            form.append("legajo", legajo);
            $.ajax({
                type: 'POST',
                url: "../BACKEND/",
                dataType: "json",
                data: form,
                contentType: false,
                processData: false,
            })
                .done(function (objJson) {
                localStorage.setItem("mitoken", objJson);
                console.log(objJson);
                //location.href ="login.html";
            })
                .fail(function (aaa) {
                console.log(JSON.stringify(aaa));
            });
        }
    };
    Manejador.VerificarUsuario = function () {
        var mail = $("#mail").val();
        var clave = $("#clave").val();
        var form = new FormData();
        form.append("mail", mail);
        form.append("clave", clave);
        $.ajax({
            type: 'POST',
            url: "../BACKEND/mail/clave",
            dataType: "json",
            data: form,
            contentType: false,
            processData: false,
        })
            .done(function (objJson) {
            console.log(objJson);
            //location.href ="listado.html";
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.TraerTodos = function () {
        $.ajax({
            type: 'GET',
            url: "../BACKEND/",
            dataType: "json",
            contentType: false,
            processData: false,
        })
            .done(function (objJson) {
            console.log(objJson);
            //location.href ="listado.html";
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.AgregarProducto = function () {
        var form = new FormData();
        var nombre = $("#nombre").val();
        ;
        var precio = $("#precio").val();
        ;
        form.append("precio", precio);
        form.append("nombre", nombre);
        $.ajax({
            type: 'POST',
            url: "../BACKEND/productos",
            dataType: "json",
            data: form,
            contentType: false,
            processData: false,
        })
            .done(function (objJson) {
            console.log(objJson);
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.TraerProductos = function () {
        $.ajax({
            type: 'GET',
            url: "../BACKEND/productos",
            dataType: "json",
            contentType: false,
            processData: false,
        })
            .done(function (objJson) {
            console.log(objJson);
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.ModificarProducto = function () {
        var nombre = $("#nombre").val();
        ;
        var precio = $("#precio").val();
        ;
        var id = $("#id").val();
        ;
        $.ajax({
            type: 'PUT',
            url: "../BACKEND/productos",
            dataType: "json",
            contentType: false,
            processData: false,
            headers: { "id": id, "nombre": nombre, "precio": precio }
        })
            .done(function (objJson) {
            console.log(objJson);
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.EliminarProducto = function () {
        var id = $("#id").val();
        ;
        $.ajax({
            type: 'DELETE',
            url: "../BACKEND/productos",
            dataType: "json",
            contentType: false,
            processData: false,
            headers: { "id": id }
        })
            .done(function (objJson) {
            console.log(objJson);
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.prueba = function () {
        for (var i = 0; i < 150; i++) {
            console.log("aaaa");
        }
    };
    Manejador.AgregarJuego = function (derecha) {
        var form = new FormData();
        var titulo;
        var precio;
        var genero;
        var foto;
        var empresa;
        if (derecha) {
            var titulo_1 = $("#tituloD").val();
            var precio_1 = $("#precioD").val();
            var genero_1 = $("#generoD").val();
            var foto_1 = document.getElementById("fotoD");
            var empresa_1 = $("#empresaD").val();
            var path = "fotos/" + titulo_1 + ".jpg";
            var token = localStorage.getItem("mitoken");
            if (foto_1.files.length == 0) {
                alert("Error");
                return "";
            }
            form.append("foto", foto_1.files[0]);
            form.append("precio", precio_1);
            form.append("titulo", titulo_1);
            form.append("genero", genero_1);
            form.append("empresa", empresa_1);
            form.append("token", token);
            form.append("path", path);
            $.ajax({
                type: 'POST',
                url: "../BACKEND/videojuegos",
                dataType: "json",
                data: form,
                contentType: false,
                processData: false,
            })
                .done(function (objJson) {
                Manejador.MostrarLosJuego();
                console.log(objJson);
            })
                .fail(function (aaa) {
                console.log(JSON.stringify(aaa));
            });
        }
        else {
            var titulo_2 = $("#tituloA").val();
            var precio_2 = $("#precioA").val();
            var genero_2 = $("#generoA").val();
            var foto_2 = document.getElementById("fotoA");
            var empresa_2 = $("#empresaA").val();
            if (foto_2.files.length == 0) {
                alert("Error");
                return "";
            }
            var path = "fotos/" + titulo_2 + ".jpg";
            var token = localStorage.getItem("mitoken");
            form.append("foto", foto_2.files[0]);
            form.append("precio", precio_2);
            form.append("titulo", titulo_2);
            form.append("genero", genero_2);
            form.append("empresa", empresa_2);
            form.append("token", token);
            form.append("path", path);
            $.ajax({
                type: 'POST',
                url: "../BACKEND/videojuegos",
                dataType: "json",
                data: form,
                contentType: false,
                processData: false,
            })
                .done(function (objJson) {
                Manejador.MostrarLosJuego();
                console.log(objJson);
            })
                .fail(function (aaa) {
                console.log(JSON.stringify(aaa));
            });
        }
    };
    Manejador.ModificarJuego = function (i) {
        var titulo = $("#" + i + "titulo").val();
        var precio = $("#" + i + "precio").val();
        var genero = $("#" + i + "genero").val();
        var empresa = $("#" + i + "empresa").val();
        var token = localStorage.getItem("mitoken");
        var path = "fotos/" + titulo + ".jpg";
        var form = new FormData();
        var url = "../BACKEND/videojuegos/modificar";
        var tipo = "POST";
        form.append("precio", precio);
        form.append("titulo", titulo);
        form.append("genero", genero);
        form.append("empresa", empresa);
        form.append("token", token);
        form.append("path", path);
        $.ajax({
            type: tipo,
            url: url,
            dataType: "json",
            data: form,
            contentType: false,
            processData: false,
        })
            .done(function (objJson) {
            Manejador.MostrarLosJuego();
            console.log(objJson);
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.ModificarJuegoConFoto = function (i) {
        var titulo = $("#" + i + "titulo").val();
        var precio = $("#" + i + "precio").val();
        var genero = $("#" + i + "genero").val();
        var empresa = $("#" + i + "empresa").val();
        var token = localStorage.getItem("mitoken");
        var foto = document.getElementById("fotoD");
        var path = "fotos/" + titulo + ".jpg";
        var form = new FormData();
        var url = "../BACKEND/videojuegos/modificar";
        var tipo = "POST";
        if (foto.files.length == 0) {
            alert("Error");
            return "";
        }
        form.append("precio", precio);
        form.append("foto", foto.files[0]);
        form.append("titulo", titulo);
        form.append("genero", genero);
        form.append("empresa", empresa);
        form.append("token", token);
        form.append("path", path);
        $.ajax({
            type: tipo,
            url: url,
            dataType: "json",
            data: form,
            contentType: false,
            processData: false,
        })
            .done(function (objJson) {
            location.href = "listado.html";
            console.log(objJson);
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.BorrarJuego = function (i) {
        var titulo = $("#" + i + "titulo").val();
        var token = localStorage.getItem("mitoken");
        if (confirm("Desea borrar el juego " + titulo + "?")) {
            $.ajax({
                type: 'DELETE',
                url: "../BACKEND/videojuegos",
                dataType: "json",
                contentType: false,
                processData: false,
                headers: { "token": token, "path": "fotos/" + titulo + ".jpg", "titulo": titulo }
            })
                .done(function (objJson) {
                Manejador.MostrarLosJuego();
            })
                .fail(function (aaa) {
                console.log(JSON.stringify(aaa));
            });
        }
    };
    Manejador.MostrarLosJuego = function () {
        var token = localStorage.getItem("mitoken");
        $.ajax({
            type: 'PUT',
            url: "../BACKEND/videojuegos",
            dataType: "json",
            contentType: false,
            processData: false,
            headers: { "token": token }
        })
            .done(function (objJson) {
            $("#divLista").html("");
            var i = 0;
            var lista = '<table class="table"><thead><tr><th scope="col">Titulo</th><th scope="col">Empresa</th><th scope="col">Genero</th><th scope="col">Precio</th><th colspan="4" scope="col">Foto</th></tr></thead><tbody>';
            for (var i_1 = 0; i_1 < objJson.length; i_1++) {
                lista += '<tr><td><input id="' + i_1 + 'titulo"name="' + i_1 + 'titulo" type="text" class="form-control" value="' + objJson[i_1].titulo + '" readonly></td><td><input id="' + i_1 + 'empresa" type="text" class="form-control" name="' + i_1 + 'empresa" value="' + objJson[i_1].empresa + '"></td><td><input id="' + i_1 + 'genero" type="text" class="form-control" name="' + i_1 + 'genero" value="' + objJson[i_1].genero + '"></td><td><input type="number" min="0" max="300" step="0.01"class="form-control" name="' + i_1 + 'precio"id="' + i_1 + 'precio" value="' + objJson[i_1].precio + '"></td><td><img  src="../BACKEND/' + objJson[i_1].path + '"width="50px" height="50px" class="img-circle"></td><td><a class="btn btn-primary" role="button" onclick="Manejador.ModificarJuego(' + i_1 + ')" >Modificar</a></td><td><a href="modificar.html" class="btn btn-primary" role="button">Modificar Foto</a></td><td><a class="btn btn-danger" role="button" onclick="Manejador.BorrarJuego(' + i_1 + ')">Borrar</a></td></tr>';
            }
            $("#divLista").html(lista + '</tbody></table>');
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.MostrarJuego = function () {
        var token = localStorage.getItem("mitoken");
        var titulo = $("#titulo").val();
        $.ajax({
            type: 'PUT',
            url: "../BACKEND/videojuegos",
            dataType: "json",
            contentType: false,
            processData: false,
            headers: { "token": token, "titulo": titulo }
        })
            .done(function (objJson) {
            $("#0titulo").val(objJson[0].titulo);
            $("#0precio").val(objJson[0].precio);
            $("#0genero").val(objJson[0].genero);
            $("#0empresa").val(objJson[0].empresa);
            $("#divLista").html('<a class="btn btn-success" role="button" onclick="Manejador.ModificarJuegoConFoto(0)">Modificar</a>');
            //<a class="btn btn-success" role="button" onclick="Manejador.ModificarJuego(true)">Modificar</a> 
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.MostrarUsuario = function () {
        var mail = $("#mail").val();
        var clave = $("#clave").val();
        var token = localStorage.getItem("mitoken");
        var form = new FormData();
        form.append("mail", mail);
        form.append("clave", clave);
        form.append("token", token);
        $.ajax({
            type: 'POST',
            url: "../BACKEND/usuario",
            dataType: "json",
            data: form,
            contentType: false,
            processData: false,
        })
            .done(function (objJson) {
            //localStorage.setItem("mitoken",objJson);
            //location.href ="listado.php";
            console.log(objJson);
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    Manejador.BorrarUsuario = function () {
        var mail = $("#mail").val();
        var clave = $("#clave").val();
        var token = localStorage.getItem("mitoken");
        $.ajax({
            type: 'DELETE',
            url: "../BACKEND/usuario",
            dataType: "json",
            contentType: false,
            processData: false,
            headers: { "token": token, "mail": mail, "clave": clave }
        })
            .done(function (objJson) {
            console.log(objJson);
        })
            .fail(function (aaa) {
            console.log(JSON.stringify(aaa));
        });
    };
    return Manejador;
}());
//# sourceMappingURL=Manejador.js.map