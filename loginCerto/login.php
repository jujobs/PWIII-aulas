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
    <title>Document</title>
</head>
<body>
    <form action = "teste.php" method = "post">
        <input type="text" name="nome" placeholder="Digite um Nome">
        <input type="text" name="email" placeholder="Digite um Email">
        <input type="text" name="senha" placeholder="Digite um Senha">

        <input type="submit" value = "Cadastrar">
    </form> 
</body>
</html>