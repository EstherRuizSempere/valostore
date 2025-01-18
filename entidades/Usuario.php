<?php
use DateTime as Date;
class Usuario{
    private int $id;
    private string $usuario;
    private string $email;
    private string $nombre;
    private string $apellido1;
    private string $apellido2;
    private string $direccion;
    private string $localidad;
    private string $provincia;
    private string $telefono;
    private string $contrasenya;
    private Date $fechaNacimiento;
    private string $rol;
    private int $activo;

    /**
     * @param int $id
     * @param string $usuario
     * @param string $email
     * @param string $nombre
     * @param string $apellido1
     * @param string $apellido2
     * @param string $direccion
     * @param string $localidad
     * @param string $provincia
     * @param string $telefono
     * @param string $contrasenya
     * @param DateTime $fechaNacimiento
     * @param string $rol
     * @param int $activo
     */
    public function __construct(int $id, string $usuario, string $email, string $nombre, string $apellido1, string $apellido2, string $direccion, string $localidad, string $provincia, string $telefono, string $contrasenya, DateTime $fechaNacimiento, string $rol, int $activo)
    {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->direccion = $direccion;
        $this->localidad = $localidad;
        $this->provincia = $provincia;
        $this->telefono = $telefono;
        $this->contrasenya = $contrasenya;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->rol = $rol;
        $this->activo = $activo;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsuario(): string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): void
    {
        $this->usuario = $usuario;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellido1(): string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): void
    {
        $this->apellido1 = $apellido1;
    }

    public function getApellido2(): string
    {
        return $this->apellido2;
    }

    public function setApellido2(string $apellido2): void
    {
        $this->apellido2 = $apellido2;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    public function getLocalidad(): string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): void
    {
        $this->localidad = $localidad;
    }

    public function getProvincia(): string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): void
    {
        $this->provincia = $provincia;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getContrasenya(): string
    {
        return $this->contrasenya;
    }

    public function setContrasenya(string $contrasenya): void
    {
        $this->contrasenya = $contrasenya;
    }

    public function getFechaNacimiento(): Date
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(Date $fecha_nacimiento): void
    {
        $this->fechaNacimiento = $fecha_nacimiento;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    public function getActivo(): int
    {
        return $this->activo;
    }

    public function setActivo(int $activo): void
    {
        $this->activo = $activo;
    }

}