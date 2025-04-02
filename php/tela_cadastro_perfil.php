<?php
// Inclui o arquivo de conexão já existente
require_once "../php/conexao.php"; // Certifique-se de que o caminho está correto

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $perfil = $_POST["perfil"]; // Valor será "Aluno" ou "Professor"

    // Define a tabela com base no perfil selecionado
    $tabela = ($perfil == "Aluno") ? "alunos" : "professores";

    // Verifica se o CPF já está cadastrado na tabela correspondente
    $sql_verificacao = "SELECT cpf FROM $tabela WHERE cpf = ?";
    $stmt_verificacao = $mysqli->prepare($sql_verificacao); // $mysqli vem do arquivo de conexão incluído
    $stmt_verificacao->bind_param("s", $cpf);
    $stmt_verificacao->execute();
    $stmt_verificacao->store_result();

    if ($stmt_verificacao->num_rows > 0) {
        die("Erro: Este CPF já está cadastrado como $perfil.");
    }

    // *** Hash da senha para segurança ***
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere os dados na tabela correta
    $sql = "INSERT INTO $tabela (cpf, nome_completo, email, senha, tipo_de_perfil) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss", $cpf, $nome, $email, $senha_hash, $perfil);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso na tabela $tabela!";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    // Fecha as conexões
    $stmt_verificacao->close();
    $stmt->close();
}
?>