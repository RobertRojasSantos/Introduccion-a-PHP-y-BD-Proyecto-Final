<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | IDAT</title>
    <link rel="stylesheet" href="style.css?v=3">
</head>
<body>
    <header class="topbar">
        <div class="topbar-contenido">
            <div class="marca">
                <span class="logo-icono">👥</span>
                <div>
                    <h1>Gestión de Usuarios</h1>
                    <p>Panel de Administración CRUD • PHP & MySQL</p>
                </div>
            </div>
            <div class="contador-badge">
                Total registrados: <strong><?php echo $totalUsuarios; ?></strong>
            </div>
        </div>
    </header>

    <main class="contenedor">
        <?php if (!empty($mensaje)): ?>
            <div class="alerta <?php echo $tipoMensaje; ?>" id="alerta-msg">
                <span><?php echo $mensaje; ?></span>
                <button type="button" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        <?php endif; ?>

        <div class="panel-grid">

            <section class="card">
                <div class="card-header">
                    <h2>Nuevo Usuario</h2>
                    <span class="subtexto">Completa los datos para registrar</span>
                </div>

                <form action="index.php" method="POST" class="formulario">
                    <div class="grupo-input">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Carlos Mendoza" required>
                    </div>

                    <div class="grupo-input">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" placeholder="Ej: carlos@gmail.com" required>
                    </div>

                    <button type="submit" name="submit" class="btn-primario">
                        + Agregar Usuario
                    </button>
                </form>
            </section>

            <section class="card">
                <div class="card-header-flex">
                    <div>
                        <h2>Lista de Usuarios</h2>
                        <span class="subtexto">Página <?php echo $pagina; ?> de <?php echo max(1, $numeroPaginas); ?></span>
                    </div>

                    <form action="index.php" method="GET" class="form-buscador">
                        <input type="text" name="buscar" class="input-buscador" placeholder="🔍 Filtrar por nombre o correo..." value="<?php echo $busqueda; ?>">
                        <button type="submit" class="btn-buscar">Buscar</button>
                        <?php if (!empty($busqueda)): ?>
                            <a href="index.php" class="btn-limpiar">Limpiar</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="tabla-responsive">
                    <table id="tabla-usuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Correo Electrónico</th>
                                <th class="texto-derecha">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($usuarios) > 0): ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><span class="id-pill">#<?php echo $usuario['id']; ?></span></td>
                                        <td>
                                            <div class="usuario-celda">
                                                <span class="avatar"><?php echo strtoupper(substr($usuario['nombre'], 0, 1)); ?></span>
                                                <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong>
                                            </div>
                                        </td>
                                        <td class="correo-texto"><?php echo htmlspecialchars($usuario['email']); ?></td>
                                        <td class="acciones">
                                            <a href="editar.php?id=<?php echo $usuario['id']; ?>" class="btn-editar">Editar</a>
                                            <a href="eliminar.php?id=<?php echo $usuario['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Seguro que deseas eliminar a <?php echo htmlspecialchars($usuario['nombre']); ?>?');">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="vacio">No se encontraron usuarios registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($numeroPaginas > 1): ?>
                    <nav class="paginacion">
                        <ul>
                            <?php if ($pagina > 1): ?>
                                <li><a href="?pagina=<?php echo $pagina - 1; ?>&buscar=<?php echo urlencode($busqueda); ?>">&laquo; Anterior</a></li>
                            <?php else: ?>
                                <li class="disabled"><span>&laquo; Anterior</span></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $numeroPaginas; $i++): ?>
                                <li class="<?php echo ($pagina == $i) ? 'active' : ''; ?>">
                                    <a href="?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($busqueda); ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($pagina < $numeroPaginas): ?>
                                <li><a href="?pagina=<?php echo $pagina + 1; ?>&buscar=<?php echo urlencode($busqueda); ?>">Siguiente &raquo;</a></li>
                            <?php else: ?>
                                <li class="disabled"><span>Siguiente &raquo;</span></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </section>
        </div>
    </main>
</body>
</html>
