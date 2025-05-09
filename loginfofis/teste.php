<?php

require 'Usuario.class.php';

$con = $usuario = new Usuario(); 

if(isset($_POST['nome'])){
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
}
if(isset($_POST['cadastrar'])){
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];


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
                echo "<script>
                    confirm('Usuario inserido com sucesso!')
                </script>";
            } else{
                echo "<script>
                confirm('Erro ao cadastrar. Tente novamente mais tarde!')
            </script>";
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
// $resultado = $usuario->cadastrar($_POST["name"],$_POST[ "email"], $_POST["senha"]);
// if($resultado == true) {
//      echo"
//      <script>
//          alert('Registro inserido com sucesso')
//      </script>";    
// }

//  $dados = $usuario->checkPassUser($email, $senha);
//  if(!empty($dados)){
//      echo"
//      <script>
//          alert('Usuario ja EXISTE!')
//      </script>";    
//  }else{
//      echo"
//      <script>
//          alert('Logado com sucesso!')
//      </script>";    
//  }

//  if ($_POST["name"] !='' && $_POST["email"] && $_POST["senha"]) {
//      $resultado = $usuario->insertUser($_POST["name"], $_POST["email"]);
//      echo "
//      <script>
//          alert('Registro não feito')
//      </script>";
//  }