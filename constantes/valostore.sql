CREATE TABLE usuarios (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `usuario` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `apellido1` VARCHAR(255) NOT NULL,
    `apellido2` VARCHAR(255) DEFAULT NULL,
    `direccion` VARCHAR(255) NOT NULL,
    `localidad` VARCHAR(255) NOT NULL,
    `provincia` VARCHAR(255) NOT NULL,
    `telefono` VARCHAR(9) NOT NULL,
    `contrasenya` VARCHAR(255) NOT NULL,
    `fechaNacimiento` DATE NOT NULL,
    `rol` ENUM('admin', 'usuario', 'editor') NOT NULL DEFAULT 'usuario',
    `activo` TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
);
