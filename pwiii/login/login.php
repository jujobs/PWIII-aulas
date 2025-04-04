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
        <img src="images/star.webp" alt="">
        <h1">Cadastre-se</h1>
        <img src="images/star.webp" alt="">
    </div>


    <div class="login">
   <form action="teste.php" method = "post">

        <img src="images/fudencio.jpg" alt="">

        <input type="text" name="name" placeholder="Digite um nome">
        <input type="text" name="email" placeholder="Digite um email">
        <input type="text" name="senha" placeholder="Digite um senha">

    <input class="botao" type="submit" value="Cadastrar">

    <img src="images/conrado." alt="">

    </div>
</form>

<img class="conrado" src="images/conrado.webp" alt="">
<img class="maria" src="images/zemaria.webp" alt="">

</body>
</html>