<?php
// Configuración de conexión a la base de datos
$dbHost = 'localhost';
$dbName = 'todo_app';
$dbUser = 'root';  // Cambia por tu nombre de usuario de base de datos
$dbPass = 'root';  // Cambia por tu contraseña de base de datos

// Establecer conexión con la base de datos
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Falló la conexión a la base de datos: " . $e->getMessage());
}

// Función para obtener todas las tareas con posibilidad de filtrado y ordenación
function obtenerTareas($pdo, $filtros = [], $orden = null, $busqueda = '') {
    $sql = "SELECT * FROM miTODOlist WHERE 1=1";
    $params = [];
    
    // Aplicar filtros si existen
    if (!empty($filtros['prioridad'])) {
        $sql .= " AND prioridad = ?";
        $params[] = $filtros['prioridad'];
    }
    
    if (!empty($filtros['estado'])) {
        $sql .= " AND estado = ?";
        $params[] = $filtros['estado'];
    }
    
    if (!empty($filtros['asignado_a'])) {
        $sql .= " AND asignado_a = ?";
        $params[] = $filtros['asignado_a'];
    }
    
    // Aplicar búsqueda si existe
    if (!empty($busqueda)) {
        $sql .= " AND (titulo LIKE ? OR descripcion LIKE ? OR asignado_a LIKE ?)";
        $busqueda = "%$busqueda%";
        $params[] = $busqueda;
        $params[] = $busqueda;
        $params[] = $busqueda;
    }
    
    // Aplicar ordenación si existe
    if (!empty($orden)) {
        $columnasPermitidas = ['titulo', 'fecha_vencimiento', 'prioridad', 'estado', 'asignado_a', 'fecha_creacion'];
        $columna = explode('-', $orden)[0];
        $direccion = isset(explode('-', $orden)[1]) ? explode('-', $orden)[1] : 'ASC';
        
        if (in_array($columna, $columnasPermitidas)) {
            if ($direccion != 'ASC' && $direccion != 'DESC') {
                $direccion = 'ASC';
            }
            $sql .= " ORDER BY $columna $direccion";
        }
    } else {
        // Orden predeterminado
        $sql .= " ORDER BY fecha_vencimiento ASC, prioridad DESC";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener todas las personas asignadas (para el filtro)
function obtenerPersonasAsignadas($pdo) {
    $stmt = $pdo->query("SELECT DISTINCT asignado_a FROM miTODOlist WHERE asignado_a IS NOT NULL ORDER BY asignado_a");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Función para añadir una nueva tarea
function agregarTarea($pdo, $titulo, $descripcion, $fechaVencimiento, $horaVencimiento, $prioridad, $asignado_a) {
    $stmt = $pdo->prepare("INSERT INTO miTODOlist (titulo, descripcion, fecha_vencimiento, hora_vencimiento, prioridad, asignado_a) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$titulo, $descripcion, $fechaVencimiento, $horaVencimiento, $prioridad, $asignado_a]);
}

// Función para actualizar el estado de una tarea
function actualizarEstadoTarea($pdo, $id, $estado) {
    $stmt = $pdo->prepare("UPDATE miTODOlist SET estado = ? WHERE id = ?");
    return $stmt->execute([$estado, $id]);
}

// Función para actualizar una tarea completa
function actualizarTarea($pdo, $id, $titulo, $descripcion, $fechaVencimiento, $horaVencimiento, $prioridad, $estado, $asignado_a) {
    $stmt = $pdo->prepare("UPDATE miTODOlist SET titulo = ?, descripcion = ?, fecha_vencimiento = ?, hora_vencimiento = ?, prioridad = ?, estado = ?, asignado_a = ? WHERE id = ?");
    return $stmt->execute([$titulo, $descripcion, $fechaVencimiento, $horaVencimiento, $prioridad, $estado, $asignado_a, $id]);
}

// Función para eliminar una tarea
function eliminarTarea($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM miTODOlist WHERE id = ?");
    return $stmt->execute([$id]);
}

// Función para obtener una tarea específica por ID
function obtenerTareaPorId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM miTODOlist WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Inicializar variables para filtros, búsqueda y ordenación
$filtros = [
    'prioridad' => $_GET['filtro_prioridad'] ?? '',
    'estado' => $_GET['filtro_estado'] ?? '',
    'asignado_a' => $_GET['filtro_asignado'] ?? ''
];
$orden = $_GET['orden'] ?? '';
$busqueda = $_GET['busqueda'] ?? '';
$mostrarFechaCreacion = isset($_GET['mostrar_fecha_creacion']) ? true : false;

// Manejar envíos de formularios
$mensaje = '';

// Para la ventana modal - obtener tarea por ID
$tareaMostrar = null;
if (isset($_GET['mostrar']) && is_numeric($_GET['mostrar'])) {
    $tareaMostrar = obtenerTareaPorId($pdo, $_GET['mostrar']);
}

// Añadir o actualizar una tarea
if (isset($_POST['guardar_tarea'])) {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fechaVencimiento = $_POST['fecha_vencimiento'] ?? null;
    $horaVencimiento = $_POST['hora_vencimiento'] ?? null;
    $prioridad = $_POST['prioridad'] ?? 'media';
    $asignado_a = $_POST['asignado_a'] ?? null;
    
    // Validar campos requeridos
    if (!empty($titulo)) {
        if (isset($_POST['tarea_id']) && is_numeric($_POST['tarea_id'])) {
            // Actualizar tarea existente
            $tareaId = $_POST['tarea_id'];
            $estado = $_POST['estado'] ?? 'pendiente';
            
            if (actualizarTarea($pdo, $tareaId, $titulo, $descripcion, $fechaVencimiento, $horaVencimiento, $prioridad, $estado, $asignado_a)) {
                $mensaje = "¡Tarea actualizada con éxito!";
            } else {
                $mensaje = "Error al actualizar la tarea.";
            }
        } else {
            // Añadir nueva tarea
            if (agregarTarea($pdo, $titulo, $descripcion, $fechaVencimiento, $horaVencimiento, $prioridad, $asignado_a)) {
                $mensaje = "¡Tarea añadida con éxito!";
            } else {
                $mensaje = "Error al añadir la tarea.";
            }
        }
    } else {
        $mensaje = "El título de la tarea es obligatorio.";
    }
}

// Actualizar estado de la tarea
if (isset($_POST['actualizar_estado'])) {
    $tareaId = $_POST['tarea_id'] ?? 0;
    $estado = $_POST['estado'] ?? 'pendiente';
    
    if (actualizarEstadoTarea($pdo, $tareaId, $estado)) {
        $mensaje = "¡Estado de la tarea actualizado con éxito!";
    } else {
        $mensaje = "Error al actualizar el estado de la tarea.";
    }
}

// Eliminar una tarea
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $tareaId = $_GET['eliminar'];
    
    if (eliminarTarea($pdo, $tareaId)) {
        $mensaje = "¡Tarea eliminada con éxito!";
    } else {
        $mensaje = "Error al eliminar la tarea.";
    }
}

// Obtener tareas según filtros, ordenación y búsqueda
$tareas = obtenerTareas($pdo, $filtros, $orden, $busqueda);
$personasAsignadas = obtenerPersonasAsignadas($pdo);

// Obtener tarea para editar si se proporciona un ID
$editarTarea = null;
if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
    $editarTarea = obtenerTareaPorId($pdo, $_GET['editar']);
}

// Función auxiliar para crear enlaces de ordenación
function enlaceOrdenacion($columna, $ordenActual, $filtros, $busqueda, $mostrarFechaCreacion) {
    $direccion = 'ASC';
    
    // Si ya estamos ordenando por esta columna, alternar dirección
    if ($ordenActual == "$columna-ASC") {
        $direccion = 'DESC';
    } elseif ($ordenActual == "$columna-DESC") {
        $direccion = 'ASC';
    }
    
    // Construir URL con parámetros actuales
    $url = "?orden=$columna-$direccion";
    
    // Añadir filtros si existen
    foreach ($filtros as $clave => $valor) {
        if (!empty($valor)) {
            $url .= "&filtro_$clave=" . urlencode($valor);
        }
    }
    
    // Añadir búsqueda si existe
    if (!empty($busqueda)) {
        $url .= "&busqueda=" . urlencode($busqueda);
    }
    
    // Añadir mostrar fecha de creación si está activado
    if ($mostrarFechaCreacion) {
        $url .= "&mostrar_fecha_creacion=1";
    }
    
    $indicadorOrden = '';
    if ($ordenActual == "$columna-ASC") {
        $indicadorOrden = ' ↑';
    } elseif ($ordenActual == "$columna-DESC") {
        $indicadorOrden = ' ↓';
    }
    
    return $url . $indicadorOrden;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Lista de Tareas Mejorada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], 
        textarea, 
        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .filtros {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            align-items: center;
        }
        .filtros .form-group {
            margin-bottom: 0;
            min-width: 150px;
        }
        .filtros button {
            height: 38px;
        }
        .busqueda {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }
        th:hover {
            background-color: #e5e5e5;
        }
        .prioridad-alta {
            color: #d9534f;
            font-weight: bold;
        }
        .prioridad-media {
            color: #f0ad4e;
        }
        .prioridad-baja {
            color: #5bc0de;
        }
        .estado-pendiente {
            background-color: #ffe0e0;
        }
        .estado-en_progreso {
            background-color: #fff0cc;
        }
        .estado-completada {
            background-color: #e0ffe0;
        }
        .botones-accion {
            display: flex;
            gap: 5px;
        }
        .botones-accion a, .botones-accion button {
            padding: 5px 10px;
            text-decoration: none;
            font-size: 0.8em;
        }
        .btn-editar {
            background-color: #f0ad4e;
            color: white;
        }
        .btn-eliminar {
            background-color: #d9534f;
            color: white;
        }
        .btn-mostrar {
            background-color: #5bc0de;
            color: white;
        }
        .mensaje {
            padding: 10px;
            margin-bottom: 20px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            color: #155724;
        }
        
        /* Estilos para la ventana modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-contenido {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 700px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .cerrar {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .cerrar:hover {
            color: black;
        }
        .detalles-tarea {
            margin-top: 20px;
        }
        .detalles-tarea h3 {
            margin-top: 0;
            color: #333;
        }
        .detalles-tarea p {
            margin: 10px 0;
        }
        .detalles-tarea .etiqueta {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .enlace-ordenacion {
            color: inherit;
            text-decoration: none;
            position: relative;
        }
        .fila-tarea {
            cursor: pointer;
        }
        .fila-tarea:hover {
            background-color: #f9f9f9;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .checkbox-container input[type="checkbox"] {
            margin: 0;
        }

        /* Estilos para pantallas pequeñas */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 5px;
            }
            .filtros {
                flex-direction: column;
                align-items: stretch;
            }
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mi Lista de Tareas Mejorada</h1>
        
        <?php if (!empty($mensaje)): ?>
            <div class="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        
        <!-- Formulario para Añadir/Editar Tarea -->
        <form method="post" action="">
            <h2><?php echo $editarTarea ? 'Editar Tarea' : 'Añadir Nueva Tarea'; ?></h2>
            
            <?php if ($editarTarea): ?>
                <input type="hidden" name="tarea_id" value="<?php echo $editarTarea['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $editarTarea ? htmlspecialchars($editarTarea['titulo']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $editarTarea ? htmlspecialchars($editarTarea['descripcion']) : ''; ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_vencimiento">Fecha de vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $editarTarea ? $editarTarea['fecha_vencimiento'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="hora_vencimiento">Hora de vencimiento:</label>
                    <input type="time" id="hora_vencimiento" name="hora_vencimiento" value="<?php echo $editarTarea ? $editarTarea['hora_vencimiento'] : ''; ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="prioridad">Prioridad:</label>
                    <select id="prioridad" name="prioridad">
                        <option value="baja" <?php echo ($editarTarea && $editarTarea['prioridad'] == 'baja') ? 'selected' : ''; ?>>Baja</option>
                        <option value="media" <?php echo (!$editarTarea || ($editarTarea && $editarTarea['prioridad'] == 'media')) ? 'selected' : ''; ?>>Media</option>
                        <option value="alta" <?php echo ($editarTarea && $editarTarea['prioridad'] == 'alta') ? 'selected' : ''; ?>>Alta</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="asignado_a">Asignado a:</label>
                    <input type="text" id="asignado_a" name="asignado_a" placeholder="Nombre de la persona" value="<?php echo $editarTarea ? htmlspecialchars($editarTarea['asignado_a']) : ''; ?>">
                </div>
                
                <?php if ($editarTarea): ?>
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select id="estado" name="estado">
                            <option value="pendiente" <?php echo ($editarTarea['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="en_progreso" <?php echo ($editarTarea['estado'] == 'en_progreso') ? 'selected' : ''; ?>>En Progreso</option>
                            <option value="completada" <?php echo ($editarTarea['estado'] == 'completada') ? 'selected' : ''; ?>>Completada</option>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <button type="submit" name="guardar_tarea"><?php echo $editarTarea ? 'Actualizar Tarea' : 'Añadir Tarea'; ?></button>
                <?php if ($editarTarea): ?>
                    <a href="index.php" style="margin-left: 10px; color: #666; text-decoration: none;">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
        
        <!-- Filtros, búsqueda y opciones -->
        <form method="get" action="">
            <div class="filtros">
                <div class="form-group busqueda">
                    <input type="text" name="busqueda" placeholder="Buscar tareas..." value="<?php echo htmlspecialchars($busqueda); ?>">
                </div>
                
                <div class="form-group">
                    <select name="filtro_prioridad">
                        <option value="">Todas las prioridades</option>
                        <option value="baja" <?php echo ($filtros['prioridad'] == 'baja') ? 'selected' : ''; ?>>Baja</option>
                        <option value="media" <?php echo ($filtros['prioridad'] == 'media') ? 'selected' : ''; ?>>Media</option>
                        <option value="alta" <?php echo ($filtros['prioridad'] == 'alta') ? 'selected' : ''; ?>>Alta</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <select name="filtro_estado">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" <?php echo ($filtros['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="en_progreso" <?php echo ($filtros['estado'] == 'en_progreso') ? 'selected' : ''; ?>>En Progreso</option>
                        <option value="completada" <?php echo ($filtros['estado'] == 'completada') ? 'selected' : ''; ?>>Completada</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <select name="filtro_asignado">
                        <option value="">Todos los asignados</option>
                        <?php foreach ($personasAsignadas as $persona): ?>
                            <option value="<?php echo htmlspecialchars($persona); ?>" <?php echo ($filtros['asignado_a'] == $persona) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($persona); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="checkbox-container">
                    <input type="checkbox" id="mostrar_fecha_creacion" name="mostrar_fecha_creacion" <?php echo $mostrarFechaCreacion ? 'checked' : ''; ?>>
                    <label for="mostrar_fecha_creacion">Mostrar fecha de creación</label>
                </div>
                
                <button type="submit">Aplicar</button>
                <a href="index.php" style="margin-left: 5px; padding: 10px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px;">Limpiar</a>
            </div>
        </form>
        
        <!-- Lista de Tareas -->
        <h2>Tus Tareas</h2>
        <?php if (count($tareas) > 0): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th><a href="<?php echo enlaceOrdenacion('titulo', $orden, $filtros, $busqueda, $mostrarFechaCreacion); ?>" class="enlace-ordenacion">Título</a></th>
                            <th>Descripción</th>
                            <?php if ($mostrarFechaCreacion): ?>
                                <th><a href="<?php echo enlaceOrdenacion('fecha_creacion', $orden, $filtros, $busqueda, $mostrarFechaCreacion); ?>" class="enlace-ordenacion">Fecha de Creación</a></th>
                            <?php endif; ?>
                            <th><a href="<?php echo enlaceOrdenacion('fecha_vencimiento', $orden, $filtros, $busqueda, $mostrarFechaCreacion); ?>" class="enlace-ordenacion">Fecha de Vencimiento</a></th>
                            <th><a href="<?php echo enlaceOrdenacion('prioridad', $orden, $filtros, $busqueda, $mostrarFechaCreacion); ?>" class="enlace-ordenacion">Prioridad</a></th>
                            <th><a href="<?php echo enlaceOrdenacion('estado', $orden, $filtros, $busqueda, $mostrarFechaCreacion); ?>" class="enlace-ordenacion">Estado</a></th>
                            <th><a href="<?php echo enlaceOrdenacion('asignado_a', $orden, $filtros, $busqueda, $mostrarFechaCreacion); ?>" class="enlace-ordenacion">Asignado a</a></th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tareas as $tarea): ?>
                            <tr class="estado-<?php echo $tarea['estado']; ?> fila-tarea" data-id="<?php echo $tarea['id']; ?>">
                                <td><?php echo htmlspecialchars($tarea['titulo']); ?></td>
                                <td><?php echo mb_strlen($tarea['descripcion']) > 50 ? htmlspecialchars(mb_