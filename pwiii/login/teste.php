<?php

require 'Usuario.class.php';

if(isset($_POST['name'])){
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // echo "Nome $nome, email $email, senha $senha";

    $con = $usuario = new Usuario();

    if(!$con) {
        echo "<script>
        confirm('Erro ao conectar. Tente novamente mais tarde!')
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