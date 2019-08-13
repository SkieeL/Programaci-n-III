<?php

interface IMiddleware {
    function VerificarUsuario($request, $response, $next);
}