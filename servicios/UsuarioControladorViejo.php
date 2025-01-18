<?php
require_once '../entidades/GestorUsuarios.php';
require_once '../entidades/UsuarioViejo.php';

class UsuarioControladorViejo
{
    private $gestorUsuarios;

    public function __construct()
    {
        $this->gestorUsuarios = new GestorUsuarios();
    }

    public function registrarUsuarioAdmin()
    {
        //Verifico si hay un usuario logueado y si es admin
        if (!isset($_SESSION['email']) || $_SESSION['rol'] != 'admin') {
            header("Location: ../../public/autentifiacion.php?error=NoTienesPermisos");
            exit();
        }


        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return;
        }

        if (!isset($_POST["dni"]) || empty($_POST["dni"]) || !isset($_POST["nombre"]) || empty($_POST["nombre"]) || !isset($_POST["apellido1"]) || empty($_POST["apellido1"]) || !isset($_POST["apellido2"]) || empty($_POST["apellido2"]) || !isset($_POST["direccion"]) || empty($_POST["direccion"]) || !isset($_POST["localidad"]) || empty($_POST["localidad"]) || !isset($_POST["provincia"]) || empty($_POST["provincia"]) || !isset($_POST["telefono"]) || empty($_POST["telefono"]) || !isset($_POST["email"]) || empty($_POST["email"]) || !isset($_POST["fechaNacimiento"]) || empty($_POST["fechaNacimiento"]) || !isset($_POST["contrasenya"]) || empty($_POST["contrasenya"]) || !isset($_POST["rol"]) || empty($_POST["rol"])) {
            header("Location: ../vista/usuario/admin-editor/crearUsuarioNormal.php?error=CamposVacios");
            exit();
        }

        $usuario = new Usuario($_POST["dni"], $_POST["nombre"], $_POST["apellido1"], $_POST["apellido2"], $_POST["direccion"], $_POST["localidad"], $_POST["provincia"], $_POST["telefono"], $_POST["email"], $_POST["fechaNacimiento"], $_POST["contrasenya"], $_POST["rol"]);

        try {
            Utilidades::comprobarDni($usuario->getDni());
            $this->gestorUsuarios->nuevoUsuario($usuario);
        } catch (Exception $e) {
            header("Location: ../vista/usuario/admin-editor/crearUsuarioNormal.php?error=" . $e->getMessage());
            exit();
        }


        header("Location: ../vista/usuario/admin-editor/zonaAdmin.php?mensaje=UsuarioCreado");
        exit();
    }

    public function registrarUsuarioNormal($usuario)
    {
        $conexion = new ConexionBD();
        $pdo = $conexion->conectar();

        //Si no es post, return
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return;
        }

        if (!isset($_POST["dni"]) || empty($_POST["dni"]) || !isset($_POST["nombre"]) || empty($_POST["nombre"]) || !isset($_POST["apellido1"]) || empty($_POST["apellido1"]) || !isset($_POST["apellido2"]) || empty($_POST["apellido2"]) || !isset($_POST["direccion"]) || empty($_POST["direccion"]) || !isset($_POST["localidad"]) || empty($_POST["localidad"]) || !isset($_POST["provincia"]) || empty($_POST["provincia"]) || !isset($_POST["telefono"]) || empty($_POST["telefono"]) || !isset($_POST["email"]) || empty($_POST["email"]) || !isset($_POST["fechaNacimiento"]) || empty($_POST["fechaNacimiento"]) || !isset($_POST["contrasenya"]) || empty($_POST["contrasenya"])) {
            header("Location: ../vista/usuario/registro.php?error=CamposVacios");
            exit();
        }

        $usuario = new Usuario($_POST["dni"], $_POST["nombre"], $_POST["apellido1"], $_POST["apellido2"], $_POST["direccion"], $_POST["localidad"], $_POST["provincia"], $_POST["telefono"], $_POST["email"], $_POST["fechaNacimiento"], $_POST["contrasenya"], "normal");

        try {
            Utilidades::comprobarDni($usuario->getDni());
            $this->gestorUsuarios->nuevoUsuario($usuario);
        } catch (Exception $e) {
            header("Location: ../vista/usuario/registro.php?error=" . $e->getMessage());
            exit();
        }

        //Si todo es correcto, debería crear la sesion:
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['rol'] = $usuario->getRol();

        header("Location: ../vista/usuario/normal/zonaUsuarioNormal.php?mensaje=UsuarioCreado");
        exit();
    }

    public function actualizarContrasenya()
    {
        //Comprobamos que los datos se han enviado y no están vacíos
        if (isset($_POST['email']) && isset($_POST['contrasenya'])) {
            $email = $_POST['email'];
            $contrasenya = $_POST['contrasenya'];


            //Comprobamos que la contraseña tiene al menos 4 caracteres
            if (!Utilidades::validarContrasenya($contrasenya)) {
                header("Location: ../vista/usuario/editarContrasenya.php?error=ContrasenyaNoValida");
                exit();
            }

            try {
                $this->gestorUsuarios->editarContrasenya($email, Utilidades::hashContrasenya($contrasenya));
                if ($_SESSION['rol'] == 'admin') {
                    header("Location: ../vista/usuario/admin-editor/zonaAdmin.php?mensaje=ContrasenyaActualizada");
                } else if ($_SESSION['rol'] == 'editor') {
                    header("Location: ../vista/usuario/admin-editor/zonaUsuarioEditor.php?mensaje=ContrasenyaActualizada");
                } else {
                    header("Location: ../vista/usuario/normal/zonaUsuarioNormal.php?mensaje=ContrasenyaActualizada");
                }
            } catch (Exception $e) {
                header("Location: ../vista/usuario/editarContrasenya.php?error=" . $e->getMessage());
                exit();
            }
        }
    }

    public function olvidarContrasenya()
    {
        try {
            //Compruebo que los datos se han enviado y no están vacíos
            if (isset($_POST['email'])) {
                $email = $_POST['email'];

                //Compruebo que el email es válido
                Utilidades::validarEmail($email);

                //Compruebo que el email existe en la base de datos
                $usuario = $this->listarUsuario($email);

                //Si el usuario existe, dejo cambiar la contrseña
                header("Location: ../vista/usuario/olvidarContrasenya.php?email=$email?ContrasenyaCambiada");
                exit();
            } else {
                header("Location: ../vista/usuario/olvidarContrasenya.php?error=EmailNoValido");
                exit();
            }
        } catch (Throwable $e) {
            header("Location: ../vista/usuario/olvidarContrasenya.php?error=" . $e->getMessage());
            exit();
        }
    }

    public function actualizarUsuario()
    {
        //Si no estás registrado, no puedes entrar
        if (!isset($_SESSION['email'])) {
            header("Location: ../../public/autentifiacion.php?error=NoTienesPermisos");
            exit();
        }
        //Si no es post, return
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return;
        }

        if (!isset($_POST["dni"]) || empty($_POST["dni"]) || !isset($_POST["nombre"]) || empty($_POST["nombre"]) || !isset($_POST["apellido1"]) || empty($_POST["apellido1"]) || !isset($_POST["apellido2"]) || empty($_POST["apellido2"]) || !isset($_POST["direccion"]) || empty($_POST["direccion"]) || !isset($_POST["localidad"]) || empty($_POST["localidad"]) || !isset($_POST["provincia"]) || empty($_POST["provincia"]) || !isset($_POST["telefono"]) || empty($_POST["telefono"]) || !isset($_POST["email"]) || empty($_POST["email"]) || !isset($_POST["fechaNacimiento"]) || empty($_POST["fechaNacimiento"]) || !isset($_POST["contrasenya"]) || empty($_POST["contrasenya"]) || !isset($_POST["rol"]) || empty($_POST["rol"])) {
            header("Location: ../vista/usuario/editarUsuario.php?error=CamposVacios");
            exit();
        }

        try {
            $usuario = new Usuario($_POST["dni"], $_POST["nombre"], $_POST["apellido1"], $_POST["apellido2"], $_POST["direccion"], $_POST["localidad"], $_POST["provincia"], $_POST["telefono"], $_POST["email"], $_POST["fechaNacimiento"], $_POST["contrasenya"], (isset($_POST['rol']) && !empty($_POST['rol']) ? $_POST['rol'] : 'normal'));
            $this->gestorUsuarios->editarUsuario($usuario);

            if ($_SESSION['rol'] == 'admin') {
                header("Location: ../vista/usuario/admin-editor/zonaAdmin.php?mensaje=UsuarioEditado");
            } else if ($_SESSION['rol'] == 'editor') {
                header("Location: ../vista/usuario/admin-editor/zonaUsuarioEditor.php?mensaje=UsuarioEditado");
            } else {
                header("Location: ../vista/usuario/normal/zonaUsuarioNormal.php?mensaje=UsuarioEditado");
            }
        } catch (Exception $error) {
            if ($_SESSION['rol'] == 'admin') {
                header("Location: ../vista/usuario/admin-editor/zonaAdmin.php?error=" . $error->getMessage());
            } else if ($_SESSION['rol'] == 'editor') {
                header("Location: ../vista/usuario/admin-editor/zonaUsuarioEditor.php?error=" . $error->getMessage());
            } else {
                header("Location: ../vista/usuario/normal/zonaUsuarioNormal.php?error=" . $error->getMessage());
            }
        }
    }


}