<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../entidades/Producto.php';
include_once __DIR__ . '/../entidades/CarritoArticulo.php';
include_once __DIR__ . '/GestorProducto.php';

class GestorCarrito {

    public function __construct()
    {
        //Comprueba que la sesión esté iniciada, sino, la inicia
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }


        // inicializa la sesión si no está iniciada
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    // obtiene los productos del carrito
    public function getCarrito() {
        $carrito = $_SESSION['carrito'];
        $carritoArticulos = [];
        $gestorProducto = new GestorProducto();

        foreach ($carrito as $id) {
            $producto = $gestorProducto->getProducto($id);
            $carritoArticulos[$id] = new CarritoArticulo($id, $producto);
        }

        return $carritoArticulos;
    }

    // añade un producto al carrito
    public function anyadirProductoCarrito($id) {
        $carrito = $_SESSION['carrito'];

        if (!in_array($id, $carrito)) {
            $carrito[] = $id;
        } else {
            throw new Exception('El producto ya está en el carrito');
        }

        $_SESSION['carrito'] = $carrito;
    }

    // elimina un producto del carrito
    public function eliminarProducto($id) {
        $carrito = $_SESSION['carrito'];

        if (($key = array_search($id, $carrito)) !== false) {
            unset($carrito[$key]);
        }

        $_SESSION['carrito'] = $carrito;
    }

    // obtiene la cantidad de productos en el carrito
    public function getCantidadProductos() {
        return count($_SESSION['carrito']);
    }

    public function getTotal() {
        $total = 0;
        $carrito = $_SESSION['carrito'];
        $gestorProducto = new GestorProducto();

        foreach ($carrito as $id) {
            $producto = $gestorProducto->getProducto($id);
            $total += $producto->getPrecio();
        }

        return $total;
    }

    public function vaciarCarrito() {
        $_SESSION['carrito'] = [];
    }
}
