-- 1. SERVICIOS que ofrece la funeraria
CREATE TABLE IF NOT EXISTS servicios (
  id       INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre   TEXT NOT NULL,
  precio   REAL NOT NULL,
  cantidad INTEGER NOT NULL,
  foto    TEXT
);

-- 2. CLIENTES o familiares que solicitan los servicios
CREATE TABLE IF NOT EXISTS clientes (
  id       INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre   TEXT NOT NULL,
  correo   TEXT NOT NULL,
  telefono TEXT,
  foto   TEXT
);

-- 3. EMPLEADOS que trabajan en la funeraria
CREATE TABLE IF NOT EXISTS empleados (
  id       INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre   TEXT NOT NULL,
  cargo    TEXT NOT NULL,
  salario  REAL NOT NULL,
  foto   TEXT
);

-- 4. PROVEEDORES que suministran productos y servicios
CREATE TABLE IF NOT EXISTS proveedores (
  id       INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre   TEXT NOT NULL,
  contacto TEXT NOT NULL,
  ciudad   TEXT,
  foto  TEXT
);

-- 5. GASTOS de la funeraria
CREATE TABLE IF NOT EXISTS gastos (
  id       INTEGER PRIMARY KEY AUTOINCREMENT,
  concepto TEXT NOT NULL,
  monto    REAL NOT NULL,
  fecha    TEXT NOT NULL,
  foto  TEXT
);

-- ------------------------------------------------------------
-- Datos de ejemplo para que el sistema no arranque vacío
-- ------------------------------------------------------------

INSERT INTO servicios (nombre, precio, cantidad) VALUES
  ('Servicio funerario básico', 1800000, 5),
  ('Servicio funerario completo', 3500000, 3),
  ('Cremación', 1200000, 8);

INSERT INTO clientes (nombre, correo, telefono) VALUES
  ('María Rodríguez', 'maria.rodriguez@correo.com', '3001234567'),
  ('Carlos Martínez', 'carlos.martinez@correo.com', '3019876543');

INSERT INTO empleados (nombre, cargo, salario) VALUES
  ('Luis Gómez', 'Asesor funerario', 1800000),
  ('Ana Pérez', 'Administradora', 2200000);

INSERT INTO proveedores (nombre, contacto, ciudad) VALUES
  ('Funeraria Proveedores SAS', '3105551212', 'Bucaramanga'),
  ('Floristería Esperanza', '3106667878', 'Barrancabermeja');

INSERT INTO gastos (concepto, monto, fecha) VALUES
  ('Pago de energía', 280000, '2026-10-05'),
  ('Compra de arreglos florales', 350000, '2026-10-06');