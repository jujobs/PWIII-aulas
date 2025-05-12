<?php
require "Usuario.class.php";

if(isset($_POST['nome'])){
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //echo "Nome $nome, email $email, senha $senha";

    $con = $usuario = new Usuario();

    if(!$con){
        echo "<script>
                 confirm('Erro ao conectar. Tente mais tarde!')
              </script>";   
    }else{
        $exito = $usuario->cadastrar($nome, $email, $senha);
        if($exito){
            echo "<script>
                 confirm('Usuario inserido com sucesso!')
              </script>";   
        }else{
            echo "<script>
                 confirm('Erro ao CADASTRAR. Tente mais tarde!')
              </script>";   
        }

    }
}
   
