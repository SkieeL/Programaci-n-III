namespace Test
{
    export class Manejadora
    {
        public static Limpiar():void
        {
            (<HTMLInputElement>document.getElementById('nombre')).value="";
            (<HTMLInputElement>document.getElementById('clave')).value="";
        }

        public static AltaRegistro():void
        {
            let nombre:string=(<HTMLInputElement>document.getElementById('nombre')).value;
            let apellido:string=(<HTMLInputElement>document.getElementById('apellido')).value;
            let clave:string=(<HTMLInputElement>document.getElementById('clave')).value;
            let mail:string=(<HTMLInputElement>document.getElementById('mail')).value;
            let perfil:string=(<HTMLSelectElement>document.getElementById('perfil')).value;
            let legajo:string=(<HTMLInputElement>document.getElementById('legajo')).value;
            let foto:any=(<HTMLInputElement>document.getElementById('foto'));

            console.log(nombre,clave,mail,perfil,legajo);
            var formData = new FormData();

            formData.append('nombre', nombre);
            formData.append('apellido', apellido);
            formData.append('clave', clave);
            formData.append('mail', mail);
            formData.append('perfil', perfil);
            formData.append('legajo', legajo);
            formData.append('foto', foto.files[0]);

            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", "../backend.1/empleados/alta", true);
            xmlhttp.setRequestHeader("enctype","multipart/form-data");
            xmlhttp.send(formData);

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText!="Registro Incompleto")
                    {
                        console.log(xmlhttp.responseText);
                        // localStorage.setItem('miToken',xmlhttp.responseText);
                        window.location.assign('./home.php');
                    }
                    else
                    {
                        alert('Faltan datos');
                    }
                }
            }
        }

        public static Logear():void
        {
            let mail:string=(<HTMLInputElement>document.getElementById('mail')).value;
            let clave:string=(<HTMLInputElement>document.getElementById('clave')).value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "../backend.1/login/email/clave/", true);
            xmlhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
            xmlhttp.send("mail="+mail+'&clave='+clave);
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText!="Error mail o clave incorrectos")
                    {
                        localStorage.setItem('miToken',xmlhttp.responseText);
                        window.location.assign('./listadoCd.php');
                    }
                    else
                    {
                        alert('Usuario o contraseña incorrectos');
                    }
                }
            }
        }

        public static Modificar(objJson:any):void
        {
            (<HTMLInputElement>document.getElementById('id')).value=objJson.id;
            (<HTMLInputElement>document.getElementById('formularioLabel')).innerText="Modificar";
            (<HTMLInputElement>document.getElementById('titulo')).value=objJson.titulo;
            (<HTMLInputElement>document.getElementById('interprete')).value=objJson.interprete;
            (<HTMLInputElement>document.getElementById('anio')).value=objJson.anio;
            (<HTMLInputElement>document.getElementById('id')).readOnly=true;
            (<HTMLInputElement>document.getElementById('titulo')).readOnly=false;
            (<HTMLInputElement>document.getElementById('interprete')).readOnly=false;
            (<HTMLInputElement>document.getElementById('anio')).readOnly=false;
            (<HTMLInputElement>document.getElementById('divId')).hidden=false;
            (<HTMLButtonElement>document.getElementById('boton-agregar')).hidden=true;
            (<HTMLButtonElement>document.getElementById('boton-modificar')).hidden=false;
            (<HTMLButtonElement>document.getElementById('boton-borrar')).hidden=true;
            console.log(objJson);
        }
        
        public static LimpiarForm():void
        {
            (<HTMLInputElement>document.getElementById('formularioLabel')).innerText="Agregar";
            (<HTMLInputElement>document.getElementById('id')).value="";
            (<HTMLInputElement>document.getElementById('titulo')).value="";
            (<HTMLInputElement>document.getElementById('interprete')).value="";
            (<HTMLInputElement>document.getElementById('anio')).value="";
            (<HTMLInputElement>document.getElementById('id')).readOnly=false;
            (<HTMLInputElement>document.getElementById('titulo')).readOnly=false;
            (<HTMLInputElement>document.getElementById('interprete')).readOnly=false;
            (<HTMLInputElement>document.getElementById('anio')).readOnly=false;
            (<HTMLButtonElement>document.getElementById('boton-agregar')).hidden=false;
            (<HTMLButtonElement>document.getElementById('boton-borrar')).hidden=true;
            (<HTMLButtonElement>document.getElementById('boton-modificar')).hidden=true;
            (<HTMLDivElement>document.getElementById('divId')).hidden=true;
        }

        public static Eliminar(objJson:any):void
        {
            (<HTMLInputElement>document.getElementById('formularioLabel')).innerText="Eliminar";
            (<HTMLInputElement>document.getElementById('id')).value=objJson.id;
            (<HTMLInputElement>document.getElementById('titulo')).value=objJson.titulo;
            (<HTMLInputElement>document.getElementById('interprete')).value=objJson.interprete;
            (<HTMLInputElement>document.getElementById('anio')).value=objJson.anio;
            (<HTMLInputElement>document.getElementById('id')).readOnly=true;
            (<HTMLInputElement>document.getElementById('titulo')).readOnly=true;
            (<HTMLInputElement>document.getElementById('interprete')).readOnly=true;
            (<HTMLInputElement>document.getElementById('anio')).readOnly=true;
            (<HTMLInputElement>document.getElementById('divId')).hidden=false;
            (<HTMLButtonElement>document.getElementById('boton-agregar')).hidden=true;
            (<HTMLButtonElement>document.getElementById('boton-borrar')).hidden=false;
            (<HTMLButtonElement>document.getElementById('boton-modificar')).hidden=true;
        }

        public static Deslogear():void
        {
            localStorage.removeItem("miToken");
            window.location.assign('./home.php');
        }

        public static AgregarObj():any
        {
            let titulo=(<HTMLInputElement>document.getElementById('titulo')).value;
            let interprete=(<HTMLInputElement>document.getElementById('interprete')).value;
            let anio=(<HTMLInputElement>document.getElementById('anio')).value;
            
            let miToken:any=JSON.parse(localStorage.getItem('miToken'));

            if(miToken===null)
            {
                alert("Usuario no logeado");
                window.location.href='./home.php';
                return;
            }

            var formData = new FormData();

            formData.append('titulo', titulo);
            formData.append('interprete', interprete);
            formData.append('anio', anio);

            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", "../backend.1/acciones/add", true);
            xmlhttp.setRequestHeader("enctype","multipart/form-data");
            xmlhttp.setRequestHeader("miToken",miToken.jwt);
            xmlhttp.send(formData);

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                {
                    console.log(xmlhttp.responseText);
                }
            }
            location.reload();

        }

        public static BorrarObj():any
        {
            let titulo=(<HTMLInputElement>document.getElementById('titulo')).value;
            let interprete=(<HTMLInputElement>document.getElementById('interprete')).value;
            let id = (<HTMLInputElement> document.getElementById("id")).value;

            let miToken:any=JSON.parse(localStorage.getItem('miToken'));

            if(miToken===null)
            {
                alert("Usuario no logeado");
                window.location.href='./home.php';
                return;
            }

            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("DELETE", "../backend.1/acciones/delete");
            xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
            xmlhttp.setRequestHeader("miToken",miToken.jwt);
            xmlhttp.send("id=" + id + "&titulo=" + titulo + "&interprete=" + interprete);
            
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                {
                    console.log(xmlhttp.responseText);
                    let respuesta:any=JSON.parse(xmlhttp.responseText);
                    if(respuesta.mensaje=="todoOk")
                    {
                        location.reload();
                    }
                }
            }
            
        }

        public static ModificarObj():any
        {
            let id=(<HTMLInputElement>document.getElementById('id')).value;
            let titulo=(<HTMLInputElement>document.getElementById('titulo')).value;
            let interprete=(<HTMLInputElement>document.getElementById('interprete')).value;
            let anio=(<HTMLInputElement>document.getElementById('anio')).value;
            
            let miToken:any=JSON.parse(localStorage.getItem('miToken'));

            if(miToken===null)
            {
                alert("Usuario no logeado");
                window.location.href='./home.php';
                return;
            }

            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("PUT", "../backend.1/acciones/modify", true);
            xmlhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
            xmlhttp.setRequestHeader("miToken",miToken.jwt);
            xmlhttp.send("id=" + id + "&titulo=" + titulo + "&interprete=" + interprete + "&anio=" + anio);

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                {
                    console.log(xmlhttp.responseText);
                    let respuesta:any=JSON.parse(xmlhttp.responseText);
                    if(respuesta.mensaje=="todoOk")
                    {
                        location.reload();
                    }
                }
            }
        }
    }
}