<?php
require 'Usuario.class.php';

$sucesso = $usuario = new Usuario();

if( $sucesso ){ 

}else{
    echo "<h1>Banco indisponivel. Tente mais tarde";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Cadastrar</title>
</head>
<body>

    <div class="conteudo">
<div class="brilho">
        <div class="parte-secundaria">
            <div class="titulo">
                <h1>INSCREVA-SE AGORA</h1>
            </div>
                <div class="textinhos">
                    <p>Faça parte da nossa família e desfrute de vários benefícios!</p>
                    <p>Já é usuário? <a href="login_real.php">Faça já seu login.</a></p>
                </div>
            <img class="gatito" src="images/3.png" alt="">
        </div>

        <div class="formularios">
            <h1>Inscrever-se</h1>
            <form action = "teste.php" method = "post">
                <input type="text" name="nome" placeholder="Digite um Nome">
                <input type="text" name="email" placeholder="Digite um Email">
                <input type="password" name="senha" placeholder="Digite uma Senha">

                <input class="botao" type="submit" value = "Cadastrar" name="cadastrar">
            </form>
        </div>
</div>
    </div>
     
</body>
</html>