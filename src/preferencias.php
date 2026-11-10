<?php
/**
 * =====================================================================
 *  preferencias.php · Tema guardado en una cookie · IMPLEMENTACIÓN COMPLETA
 * =====================================================================
 *  PARTE 3 · CE 4.c: almacenar (setcookie) y recuperar ($_COOKIE).
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/funciones.php';
require_once __DIR__ . '/inc/sesion.php';

iniciarSesion();
$aventurero = requiereLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $temaElegido = $_POST['tema'] ?? '';
    if (in_array($temaElegido, TEMAS, true)) {
        guardarTema($temaElegido);
        mensajeFlash('Preferencia de tema guardada.');
    } else {
        mensajeFlash('Tema no válido.');
    }
    header('Location: preferencias.php');
    exit;
}

$temaGuardado = temaActual();
$flash = leerFlash();

$titulo = 'Preferencias';
require __DIR__ . '/inc/cabecera.php';
?>
<section class="tarjeta estrecha">
    <h1>Preferencias</h1>
    <?php if ($flash !== null): ?><p class="aviso"><?= e($flash) ?></p><?php endif; ?>
    <form method="post" action="preferencias.php">
        <fieldset>
            <legend>Tema del tablón</legend>
            <?php foreach (TEMAS as $opcion): ?>
                <label class="casilla">
                    <input type="radio" name="tema" value="<?= $opcion ?>" <?= $opcion === $temaGuardado ? 'checked' : '' ?>>
                    <?= ucfirst($opcion) ?>
                </label>
            <?php endforeach; ?>
        </fieldset>
        <button type="submit">Guardar</button>
    </form>
    <p class="nota">Valor crudo de la cookie '<?= COOKIE_TEMA ?>': <code><?= e($_COOKIE[COOKIE_TEMA] ?? 'no establecida') ?></code></p>
</section>
<?php require __DIR__ . '/inc/pie.php'; ?>
