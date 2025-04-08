<?php
// Inicia a sessão
session_start(); // Garante que a sessão está ativa para salvar dados do usuário após o login.

// Inclui o arquivo de conexão com o banco de dados
require_once "../php/conexao.php"; // Certifique-se de que o caminho está correto.

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Garante que o código só será executado se o método da requisição for POST.
    
    // Obtém os dados enviados pelo formulário
    $email = trim($_POST["email"]); // Captura o e-mail fornecido pelo usuário, removendo espaços extras.
    $senha = trim($_POST["senha"]); // Captura a senha fornecida pelo usuário.

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($email) || empty($senha)) {
        die("Erro: Todos os campos devem estar preenchidos!"); // Exibe mensagem de erro se algum campo estiver vazio.
    }

    // Consulta para buscar o usuário na tabela alunos com base no email
    $sql = "SELECT cpf, nome_completo, email, senha, tipo_de_perfil FROM aluno WHERE email = ?"; // Consulta para verificar se o email existe na tabela.
    $stmt = $mysqli->prepare($sql); // Prepara a consulta para evitar SQL Injection.
    $stmt->bind_param("s", $email); // Vincula o valor do email à consulta preparada.
    $stmt->execute(); // Executa a consulta.
    $resultado = $stmt->get_result(); // Obtém o resultado da consulta.

    // Verifica se o usuário foi encontrado
    if ($resultado->num_rows > 0) { // Verifica se há algum resultado correspondente ao email fornecido.
        $usuario = $resultado->fetch_assoc(); // Captura os dados do usuário.

        // Verifica se a senha fornecida corresponde ao hash armazenado
        if (password_verify($senha, $usuario["senha"])) { // Compara a senha fornecida com o hash armazenado.
            // Caso a autenticação seja bem-sucedida, salva os dados do usuário na sessão
            $_SESSION["usuario"] = [
                "cpf" => $usuario["cpf"],
                "nome_completo" => $usuario["nome_completo"],
                "email" => $usuario["email"],
                "perfil" => $usuario["tipo_de_perfil"]
            ];

            // Redireciona o usuário para a área protegida
            header("Location: ../html/tela_inicial_aluno.html"); // Redireciona para a área protegida.
            exit(); // Garante que o script pare de executar após o redirecionamento.
        } else {
            echo "Erro: Senha incorreta!"; // Exibe mensagem de erro caso a senha não corresponda ao hash.
        }
    } else {
        echo "Erro: E-mail não cadastrado!"; // Exibe mensagem de erro caso o email não seja encontrado.
    }

    // Fecha o statement para liberar recursos
    $stmt->close(); // Fecha o statement usado para a consulta.
}
?>