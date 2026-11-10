<?php
/**
 * =====================================================================
 *  tablon.php · Tablón de misiones · IMPLEMENTACIÓN COMPLETA
 * =====================================================================
 *  PARTE 1 (UD3): recorrer el array de misiones y pintar cada tarjeta.
 *  PARTE 2 (UD4): filtro por GET y aceptación por POST.
 *  PARTE 3 (UD5): página solo para miembros; contador de visitas en sesión.
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/funciones.php';
require_once __DIR__ . '/inc/sesion.php';

iniciarSesion();
$aventurero = requiereLogin();
$misiones   = require __DIR__ . '/inc/datos_misiones.php';
$_SESSION['zurron'] ??= [];

// PARTE 3: suma 1 a $_SESSION['visitas'] en cada carga del tablón.
$_SESSION['visitas'] = ($_SESSION['visitas'] ?? 0) + 1;

// ---- POST: aceptar una misión --------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    $mision = buscarMision($misiones, $id);

    if ($mision === null) {
        mensajeFlash('Esa misión no existe en el tablón.');
    } elseif (in_array($id, $_SESSION['zurron'], true)) {
        mensajeFlash('Ya has aceptado la misión "' . $mision['titulo'] . '".');
    } else {
        $_SESSION['zurron'][] = $id;
        mensajeFlash('Misión "' . $mision['titulo'] . '" añadida a tu zurrón.');
    }

    header('Location: tablon.php');
    exit;
}

// ---- GET: filtros ---------------------------------------------------------
$rango     = leerRangoFiltro($_GET);
$oroMinimo = leerOroMinimo($_GET);
$visibles  = filtrarMisiones($misiones, $rango, $oroMinimo);
$flash     = leerFlash();

$titulo = 'Tablón de misiones';
require __DIR__ . '/inc/cabecera.php';
?>
<h1>Tablón de misiones</h1>

<p class="nota">
    Hora de entrada: <?= e($_SESSION['entrada'] ?? date('H:i:s')) ?> | 
    Visitas a esta página: <?= (int)$_SESSION['visitas'] ?>
</p>

<?php if ($flash !== null): ?><p class="aviso"><?= e($flash) ?></p><?php endif; ?>

<form method="get" action="tablon.php" class="filtros">
    <label>Rango
        <select name="rango">
            <option value="">Todos</option>
            <?php foreach (RANGOS as $r): ?>
                <option value="<?= $r ?>" <?= $r === $rango ? 'selected' : '' ?>><?= $r ?> · <?= etiquetaRango($r) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Recompensa mínima
        <input type="number" name="oro" min="0" max="10000" step="10" value="<?= $oroMinimo ?>">
    </label>
    <button type="submit">Filtrar</button>
</form>

<p><?= count($visibles) ?> de <?= count($misiones) ?> misiones.</p>

<div class="misiones">
<?php if (empty($visibles)): ?>
    <p>Ninguna misión cumple el filtro.</p>
<?php else: ?>
    <?php foreach ($visibles as $m): ?>
        <?php 
            $clase = claseRango($m['rango']);
            $etiqueta = etiquetaRango($m['rango']);
            $diasTexto = $m['dias'] === 1 ? '1 día' : $m['dias'] . ' días';
            $enZurron = in_array($m['id'], $_SESSION['zurron'], true);
        ?>
        <article class="mision <?= e($clase) ?>">
            <span class="rango"><?= e($m['rango']) ?> · <?= e($etiqueta) ?></span>
            <h2><?= e($m['titulo']) ?></h2>
            <p class="nota"><?= e($m['zona']) ?> · <?= e($diasTexto) ?></p>
            <p><?= e($m['descripcion']) ?></p>
            <p class="oro"><?= e(formatearOro($m['recompensa'])) ?></p>
            
            <?php if ($enZurron): ?>
                <span class="aceptada">✔ En tu zurrón</span>
            <?php else: ?>
                <form method="post" action="tablon.php">
                    <input type="hidden" name="id" value="<?= e($m['id']) ?>">
                    <button type="submit">Aceptar misión</button>
                </form>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
</div>
<?php require __DIR__ . '/inc/pie.php'; ?>
