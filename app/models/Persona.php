<?php
class Persona {
    protected $id;
    protected $nombre;
    protected $correo;

    public function __construct($nombre, $correo) {
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    // Métodos Getters y Setters (Encapsulamiento)
    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getCorreo() { return $this->correo; }
    public function setCorreo($correo) { $this->correo = $correo; }

    // Método que será sobrescrito (Polimorfismo)
    public function obtenerDatos() {
        return "Persona: {$this->nombre}, Correo: {$this->correo}";
    }
}
?>