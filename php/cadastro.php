<?php
include_once('conexao.php'); // Incluindo a conexão com o banco de dados

if($_SERVER['REQUEST_METHOD'] == "POST"){ // Verificação se o formulário está sendo enviado
    $nome = $_POST['nome'];
    $email = $_POST['email']
}
?>