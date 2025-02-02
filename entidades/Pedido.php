<?php

class Pedido
{
    private int $id;
    private DateTime $fecha;
    private float $total;

    private string $estado;
    private int $idUsuario;
    private string $nombre;
    private string $apellido1;
    private string $apellido2;
    private string $email;
    private string $direccion;
    private string $localidad;
    private string $provincia;
    private string $telefono;
    private string $metodoPago;


    public function __construct(int $id, DateTime $fecha, float $total, string $estado, int $idUsuario, string $nombre, string $apellido1, string $apellido2, string $email, string $direccion, string $localidad, string $provincia, string $telefono, string $metodoPago)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->estado = $estado;
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->localidad = $localidad;
        $this->provincia = $provincia;
        $this->telefono = $telefono;
        $this->metodoPago = $metodoPago;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
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

    public function getMetodoPago(): string
    {
        return $this->metodoPago;
    }

    public function setMetodoPago(string $metodoPago): void
    {
        $this->metodoPago = $metodoPago;
    }



}