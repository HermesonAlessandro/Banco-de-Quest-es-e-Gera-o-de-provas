<?php
// Inicia a sessão
session_start(); // Isso é necessário para acessar os dados da sessão ativa. Sem isso, o script não teria acesso às variáveis de sessão.


// Inclui o arquivo de conexão com o banco de dados
require_once "../php/conexao.php"; // Importa o arquivo onde estão configuradas as credenciais e a conexão ao banco de dados. Isso é essencial para interagir com o banco.


/*
 * Verifica se o usuário está logado
 * Caso não esteja logado, não haverá dados disponíveis na variável de sessão, como 'email'.
 */
if (isset($_SESSION["usuario"])) { 
    // Captura o email do usuário logado a partir da variável de sessão
    $email = $_SESSION["usuario"]["email"]; 

    /*
     * Remove a sessão correspondente ao email no banco de dados
     * Esse comando SQL garante que a sessão seja excluída da tabela 'sessao'.
     */
    $sql = "DELETE FROM sessao WHERE email = ?";
    $stmt = $mysqli->prepare($sql); // Prepara a consulta para evitar ataques de SQL Injection

    if ($stmt) { 
        $stmt->bind_param("s", $email); // Associa o parâmetro '?' ao valor do email do usuário
        $stmt->execute(); // Executa o comando DELETE no banco
        $stmt->close(); // Fecha o statement para liberar recursos
    }

    /*
     * Encerra a sessão no navegador
     * session_unset() remove todas as variáveis armazenadas na sessão, enquanto session_destroy() encerra a sessão completamente.
     */
    session_unset(); 
    session_destroy(); 

    // Redireciona o usuário para a página de login após o logout
    header("Location: ../html/tela_login.html");
    exit(); // Garante que o script pare de executar após o redirecionamento
} else {
    /*
     * Caso o usuário não esteja logado (ou não exista uma sessão ativa),
     * ele será redirecionado para a página de login.
     */
    header("Location: ../html/tela_login.html");
    exit(); // Encerra a execução do script após o redirecionamento
}
?>