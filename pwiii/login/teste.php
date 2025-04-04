<?php

require 'Usuario.class.php';

$usuario = new Usuario();

$resultado = $usuario->cadastrar($_POST["name"],$_POST[ "email"], $_POST["senha"]);
if($resultado == true) {
     echo"
     <script>
         alert('Registro inserido com sucesso')
     </script>";    
}

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