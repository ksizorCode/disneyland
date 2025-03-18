<?php
// Configuración de conexión a la base de datos
$dbHost = 'localhost';
$dbName = 'todo_app';
$dbUser = 'root';  // Cambia por tu nombre de usuario de base de datos
$dbPass = 'root';      // Cambia por tu contraseña de base de datos

// Establecer conexión con la base de datos
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Falló la conexión a la base de datos: " . $e->getMessage());
}

// Función para obtener todas las tareas
function obtenerTodasLasTareas($pdo) {
    $stmt = $pdo->query("SELECT * FROM miTODOlist ORDER BY fecha_vencimiento ASC, prioridad DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para añadir una nueva tarea
function agregarTarea($pdo, $titulo, $descripcion, $fechaVencimiento, $prioridad) {
    $stmt = $pdo->prepare("INSERT INTO miTODOlist (titulo, descripcion, fecha_vencimiento, prioridad) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$titulo, $descripcion, $fechaVencimiento, $prioridad]);
}

// Función para actualizar el estado de una tarea
function actualizarEstadoTarea($pdo, $id, $estado) {
    $stmt = $pdo->prepare("UPDATE miTODOlist SET estado = ? WHERE id = ?");
    return $stmt->execute([$estado, $id]);
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

// Manejar envíos de formularios
$mensaje = '';

// Añadir una nueva tarea
if (isset($_POST['agregar_tarea'])) {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fechaVencimiento = $_POST['fecha_vencimiento'] ?? null;
    $prioridad = $_POST['prioridad'] ?? 'media';
    
    if (!empty($titulo)) {
        if (agregarTarea($pdo, $titulo, $descripcion, $fechaVencimiento, $prioridad)) {
            $mensaje = "¡Tarea añadida con éxito!";
        } else {
            $mensaje = "Error al añadir la tarea.";
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

// Obtener todas las tareas para mostrar
$tareas = obtenerTodasLasTareas($pdo);

// Obtener tarea para editar si se proporciona un ID
$editarTarea = null;
if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
    $editarTarea = obtenerTareaPorId($pdo, $_GET['editar']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Lista de Tareas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
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
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], 
        textarea, 
        input[type="date"], 
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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
        }
        .btn-eliminar {
            background-color: #d9534f;
        }
        .mensaje {
            padding: 10px;
            margin-bottom: 20px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mi Lista de Tareas</h1>
        
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
                <input type="text" id="titulo" name="titulo" value="<?php echo $editarTarea ? $editarTarea['titulo'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $editarTarea ? $editarTarea['descripcion'] : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="fecha_vencimiento">Fecha de vencimiento:</label>
                <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $editarTarea ? $editarTarea['fecha_vencimiento'] : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="prioridad">Prioridad:</label>
                <select id="prioridad" name="prioridad">
                    <option value="baja" <?php echo ($editarTarea && $editarTarea['prioridad'] == 'baja') ? 'selected' : ''; ?>>Baja</option>
                    <option value="media" <?php echo (!$editarTarea || ($editarTarea && $editarTarea['prioridad'] == 'media')) ? 'selected' : ''; ?>>Media</option>
                    <option value="alta" <?php echo ($editarTarea && $editarTarea['prioridad'] == 'alta') ? 'selected' : ''; ?>>Alta</option>
                </select>
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
                
                <button type="submit" name="actualizar_estado">Actualizar Tarea</button>
                <a href="index.php" style="margin-left: 10px; color: #666; text-decoration: none;">Cancelar</a>
            <?php else: ?>
                <button type="submit" name="agregar_tarea">Añadir Tarea</button>
            <?php endif; ?>
        </form>
        
        <!-- Lista de Tareas -->
        <h2>Tus Tareas</h2>
        <?php if (count($tareas) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tareas as $tarea): ?>
                        <tr class="estado-<?php echo $tarea['estado']; ?>">
                            <td><?php echo htmlspecialchars($tarea['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($tarea['descripcion']); ?></td>
                            <td><?php echo $tarea['fecha_vencimiento'] ? date('Y-m-d', strtotime($tarea['fecha_vencimiento'])) : 'Sin fecha'; ?></td>
                            <td class="prioridad-<?php echo $tarea['prioridad']; ?>"><?php echo ucfirst($tarea['prioridad']); ?></td>
                            <td><?php 
                                if ($tarea['estado'] == 'pendiente') echo "Pendiente";
                                elseif ($tarea['estado'] == 'en_progreso') echo "En Progreso";
                                else echo "Completada";
                            ?></td>
                            <td class="botones-accion">
                                <a href="?editar=<?php echo $tarea['id']; ?>" class="btn-editar">Editar</a>
                                
                                <form method="post" action="" style="display: inline;">
                                    <input type="hidden" name="tarea_id" value="<?php echo $tarea['id']; ?>">
                                    <input type="hidden" name="estado" value="<?php echo $tarea['estado'] == 'pendiente' ? 'en_progreso' : ($tarea['estado'] == 'en_progreso' ? 'completada' : 'pendiente'); ?>">
                                    <button type="submit" name="actualizar_estado">
                                        <?php 
                                        if ($tarea['estado'] == 'pendiente') echo "Iniciar";
                                        elseif ($tarea['estado'] == 'en_progreso') echo "Completar";
                                        else echo "Reabrir";
                                        ?>
                                    </button>
                                </form>
                                
                                <a href="?eliminar=<?php echo $tarea['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron tareas. ¡Añade tu primera tarea arriba!</p>
        <?php endif; ?>
    </div>
</body>
</html>