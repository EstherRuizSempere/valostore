<?php

class UsuarioProducto
{
    private int $idUsuario;
    private int $idProducto;

    public function __construct(int $idUsuario, int $idProducto)
    {
        $this->idUsuario = $idUsuario;
        $this->idProducto = $idProducto;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function getIdProducto(): int
    {
        return $this->idProducto;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function setIdProducto(int $idProducto): void
    {
        $this->idProducto = $idProducto;
    }
}