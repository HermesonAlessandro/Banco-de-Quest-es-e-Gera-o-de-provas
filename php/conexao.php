<?php // Comando para inserir um código em php
$hostname = "localhost"; // Significa que a conexão vai ser local
$banco_de_dados = "concurs_bank"; // Nome do banco de dados
$usuario = "root"; // No caso significa um usuário que tem previlégios ilimitados
$senha = ""; // No caso como não foi definido nenhuma senha, significa que o usuário é sem senha
$porta = 3307; // Porta de conexão com o phpMyAdmin

$mysqli = new mysqli($hostname, $usuario, $senha, $banco_de_dados, $porta);
/*
Basicamente ele vai tentar estabelecer conexão com o banco de dados, se a conexão for bem estabelecida, a variável
$mysqli contera o objeto de conexão para interagir com o banco de dados: executar consultas, obter resultados.
Se a mesma falhar a propiedade connect_errno vai tratar esse erro do objeto $mysqli.
*/
if($mysqli -> connect_errno){
    echo "Falha ao se conectar: (".$mysqli -> connect_errno.")".$mysqli -> connect_error;
}else{
    echo "Banco conectado com sucesso";
}
/*
Basicamente, esse trecho de código está verificando se a conexão com o banco de dados foi estabelecida com sucesso ou não, 
e exibindo a mensagem correspondente.
*/
//Fechamento do código em php?>