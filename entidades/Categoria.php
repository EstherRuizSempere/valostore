<?php
class Categoria{
    private int $id;
    private string $nombre;
    private int $activo;
    private ?int $idCategoriaPadre;


    public function __construct(int $id, string $nombre, int $activo, ?int $idCategoriaPadre) //Añado el ? para indicar que puede ser int o null
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->activo = $activo;
        $this->idCategoriaPadre = $idCategoriaPadre;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getActivo(): int
    {
        return $this->activo;
    }

    public function setActivo(int $activo): void
    {
        $this->activo = $activo;
    }

    public function getIdCategoriaPadre(): ?int
    {
        return $this->idCategoriaPadre;
    }

    public function setIdCategoriaPadre(?int $idCategoriaPadre): void
    {
        $this->idCategoriaPadre = $idCategoriaPadre;
    }



}