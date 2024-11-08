
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
</head>

<?php
$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "proyecto";

// Crear conexión usando mysqli
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Inicializar $usuarios como un array vacío
$usuarios = [];

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $direccion_residencia = $_POST['direccion_residencia'];
    $latitud_residencia = $_POST['latitude1'];
    $longitud_residencia = $_POST['longitude1'];
    $direccion_trabajo = $_POST['direccion_trabajo']; 
    $latitud_trabajo = $_POST['latitude2'];
    $longitud_trabajo = $_POST['longitude2'];

    // Debug para verificar el valor de dirección de trabajo
    echo "Direccion de trabajo recibida: " . $direccion_trabajo . "<br>";

    // Preparar la llamada al procedimiento almacenado para insertar datos
    $stmt = $conn->prepare("CALL InsertarEstudiante(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssddsdd", $cedula, $nombres, $apellidos, $direccion_residencia, $latitud_residencia, $longitud_residencia, $direccion_trabajo, $latitud_trabajo, $longitud_trabajo);

    // Ejecutar y verificar la inserción
    if ($stmt->execute()) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error al guardar los datos: " . $stmt->error;
    }

    $stmt->close();
}

// Preparar la llamada al procedimiento almacenado para consultar datos
if ($resultado = $conn->query("CALL consultar()")) {
    // Verificar si se obtuvo algún resultado
    if ($resultado->num_rows > 0) {
        $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "No se encontraron datos en la consulta.";
    }
    $resultado->close();
} else {
    echo "Error al ejecutar el procedimiento almacenado: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>

<body class="bg-light">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="card p-4">
                    <h1 class="text-center h4 mb-4">Formulario de Registro</h1>
                    <form onsubmit="handleSubmit(event)" method="POST" action="">
                        <div class="mb-3">
                            <label for="document" class="form-label">Número de Documento</label>
                            <input type="text" name="cedula" id="document" class="form-control"
                                placeholder="Ingrese su número de documento" required pattern="[0-9]+"
                                title="Solo se permiten números">
                        </div>

                        <div class="mb-3">
                            <label for="names" class="form-label">Nombres</label>
                            <input type="text" name="nombres" id="names" class="form-control" placeholder="Ingrese sus nombres"
                                required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo se permiten letras">
                        </div>

                        <div class="mb-3">
                            <label for="surnames" class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" id="surnames" class="form-control" placeholder="Ingrese sus apellidos"
                                required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo se permiten letras">
                        </div>

                        <!-- Dirección de residencia -->
                        <div class="mb-3">
                            <label for="address1" class="form-label">Dirección de residencia</label>
                            <input type="text" name="direccion_residencia" id="address1" class="form-control" placeholder="Ingrese su dirección"
                                required>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="latitude1" class="form-label">Latitud R</label>
                                <input type="text" name="latitude1" id="latitude1" class="form-control" value="4.633105" readonly>
                            </div>
                            <div class="col">
                                <label for="longitude1" class="form-label">Longitud R</label>
                                <input type="text" name="longitude1" id="longitude1" class="form-control" value="-74.080603" readonly>
                            </div>
                        </div>

                        <!-- Dirección de trabajo -->
                        <div class="mb-3">
                            <label for="address2" class="form-label">Dirección de trabajo</label>
                            <input type="text" name="direccion_trabajo" id="address2" class="form-control" placeholder="Ingrese otra dirección" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="latitude2" class="form-label">Latitud T</label>
                                <input type="text" name="latitude2" id="latitude2" class="form-control" value="4.633105" readonly>
                            </div>
                            <div class="col">
                                <label for="longitude2" class="form-label">Longitud T</label>
                                <input type="text" name="longitude2" id="longitude2" class="form-control" value="-74.080603" readonly>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Guardar Usuario</button>
                    </form>
                    <br>
                    <button class="btn btn-success w-15" data-bs-toggle="modal" data-bs-target="#userModal">
                    Ver Datos de Usuarios
                    </button>

                </div>
            </div>

            <div class="col-md-6">
                <div class="position-relative border rounded overflow-hidden mb-4" style="height: 300px;">
                    <div id="map1" style="height: 100%; width: 100%;"></div>
                </div>
                <div class="position-relative border rounded overflow-hidden" style="height: 300px;">
                    <div id="map2" style="height: 100%; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!--pop op para consultar-->

<div class="container text-center">
    
    

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Datos de Usuarios</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" style="max-height: 70vh;">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Dirección Residencia</th>
                                    <th>Latitud Residencia</th>
                                    <th>Longitud Residencia</th>
                                    <th>Dirección Trabajo</th>
                                    <th>Latitud Trabajo</th>
                                    <th>Longitud Trabajo</th>
                                    <th>Distancia (km)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['cedula']); ?></td>
                                    <td><?= htmlspecialchars($usuario['nombres']); ?></td>
                                    <td><?= htmlspecialchars($usuario['apellidos']); ?></td>
                                    <td><?= htmlspecialchars($usuario['direccion_residencia']); ?></td>
                                    <td><?= htmlspecialchars($usuario['latitud_residencia']); ?></td>
                                    <td><?= htmlspecialchars($usuario['longitud_residencia']); ?></td>
                                    <td><?= htmlspecialchars($usuario['direccion_trabajo']); ?></td>
                                    <td><?= htmlspecialchars($usuario['latitud_trabajo']); ?></td>
                                    <td><?= htmlspecialchars($usuario['longitud_trabajo']); ?></td>
                                    <td><?= round($usuario['distancia_metros'] / 1000, 2); // Convertir a km ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="./script.js"></script>
</body>

</html>
