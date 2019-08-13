window.onload=function():void
{
    var xmlhttp = new XMLHttpRequest();
    if((localStorage.getItem('miToken')===null))
    {
        alert("Usuario no logeado");
        window.location.href='./home.php';
        return;
    }

    let miToken:any=JSON.parse(localStorage.getItem('miToken'));
    if(miToken.jwt===null)
    {
        alert("Usuario no logeado");
        window.location.href='./home.php';
        return;
    }

    xmlhttp.open("GET", "../backend.1/lista", true);
    xmlhttp.setRequestHeader("miToken",miToken.jwt);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log(xmlhttp.responseText);
            let respuesta=JSON.parse(xmlhttp.responseText);
            console.log(respuesta);
            console.log(respuesta.mensaje);
            if(respuesta.mensaje==undefined)
            {
                let stringTabla:string="<table class='table'><th>ID</th><th>Nombre</th><th>Apellido</th><th>Mail</th><th>Foto</th><th>Legajo</th><th>Clave</th><th>Perfil</th>";
                respuesta.forEach((empleado:any) => {
                    //stringTabla+="<tr><td>"+cd.titel+"</td><td>"+cd.interpret+"</td><td>"+cd.jahr+"</td><td>"+cd.id+"</td><td><a class='btn btn-warning' data-toggle='modal' data-target='#formulario' onclick='Test.Manejadora.Modificar("+JSON.stringify(cd)+")'>Modificar</a></td><td><a class='btn btn-danger' data-toggle='modal' data-target='#formulario' onclick='Test.Manejadora.Eliminar("+JSON.stringify(cd)+")'>Eliminar</a></td></tr>";
                    stringTabla+="<tr><td>"+empleado.id+"</td><td>"+empleado.nombre+"</td><td>"+empleado.apellido+"</td><td>"+empleado.mail+"</td><td><img class='img-thumbnail' width='50px' src='../backend.1/"+empleado.foto+"' alt='"+empleado.foto+"'></td><td>"+empleado.legajo+"</td><td>"+empleado.clave+"</td><td>"+empleado.perfil+"</td></tr>";
                    console.log(empleado);
                });
                stringTabla+="</table>";
                (<HTMLDivElement>document.getElementById('laTabla')).innerHTML+=stringTabla;
            }
            else
            {
                window.location.href='./home.php';
            } 
        }
    }
};
    