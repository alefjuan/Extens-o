<?php
// Inicia uma sessão para gerenciar dados persistentes do usuário
session_start();

// Conecta ao banco de dados 'crud' no servidor local (localhost) com o usuário 'root' e senha vazia
$conn = new mysqli('localhost', 'root', '', 'crud');

// Verifica se o método de requisição é POST (indicando que o formulário de login foi enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário e armazena em variáveis
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];

    // Prepara uma declaração SQL para verificar se o nome de usuário existe na tabela 'usuarios'
    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE nome_usuario = ?");
    // Associa a variável $nome_usuario ao parâmetro na declaração preparada
    $stmt->bind_param("s", $nome_usuario); // "s" indica que o parâmetro é uma string
    // Executa a declaração preparada
    $stmt->execute();
    // Obtém o resultado da execução da declaração
    $result = $stmt->get_result();

    // Verifica se foi encontrado exatamente um usuário com o nome de usuário fornecido
    if ($result->num_rows == 1) {
        // Obtém os dados do usuário encontrado
        $row = $result->fetch_assoc();
        // Verifica se a senha fornecida corresponde à senha armazenada
        if ($senha === $row['senha']) {
            // Autenticação bem-sucedida
            // Armazena o ID do usuário na sessão
            $_SESSION['usuario_id'] = $row['id'];
            // Redireciona o usuário para a página 'carros.html'
            header("Location: carros.html");
            exit(); // Encerra a execução do script
        } else {
            // Senha incorreta
            echo "Senha incorreta.";
        } 
    } else {
        // Nome de usuário não encontrado
        echo "Nome de usuário não encontrado.";
    }
}
?>
