<?php
session_start();
require "Usuario.class.php";

$usuario = new Usuario();

if(isset($_POST['entrar'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $user = $usuario->chkPass($email, $senha);

    if($user){
        // Login ok, salva os dados na sessão (exemplo: id e nome)
        $_SESSION['id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['email'] = $user['email'];

        // Redireciona para a página de registros
        header("Location: mostrar_registros.php");
        exit();
    } else {
        $erro = "Email ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Login</title>
</head>
<script>
  setTimeout(() => {
    const erro = document.querySelector('.mensagem-erro');
    if (erro) erro.style.display = 'none';
  }, 4000);
</script>
<body>

    <div class="conteudo">
    <div class="brilho">

    <div class="parte-secundaria">
            <div class="titulo">
                <h1>INSCREVA-SE AGORA</h1>
            </div>
                <div class="textinhos">
                    <p>Faça parte da nossa família e desfrute de vários benefícios!</p>
                    <p>Ainda não é usuário? <a href="login.php">Faça já seu cadastro.</a></p>
                </div>
            <img class="gatito" src="images/3.png" alt="">
        </div>

        <div class="formularios">
            <h1>Fazer login</h1>

            <?php if(!empty($erro)): ?>
        <div class="mensagem-erro">
            <?= htmlspecialchars($erro) ?>
        </div>
    <?php endif; ?>

            <form method="post" action="">
                <input type="email" name="email" placeholder="Digite seu email" required /><br>
                <input type="password" name="senha" placeholder="Digite sua senha" required /><br>
                <input type="submit" class="botao" name="entrar" value="Entrar" />
            </form>
        </div>
    </div>    
    </div>
</body>
</html>
