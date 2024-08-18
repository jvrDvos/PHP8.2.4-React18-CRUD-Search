<?php
// Establecer los encabezados CORS
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Max-Age: 1728000");

// Comprobar el método HTTP
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Responder a las solicitudes de preflight (opciones)
    http_response_code(204);
    exit;
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    $sql = "DELETE FROM `articles` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    try {
        if ($stmt->execute()) {
            $response = [
                'mensaje' => 'success'
            ];
            http_response_code(200);
            echo json_encode($response);
        } else {
            http_response_code(500);
            echo json_encode([
                'mensaje' => 'Error deleting the article'
            ]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        error_log("Error deleting article: " . $e->getMessage());
        echo json_encode([
            'mensaje' => 'An error occurred while deleting the article'
        ]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['mensaje' => 'Method not allowed']);
}
?>