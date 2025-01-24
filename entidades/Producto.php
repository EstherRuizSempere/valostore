<?php
class Producto{
    private int $id;
    private string $codigo;
    private string $nombre;
    private string $descripcion;
    private int $categoria;
    private float $precio;
    private string $imagen;
    private int $activo;

    public function __construct(int $id, string $codigo, string $nombre, string $descripcion, int $categoria, float $precio, string $imagen, int $activo)
    {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->imagen = $imagen;
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

    public function getCodigo(): string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): void
    {
        $this->codigo = $codigo;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getCategoria(): int
    {
        return $this->categoria;
    }

    public function setCategoria(int $categoria): void
    {
        $this->categoria = $categoria;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
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