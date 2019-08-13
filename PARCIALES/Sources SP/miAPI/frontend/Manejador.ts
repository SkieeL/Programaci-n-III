/// <reference path="node_modules/@types/jquery/index.d.ts" />
class Manejador 
{

    public static AgregarUsuario() 
    {
        let nombre:any=$("#nombre").val();
        let mail:any=$("#mail").val();
        let clave:any=$("#clave").val();
        let clave2:any=$("#claveComparar").val();
        let foto : any = (<HTMLInputElement>document.getElementById("foto"));
        let apellido:any=$("#apellido").val();
        let perfil:any=$("#perfil").val();
        let legajo:any=$("#legajo").val();
        let form:FormData=new FormData();
        if(clave==clave2)
        {
            form.append("nombre",nombre);
            form.append("mail",mail);
            form.append("clave",clave);
            form.append("foto",foto.files[0]);
            form.append("perfil",perfil);
            form.append("apellido",apellido);
            form.append("legajo",legajo);
            $.ajax({
                type: 'POST',
                url: "../BACKEND/",
                dataType:"json",
                data:form,
                contentType: false,
                processData: false,
            })
            .done(function (objJson) {

                    localStorage.setItem("mitoken",objJson);
                    
                    console.log(objJson);
                    //location.href ="login.html";
                
            })
            .fail(function(aaa){
                console.log(JSON.stringify(aaa));
                
            }); 
        }
        

         
    }

    public static VerificarUsuario() 
    {
        let mail:any=$("#mail").val();
        let clave:any=$("#clave").val();
        let form:FormData=new FormData();
        form.append("mail",mail);
        form.append("clave",clave);

        $.ajax({
            type: 'POST',
            url: "../BACKEND/mail/clave",
            dataType:"json",
            data:form,
            contentType: false,
            processData: false,
        })
        .done(function (objJson) {
            console.log(objJson);
            //location.href ="listado.html";
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
        });  
    }
    public static TraerTodos() 
    {
        $.ajax({
            type: 'GET',
            url: "../BACKEND/",
            dataType:"json",
            contentType: false,
            processData: false,
        })
        .done(function (objJson) {
            console.log(objJson);
            //location.href ="listado.html";
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
        });  
    }


    public static AgregarProducto() 
    {
        let form:FormData=new FormData();
        let nombre:any=$("#nombre").val();;
        let precio:any=$("#precio").val();;
       
            
        form.append("precio",precio);
        form.append("nombre",nombre);

        $.ajax({
            type: 'POST',
            url: "../BACKEND/productos",
            dataType:"json",
            data:form,
            contentType: false,
            processData: false,
        })
        .done(function (objJson) {

            console.log(objJson);
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });  

 
        
    }

    public static TraerProductos() 
    {
        $.ajax({
            type: 'GET',
            url: "../BACKEND/productos",
            dataType:"json",
            contentType: false,
            processData: false,
        })
        .done(function (objJson) {

            console.log(objJson);
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });  
    }

    public static ModificarProducto() 
    {
        let nombre:any=$("#nombre").val();;
        let precio:any=$("#precio").val();;
        let id:any=$("#id").val();;
        $.ajax({
            type: 'PUT',
            url: "../BACKEND/productos",
            dataType:"json",
            contentType: false,
            processData: false,
            headers:{"id":id,"nombre":nombre,"precio":precio}
        })
        .done(function (objJson) {

            console.log(objJson);
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });    
    }

    public static EliminarProducto() 
    {
        let id:any=$("#id").val();;
        $.ajax({
            type: 'DELETE',
            url: "../BACKEND/productos",
            dataType:"json",
            contentType: false,
            processData: false,
            headers:{"id":id}
        })
        .done(function (objJson) {

            console.log(objJson);
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });    
    }


































    public static prueba()
    {
        for(let i=0;i<150;i++)
        {
            console.log("aaaa");            
        }
    }
    public static AgregarJuego(derecha:boolean) 
    {
        let form:FormData=new FormData();
        let titulo:any;
        let precio:any;
        let genero:any;
        let foto:any;
        let empresa:any;
        if(derecha)
        {
            let titulo:any=$("#tituloD").val();
            let precio:any=$("#precioD").val();
            let genero:any=$("#generoD").val();
            let foto : any = (<HTMLInputElement>document.getElementById("fotoD"));
            let empresa:any=$("#empresaD").val();
            let path:string="fotos/"+titulo+".jpg";
            let token:any=localStorage.getItem("mitoken");
            if(foto.files.length==0)
            {
                alert("Error");
                return "";
            }
            form.append("foto",foto.files[0]);
            form.append("precio",precio);
            form.append("titulo",titulo);
            form.append("genero",genero);
            form.append("empresa",empresa);
            form.append("token",token);
            form.append("path",path);

            $.ajax({
                type: 'POST',
                url: "../BACKEND/videojuegos",
                dataType:"json",
                data:form,
                contentType: false,
                processData: false,
            })
            .done(function (objJson) {

                Manejador.MostrarLosJuego();
                console.log(objJson);
            })
            .fail(function(aaa){
                console.log(JSON.stringify(aaa));
                
            });  



        }
        else
        {
            let titulo:any=$("#tituloA").val();
            let precio:any=$("#precioA").val();
            let genero:any=$("#generoA").val();
            let foto : any = (<HTMLInputElement>document.getElementById("fotoA"));
            let empresa:any=$("#empresaA").val();
            if(foto.files.length==0)
            {
                alert("Error");
                return "";
            }
            let path:string="fotos/"+titulo+".jpg";
            let token:any=localStorage.getItem("mitoken");
            form.append("foto",foto.files[0]);
            form.append("precio",precio);
            form.append("titulo",titulo);
            form.append("genero",genero);
            form.append("empresa",empresa);
            form.append("token",token);
            form.append("path",path);

            $.ajax({
                type: 'POST',
                url: "../BACKEND/videojuegos",
                dataType:"json",
                data:form,
                contentType: false,
                processData: false,
            })
            .done(function (objJson) {

                Manejador.MostrarLosJuego();
                console.log(objJson);
            })
            .fail(function(aaa){
                console.log(JSON.stringify(aaa));
                
            });
        }
        
        
        
        
    }

    

    public static ModificarJuego(i:number) 
    {
        let titulo:any=$("#"+i+"titulo").val();        
        let precio:any=$("#"+i+"precio").val();
        let genero:any=$("#"+i+"genero").val();
        let empresa:any=$("#"+i+"empresa").val();
        let token:any=localStorage.getItem("mitoken");
        let path:string="fotos/"+titulo+".jpg";
        let form:FormData=new FormData();
        let url:string="../BACKEND/videojuegos/modificar";
        let tipo:string="POST";
        

        

        form.append("precio",precio);
        form.append("titulo",titulo);
        form.append("genero",genero);
        form.append("empresa",empresa);
        form.append("token",token);
        form.append("path",path);


        $.ajax({
            type: tipo,
            url: url,
            dataType:"json",
            data:form,
            contentType: false,
            processData: false,
        })
        .done(function (objJson) {
            Manejador.MostrarLosJuego();
            console.log(objJson);
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });  
    }
    public static ModificarJuegoConFoto(i:number) 
    {
        let titulo:any=$("#"+i+"titulo").val();        
        let precio:any=$("#"+i+"precio").val();
        let genero:any=$("#"+i+"genero").val();
        let empresa:any=$("#"+i+"empresa").val();
        let token:any=localStorage.getItem("mitoken");
        let foto : any = (<HTMLInputElement>document.getElementById("fotoD"));
        let path:string="fotos/"+titulo+".jpg";
        let form:FormData=new FormData();
        let url:string="../BACKEND/videojuegos/modificar";
        let tipo:string="POST";
        if(foto.files.length==0)
            {
                alert("Error");
                return "";
            }

        

        form.append("precio",precio);
        form.append("foto",foto.files[0]);
        form.append("titulo",titulo);
        form.append("genero",genero);
        form.append("empresa",empresa);
        form.append("token",token);
        form.append("path",path);


        $.ajax({
            type: tipo,
            url: url,
            dataType:"json",
            data:form,
            contentType: false,
            processData: false,
        })
        .done(function (objJson) {
            location.href ="listado.html";
            console.log(objJson);
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });  
    }
    public static BorrarJuego(i:number) 
    {
        let titulo:any=$("#"+i+"titulo").val();       
        let token:any=localStorage.getItem("mitoken");
        if(confirm("Desea borrar el juego "+titulo+"?"))
        {
            $.ajax({
                type: 'DELETE',
                url: "../BACKEND/videojuegos",
                dataType:"json",
                contentType: false,
                processData: false,
                headers:{"token":token,"path":"fotos/"+titulo+".jpg","titulo":titulo}
            })
            .done(function (objJson) {
                Manejador.MostrarLosJuego();
            })
            .fail(function(aaa){
                console.log(JSON.stringify(aaa));
            });  
        }


        
    }

    public static MostrarLosJuego() 
    {
        let token:any=localStorage.getItem("mitoken");

        $.ajax({
            type: 'PUT',
            url: "../BACKEND/videojuegos",
            dataType:"json",
            contentType: false,
            processData: false,
            headers:{"token":token}
        })
        .done(function (objJson) {
            $("#divLista").html("");
            let i:number=0;
            let lista:string='<table class="table"><thead><tr><th scope="col">Titulo</th><th scope="col">Empresa</th><th scope="col">Genero</th><th scope="col">Precio</th><th colspan="4" scope="col">Foto</th></tr></thead><tbody>';
            for (let i = 0; i < objJson.length; i++) 
            {
                lista+='<tr><td><input id="'+i+'titulo"name="'+i+'titulo" type="text" class="form-control" value="'+objJson[i].titulo+'" readonly></td><td><input id="'+i+'empresa" type="text" class="form-control" name="'+i+'empresa" value="'+objJson[i].empresa+'"></td><td><input id="'+i+'genero" type="text" class="form-control" name="'+i+'genero" value="'+objJson[i].genero+'"></td><td><input type="number" min="0" max="300" step="0.01"class="form-control" name="'+i+'precio"id="'+i+'precio" value="'+objJson[i].precio+'"></td><td><img  src="../BACKEND/'+objJson[i].path+'"width="50px" height="50px" class="img-circle"></td><td><a class="btn btn-primary" role="button" onclick="Manejador.ModificarJuego('+i+')" >Modificar</a></td><td><a href="modificar.html" class="btn btn-primary" role="button">Modificar Foto</a></td><td><a class="btn btn-danger" role="button" onclick="Manejador.BorrarJuego('+i+')">Borrar</a></td></tr>';
            }
            $("#divLista").html(lista+'</tbody></table>');
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });  
    }

    public static MostrarJuego() 
    {
        let token:any=localStorage.getItem("mitoken");
        let titulo:any=$("#titulo").val();
        
        $.ajax({
            type: 'PUT',
            url: "../BACKEND/videojuegos",
            dataType:"json",
            contentType: false,
            processData: false,
            headers:{"token":token,"titulo":titulo}
        })
        .done(function (objJson) {
            $("#0titulo").val(objJson[0].titulo);
            $("#0precio").val(objJson[0].precio);
            $("#0genero").val(objJson[0].genero);
            $("#0empresa").val(objJson[0].empresa);
            $("#divLista").html('<a class="btn btn-success" role="button" onclick="Manejador.ModificarJuegoConFoto(0)">Modificar</a>');

            //<a class="btn btn-success" role="button" onclick="Manejador.ModificarJuego(true)">Modificar</a> 

        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });  
    }



















   

    public static MostrarUsuario() 
    {
        let mail:any=$("#mail").val();
        let clave:any=$("#clave").val();
        let token:any=localStorage.getItem("mitoken");
        
        let form:FormData=new FormData();
        form.append("mail",mail);
        form.append("clave",clave);
        form.append("token",token);

        $.ajax({
            type: 'POST',
            url: "../BACKEND/usuario",
            dataType:"json",
            data:form,
            contentType: false,
            processData: false,
        })
        .done(function (objJson) {

            //localStorage.setItem("mitoken",objJson);
            //location.href ="listado.php";
            console.log(objJson);
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
        });  
    }

    public static BorrarUsuario() 
    {
        let mail:any=$("#mail").val();
        let clave:any=$("#clave").val();
        let token:any=localStorage.getItem("mitoken");

        $.ajax({
            type: 'DELETE',
            url: "../BACKEND/usuario",
            dataType:"json",
            contentType: false,
            processData: false,
            headers:{"token":token,"mail":mail,"clave":clave}
        })
        .done(function (objJson) {

            console.log(objJson);
        })
        .fail(function(aaa){
            console.log(JSON.stringify(aaa));
            
        });  
    }
}