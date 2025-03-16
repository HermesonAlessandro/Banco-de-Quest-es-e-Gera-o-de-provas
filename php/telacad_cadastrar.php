<?php
// Inclui a conexão com o banco de dados
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura e valida os dados enviados pelo formulário
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha
    $perfil = $_POST['perfil'];

    if (empty($cpf) || empty($nome) || empty($email) || empty($senha)) {
        die("Por favor, preencha todos os campos.");
    }

    // Valida o valor do perfil
    if ($perfil === 'Aluno') {
        $sql = "INSERT INTO alunos(cpf, nome_completo, email, senha) VALUES (?, ?, ?, ?)";
    } elseif ($perfil === 'Professor') {
        $sql = "INSERT INTO professores(cpf, nome_completo, email, senha) VALUES (?, ?, ?, ?)";
    } else {
        die("Perfil inválido. Selecione 'Aluno' ou 'Professor'.");
    }

    // Inicializa a consulta preparada
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        // Vincula os parâmetros à consulta preparada
        $stmt->bind_param("ssss", $cpf, $nome, $email, $senha);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso no perfil $perfil!";
        } else {
            if (strpos($stmt->error, 'Duplicate entry') !== false) {
                echo "Erro: O CPF já está cadastrado.";
            } else {
                echo "Erro ao cadastrar: " . htmlspecialchars($stmt->error);
            }
        }

        // Fecha a consulta preparada
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . htmlspecialchars($mysqli->error);
    }

    // Fecha a conexão com o banco de dados
    $mysqli->close();
} else {
    echo "Método de requisição inválido.";
}
?>
