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
        $id = (int)$_POST['id'];
        $nombre = trim(htmlspecialchars($_POST['nombre']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

        if (!empty($nombre) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $check = $conexion->prepare("SELECT id FROM usuarios WHERE email = :email AND id != :id LIMIT 1");
            $check->execute([
                ':email' => $email,
                ':id' => $id
            ]);

            if ($check->fetch()) {
                $mensaje = 'Ese correo electrónico ya está registrado por otro usuario.';
                $tipoMensaje = 'error';
            } else {
                $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
                $statement = $conexion->prepare($sql);
                $statement->execute([
                    ':nombre' => $nombre,
                    ':email' => $email,
                    ':id' => $id
                ]);

                header('Location: index.php?msg=actualizado');
                exit();
            }
        } else {
            $mensaje = 'Por favor, completa un nombre y un correo electrónico válido.';
            $tipoMensaje = 'error';
        }
    }

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $statement = $conexion->prepare($sql);
        $statement->execute([':id' => $id]);
        $usuario = $statement->fetch();

        if (!$usuario) {
            header('Location: index.php');
            exit();
        }
    } else {
        header('Location: index.php');
        exit();
    }

} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}

require 'editar.view.php';
?>
