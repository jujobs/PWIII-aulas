<?php
session_start();

if(isset($_SESSION['nome']) ) {
    $nome = $_SESSION['nome'];
    echo "<h1>Bem vindo $nome";
}else{
    echo "<h1>Você não tá logado!";
}