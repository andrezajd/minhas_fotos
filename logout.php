<?php
session_start();
session_unset(); // Limpa todas as variáveis de sessão
session_destroy(); // Destrói a sessão completamente

// Redireciona para a página de login
header("Location: login.php");
exit;
?>