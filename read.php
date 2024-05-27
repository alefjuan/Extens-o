<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

$result = $conn->query("SELECT * FROM usuarios");
$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);
?>
