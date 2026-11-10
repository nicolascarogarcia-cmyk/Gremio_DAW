<?php
/**
 * inc/cabecera.php · Parte común de todas las páginas (se incluye con require).
 * Espera las variables $titulo (string) y $aventurero (array|null).
 * El tema visual sale de la cookie de preferencias.
 */
declare(strict_types=1);
$tema = temaActual();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> · Gremio de Aventureros</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="tema-<?= e($tema) ?>">
<header class="barra">
    <span class="marca">⚔️ Gremio de Aventureros</span>
    <?php if ($aventurero !== null): ?>
        <nav>
            <a href="tablon.php">Tablón</a>
            <a href="zurron.php">Mi zurrón (<?= count($_SESSION['zurron'] ?? []) ?>)</a>
            <a href="preferencias.php">Preferencias</a>
            <a href="logout.php">Salir</a>
        </nav>
        <span class="quien"><?= e($aventurero['nombre']) ?> · <?= e($aventurero['clase']) ?></span>
    <?php endif; ?>
</header>
<main>
