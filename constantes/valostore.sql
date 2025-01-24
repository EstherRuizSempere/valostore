CREATE TABLE producto (
    id INT(11) AUTO_INCREMENT PRIMARY KEY, 
    codigo VARCHAR(50) NOT NULL UNIQUE, 
    nombre VARCHAR(100) NOT NULL, 
    descripcion TEXT, 
    categoria INT NOT NULL, 
    precio FLOAT NOT NULL,
    imagen VARCHAR(255), 
    activo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (categoria) REFERENCES categoria(codigo)
);
