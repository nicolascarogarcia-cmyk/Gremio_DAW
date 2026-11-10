<?php
/**
 * =====================================================================
 *  inc/funciones.php · Funciones del tablón · IMPLEMENTACIÓN COMPLETA
 * =====================================================================
 *  PARTE 1 (UD3): decisión con match, recorridos con foreach, arrays.
 *  PARTE 2 (UD4): funciones propias con tipos, parámetros y retorno.
 */

declare(strict_types=1);

/** Rangos válidos, de menor a mayor dificultad. (Dado) */
const RANGOS = ['E', 'D', 'C', 'B', 'A', 'S'];

/** Escapa texto para pintarlo en HTML. (Dado: úsalo SIEMPRE al pintar datos) */
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

/**
 * PARTE 1 · Nombre del rango.
 * E Novato · D Aprendiz · C Veterano · B Experto · A Élite · S Leyenda
 */
function etiquetaRango(string $rango): string
{
    return match ($rango) {
        'E' => 'Novato',
        'D' => 'Aprendiz',
        'C' => 'Veterano',
        'B' => 'Experto',
        'A' => 'Élite',
        'S' => 'Leyenda',
        default => 'Desconocido',
    };
}

/**
 * PARTE 1 · Clase CSS según dificultad.
 * E y D → 'facil' · C y B → 'media' · A y S → 'dificil'
 */
function claseRango(string $rango): string
{
    return match ($rango) {
        'E', 'D' => 'facil',
        'C', 'B' => 'media',
        'A', 'S' => 'dificil',
        default => '',
    };
}

/**
 * PARTE 1 · Formatea monedas de oro: 5000 → "5.000 mo".
 */
function formatearOro(int $oro): string
{
    return number_format($oro, 0, ',', '.') . ' mo';
}

/**
 * PARTE 2 · Filtra misiones por rango (null = todos) y recompensa mínima.
 */
function filtrarMisiones(array $misiones, ?string $rango, int $oroMinimo): array
{
    $resultado = [];
    foreach ($misiones as $mision) {
        if ($rango !== null && $mision['rango'] !== $rango) {
            continue;
        }
        if ($mision['recompensa'] < $oroMinimo) {
            continue;
        }
        $resultado[] = $mision;
    }
    return $resultado;
}

/**
 * PARTE 2 · Busca una misión por su id ('M05'). Devuelve null si no existe.
 */
function buscarMision(array $misiones, string $id): ?array
{
    foreach ($misiones as $mision) {
        if ($mision['id'] === $id) {
            return $mision;
        }
    }
    return null;
}

/**
 * PARTE 2 · Suma la recompensa de las misiones cuyos ids se indican.
 * Reutiliza buscarMision(). Un id inexistente no suma nada.
 */
function totalRecompensa(array $misiones, array $ids): int
{
    $total = 0;
    foreach ($ids as $id) {
        $mision = buscarMision($misiones, $id);
        if ($mision !== null) {
            $total += $mision['recompensa'];
        }
    }
    return $total;
}

/**
 * PARTE 2 · Lee el rango de $_GET['rango'] y lo valida.
 * Devuelve el rango en MAYÚSCULAS si está en RANGOS; si no viene o no es
 * válido, null. Nunca te fíes de la URL: el usuario puede escribir lo que quiera.
 */
function leerRangoFiltro(array $get): ?string
{
    if (!isset($get['rango']) || !is_string($get['rango'])) {
        return null;
    }
    $rango = strtoupper(trim($get['rango']));
    if (in_array($rango, RANGOS, true)) {
        return $rango;
    }
    return null;
}

/**
 * PARTE 2 · Lee $_GET['oro'] y lo valida como entero entre 0 y 10000.
 * Si no viene o no es válido, 0.
 */
function leerOroMinimo(array $get): int
{
    if (!isset($get['oro'])) {
        return 0;
    }
    $val = filter_var($get['oro'], FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => 0,
            'max_range' => 10000,
        ]
    ]);
    return ($val !== false) ? $val : 0;
}
