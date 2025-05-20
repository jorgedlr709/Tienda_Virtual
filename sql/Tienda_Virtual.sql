// Por si hay que comprobar la base de datos en phpmyadmin

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE
);
 

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    fecha_nacimiento DATE NOT NULL,
    genero ENUM('Masculino', 'Femenino', 'Otro') NOT NULL
);
 

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    imagen VARCHAR(255) 
);
 

CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    fecha_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES
('Camiseta Deportiva', 'Camiseta técnica transpirable para entrenamiento.', 19.99, 50, 'camiseta.png'),
('Pantalón de Compresión', 'Pantalón ajustado ideal para ejercicios de pierna.', 29.99, 30, 'pantalon.png'),
('Zapatillas Training Pro', 'Zapatillas de entrenamiento con suela antideslizante.', 59.99, 20, 'zapatillas.png'),
('Guantes de Gimnasio', 'Guantes acolchados para levantamiento de pesas.', 14.99, 100, 'guantes.png'),
('Shaker Botella 700ml', 'Mezclador de proteína con compartimentos.', 9.99, 80, 'shaker.png'),
('Proteína Whey 1kg', 'Suplemento proteico sabor chocolate.', 34.99, 40, 'proteina.png'),
('Creatina Monohidrato 300g', 'Creatina pura para mejorar el rendimiento.', 19.50, 60, 'creatina.png'),
('Banda Elástica de Resistencia', 'Banda de resistencia media para ejercicios de cuerpo completo.', 11.99, 70, 'banda.png'),
('Cinturón de Levantamiento', 'Cinturón de cuero para proteger la espalda.', 24.99, 25, 'cinturon.png'),
('Toalla Deportiva Microfibra', 'Toalla absorbente y ligera para entrenamientos.', 7.99, 90, 'toalla.png');