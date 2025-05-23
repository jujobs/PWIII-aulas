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
    <title>Document</title>
</head>
<body>

    <div class="tudinho">
        <form action = "teste.php" method = "post">
            <input type="text" name="nome" placeholder="Digite um Nome">
            <input type="text" name="email" placeholder="Digite um Email">
            <input type="password" name="senha" placeholder="Digite um Senha">

            <input class="botao" type="submit" value = "Cadastrar" name="cadastrar">
        </form>
    </div>
     
</body>
</html>