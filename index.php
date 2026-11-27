<?php

$host = 'localhost';
$dbname = 'prueba_web';
$username = 'root';
$password = '';

$mensaje = '';
$tipoMensaje = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = trim(htmlspecialchars($_POST['nombre']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

        if (!empty($nombre) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $check = $conexion->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
            $check->execute([':email' => $email]);

            if ($check->fetch()) {
                $mensaje = 'Este correo electrónico ya se encuentra registrado.';
                $tipoMensaje = 'error';
            } else {
                $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
                $statement = $conexion->prepare($sql);
                $statement->execute([
                    ':nombre' => $nombre,
                    ':email' => $email
                ]);

                header('Location: index.php?msg=agregado');
                exit();
            }
        } else {
            $mensaje = 'Por favor, ingresa un nombre y un correo electrónico válido.';
            $tipoMensaje = 'error';
        }
    }

    if (isset($_GET['msg'])) {
        if ($_GET['msg'] === 'agregado') {
            $mensaje = 'Usuario registrado correctamente.';
            $tipoMensaje = 'exito';
        } elseif ($_GET['msg'] === 'actualizado') {
            $mensaje = 'Datos del usuario actualizados con éxito.';
            $tipoMensaje = 'exito';
        } elseif ($_GET['msg'] === 'eliminado') {
            $mensaje = 'Usuario eliminado del sistema.';
            $tipoMensaje = 'exito';
        }
    }

    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina < 1) $pagina = 1;
    $postPorPagina = 5;
    $inicio = ($pagina > 1) ? ($pagina * $postPorPagina - $postPorPagina) : 0;

    $busqueda = isset($_GET['buscar']) ? trim(htmlspecialchars($_GET['buscar'])) : '';

    if (!empty($busqueda)) {
        $paramBusqueda = "%$busqueda%";
        $totalStmt = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE nombre LIKE :b OR email LIKE :b");
        $totalStmt->execute([':b' => $paramBusqueda]);
        $totalUsuarios = $totalStmt->fetchColumn();

        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE nombre LIKE :b OR email LIKE :b ORDER BY id DESC LIMIT $inicio, $postPorPagina");
        $stmt->execute([':b' => $paramBusqueda]);
    } else {
        $totalUsuarios = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $stmt = $conexion->query("SELECT * FROM usuarios ORDER BY id DESC LIMIT $inicio, $postPorPagina");
    }

    $usuarios = $stmt->fetchAll();
    $numeroPaginas = ceil($totalUsuarios / $postPorPagina);

} catch (PDOException $error) {
    $mensaje = "Error de conexión: " . $error->getMessage();
    $tipoMensaje = 'error';
    $usuarios = [];
    $totalUsuarios = 0;
    $numeroPaginas = 0;
}

require 'index.view.php';
?>
