<?php

$host = 'localhost';
$dbname = 'prueba_web';
$username = 'root';
$password = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $sql = "DELETE FROM usuarios WHERE id = :id";
        $statement = $conexion->prepare($sql);
        $statement->execute([':id' => $id]);
    }

    header('Location: index.php?msg=eliminado');
    exit();

} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>
