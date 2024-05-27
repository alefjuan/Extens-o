<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $preco = $_POST['preco'];

    $stmt = $conn->prepare("UPDATE carros SET marca=?, modelo=?, ano=?, preco=? WHERE id=?");
    $stmt->bind_param("ssssi", $marca, $modelo, $ano, $preco, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
?>
