<?php

class cd {
    public $titulo;
    public $interprete;
    public $anio;

    public function mostrarDatos() {
        return $this->titulo . " - " . $this->interprete . " - " . $this->anio;
    }
}

?>