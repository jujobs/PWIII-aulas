<?php
require 'Usuario.class.php';

$sucesso = $usuario = new Usuario();

if( $sucesso ){

}else{
        echo "<script>alert('tem banco não');</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=in, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <div class="titulo">
        <h1">Cadastre-se</h1>
    </div>


    <div class="login">
   <form action="teste.php" method = "post">


        <input type="text" name="name" placeholder="Digite um nome">
        <input type="text" name="email" placeholder="Digite um email">
        <input type="password" name="senha" placeholder="Digite um senha">

    <input class="botao" type="submit" name="Cadastrar" value="Cadastrar">
    <input class="botao" type="submit" name="Entrar" value="Entrar">

    </div>
</form>

</body>
</html>