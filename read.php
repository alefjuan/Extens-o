<?php
// Conecta ao banco de dados 'crud' no servidor local (localhost) com o usuário 'root' e senha vazia
$conn = new mysqli('localhost', 'root', '', 'crud');

// Executa uma consulta SQL para selecionar todos os registros da tabela 'carros'
$result = $conn->query("SELECT * FROM carros");

// Inicializa um array vazio para armazenar os dados dos carros
$carros = [];

// Loop através de cada linha do resultado da consulta
while ($row = $result->fetch_assoc()) {
    // Adiciona a linha (um array associativo) ao array $carros
    $carros[] = $row;
}

// Converte o array $carros em formato JSON e o imprime
echo json_encode($carros);
?>
