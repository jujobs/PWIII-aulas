<?php
require "Usuario.class.php";
$con = $usuario = new Usuario();

if(isset($_POST['nome'])){
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
}    

if(isset($_POST['cadastrar'])){

    if(!$con) {
        echo "<script>
        confirm('Erro ao conectar. Tente novamente mais tarde!')
        </script>";
    } else {
 
        $user = $usuario->chkUser($email);
        if($user){
            echo "<script>
            confirm('Email já cadastrado!')
            </script>";
        } else {
            $exito = $usuario->cadastrar($nome, $email, $senha);
            if($exito){
                echo "<script>confirm('Usuario inserido com sucesso!')</script>";
            } else{
                echo "<script>confirm('Erro ao cadastrar. Tente novamente mais tarde!')</script>";
            }
        }
    }
  
}    

if(isset($_POST['entrar'])){
    $user = $usuario->chkPass($email, $senha);
        if($user){
            echo "<pre>";
            var_dump($user);
        }
}
        

