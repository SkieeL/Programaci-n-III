<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <title>Login</title>
    <style>
        body{
            background-color:#563d7c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 18rem;">
                <div class="card-body bg-secondary">
                    <h5 class="card-title">Login</h5>
                    <form class="form-horizontal" role="form" id='formulario'>
                        <div class="form-group">
                            <label for="ejemplo_email_3" class="control-label"><h6 class="card-subtitle mb-2 text-light">Mail</h6>
                            </label>
                            <input type="text" class="form-control" name="mail" id="mail" placeholder="Mail">
                        </div>
                        <div class="form-group">
                            <label for="ejemplo_password_3" class="control-label"></label><h6 class="card-subtitle mb-2 text-light">Contraseña</h6>
                            </label>
                            <input type="password" class="form-control" name="clave" id="clave" placeholder="Contraseña">
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-center row">
                                <a class="btn btn-success mr-2" onclick="Test.Manejadora.Logear()">Entrar</a>
                                <a class="btn btn-danger ml-2" onclick="Test.Manejadora.Limpiar()">Cancelar</a>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <a class="btn btn-warning mt-2" onclick="Test.Manejadora.">Registrarse</a>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>               
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="funciones.js"></script>
</body>

</html>  