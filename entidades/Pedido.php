<?php

class Pedido
{
    private int $id;
    private DateTime $fecha;
    private float $total;

    private string $estado;
    private int $idUsuario;


    public function __construct(int $id, DateTime $fecha, float $total, string $estado, int $idUsuario)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->estado = $estado;
        $this->idUsuario = $idUsuario;
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


}