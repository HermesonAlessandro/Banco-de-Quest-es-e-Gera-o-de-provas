<?php
// Inclui o arquivo de conexão já existente
require_once "../php/conexao.php"; // Certifique-se de que o caminho está correto. Este arquivo contém as configurações para conectar ao banco de dados.

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Garante que o código só será executado se o método da requisição for POST.
    
    // Obtém os dados enviados pelo formulário
    $cpf = trim($_POST["cpf"]); // Captura o CPF fornecido pelo usuário e remove espaços extras.
    $nome = trim($_POST["nome"]); // Captura o nome completo fornecido pelo usuário.
    $email = trim($_POST["email"]); // Captura o e-mail fornecido pelo usuário.
    $senha = trim($_POST["senha"]); // Captura a senha fornecida pelo usuário.
    $perfil = trim($_POST["perfil"]); // Determina se o usuário será "Aluno" ou "Professor".

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($cpf) || empty($nome) || empty($email) || empty($senha) || empty($perfil)) {
        die("Erro: Todos os campos devem estar preenchidos!"); // Exibe mensagem de erro se algum campo estiver vazio.
    }

    // Define a tabela com base no perfil selecionado
    $tabela = ($perfil === "Aluno") ? "aluno" : "professor"; // Verifica se o perfil selecionado é "Aluno" ou "Professor".

    // Verifica se o CPF já está cadastrado na tabela correspondente
    $sql_verificacao = "SELECT cpf FROM $tabela WHERE cpf = ?"; // Consulta para verificar se o CPF já existe na tabela do banco de dados.
    $stmt_verificacao = $mysqli->prepare($sql_verificacao); // Prepara a consulta para evitar SQL Injection.
    $stmt_verificacao->bind_param("s", $cpf); // Vincula o valor do CPF à consulta preparada.
    $stmt_verificacao->execute(); // Executa a consulta.
    $stmt_verificacao->store_result(); // Armazena o resultado da consulta.

    if ($stmt_verificacao->num_rows > 0) { // Verifica se o CPF já existe na tabela.
        die("Erro: Este CPF já está cadastrado como $perfil."); // Interrompe a execução caso o CPF já esteja cadastrado.
    }

    // *** Hash da senha para segurança ***
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Gera um hash seguro da senha usando o algoritmo padrão. Isso garante que a senha seja armazenada de forma segura no banco de dados.

    // Insere os dados na tabela correta
    $sql = "INSERT INTO $tabela (cpf, nome_completo, email, senha, tipo_de_perfil) VALUES (?, ?, ?, ?, ?)"; // Consulta para inserir os dados na tabela correspondente.
    $stmt = $mysqli->prepare($sql); // Prepara a consulta para evitar SQL Injection.
    $stmt->bind_param("sssss", $cpf, $nome, $email, $senha_hash, $perfil); // Vincula os valores recebidos à consulta preparada.

    if ($stmt->execute()) { // Executa a inserção dos dados no banco de dados.
        // Redireciona ao login após o cadastro com sucesso
        header("Location: ../html/tela_login.html"); // Redireciona o usuário para a página de login.
        exit(); // Garante que o script pare de executar após o redirecionamento.
    } else {
        echo "Erro ao cadastrar: " . $stmt->error; // Exibe uma mensagem de erro caso a inserção no banco de dados falhe.
    }

    // Fecha as conexões
    $stmt_verificacao->close(); // Fecha o statement usado para a verificação.
    $stmt->close(); // Fecha o statement usado para a inserção.
}
?>