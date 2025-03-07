<?php
require 'Usuario.class.php';

$sucesso = $usuario = new Usuario();
if( $sucesso ){
    $user = $usuario->ChkUser("fabinho@gmail.com");
    if ($user){
        echo "<h1>cadastrado com sucesso! :3</h1>";
    } else {
        echo "<h1>Erros ao cadastrar!</h1>";
    }
}
