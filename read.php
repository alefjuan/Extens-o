<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

$result = $conn->query("SELECT * FROM carros");
$carros = [];

while ($row = $result->fetch_assoc()) {
    $carros[] = $row;
}

echo json_encode($carros);
?>
