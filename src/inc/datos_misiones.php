<?php
/**
 * =====================================================================
 *  inc/datos_misiones.php · Misiones del tablón (se entrega HECHO)
 * =====================================================================
 *  Fichero solo PHP que DEVUELVE un array con return. Se carga así:
 *
 *      $misiones = require __DIR__ . '/datos_misiones.php';
 *
 *  Cada misión es un array asociativo con:
 *    id (string) · titulo · zona · rango (E, D, C, B, A, S)
 *    recompensa (int, monedas de oro) · dias (int) · descripcion
 *
 *  (En la UD9 estas misiones pasarán a una tabla de MySQL.)
 */

declare(strict_types=1);

return [
    ['id' => 'M01', 'titulo' => 'Ratas en la bodega',          'zona' => 'Villa Roble',      'rango' => 'E', 'recompensa' => 40,   'dias' => 1, 'descripcion' => 'La taberna del Jabalí Tuerto pide ayuda: algo roe los barriles por la noche.'],
    ['id' => 'M02', 'titulo' => 'Escolta al mercader',         'zona' => 'Camino Real',      'rango' => 'D', 'recompensa' => 120,  'dias' => 3, 'descripcion' => 'Acompaña a un mercader de especias hasta la Puerta Norte sin perder la carga.'],
    ['id' => 'M03', 'titulo' => 'Hierbas de luna',             'zona' => 'Bosque Susurrante', 'rango' => 'E', 'recompensa' => 35,   'dias' => 1, 'descripcion' => 'La herbolaria necesita diez flores que solo se abren con luna llena.'],
    ['id' => 'M04', 'titulo' => 'El puente roto',              'zona' => 'Río Ceniza',       'rango' => 'C', 'recompensa' => 300,  'dias' => 4, 'descripcion' => 'Un troll cobra peaje en el único puente del río. Negocia… o no.'],
    ['id' => 'M05', 'titulo' => 'Bandidos del desfiladero',    'zona' => 'Paso del Cuervo',  'rango' => 'B', 'recompensa' => 650,  'dias' => 5, 'descripcion' => 'Una banda asalta las caravanas. Encuentra su guarida y recupera lo robado.'],
    ['id' => 'M06', 'titulo' => 'La biblioteca encantada',     'zona' => 'Torre de Arcilla', 'rango' => 'C', 'recompensa' => 280,  'dias' => 2, 'descripcion' => 'Los libros vuelan solos. Descubre qué hechizo los ha despertado.'],
    ['id' => 'M07', 'titulo' => 'Huevo de grifo',              'zona' => 'Picos Helados',    'rango' => 'A', 'recompensa' => 1200, 'dias' => 7, 'descripcion' => 'Recupera un huevo de grifo robado antes de que eclosione lejos de su nido.'],
    ['id' => 'M08', 'titulo' => 'El dragón de Obsidiana',      'zona' => 'Volcán Durmiente', 'rango' => 'S', 'recompensa' => 5000, 'dias' => 12, 'descripcion' => 'Solo para leyendas: el dragón ha despertado y exige tributo al reino.'],
    ['id' => 'M09', 'titulo' => 'Cartas perdidas',             'zona' => 'Villa Roble',      'rango' => 'E', 'recompensa' => 25,   'dias' => 1, 'descripcion' => 'El cartero ha perdido la saca. Recorre el pueblo y entrega las cartas.'],
    ['id' => 'M10', 'titulo' => 'Sombras en el cementerio',    'zona' => 'Colina Gris',      'rango' => 'B', 'recompensa' => 540,  'dias' => 3, 'descripcion' => 'Algo se mueve entre las lápidas. El sacerdote pide discreción absoluta.'],
];
