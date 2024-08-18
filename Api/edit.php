<?php
// Configuración CORS
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

include 'conexion.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $nombre = $_POST['name'];
    $descripcion = $_POST['description'];
    $precio = $_POST['price'];
    $stock = $_POST['stock'];
    
    $sql = "UPDATE articles SET title = ?, details = ?, total = ?, cost = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddi", $nombre, $descripcion, $precio, $stock, $id);
    
    if ($stmt->execute()) {
        // Preparar la respuesta
        $response = [
            'mensaje' => 'success'
        ];

        http_response_code(200);
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode([
            'mensaje' => 'Error: ' . $stmt->error
        ]);
    }


    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['mensaje' => 'Método no permitido']);
}
?>