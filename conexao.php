<?php

$host = "localhost";
$usuario = "root";
$senha = "usbw"; 
$banco = "minhas_fotos"; 

// Criando a conexão
$conexao = mysqli_connect($host, $usuario, $senha, $banco);

// Verifica se deu algum erro na conexão
if (!$conexao) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

// Configura o banco para aceitar acentos corretamente (UTF-8)
mysqli_set_charset($conexao, "utf8");
?>