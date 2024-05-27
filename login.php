<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];

    // Consulta para verificar se o nome de usuário e senha correspondem a um usuário na tabela
    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE nome_usuario = ?");
    $stmt->bind_param("s", $nome_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($senha === $row['senha']) {
            // Autenticação bem-sucedida
            $_SESSION['usuario_id'] = $row['id'];
            header("Location: carros.html");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Nome de usuário não encontrado.";
    }
    

}
?>
