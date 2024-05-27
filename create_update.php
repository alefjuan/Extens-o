<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null; // Verifica se 'id' está definido
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE usuarios SET nome=?, email=?, telefone=? WHERE id=?");
        $stmt->bind_param("sssi", $nome, $email, $telefone, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, telefone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $telefone);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
