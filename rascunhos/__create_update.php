<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null; // Verifica se 'id' está definido
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $preco = $_POST['preco'];

    if (!empty($id)) {
        // Se um ID foi fornecido e não está vazio, atualize o item existente
        $stmt = $conn->prepare("UPDATE carros SET marca=?, modelo=?, ano=?, preco=? WHERE id=?");
        $stmt->bind_param("ssssi", $marca, $modelo, $ano, $preco, $id);
        
        if ($stmt->execute()) {
            // Retorne uma resposta JSON indicando o sucesso da operação
            echo json_encode(['success' => true]);
        } else {
            // Retorne uma resposta JSON indicando o fracasso da operação
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        // Se nenhum ID foi fornecido ou é vazio, retorne uma resposta de erro
        echo json_encode(['success' => false, 'error' => 'ID do carro não foi fornecido']);
    }
}
?>
