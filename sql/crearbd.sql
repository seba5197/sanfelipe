CREATE DATABASE IF NOT EXISTS websanfelipe;

-- Usar la base de datos creada
USE websanfelipe;

-- Crear el usuario 'sanfelipe' si no existe
CREATE USER IF NOT EXISTS 'sanfelipe'@'localhost' IDENTIFIED BY 'sQr.C43HGP]lw44K';

-- Otorgar todos los privilegios al usuario sobre la base de datos 'websanfelipe'
GRANT ALL PRIVILEGES ON websanfelipe.* TO 'sanfelipe'@'localhost' WITH GRANT OPTION;

-- Asegurarse de que los privilegios se apliquen
FLUSH PRIVILEGES;