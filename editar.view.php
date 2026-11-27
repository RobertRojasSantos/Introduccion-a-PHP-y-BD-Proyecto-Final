<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario | IDAT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <div class="topbar-contenido">
            <div class="marca">
                <span class="logo-icono">✏️</span>
                <div>
                    <h1>Editar Usuario</h1>
                    <p>Modificando registro #<?php echo $usuario['id']; ?></p>
                </div>
            </div>
        </div>
    </header>

    <main class="contenedor contenedor-angosto">
        <?php if (!empty($mensaje)): ?>
            <div class="alerta <?php echo $tipoMensaje; ?>" id="alerta-msg">
                <span><?php echo $mensaje; ?></span>
                <button type="button" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        <?php endif; ?>

        <section class="card">
            <div class="card-header">
                <h2>Actualizar Información</h2>
                <span class="subtexto">Modifica los campos necesarios y guarda los cambios</span>
            </div>

            <form action="editar.php?id=<?php echo $usuario['id']; ?>" method="POST" class="formulario">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                <div class="grupo-input">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>

                <div class="grupo-input">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>

                <div class="botones-editar">
                    <button type="submit" class="btn-primario">Guardar Cambios</button>
                    <a href="index.php" class="btn-secundario">Cancelar</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
