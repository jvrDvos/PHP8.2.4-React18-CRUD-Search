<?php
// Configuración CORS
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['name'];
    $descripcion = $_POST['description'];
    $precio = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO articles (title, details, total, cost) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdd", $nombre, $descripcion, $precio, $stock);

    if ($stmt->execute()) {
        // Prepare response
        $response = [
            'mensaje' => 'success'
        ];

        http_response_code(200);
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(['mensaje' => 'Error: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(['mensaje' => 'Método no permitido']);
    $stmt->close();
}
?>