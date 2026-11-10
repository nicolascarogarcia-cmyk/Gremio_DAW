<?php
/**
 * logout.php · Cierre de sesión · (dado completo)
 * PARTE 3 · CE 4.e.1: cierre de sesión completo.
 * Las cookies de preferencias (tema, usuario recordado) NO se borran:
 * son del navegador, no de la sesión.
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/sesion.php';

iniciarSesion();
cerrarSesion();
header('Location: login.php?motivo=salida');
exit;
