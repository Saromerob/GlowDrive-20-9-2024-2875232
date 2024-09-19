-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2024 a las 21:19:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `glowdrive`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autolavados`
--

CREATE TABLE `autolavados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `horario` varchar(150) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `dueno_id` int(11) NOT NULL,
  `localidad_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
  `aprobado` tinyint(1) DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autolavados`
--

INSERT INTO `autolavados` (`id`, `nombre`, `direccion`, `telefono`, `horario`, `descripcion`, `dueno_id`, `localidad_id`, `fecha_creacion`, `fecha_actualizacion`, `latitud`, `longitud`, `aprobado`, `foto`) VALUES
(4, 'SENA', 'Ave Cra 30 #17B-25 Sur, Antonio Nariño, Bogotá', 3252525625, '6 am - 10pm', 'el mejor en tuzona', 4, 4, '2024-09-17 16:30:03', '2024-09-17 17:13:38', 4.5962, -74.1109, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `autolavado_id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `tipo_vehiculo` varchar(50) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `estado` varchar(30) DEFAULT 'Pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `usuario_id`, `autolavado_id`, `servicio_id`, `fecha`, `hora`, `nombre`, `apellido`, `placa`, `telefono`, `tipo_vehiculo`, `comentarios`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 5, 4, 18, '2024-09-17', '13:09:00', 'cliente', 'sena', '333LLMm', '3232122124', '2', 'lavado porfavor', 'terminado', '2024-09-17 17:10:27', '2024-09-17 17:15:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidades`
--

CREATE TABLE `localidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `localidades`
--

INSERT INTO `localidades` (`id`, `nombre`) VALUES
(1, 'Usaquén'),
(2, 'Chapinero'),
(3, 'Santa Fe'),
(4, 'San Cristóbal'),
(5, 'Usme'),
(6, 'Tunjuelito'),
(7, 'Bosa'),
(8, 'Kennedy'),
(9, 'Fontibón'),
(10, 'Engativá'),
(11, 'Suba'),
(12, 'Barrios Unidos'),
(13, 'Teusaquillo'),
(14, 'Los Mártires'),
(15, 'Antonio Nariño'),
(16, 'Puente Aranda'),
(17, 'La Candelaria'),
(18, 'Rafael Uribe Uribe'),
(19, 'Ciudad Bolívar'),
(20, 'Sumapaz'),
(21, 'Bogotá');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `id` int(11) NOT NULL,
  `reserva_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recibos`
--

INSERT INTO `recibos` (`id`, `reserva_id`, `usuario_id`, `nombre_archivo`, `contenido`, `fecha`) VALUES
(1, 1, 5, 'Recibo_Reserva_1.txt', '\r\n            Recibo de Reserva\n\r\n            Cliente: cliente Sena\n\r\n            Autolavado: SENA\n\r\n            Fecha de la cita: 2024-09-17 13:09:00\n\r\n            Servicio: Lavado Completo\n\r\n            Descripción: Incluye lavado exterior, interior y limpieza de tapicería.\n\r\n            Precio: 30\n\r\n            Placa del vehículo: 333LLMm\n\r\n            Estado: completada\n\r\n        ', '2024-09-17 17:15:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `autolavado_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo_vehiculo_id` int(11) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `estado` varchar(30) DEFAULT 'Pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `usuario_id`, `autolavado_id`, `fecha`, `tipo_vehiculo_id`, `placa`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 5, 4, '2024-09-17 00:00:00', 2, '333LLMm', 'completada', '2024-09-17 17:15:19', '2024-09-17 17:15:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `comentario` varchar(800) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `autolavado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`id`, `usuario_id`, `puntuacion`, `comentario`, `fecha_creacion`, `fecha_actualizacion`, `autolavado_id`) VALUES
(1, 5, 7, 'excelelnte servicio', '2024-09-17 05:00:00', '2024-09-17 17:28:32', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `estatus` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `estatus`, `created_at`) VALUES
(1, 'gerente', 1, '2024-08-09 01:33:27'),
(2, 'Cliente', 1, '2024-08-09 01:33:27'),
(3, 'Super_Admin', 1, '2024-08-09 01:33:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_requests`
--

CREATE TABLE `role_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `requested_role_id` int(11) NOT NULL,
  `status` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `role_requests`
--

INSERT INTO `role_requests` (`id`, `user_id`, `requested_role_id`, `status`, `request_date`) VALUES
(7, 4, 1, 'aprobado', '2024-09-17 16:27:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `autolavado_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `precio`, `autolavado_id`, `usuario_id`) VALUES
(18, 'Lavado Completo', 'Incluye lavado exterior, interior y limpieza de tapicería.', 30, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `tipo`) VALUES
(1, 'Cédula de Ciudadanía'),
(2, 'Cédula de Extranjería'),
(3, 'Pasaporte'),
(4, 'NIT'),
(5, 'Tarjeta de Identidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `id` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`id`, `tipo`) VALUES
(1, 'Automovil'),
(2, 'Camioneta'),
(3, 'Motocicleta'),
(4, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `num_documento` varchar(25) NOT NULL,
  `tipo_documento_id` int(11) NOT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `localidad_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `foto_perfil` varchar(225) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `num_documento`, `tipo_documento_id`, `telefono`, `correo`, `contrasena`, `fecha_nacimiento`, `fecha_creacion`, `fecha_actualizacion`, `localidad_id`, `role_id`, `estado`, `foto_perfil`) VALUES
(1, 'Administrador', 'Sena', '122233445', 1, 322211144, 'glowdrivesoporte@gmail.com', '$2y$10$Wc7e1zSqwhxRjsUEywclYuHChBQTgSEA1qifPNRbQ98n/EG8BMNOC', '2024-09-17', '2024-09-17 15:39:13', '2024-09-17 15:40:12', 9, 3, 1, 'default.png'),
(3, 'Gerente', 'sena', '21113311', 1, 2112130, 'gerente1@gmail.com', '$2y$10$n9KECE54RROHAyTuSHkeEeP/wUkwWNTN0H4TSLY8CnyiX6FT/VNZa', '2024-09-17', '2024-09-17 16:25:22', '2024-09-17 16:25:22', 14, 2, 1, 'default.png'),
(4, 'Gerentes', 'Sena', '12212321', 1, 3222222222, 'gerente2@gmail.com', '$2y$10$x36mvTiuJP3oGLUe0jQaI.cmVHsZDhRYx/f1tvHc6ttaO./EID1Fu', '2024-09-17', '2024-09-17 16:27:13', '2024-09-17 16:28:29', 12, 1, 1, 'default.png'),
(5, 'cliente', 'Sena', '121232121', 1, 3123232, 'cliente1@gmail.com', '$2y$10$If.oo2fFb9VHXjRSyieE5uWkujI3TVF7JJjGvnbkrVzf23vVyAbAC', '2024-09-17', '2024-09-17 17:08:55', '2024-09-17 17:08:55', 15, 2, 1, 'default.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autolavados`
--
ALTER TABLE `autolavados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dueño_id` (`dueno_id`),
  ADD KEY `localidad_id` (`localidad_id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `autolavado_id` (`autolavado_id`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserva_id` (`reserva_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `autolavado_id` (`autolavado_id`),
  ADD KEY `tipo_vehiculo_id` (`tipo_vehiculo_id`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role_requests`
--
ALTER TABLE `role_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `requested_role_id` (`requested_role_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autolavado_id` (`autolavado_id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_documento` (`num_documento`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `tipo_documento_id` (`tipo_documento_id`),
  ADD KEY `localidad_id` (`localidad_id`),
  ADD KEY `fk_role` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autolavados`
--
ALTER TABLE `autolavados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `role_requests`
--
ALTER TABLE `role_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `autolavados`
--
ALTER TABLE `autolavados`
  ADD CONSTRAINT `autolavados_ibfk_1` FOREIGN KEY (`dueno_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`),
  ADD CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`autolavado_id`) REFERENCES `autolavados` (`id`);

--
-- Filtros para la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD CONSTRAINT `recibos_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`),
  ADD CONSTRAINT `recibos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`autolavado_id`) REFERENCES `autolavados` (`id`),
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`tipo_vehiculo_id`) REFERENCES `tipo_vehiculo` (`id`);

--
-- Filtros para la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD CONSTRAINT `reseñas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `role_requests`
--
ALTER TABLE `role_requests`
  ADD CONSTRAINT `role_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `role_requests_ibfk_2` FOREIGN KEY (`requested_role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`autolavado_id`) REFERENCES `autolavados` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
