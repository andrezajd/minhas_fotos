<?php

session_start();
// Se não estiver logado OU se quem estiver logado NÃO for o admin, chuta para o login
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['nome_usuario'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

include("conexao.php");

// Pega a descrição que você digitou no formulário
$descricao = $_POST['descricao'];

// Recebe o array com as fotos
$arquivos = $_FILES['foto'];

// Verifica se realmente foi enviado algum arquivo
if (isset($arquivos['name']) && is_array($arquivos['name'])) {
    
    // Conta quantas fotos foram selecionadas
    $totalArquivos = count($arquivos['name']);

    // Faz o laço para rodar o código para cada uma das fotos
    for ($i = 0; $i < $totalArquivos; $i++) {
        
        // Pega os dados da foto atual do laço usando o índice [$i]
        $nome = $arquivos['name'][$i];
        $tmp = $arquivos['tmp_name'][$i];

        // Se o nome estiver vazio (nenhum arquivo nessa posição), pula para o próximo
        if (empty($nome)) {
            continue;
        }

        // Pega a extensão do arquivo atual
        $extensao = strtolower(
            pathinfo($nome, PATHINFO_EXTENSION)
        );

        // Validação do seu professor para os formatos aceitos
        if($extensao == "jpg" || $extensao == "jpeg" || $extensao == "png"){

            // Cria o novo nome usando o tempo + o número da foto (para não duplicar nomes iguais no mesmo segundo)
            $novoNome = time() . "_" . $i . "." . $extensao;

            // Move a foto para a pasta uploads/
            move_uploaded_file(
                $tmp,
                "uploads/" . $novoNome
            );

            // Insere a foto no banco de dados e coloca a descrição que você digitou
            $sql = "INSERT INTO fotos(imagem, descricao) VALUES('$novoNome','$descricao')";
            
            mysqli_query($conexao, $sql);
        }
    }
}

// Depois que enviar todas, volta para a página principal
header("Location:index.php");
?>