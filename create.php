<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $preco = $_POST['preco'];

    $stmt = $conn->prepare("INSERT INTO carros (marca, modelo, ano, preco) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $marca, $modelo, $ano, $preco);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
?>
