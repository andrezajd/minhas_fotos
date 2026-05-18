<?php
session_start();
// Se a sessão "logado" não existir, chuta o usuário de volta para o login
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<?php
include("conexao.php");

$sql = "SELECT * FROM fotos ORDER BY id DESC";
$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Fotos Preferidas</title>
    
    <!-- Bootstrap 5 (Opcional, mas útil para o form) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
    /* body {
    background: #111;
    color: white;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
} */
    body {
    background: #111;
    color: white;
    /* Aplica a fonte Poppins em todo o site */
    font-family: 'Poppins', sans-serif; 
    margin: 0;
    padding: 0;
    text-align: center;
}

/* TOPO */
/* .topo {
    text-align: center;
    padding: 20px 0;
    margin-bottom: 20px;
} */
    /* Deixa o título principal mais marcante */
.topo h1 {
    font-weight: 800;
    letter-spacing: 1px; /* Espaçamento elegante entre as letras */
}
/* Deixa o título do formulário e das fotos bonito */
.formulario h2, .descricao {
    font-weight: 600;
}

/* FORMULÁRIO (Fixo à Esquerda) */
.formulario {
    width: 300px;
    background: #1b1b1b;
    padding: 20px;
    border-radius: 15px;
    border: 2px solid deeppink;
    box-shadow: 0 0 10px deeppink;
    position: fixed;
    top: 76px;
    left: 20px;
    z-index: 100;
}
.formulario h2 {
    margin-top: 0;
    text-align: center;
}

/* GALERIA */
.galeria {
    margin-left: 340px; 
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}

/* CARD FOTO TOTALMENTE COMPACTO */
.card-foto {
    width: 220px;
    background: #1b1b1b;
    border-radius: 15px;
    overflow: hidden;
    border: 2px solid deeppink;
    box-shadow: 0 0 10px deeppink;
    transition: 0.3s;
    display: flex;
    flex-direction: column;
}
.card-foto:hover {
    transform: scale(1.03);
    box-shadow: 0 0 20px deeppink;
}

/* IMAGEM */
.card-foto img {
    width: 100%;
    height: 160px; /* Altura ideal para o card não ficar gigante */
    object-fit: cover;
    cursor: pointer;
    display: block;
}

/* CONTAINER DAS INFORMAÇÕES (Super Compacto) */
.info-card {
    padding: 8px 12px;
    text-align: center;
    background: #151515; /* Um tom levemente mais escuro para destacar a foto */
}

.descricao {
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; /* Se o texto for muito grande, coloca "..." automaticamente */
}

/* BOTÕES */
.acoes {
    display: flex;
    justify-content: center;
    gap: 15px;
}
.acoes a {
    text-decoration: none;
    font-size: 18px;
    transition: transform 0.2s;
}
.acoes a:hover {
    transform: scale(1.2); /* Dá um zoomzinho no emoji ao passar o mouse */
}

/* MODAL */
.modal-img {
    display: none;
    position: fixed;
    z-index: 999;
    padding-top: 40px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
}
.modal-img img {
    display: block;
    margin: auto;
    max-width: 85%;
    max-height: 85%;
    border-radius: 15px;
    border: 3px solid deeppink;
    box-shadow: 0 0 25px deeppink;
}
.fechar {
    position: absolute;
    top: 15px;
    right: 30px;
    font-size: 35px;
    color: white;
    cursor: pointer;
}

@media (max-width: 768px) {
    .formulario {
        position: relative;
        width: 100%;
        top: 0;
        left: 0;
        margin-bottom: 20px;
    }
    .galeria {
        margin-left: 0;
        justify-content: center;
    }
}
/* SETAS DE NAVEGAÇÃO DO MODAL */
.seta {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 50px;
    color: white;
    background: rgba(0, 0, 0, 0.5);
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.3s;
    user-select: none;
}

.seta:hover {
    background: deeppink;
    color: white;
}

.seta-esq {
    left: 20px;
}

.seta-dir {
    right: 20px;
}
</style>
</head>
<body>

<div class="topo">
    <h1>Minhas Fotos Preferidas</h1>
    <div style="text-align: right; padding: 10px;">
    <span>Olá, <strong><?php echo $_SESSION['nome_usuario']; ?></strong>!</span>
    <a href="logout.php" style="color: deeppink; margin-left: 15px; text-decoration: none; font-weight: bold;">Sair / Logout</a>
</div>
</div>

<div class="container-fluid">
    <!-- Formulário Fixo (Lateral) -->
    <div class="formulario">
        <h2> Fotos</h2>
        <?php if ($_SESSION['nome_usuario'] == 'Admin'): ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="descricao" class="form-control mb-3" placeholder="Descrição" required>
            <input type="file" name="foto[]" class="form-control mb-3" multiple required>
            <button type="submit" class="btn btn-danger w-100">Enviar</button>
        </form>
        <?php endif; ?>
    </div>

    <!-- Galeria de Fotos -->
    <div class="galeria">
    <?php 
    $imagensJavaScript = []; // Array auxiliar para o JavaScript
    $index = 0;
    
    while($dados = mysqli_fetch_assoc($resultado)): 
        $caminhoImagem = "uploads/" . $dados['imagem'];
        $imagensJavaScript[] = $caminhoImagem; // Guarda o caminho da foto
    ?>
        <div class="card-foto">
            <img src="<?php echo $caminhoImagem; ?>" alt="Foto" onclick="abrirModal(<?php echo $index; ?>)" onerror="this.src='https://placehold.co/220x160/1b1b1b/deeppink?text=Erro+na+Imagem'">
            
            <div class="info-card">
                <div class="descricao">
                    <?php echo htmlspecialchars($dados['descricao']); ?>
                </div>
                
                <div class="acoes">
                    <a href="#" onclick="abrirModal(<?php echo $index; ?>); return false;" title="Visualizar Detalhes">🔍</a>
                    <?php if ($_SESSION['nome_usuario'] == 'Admin'): ?>
                    <a href="excluir.php?id=<?php echo $dados['id']; ?>" title="Excluir Foto">🗑️</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php 
        $index++;
    endwhile; 
    ?>
</div>

<div class="modal-img" id="modal">
    <span class="fechar" onclick="fecharModal()">&times;</span>
    
    <button class="seta seta-esq" onclick="mudarFoto(-1)">&#10094;</button>
    <button class="seta seta-dir" onclick="mudarFoto(1)">&#10095;</button>
    
    <img id="imgModal" alt="Imagem Ampliada">
</div>
<script>
// Passa o array de imagens do PHP direto para o JavaScript
const listaImagens = <?php echo json_encode($imagensJavaScript); ?>;
let fotoAtualIndex = 0;

function abrirModal(index){
    // Se a imagem estiver quebrada ou não houver lista, não abre
    if (listaImagens.length === 0) return;
    
    fotoAtualIndex = index;
    document.getElementById("modal").style.display = "block";
    document.getElementById("imgModal").src = listaImagens[fotoAtualIndex];
}

function fecharModal(){
    document.getElementById("modal").style.display = "none";
}

function mudarFoto(direcao) {
    // Soma ou subtrai o index
    fotoAtualIndex += direcao;
    
    // Se chegar no final da galeria, volta para a primeira foto
    if (fotoAtualIndex >= listaImagens.length) {
        fotoAtualIndex = 0;
    }
    // Se voltar antes da primeira foto, vai para a última
    if (fotoAtualIndex < 0) {
        fotoAtualIndex = listaImagens.length - 1;
    }
    
    // Atualiza a imagem do modal
    document.getElementById("imgModal").src = listaImagens[fotoAtualIndex];
}

// Fechar o modal se o usuário clicar no fundo escuro
window.onclick = function(event) {
    var modal = document.getElementById("modal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// BÔNUS: Permite passar as fotos também usando as setas do teclado!
document.addEventListener('keydown', function(event) {
    var modal = document.getElementById("modal");
    if (modal.style.display === "block") {
        if (event.key === "ArrowLeft") {
            mudarFoto(-1); // Seta esquerda do teclado
        } else if (event.key === "ArrowRight") {
            mudarFoto(1);  // Seta direita do teclado
        } else if (event.key === "Escape") {
            fecharModal();  // Tecla Esc fecha o modal
        }
    }
});
</script>

</body>
</html>