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

    // Consulta para buscar o usuário na tabela alunos
    $sql_aluno = "SELECT cpf, nome_completo, email, senha, 'aluno' AS tipo_de_perfil FROM aluno WHERE email = ?";
    $stmt_aluno = $mysqli->prepare($sql_aluno);
    $stmt_aluno->bind_param("s", $email);
    $stmt_aluno->execute();
    $resultado_aluno = $stmt_aluno->get_result();

    if ($resultado_aluno->num_rows > 0) { // Se o usuário for encontrado na tabela aluno
        $usuario = $resultado_aluno->fetch_assoc(); // Captura os dados do usuário

        if (password_verify($senha, $usuario["senha"])) { // Compara a senha fornecida com o hash armazenado
            $_SESSION["usuario"] = [
                "cpf" => $usuario["cpf"],
                "nome_completo" => $usuario["nome_completo"],
                "email" => $usuario["email"],
                "perfil" => $usuario["tipo_de_perfil"]
            ];

            // Redireciona para a tela inicial do aluno
            header("Location: ../html/tela_inicial_aluno.html");
            exit();
        } else {
            die("Erro: Senha incorreta!"); // Exibe erro se a senha não corresponder
        }
    }

    // Consulta para buscar o usuário na tabela professores
    $sql_professor = "SELECT cpf, nome_completo, email, senha, 'professor' AS tipo_de_perfil FROM professor WHERE email = ?";
    $stmt_professor = $mysqli->prepare($sql_professor);
    $stmt_professor->bind_param("s", $email);
    $stmt_professor->execute();
    $resultado_professor = $stmt_professor->get_result();

    if ($resultado_professor->num_rows > 0) { // Se o usuário for encontrado na tabela professor
        $usuario = $resultado_professor->fetch_assoc(); // Captura os dados do usuário

        if (password_verify($senha, $usuario["senha"])) { // Compara a senha fornecida com o hash armazenado
            $_SESSION["usuario"] = [
                "cpf" => $usuario["cpf"],
                "nome_completo" => $usuario["nome_completo"],
                "email" => $usuario["email"],
                "perfil" => $usuario["tipo_de_perfil"]
            ];

            // Redireciona para a tela inicial do professor
            header("Location: ../html/tela_inicial_professor.html");
            exit();
        } else {
            die("Erro: Senha incorreta!"); // Exibe erro se a senha não corresponder
        }
    }

    // Se o email não for encontrado em nenhuma tabela
    die("Erro: E-mail não cadastrado!");

    // Fecha os statements
    $stmt_aluno->close();
    $stmt_professor->close();
}
?>