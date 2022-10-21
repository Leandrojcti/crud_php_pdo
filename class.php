<?php 

//CLASSE DE CONEXÃO COM O BANCO DE DADOS E FUNÇOES 

class conexao{
   
    private $con;
   

 public function __construct($dbname, $host, $user, $senha) {
        
        try{
            $this->con = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $senha);   
             
           // PDO("mysql: dbname=" . $dbname . "; host =" . $host, $user, $senha); -> modo incorreto 

            
            
        } 
        //CATCH PARA TRATAR ERRO NO BANCO DE DADOS  
        catch(PDOException $erro){
             echo "erro com banco de dados:" . $erro->getMessage();
             exit();
        } 
        //CATCH PARA TRATAR ERRO GENERICO
        catch(Exception $erro){
            echo "erro generico:" . $erro->getMessage();
            exit();
        }
     } 

     



       


     //função para buscar os dados no Banco
public function buscarDados(){
        $cmd = $this->con->prepare("SELECT * FROM ob_tabela; ");
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }




    //função para cadastar os dados no banco
public function cad_usuario($Nome, $Telefone, $Email) {
        
        $cmd = $this->con->prepare("INSERT INTO ob_tabela (Nome, Telefone, Email) VALUES (:n, :t, :e)");
        $cmd->bindValue(":n" , $Nome);
        $cmd->bindValue(":t" , $Telefone);
        $cmd->bindValue(":e" , $Email);
        $cmd->execute();
        return true;
    
}
     //função para excluir
public function excluir($id){
    $cmd = $this->con->prepare("DELETE FROM ob_tabela WHERE id = :id");
    $cmd->bindValue(":id", $id); 
    $cmd->execute();

}

     //Função para buscar os dados para atualizar
public function buscar_edit($id){
     $result = array();
     $cmd = $this->con->prepare("SELECT * FROM ob_tabela WHERE id = :id");
     $cmd->bindValue(":id",$id);
     $cmd->execute();
     $result = $cmd->fetch (PDO::FETCH_ASSOC);
     return $result;

}


     //função para atualizar os dados
public function atualizar_dados($id, $Nome, $Telefone, $Email){
       $cmd = $this->con->prepare("UPDATE ob_tabela SET Nome = :n, Telefone = :t,Email = :e WHERE id= :id");
       $cmd->bindValue(":n", $Nome);
       $cmd->bindValue(":t", $Telefone);
       $cmd->bindValue(":e", $Email);
       $cmd->bindValue(":id",$id);
       $cmd->execute();
       return true;
}


}



