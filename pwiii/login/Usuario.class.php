<?php
class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;    
    private $pdo;

    public function __construct(){
        $dns    = "mysql:dbname=Usuario;host=localhost"; 
        $dbUser = "root";
        $dbPass = "";
        try {
            $this->pdo = new PDO($dns, $dbUser, $dbPass);
            echo "<h1>Conectado ao banco! Seu Lindao ^^</h1>";
            return true;
        } catch (\Throwable $th) {
            echo "<h1>Erro ao conectar ao banco! burrinho! :P</h1>";
            return false;
        }
       
    }


    public function cadastrar($nome, $email, $senha) {
        //primeiro passo: criar a consulta sql
        $sql = "INSERT INTO usuarios SET nome = :n, email = :e, senha = :s";
        //segundo passo: passar a consulta para o metodo prepare do PDO
        $stmt = $this->pdo->prepare($sql);
        //terceiro passo para cada apelido passar o valor correspondente
        $stmt->bindValue(":n",$nome);
        $stmt->bindValue(":e",$email);
        $stmt->bindValue(":s",$senha);
        $ChkUser = $this->ChkUser($email);
        if ($ChkUser){
            Echo "naooooo esse usuario ja existe:/";
            return false;
        } else {
            return $stmt->execute();
        }
        //quarto passo executar
        
    }

    public function ChkUser($email) {
        $sql = "SELECT * FROM usuarios WHERE email=:e";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":e",$email);

         $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true; 
        } else {
            return false;
        }    
    }

    public function ChkPass($senha, $email) {
        $sql = "SELECT * FROM usuarios WHERE email=:e and senha=:s";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":e",$email);

        $usuario = $stmt->execute();
        if (!empty($usuario)) {
            return true; 
        } else {
            return false;
        }    
    }

}