<?php

include 'conexion.php';

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: GET, OPTIONS");

// Creatiion search 
$name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';

// Run the query
$sql = "SELECT * FROM articles";

if ($name) {

    $sql .= " WHERE title LIKE '%$name%'";

} else {

    $sql .= " ORDER BY id DESC";

}

// Total Articles       
 $result = $conn->query($sql);
 $articleCount = $result->num_rows;


try {
    // Run the query
    $result = $conn->query($sql);

    // Change variables
    $articles = [];
    while ($row = $result->fetch_assoc()) {
        $articles[] = [
            'id' => $row['id'],
            'name' => $row['title'],
            'description' => $row['details'],
            'price' => $row['total'],
            'stock' => $row['cost']
        ];
    }

    // Prepare response
    $response = [
        'article' => $articles,
        'articleCount' => $articleCount,
    ];

    // Send JSON
    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {

    // Errors
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} finally {

    // Close conection
     $conn->close();
}

?>