# Memoria · Gremio de Aventureros

**Código de alumno/a:** DAW2A-NCG

## 1. Mi aventurero
- Usuario que he añadido a la tabla: `nicolas`
- Comando o pasos que he usado para generar el hash:
  He ejecutado el siguiente comando PHP en CLI para generar el hash bcrypt de la contraseña `Cyber2026!`:
  ```bash
  docker compose exec www php -r "echo password_hash('Cyber2026!', PASSWORD_DEFAULT), PHP_EOL;"
  ```
  El hash resultante se guardó en la base de datos mediante la sentencia SQL incluida en `sql/mi_aventurero.sql`.

## 2. Parte 1 · match
¿Has puesto `default` en `etiquetaRango()`? ¿Qué pasa si llega el rango `'Z'`? ¿Por qué lo prefieres así?

Sí, he incluido un brazo `default => 'Desconocido'` en el bloque `match`. Si llega un rango no reconocido como `'Z'`, `match` no lanzará una excepción no controlada (`UnhandledMatchError`), sino que devolverá la cadena `'Desconocido'`. Es la opción preferida por robustez y programación defensiva: evita que la aplicación rompa en producción ante entradas imprevistas o manipulaciones de parámetros.

## 3. Parte 2 · Validación de la URL
Escribe a mano en la barra `tablon.php?rango=Z&oro=hola`. ¿Qué ocurre y qué línea de tu código lo evita?

Al escribir dicha URL, el tablón muestra todas las misiones correctamente sin lanzar ningún aviso ni error.
- El rango `'Z'` es capturado por `leerRangoFiltro($_GET)`; al no pertenecer al array `RANGOS`, la condición `in_array($rango, RANGOS, true)` falla y la función retorna `null` (lo que equivale a mostrar todos los rangos).
- El valor `'hola'` es validado por `leerOroMinimo($_GET)` mediante la función `filter_var($_GET['oro'], FILTER_VALIDATE_INT, ...)`. Al no ser un entero válido entre 0 y 10000, `filter_var` devuelve `false` y la función retorna `0`.

## 4. Parte 3 · Sesión frente a cookie
Explica con tus palabras qué guardas en `$_SESSION` y qué guardas en cookies, y por qué no al revés.

- **En `$_SESSION` (Servidor):** Guardamos los datos sensibles y del estado de la aplicación actual, como los datos del usuario autenticado (`$_SESSION['aventurero']`), el estado del zurrón (`$_SESSION['zurron']`), la hora de entrada y el contador de visitas. Se guarda en el servidor porque son datos que deben vaciarse al cerrar la sesión por seguridad y no deben ser modificados directamente por el usuario desde el navegador.
- **En Cookies (Cliente/Navegador):** Guardamos preferencias estéticas e identidades no sensibles persistentes a largo plazo, como la preferencia de tema (`gremio_tema`, dura 1 año) y el nombre de usuario para el autorellenado (`gremio_usuario`, dura 30 días). 
- **¿Por qué no al revés?** Si guardáramos el zurrón o el usuario autenticado en cookies, el usuario podría manipular el contenido de su zurrón o su identidad directamente en las DevTools sin pasar por la lógica de validación de la aplicación. Por contra, la sesión se destruye en el servidor al hacer logout, asegurando que nadie pueda acceder al zurrón tras cerrar sesión.

## 5. Parte 3 · Seguridad del login
- **¿Qué pasa si en el usuario escribes `' OR '1'='1`? ¿Por qué?**
  No ocurre nada malo: el sistema responde con "Usuario o contraseña incorrectos" y no permite el acceso. Esto se debe a que la consulta utiliza sentencias preparadas con marcadores de parámetros (`:usuario`). La cadena `' OR '1'='1` se trata literalmente como el valor del nombre de usuario a buscar en MySQL, evitando cualquier inyección SQL.

- **¿Para qué sirve `session_regenerate_id(true)`?**
  Sirve para prevenir ataques de fijación de sesión (Session Fixation). Al autenticarse con éxito, se genera un nuevo ID de sesión de PHP y el parámetro `true` elimina el archivo de sesión antiguo, evitando que un atacante que hubiera capturado el ID de sesión anónimo previo pueda suplantar al usuario tras el login.

- **¿Por qué el mensaje de error es el mismo si falla el usuario o la contraseña?**
  Por principio de seguridad de divulgación mínima de información (Enumeración de usuarios). Si mostráramos "El usuario no existe", un atacante podría deducir qué nombres de usuario están registrados en la plataforma para realizar posteriores ataques de fuerza bruta. Mostrar un mensaje genérico ("Usuario o contraseña incorrectos") protege la privacidad de los usuarios registrados.

## 6. Pruebas que he hecho
| Prueba | Resultado esperado | Resultado obtenido |
|---|---|---|
| Entrar en tablon.php sin login | Redirige a `login.php?motivo=privado` con aviso | OK · Redirigido correctamente |
| Login con contraseña mala | Muestra "Usuario o contraseña incorrectos." | OK · Mensaje de error mostrado |
| Aceptar la misma misión dos veces | Avisa de que ya está en el zurrón y no duplica | OK · Aviso mostrado, zurrón sin duplicados |
| Cerrar sesión y volver al zurrón | Redirige al login y el zurrón se vacía | OK · Sesión destruida |
| Cambiar el tema y cerrar sesión | El tema se mantiene (cookie) y el zurrón se vacía | OK · Tema persistido en cookie |

## 7. Dificultades y cómo las he resuelto
- **Gestión de redirecciones y Post/Redirect/Get (PRG):** Se aseguró de llamar a `header('Location: ...')` seguido de `exit` tras procesar los formularios POST para evitar el reenvío de datos con F5.
- **Validación estricta de cookies de tema:** Se implementó una verificación con `in_array($tema, TEMAS, true)` en `temaActual()` para forzar el tema `'claro'` si el valor de la cookie se modifica manualmente en el navegador con un valor no permitido.
