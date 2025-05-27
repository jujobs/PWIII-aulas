<?php
require 'Usuario.class.php';

$usuario = new Usuario();

// Verifica se tem um ID na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os dados atuais do usuário
    $dados = $usuario->getUsuarioById($id);

    if (!$dados) {
        echo "Usuário não encontrado.";
        exit;
    }
} else {
    echo "ID não informado.";
    exit;
}

// Se o formulário foi enviado:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoNome  = $_POST['nome'];
    $novoEmail = $_POST['email'];

    $novaSenha = $_POST['senha'];
    $usuario->atualizarUsuario($id, $novoNome, $novoEmail, $novaSenha);
    
    // Redireciona após salvar
    header("Location: mostrar_registros.php");
    exit;
}
?>

<!-- Formulário de edição -->

<link rel="stylesheet" href="css/editar.css">


<form method="POST">
    
    <div class="titulo">Alterar dados</div>

    <label>Digite o novo nome:</label>
    <input type="text" name="nome" value="<?= $dados['nome'] ?>" required><br>

    <label>Digite o novo Email:</label>
    <input type="email" name="email" value="<?= $dados['email'] ?>" required><br>

    <label>Digite a nova senha:</label>
    <input type="password" name="senha" required><br>

    <button type="submit">Salvar</button>

</form>
