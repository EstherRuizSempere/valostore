<?php

class LineaPedido
{
    private int $id;
    private int $idPedido;
    private int $idProducto;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private string $imagen;

    public function __construct(int $id, int $idPedido, int $idProducto, string $nombre, string $descripcion, float $precio, string $imagen)
    {
        $this->id = $id;
        $this->idPedido = $idPedido;
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdPedido(): int
    {
        return $this->idPedido;
    }

    public function setIdPedido(int $idPedido): void
    {
        $this->idPedido = $idPedido;
    }

    public function getIdProducto(): int
    {
        return $this->idProducto;
    }

    public function setIdProducto(int $idProducto): void
    {
        $this->idProducto = $idProducto;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

public
function getDescripcion(): string
{
    return $this->descripcion;
}

public
function setDescripcion(string $descripcion): void
{
    $this->descripcion = $descripcion;
}

public
function getPrecio(): float
{
    return $this->precio;
}

public
function setPrecio(float $precio): void
{
    $this->precio = $precio;
}

public
function getImagen(): string
{
    return $this->imagen;
}

public
function setImagen(string $imagen): void
{
    $this->imagen = $imagen;
}


}