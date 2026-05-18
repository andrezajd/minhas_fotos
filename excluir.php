
<?php
session_start();
// Se não estiver logado OU se quem estiver logado NÃO for o admin, chuta para o login
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['nome_usuario'] !== 'Admin') {
    header("Location: login.php");
    exit;
}



include("conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM fotos WHERE id = $id";

$resultado = mysqli_query($conexao, $sql);

$dados = mysqli_fetch_assoc($resultado);

unlink("uploads/" . $dados['imagem']);

$sqlExcluir = "DELETE FROM fotos WHERE id = $id";

mysqli_query($conexao, $sqlExcluir);

header("Location: index.php");

?>