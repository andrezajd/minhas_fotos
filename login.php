<?php
include("conexao.php");
session_start();

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexao, $sql);
    
    if ($dados = mysqli_fetch_assoc($resultado)) {
        // Verifica se a senha digitada bate com a criptografada no banco
        if (password_verify($senha, $dados['senha'])) {
            $_SESSION['logado'] = true;
            $_SESSION['usuario_id'] = $dados['id'];
            $_SESSION['nome_usuario'] = $dados['usuario'];
            header("Location: index.php");
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Galeria Privada</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: #111;
            color: white;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .box-login {
            background: #1b1b1b;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 20, 147, 0.2);
            width: 300px;
            text-align: center;
        }
        h2 { color: deeppink; margin-bottom: 20px; }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #222;
            border: 1px solid #333;
            color: white;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input:focus { border-color: deeppink; outline: none; }
        button {
            background: deeppink;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        button:hover { background: #ff1493cc; }
        .erro { color: red; font-size: 14px; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="box-login">
    <h2>Área Restrita</h2>
    <?php if($erro != ""): ?>
        <div class="erro"><?php echo $erro; ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</div>

</body>
</html>