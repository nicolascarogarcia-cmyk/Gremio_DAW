<?php
/**
 * =====================================================================
 *  zurron.php · Mi zurrón: misiones aceptadas · IMPLEMENTACIÓN COMPLETA
 * =====================================================================
 *  PARTE 2 (listar y total) · PARTE 3 (los datos viven en $_SESSION)
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/funciones.php';
require_once __DIR__ . '/inc/sesion.php';

iniciarSesion();
$aventurero = requiereLogin();
$misiones   = require __DIR__ . '/inc/datos_misiones.php';
$_SESSION['zurron'] ??= [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    $key = array_search($id, $_SESSION['zurron'], true);

    if ($key !== false) {
        unset($_SESSION['zurron'][$key]);
        $_SESSION['zurron'] = array_values($_SESSION['zurron']);
        $mision = buscarMision($misiones, $id);
        $nombreMision = $mision ? $mision['titulo'] : $id;
        mensajeFlash('Has abandonado la misión "' . $nombreMision . '".');
    }

    header('Location: zurron.php');
    exit;
}

$ids   = $_SESSION['zurron'];
$total = totalRecompensa($misiones, $ids);
$flash = leerFlash();

$titulo = 'Mi zurrón';
require __DIR__ . '/inc/cabecera.php';
?>
<h1>Mi zurrón</h1>
<?php if ($flash !== null): ?><p class="aviso"><?= e($flash) ?></p><?php endif; ?>

<?php if (empty($ids)): ?>
    <p>Tu zurrón está vacío. Visita el <a href="tablon.php">tablón de misiones</a> para aceptar encargos.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Misión</th>
                <th>Rango</th>
                <th>Recompensa</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ids as $id): ?>
                <?php $m = buscarMision($misiones, $id); ?>
                <?php if ($m !== null): ?>
                    <tr>
                        <td><?= e($m['titulo']) ?></td>
                        <td><?= e($m['rango']) ?> · <?= e(etiquetaRango($m['rango'])) ?></td>
                        <td><?= e(formatearOro($m['recompensa'])) ?></td>
                        <td>
                            <form method="post" action="zurron.php">
                                <input type="hidden" name="id" value="<?= e($m['id']) ?>">
                                <button type="submit">Abandonar</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Recompensa Total</th>
                <td colspan="2"><strong><?= e(formatearOro($total)) ?></strong></td>
            </tr>
        </tfoot>
    </table>
<?php endif; ?>

<p class="nota">El zurrón vive en la sesión: si sales del gremio, se vacía.</p>
<?php require __DIR__ . '/inc/pie.php'; ?>
