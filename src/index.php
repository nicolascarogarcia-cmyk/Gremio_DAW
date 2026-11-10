<?php
/** index.php · Puerta del gremio: al tablón si hay sesión; si no, al login. */
declare(strict_types=1);
require_once __DIR__ . '/inc/sesion.php';
iniciarSesion();
header('Location: ' . (aventureroActual() === null ? 'login.php' : 'tablon.php'));
exit;
