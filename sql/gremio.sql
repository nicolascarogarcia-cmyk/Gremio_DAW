-- =====================================================================
--  gremio.sql · Tabla de aventureros del Gremio (UD5 · reto integrador)
-- =====================================================================
--  Cómo importarlo (phpMyAdmin, http://localhost:8080):
--    1. Entra en phpMyAdmin y selecciona la base de datos de tu LAMP
--       (la de MYSQL_DATABASE en tu .env).
--    2. Pestaña «Importar» → elige este fichero → «Importar».
--  (La carpeta dump/ del LAMP solo se ejecuta la PRIMERA vez que se crea
--   el volumen de MySQL; si tu entorno ya estaba arrancado, impórtalo así.)
--
--  Contraseñas de prueba (NUNCA se guardan en claro: solo su hash bcrypt):
--    brunhilda / Martillo2026
--    aldric    / Arcano2026
--    vex       / Sombra2026
-- =====================================================================

DROP TABLE IF EXISTS aventureros;

CREATE TABLE aventureros (
    id            INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    usuario       VARCHAR(30)   NOT NULL,
    nombre        VARCHAR(80)   NOT NULL,
    clase         VARCHAR(30)   NOT NULL,
    password_hash VARCHAR(255)  NOT NULL,
    creado_en     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_aventureros_usuario (usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO aventureros (usuario, nombre, clase, password_hash) VALUES
('brunhilda', 'Brunhilda <Martillo de Hierro>', 'Guerrera',  '$2y$10$J/jtwgkymRdiLxtrxFkV9eXtvPNwOMjSWO5C5nvFXW.ZWwlvHxW66'),
('aldric',    'Aldric <el Arcano>',             'Hechicero', '$2y$10$T.bUxgnoGwW2WNlMo8c0he0B.WWOaZC0jCJgYSQCIbFE9paBF0tha'),
('vex',       'Vex <Sin Nombre>',               'Pícara',    '$2y$10$yDhAkvCSRNZzxLAc5Mri9OhRiyX/gVrZB7ZJOXtd1/OMIHemnTEXK');
