
 <?php   
 /*inclusão do arquivo class.php e istanciamento da classe conexão com a passagem dos parametros do banco de dados*/ 

 require_once 'class.php';
 
 $p = new conexao("crud_op", "localhost", "root", "");



 ?>

<!doctype html>
<html lang="pt-br">
  <head>
    <title>CRUD com php pdo</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="Stilo.css">

  </head>
  <body>

    <div>
    
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
       
  <?php 
  //.....................ao clicar no botão cadastrar ou atualizar...................
     if(isset($_POST['cnome'])){ 
       //.......................ATUALIZAR.......................
         if(isset($_GET['id_up']) && !empty($_GET['id_up'])){

          $id_update = addslashes($_GET['id_up']);
          $Nome = addslashes($_POST['cnome']);
          $Telefone = addslashes($_POST['ctel']);
          $Email = addslashes($_POST['cemail']);
      
      $p->atualizar_dados($id_update, $Nome, $Telefone, $Email);
      header("location: index.php");
        
    

     //...................CADASTRAR...........................................
   } else{
          $Nome = addslashes($_POST['cnome']);
          $Telefone = addslashes($_POST['ctel']);
          $Email = addslashes($_POST['cemail']);

                /*    outro metodp que funciona
                 $Nome = filter_input(INPUT_POST,'cnome');
                 $Telefone = filter_input(INPUT_POST,'ctel');
                 $Email = filter_input(INPUT_POST,'cemail');
               */
      
      $p->cad_usuario($Nome, $Telefone, $Email);
         
         
   }
 }   
?>    

<?php 
     /*VERIFICA SE CLICOU NO BOTÃO EDITAR*/
     if(isset($_GET['id_up'])){
           $id_update = addslashes($_GET['id_up']);
           $res = $p->buscar_edit($id_update);
     }
?>
   
<section id="formu">
    <form action="" method="POST">
        <h2>CADASTRO DE USUÁRIOS</h2>
           <label for="nome"> Nome</label>
           <input type="text" id="nome" name="cnome" size="40" maxlength="40" placeholder="Seu nome" required
           value="<?php if(isset($res) && count($res) > 0) {echo $res['Nome'];} ?>">

           <label for="tel"> Telefone</label>
           <input type="tel" id="tel" name="ctel" size="20" maxlength="13" placeholder="Seu Telefone" required
           value="<?php if(isset($res)  && count($res) > 0) {echo $res['Telefone'];} ?>">

           <label for="email"> E-mail</label>
           <input type="email" id="email" name="cemail" size="50" maxlength="50" placeholder="Seu E-mail" required
           value="<?php if(isset($res)  && count($res) > 0) {echo $res['Email'];} ?>">

           <input type="submit" id="enviar" value="<?php if(isset($res)){
             echo "Atualizar";
           }else{ echo "Cadastrar";} ?>">
       </form>

</section>  



<section id="exibir">
    <table>
        <tr id="titulo">
            <td>Nome</td>            
            <td>Telefone</td>
            <td colspan="2">E-mail</td>   
        </tr>

   <?php 
   $dados = $p->buscarDados();
   if(count($dados) >0){
     for($i=0; $i < count($dados); $i++){
            echo "<tr>";

       foreach($dados[$i] as $coluna => $value){
         if($coluna != "id"){
            
          echo "<td>".$value."</td>";
       }
       }
       ?>

       <td>             
          <a href="index.php?id_up=<?php echo $dados[$i] ['id']; ?>">Atualizar</a> 
       
          <a href="index.php?id=<?php echo $dados[$i] ['id']; ?>">Excluir</a> 

        </td>
       <?php
       echo "</tr>";
      
     }
    
   } else{
     echo "Ainda nao há usuários cadastrados!";
   }


   ?>
</section>
</table>



<?php 
if(isset($_GET['id'])){
       $id_user = addslashes($_GET['id']);
       $p->excluir($id_user);
      header("location: index.php"); /* 'die' solução para o erro*/
      
     }
?>

</div>
  </body>
</html>

