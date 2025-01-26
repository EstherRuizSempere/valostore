<?php
 class CarritoArticulo {

        private int $id;
        private Producto $producto;

    public function __construct(int $id, Producto $producto)
    {
        $this->id = $id;
        $this->producto = $producto;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProducto(): Producto
    {
        return $this->producto;
    }

    public function setProducto(Producto $producto): void
    {
        $this->producto = $producto;
    }

    public function getSubtotal(): float
    {
        return $this->producto->getPrecio();
    }
}
