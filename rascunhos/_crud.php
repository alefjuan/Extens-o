<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $preco = $_POST['preco'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE carros SET marca=?, modelo=?, ano=?, preco=? WHERE id=?");
        $stmt->bind_param("ssiii", $marca, $modelo, $ano, $preco, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO carros (marca, modelo, ano, preco) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $marca, $modelo, $ano, $preco);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    $stmt = $conn->prepare("DELETE FROM carros WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM carros");
    $carros = [];

    while ($row = $result->fetch_assoc()) {
        $carros[] = $row;
    }

    echo json_encode($carros);
}
?>
