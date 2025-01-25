CREATE TABLE productos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100) NOT NULL, 
    descripcion TEXT, 
    categoria_id INT NOT NULL, 
    precio FLOAT NOT NULL,
    imagen VARCHAR(255), 
    activo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);
