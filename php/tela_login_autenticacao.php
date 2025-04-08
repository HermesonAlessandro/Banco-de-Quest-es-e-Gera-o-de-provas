<?php
// Inicia a sessão para gerenciar os dados do usuário após o login
session_start(); // Necessário para acessar ou armazenar dados de sessão no servidor

// Inclui o arquivo de conexão com o banco de dados MySQL
require_once "../php/conexao.php"; // Garante que as credenciais e a conexão com o banco estão acessíveis

// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Assegura que o código só seja executado ao receber dados de um formulário enviado
    
    // Captura os dados enviados pelo formulário de login
    $email = trim($_POST["email"]); // Remove espaços em branco desnecessários antes e depois do e-mail
    $senha = trim($_POST["senha"]); // Remove espaços em branco desnecessários antes e depois da senha

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($email) || empty($senha)) { // Verifica se o campo de e-mail ou senha está vazio
        die("Erro: Todos os campos devem estar preenchidos!"); // Termina a execução com uma mensagem de erro
    }

    // CONSULTA NA TABELA ALUNO
    // Prepara a consulta SQL para verificar se o e-mail pertence a um aluno
    $sql_aluno = "SELECT cpf, nome_completo, email, senha, 'aluno' AS tipo_de_perfil FROM aluno WHERE email = ?";
    $stmt_aluno = $mysqli->prepare($sql_aluno); // Prepara a consulta para evitar SQL Injection
    $stmt_aluno->bind_param("s", $email); // Substitui o marcador "?" pelo valor do e-mail
    $stmt_aluno->execute(); // Executa a consulta
    $resultado_aluno = $stmt_aluno->get_result(); // Obtém o resultado da consulta

    if ($resultado_aluno->num_rows > 0) { // Se o e-mail for encontrado na tabela de alunos
        $usuario = $resultado_aluno->fetch_assoc(); // Captura os dados do usuário encontrados no banco de dados

        // Valida a senha fornecida pelo usuário
        if (password_verify($senha, $usuario["senha"])) { // Compara a senha fornecida com o hash armazenado
            // Armazena os dados do usuário na sessão ativa
            $_SESSION["usuario"] = [
                "cpf" => $usuario["cpf"], // CPF do usuário
                "nome_completo" => $usuario["nome_completo"], // Nome completo do usuário
                "email" => $usuario["email"], // E-mail do usuário
                "perfil" => $usuario["tipo_de_perfil"] // Tipo de perfil (neste caso, "aluno")
            ];

            // INSERÇÃO NA TABELA SESSAO
            // Grava o login do aluno na tabela "sessao"
            $sql_sessao = "INSERT INTO sessao (email, senha, tipo_de_usuario) VALUES (?, ?, ?)";
            $stmt_sessao = $mysqli->prepare($sql_sessao); // Prepara a consulta para evitar SQL Injection
            $stmt_sessao->bind_param("sss", $usuario["email"], $usuario["senha"], $usuario["tipo_de_perfil"]); // Associa os valores
            $stmt_sessao->execute(); // Executa a inserção no banco

            // Redireciona o usuário para a tela inicial do aluno
            header("Location: ../html/tela_inicial_aluno.html"); // Redireciona para a página inicial
            exit(); // Encerra a execução do script
        } else {
            die("Erro: Senha incorreta!"); // Retorna mensagem de erro se a senha não for válida
        }
    }

    // CONSULTA NA TABELA PROFESSORES
    // Prepara a consulta SQL para verificar se o e-mail pertence a um professor
    $sql_professor = "SELECT cpf, nome_completo, email, senha, 'professor' AS tipo_de_perfil FROM professor WHERE email = ?";
    $stmt_professor = $mysqli->prepare($sql_professor); // Prepara a consulta para evitar SQL Injection
    $stmt_professor->bind_param("s", $email); // Substitui o marcador "?" pelo valor do e-mail
    $stmt_professor->execute(); // Executa a consulta
    $resultado_professor = $stmt_professor->get_result(); // Obtém o resultado da consulta

    if ($resultado_professor->num_rows > 0) { // Se o e-mail for encontrado na tabela de professores
        $usuario = $resultado_professor->fetch_assoc(); // Captura os dados do usuário encontrados no banco de dados

        // Valida a senha fornecida pelo usuário
        if (password_verify($senha, $usuario["senha"])) { // Compara a senha fornecida com o hash armazenado
            // Armazena os dados do usuário na sessão ativa
            $_SESSION["usuario"] = [
                "cpf" => $usuario["cpf"], // CPF do usuário
                "nome_completo" => $usuario["nome_completo"], // Nome completo do usuário
                "email" => $usuario["email"], // E-mail do usuário
                "perfil" => $usuario["tipo_de_perfil"] // Tipo de perfil (neste caso, "professor")
            ];

            // INSERÇÃO NA TABELA SESSAO
            // Grava o login do professor na tabela "sessao"
            $sql_sessao = "INSERT INTO sessao (email, senha, tipo_de_usuario) VALUES (?, ?, ?)";
            $stmt_sessao = $mysqli->prepare($sql_sessao); // Prepara a consulta para evitar SQL Injection
            $stmt_sessao->bind_param("sss", $usuario["email"], $usuario["senha"], $usuario["tipo_de_perfil"]); // Associa os valores
            $stmt_sessao->execute(); // Executa a inserção no banco

            // Redireciona o usuário para a tela inicial do professor
            header("Location: ../html/tela_inicial_professor.html"); // Redireciona para a página inicial
            exit(); // Encerra a execução do script
        } else {
            die("Erro: Senha incorreta!"); // Retorna mensagem de erro se a senha não for válida
        }
    }

    // SE O E-MAIL NÃO FOR ENCONTRADO EM NENHUMA TABELA
    die("Erro: E-mail não cadastrado!"); // Retorna mensagem de erro se o e-mail não existir no banco de dados

    // Fecha os recursos para liberar memória
    $stmt_aluno->close();
    $stmt_professor->close();
}
?>