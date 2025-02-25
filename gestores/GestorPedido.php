<?php

include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../config/utilidades.php';
include_once __DIR__ . '/../entidades/Pedido.php';
include_once __DIR__ . '/../gestores/GestorUsuarioProducto.php';
include_once __DIR__ . '/../gestores/GestorLineaPedido.php';

class GestorPedido
{
    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }
    public function crearPedido(Pedido $pedido)
    {
        $sql = "INSERT INTO pedidos (fecha, total, estado, idUsuario, nombre, apellido1, apellido2, email, direccion, localidad, provincia, telefono, metodoPago) VALUES (:fecha, :total, :estado, :idUsuario, :nombre, :apellido1, :apellido2, :email, :direccion, :localidad, :provincia, :telefono, :metodoPago)";
        try {
            $statement = $this->rellenarDatosPedido($sql, $pedido);
            $statement->execute();
            return $this->pdo->lastInsertId(); // Devuelve el ID del pedido recién creado
        }catch (PDOException $e) {
            echo "Error al insertar el pedido: " . $e->getMessage();
            exit();
        }
    }

    public function getPedido($id)
    {
        //Preparo la consulta sql:
        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        try {
            $statement->execute();
            $pedido_bd = $statement->fetch(PDO::FETCH_ASSOC);

            return new Pedido($pedido_bd['id'], new DateTime($pedido_bd['fecha']), $pedido_bd['total'], $pedido_bd['estado'], $pedido_bd['idUsuario'], $pedido_bd['nombre'], $pedido_bd['apellido1'], $pedido_bd['apellido2'], $pedido_bd['email'], $pedido_bd['direccion'], $pedido_bd['localidad'], $pedido_bd['provincia'], $pedido_bd['telefono'], $pedido_bd['metodoPago']);

        } catch (PDOException $e) {
            echo "Error al obtener el pedido: " . $e->getMessage();
            exit();
        }
    }

    public function listarPedidos(?string $filtroEstado, ?string $filtroFecha, ?string $filtroIdPedido, int $inicio = 0, int $limite = 10)
    {
        $filtroEstadoQuery = ($filtroEstado != null) ? "AND estado = :estado" : "";
        $filtroFechaQuery = ($filtroFecha != null) ? "AND DATE(fecha) = :fecha" : "";
        $filtroIdPedidoQuery = ($filtroIdPedido != null) ? "AND id LIKE :id" : "";

        // Ponemos 1=1 para que no de error si no hay ningún filtro
        $sqlPedidos = "SELECT * FROM pedidos  WHERE 1=1 $filtroEstadoQuery $filtroFechaQuery $filtroIdPedidoQuery order by fecha desc LIMIT :offset, :limit";
        $sqlTotalPedidos = "SELECT * FROM pedidos  WHERE 1=1 $filtroEstadoQuery $filtroFechaQuery $filtroIdPedidoQuery";



        $statementPedidos = $this->pdo->prepare($sqlPedidos);
        $statementTotalPedidos = $this->pdo->prepare($sqlTotalPedidos);
        try {

            if ($filtroEstado != null) {
                $statementPedidos->bindValue(':estado', $filtroEstado);
                $statementTotalPedidos->bindValue(':estado', $filtroEstado);
            }

            if ($filtroFecha != null) {
                $statementPedidos->bindValue(':fecha', $filtroFecha);
                $statementTotalPedidos->bindValue(':fecha', $filtroFecha);
            }

            if ($filtroIdPedido != null) {
                $statementPedidos->bindValue(':id', "%$filtroIdPedido%");
                $statementTotalPedidos->bindValue(':id', "%$filtroIdPedido%");
            }

            //Paginación
            $statementPedidos->bindValue(':offset', $inicio, PDO::PARAM_INT);
            $statementPedidos->bindValue(':limit', $limite, PDO::PARAM_INT);

            $statementPedidos->execute();
            $statementTotalPedidos->execute();

            $pedidos_bd = $statementPedidos->fetchAll(PDO::FETCH_ASSOC);
            $totalPedidos_bd = count($statementTotalPedidos->fetchAll(PDO::FETCH_ASSOC));
            $pedidos = [];
            foreach ($pedidos_bd as $pedido_bd) {
                $pedido = new Pedido($pedido_bd['id'], new DateTime($pedido_bd['fecha']), $pedido_bd['total'], $pedido_bd['estado'], $pedido_bd['idUsuario'], $pedido_bd['nombre'], $pedido_bd['apellido1'], $pedido_bd['apellido2'], $pedido_bd['email'], $pedido_bd['direccion'], $pedido_bd['localidad'], $pedido_bd['provincia'], $pedido_bd['telefono'], $pedido_bd['metodoPago']);
                $pedidos[] = $pedido;
            }
            return ["pedidos" => $pedidos, "totalPedidos" => $totalPedidos_bd];
        } catch (Exception $e) {
            echo "Error al listar los pedidos: " . $e->getMessage();
            exit();
        }
    }

    public function cambiarEstadoPedido(int $id, string $estado)
    {
        $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':estado', $estado);
        $statement->bindValue(':id', $id);
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error al cambiar el estado del pedido: " . $e->getMessage();
            exit();
        }

        if($estado == "aprobado") {
            $gestorUsuarioProducto = new GestorUsuarioProducto();
            $gestorLineaPedido = new GestorLineaPedido();
            $pedido = $this->getPedido($id);
            $lineasPedido = $gestorLineaPedido->getLineasDePedido($id);

            foreach ($lineasPedido as $lineaPedido) {
                $gestorUsuarioProducto->nuevoUsuarioProducto($pedido->getIdUsuario(), $lineaPedido->getIdProducto());
            }
        }

        if($estado == "reembolsado") {
            $gestorUsuarioProducto = new GestorUsuarioProducto();
            $gestorLineaPedido = new GestorLineaPedido();
            $pedido = $this->getPedido($id);
            $lineasPedido = $gestorLineaPedido->getLineasDePedido($id);

            foreach ($lineasPedido as $lineaPedido) {
                $gestorUsuarioProducto->borrarUsuarioProducto($pedido->getIdUsuario(), $lineaPedido->getIdProducto());
            }
        }
    }

    public function cambiarMetodoPagoPedido(int $id, string $metodoPago)
    {
        $sql = "UPDATE pedidos SET metodoPago = :metodoPago WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':metodoPago', $metodoPago);
        $statement->bindValue(':id', $id);
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error al cambiar el método de pago del pedido: " . $e->getMessage();
            exit();
        }
    }

    public function listarPedidosUsuario(int $idUsuario)
    {
        $sql = "SELECT * FROM pedidos WHERE idUsuario = :idUsuario";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':idUsuario', $idUsuario);
        try {
            $statement->execute();
            $pedidos_bd = $statement->fetchAll(PDO::FETCH_ASSOC);
            $pedidos = [];
            foreach ($pedidos_bd as $pedido_bd) {
                $pedido = new Pedido($pedido_bd['id'], new DateTime($pedido_bd['fecha']), $pedido_bd['total'], $pedido_bd['estado'], $pedido_bd['idUsuario'], $pedido_bd['nombre'], $pedido_bd['apellido1'], $pedido_bd['apellido2'], $pedido_bd['email'], $pedido_bd['direccion'], $pedido_bd['localidad'], $pedido_bd['provincia'], $pedido_bd['telefono'], $pedido_bd['metodoPago']);
                $pedidos[] = $pedido;
            }
            return $pedidos;
        } catch (Exception $e) {
            echo "Error al listar los pedidos del usuario: " . $e->getMessage();
            exit();
        }
    }


    public function rellenarDatosPedido($sql, Pedido $pedido)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':fecha', $pedido->getFecha() ->format('Y-m-d H:i:s'));
        $statement->bindValue(':total', $pedido->getTotal());
        $statement->bindValue(':estado', $pedido->getEstado());
        $statement->bindValue(':idUsuario', $pedido->getIdUsuario());
        $statement->bindValue(':nombre', $pedido->getNombre());
        $statement->bindValue(':apellido1', $pedido->getApellido1());
        $statement->bindValue(':apellido2', $pedido->getApellido2());
        $statement->bindValue(':email', $pedido->getEmail());
        $statement->bindValue(':direccion', $pedido->getDireccion());
        $statement->bindValue(':localidad', $pedido->getLocalidad());
        $statement->bindValue(':provincia', $pedido->getProvincia());
        $statement->bindValue(':telefono', $pedido->getTelefono());
        $statement->bindValue(':metodoPago', $pedido->getMetodoPago());
        return $statement;

    }
}

