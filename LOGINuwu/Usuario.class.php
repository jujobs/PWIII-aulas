<?php
class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;    
    private $pdo;

    public function __construct(){
        $dns    = "mysql:dbname=usuarioetimpwiii;host=localhost"; 
        $dbUser = "root";
        $dbPass = "12345678";
        
        try {
            $this->pdo = new PDO($dns, $dbUser, $dbPass);           
            return true;
        } catch (\Throwable $th) {           
            return false;
        }   
    }

    public function cadastrar($nome, $email, $senha){
        //primeiro passo: criar a consulta sql
        $sql = "INSERT INTO usuarios SET nome = :n, email = :e, senha = :s";
        
        //segundo passo: passar a consulta para o metdo prepare do PDO
        $stmt = $this->pdo->prepare($sql);

        //terceiro passo: para cada apelido, passar o valor correspondente
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":s", $senha);

        //quarto passo: executar o comando
        return $stmt->execute();
    }

    public function chkUser($email){
        //passo 1: criar a consulta sql
        $sql = "SELECT * FROM usuarios WHERE email = :e";

        //passo 2: passar a consulta para o método prepare do PDO
        $stmt = $this->pdo->prepare($sql);

        //passo 3: para cada apelido, passar o valor correspondente
        $stmt->bindValue(":e", $email);
        
        //passo 4: executar o comando
        $stmt->execute();

        if( $stmt->rowCount() > 0 ){
            return true;
        }else{
            return false;
        }    
    }

    public function chkPass($email, $senha){
        //passo 1: criar a consulta sql
        $sql = "SELECT * FROM usuarios WHERE email = :e AND senha = :s";

        //passo 2: passar a consulta para o método prepare do PDO
        $stmt = $this->pdo->prepare($sql);

        //passo 3: para cada apelido, passar o valor correspondente
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":s", $senha);
        
        //passo 4: executar o comando
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return $stmt->fetch();
        }else{
            return false;
        }     
    }

    public function getUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $dados = $sql->fetchAll();
        } else {
            $dados = array();
        }
        
        return $dados;

    }

    public function excluirUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql); // <- corrigido aqui
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }    

    public function getUsuarioById($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function atualizarUsuario($id, $nome, $email, $senha) {
        $sql = "UPDATE usuarios SET nome = :n, email = :e, senha = :s WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':n', $nome);
        $stmt->bindParam(':e', $email);
        $stmt->bindParam(':s', $senha);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }      

}