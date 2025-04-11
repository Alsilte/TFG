CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,           -- Correo electrónico único para inicio de sesión
    password VARCHAR(255) NOT NULL,               -- Contraseña encriptada
    tipo_usuario ENUM('administrador', 'club', 'jugador', 'arbitro') NOT NULL, -- Rol del usuario
    email_verificado BOOLEAN DEFAULT FALSE,       -- Estado de verificación de correo
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Fecha de creación del registro
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Última actualización
);

-- Tabla de Perfiles: Información personal extendida de los usuarios
CREATE TABLE perfiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNIQUE NOT NULL,               -- Referencia al usuario
    nombre VARCHAR(100) NOT NULL,                 -- Nombre personal
    apellidos VARCHAR(100) NOT NULL,              -- Apellidos 
    foto_perfil VARCHAR(255),                     -- Ruta de la foto de perfil
    telefono VARCHAR(20),                         -- Número de teléfono
    fecha_nacimiento DATE,                        -- Fecha de nacimiento
    direccion TEXT,                               -- Dirección completa
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE  -- Eliminar perfil si se elimina el usuario
);

-- Tabla de Administradores: Gestores del sistema con diferentes niveles de acceso
CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNIQUE NOT NULL,               -- Referencia al usuario
    nivel_acceso ENUM('super_admin', 'admin') NOT NULL,  -- Nivel de privilegios
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de Torneos: Información de cada competición deportiva
CREATE TABLE torneos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,                 -- Nombre del torneo
    descripcion TEXT,                             -- Descripción detallada
    administrador_id INT NOT NULL,                -- Administrador responsable
    fecha_inicio DATE NOT NULL,                   -- Fecha de inicio del torneo
    fecha_fin DATE NOT NULL,                      -- Fecha de finalización
    formato ENUM('liga', 'copa', 'grupos') NOT NULL,  -- Tipo de formato de competición
    estado ENUM('programado', 'en_curso', 'finalizado') NOT NULL,  -- Estado actual del torneo
    reglas JSON,                                  -- Reglas específicas en formato JSON
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (administrador_id) REFERENCES administradores(id)
);

-- Tabla de Equipos: Información de los equipos participantes
CREATE TABLE equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,                 -- Nombre del equipo
    logo VARCHAR(255),                            -- Ruta del logo del equipo
    club VARCHAR(255),                            -- Club al que pertenece
    fecha_fundacion DATE,                         -- Fecha de fundación del equipo
    torneo_id INT NOT NULL,                       -- Torneo en el que participa
    FOREIGN KEY (torneo_id) REFERENCES torneos(id) ON DELETE CASCADE
);

-- Tabla de Jugadores: Información de los jugadores individuales
CREATE TABLE jugadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNIQUE NOT NULL,               -- Referencia al usuario
    equipo_id INT NOT NULL,                       -- Equipo al que pertenece
    numero_camiseta VARCHAR(10),                  -- Número de camiseta
    posicion VARCHAR(50),                         -- Posición en el campo
    fecha_ingreso DATE,                           -- Fecha de ingreso al equipo
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (equipo_id) REFERENCES equipos(id) ON DELETE CASCADE
);

-- Tabla de Árbitros: Información de los árbitros que dirigen los partidos
CREATE TABLE arbitros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNIQUE NOT NULL,               -- Referencia al usuario
    licencia VARCHAR(50) UNIQUE NOT NULL,         -- Número de licencia de árbitro
    especialidad VARCHAR(100),                    -- Especialidad o deporte
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de Partidos: Registro de cada encuentro deportivo
CREATE TABLE partidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    torneo_id INT NOT NULL,                       -- Torneo al que pertenece
    equipo_local_id INT NOT NULL,                 -- Equipo local
    equipo_visitante_ID INT NOT NULL,             -- Equipo visitante
    arbitro_id INT NOT NULL,                      -- Árbitro que dirige
    fecha DATETIME NOT NULL,                      -- Fecha y hora del partido
    estado ENUM('programado', 'en_curso', 'finalizado') NOT NULL,  -- Estado del partido
    resultado_local INT DEFAULT 0,                -- Goles del equipo local
    resultado_visitante INT DEFAULT 0,            -- Goles del equipo visitante
    FOREIGN KEY (torneo_id) REFERENCES torneos(id) ON DELETE CASCADE,
    FOREIGN KEY (equipo_local_id) REFERENCES equipos(id),
    FOREIGN KEY (equipo_visitante_id) REFERENCES equipos(id),
    FOREIGN KEY (arbitro_id) REFERENCES arbitros(id)
);

-- Tabla de Eventos: Sucesos durante un partido (goles, tarjetas, etc.)
CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    partido_id INT NOT NULL,                      -- Partido al que pertenece
    jugador_id INT NOT NULL,                      -- Jugador que genera el evento
    tipo ENUM('gol', 'tarjeta_amarilla', 'tarjeta_roja', 'sustitucion', 'tiempo_extra') NOT NULL,  -- Tipo de evento
    minuto INT NOT NULL,                          -- Minuto en que ocurre
    descripcion TEXT,                             -- Descripción adicional
    FOREIGN KEY (partido_id) REFERENCES partidos(id) ON DELETE CASCADE,
    FOREIGN KEY (jugador_id) REFERENCES jugadores(id) ON DELETE CASCADE
);

-- Tabla de Clasificaciones: Estado de los equipos en un torneo
CREATE TABLE clasificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    torneo_id INT NOT NULL,                       -- Torneo correspondiente
    equipo_id INT NOT NULL,                       -- Equipo
    puntos INT DEFAULT 0,                         -- Puntos acumulados
    partidos_jugados INT DEFAULT 0,               -- Total de partidos jugados
    partidos_ganados INT DEFAULT 0,               -- Partidos ganados
    partidos_empatados INT DEFAULT 0,             -- Partidos empatados
    partidos_perdidos INT DEFAULT 0,              -- Partidos perdidos
    goles_favor INT DEFAULT 0,                    -- Goles a favor
    goles_contra INT DEFAULT 0,                   -- Goles en contra
    UNIQUE KEY (torneo_id, equipo_id),            -- Clave única por torneo y equipo
    FOREIGN KEY (torneo_id) REFERENCES torneos(id) ON DELETE CASCADE,
    FOREIGN KEY (equipo_id) REFERENCES equipos(id) ON DELETE CASCADE
);

-- Tabla de Invitaciones: Sistema de invitaciones para jugadores y equipos
CREATE TABLE invitaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,                  -- Correo electrónico del invitado
    tipo_invitacion ENUM('jugador', 'equipo') NOT NULL,  -- Tipo de invitación
    torneo_id INT,                                -- Torneo relacionado (opcional)
    equipo_id INT,                                -- Equipo relacionado (opcional)
    token VARCHAR(255) UNIQUE NOT NULL,           -- Token único de invitación
    estado ENUM('pendiente', 'aceptada', 'rechazada') DEFAULT 'pendiente',  -- Estado de la invitación
    fecha_expiracion DATETIME NOT NULL,           -- Fecha de expiración del token
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (torneo_id) REFERENCES torneos(id) ON DELETE SET NULL,
    FOREIGN KEY (equipo_id) REFERENCES equipos(id) ON DELETE SET NULL
);

-- Índices para optimización de rendimiento
-- Mejoran la velocidad de búsqueda en tablas frecuentemente consultadas
CREATE INDEX idx_usuario_email ON usuarios(email);
CREATE INDEX idx_torneo_fechas ON torneos(fecha_inicio, fecha_fin);
CREATE INDEX idx_partido_fechas ON partidos(fecha);
CREATE INDEX idx_evento_partido ON eventos(partido_id);
CREATE INDEX idx_clasificacion_torneo ON clasificaciones(torneo_id);