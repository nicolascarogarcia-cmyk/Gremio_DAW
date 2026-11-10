<?php
/**
 * =====================================================================
 *  inc/conexion.php · Conexión a MySQL con PDO (se entrega HECHO)
 * =====================================================================
 *  Los datos de conexión NO se escriben en el código: se leen de las
 *  variables de entorno que el docker-compose del LAMP pasa al contenedor
 *  www (MYSQL_HOST, MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD).
 *
 *  Uso:   $pdo = conectar();
 *
 *  PDO en Java era JDBC: new PDO(...) ≈ DriverManager.getConnection(...)
 *                        $pdo->prepare(...) ≈ connection.prepareStatement(...)
 *
 *  El acceso a datos completo (insertar, modificar, borrar, transacciones)
 *  se estudia en la UD9. Aquí solo necesitamos CONSULTAR un usuario.
 */

declare(strict_types=1);

function conectar(): PDO
{
    // static: la conexión se crea una sola vez por petición y se reutiliza
    // (recuerda la UD2: static vive lo que dura la petición, no más).
    static $pdo = null;

    if ($pdo === null) {
        $host     = getenv('MYSQL_HOST') ?: 'db';       // 'db' = nombre del servicio MySQL en el compose
        $baseDatos = getenv('MYSQL_DATABASE') ?: 'dbname';
        $usuario  = getenv('MYSQL_USER') ?: 'dbuser';
        $clave    = getenv('MYSQL_PASSWORD') ?: '';

        $dsn = "mysql:host={$host};dbname={$baseDatos};charset=utf8mb4";

        $pdo = new PDO($dsn, $usuario, $clave, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // los errores lanzan PDOException
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // filas como arrays asociativos
            PDO::ATTR_EMULATE_PREPARES   => false,                  // sentencias preparadas reales
        ]);
    }

    return $pdo;
}
