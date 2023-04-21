<?php
require_once 'classe-pessoa.php';
$p = new Pessoa($servidor, $bancoDados, $usuario, $senha);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>CRUD-PESSOA</title>
</head>
<body>
    <?php
        //-------------------- EXCLUIR ---------------------
        if(isset($_GET['id']))//verifica se a pessoa clicou no botão de excluir
        {
            $id_pessoa = addslashes($_GET['id']);
            $p->excluirPessoa($id_pessoa);
            header("location: index.php");
        }
        if(isset($_POST['nome']))// Verifica se a pessoa clicou no botão cadastrar ou editar
    {
        //-------------------- EDITAR ---------------------
        if(isset($_GET['id_up']) && !empty($_GET['id_up']))
        {
            $id_up      = addslashes($_GET['id_up']);
            $nome       = addslashes($_POST['nome']);
            $telefone   = addslashes($_POST['telefone']); 
            $email      = addslashes($_POST['email']);
            
            // verificar se as variaveis estão vazias, tornando-as assim, obrigatórias
            if( !empty($nome) && !empty($telefone) && !empty($email))
            {
                // ATUALIZAR
                $p->altualizarDados($id_up, $nome, $telefone, $email);
                header("location: index.php");
            }
            else
            {
                ?>
                <div class="aviso">
                    <img src="imgs/aviso.svg" alt="Alarme">
                    <h4>Preencha todos os campos!</h4>
                </div>
                <?php
            }
        }
        //------------------ CADASTRAR ---------------------
        else
        {
            $nome       = addslashes($_POST['nome']);
            $telefone   = addslashes($_POST['telefone']); 
            $email      = addslashes($_POST['email']);

            // verificar se as variaveis estão vazias, tornando-as assim, obrigatórias
            if( !empty($nome) && !empty($telefone) && !empty($email))
            {

                if(!$p->cadastrarPessoa($nome, $telefone, $email))
                {
                    ?>
                    <div class="aviso">
                        <img src="imgs/aviso.svg" alt="Alarme">
                        <h4>Email já está cadastrado</h4>
                    </div>
                    <?php
                }    
            }
            else
            {  
                
                ?>
                <div class="aviso">
                    <img src="imgs/aviso.svg" alt="Alarme">
                    <h4>Preencha todos os campos!</h4>
                </div>
                <?php
            }
        }   
    }
    ?>
    <?php 
        if(isset($_GET['id_up']))// Verifica se a pessoa clicou no botão editar
        {
            $id_up_pessoa = addslashes($_GET['id_up']);
            $resp = $p->buscarDadosPessoa($id_up_pessoa);
        }
    ?>
    <section class="esquerda">
       <div class="esquerda_container">
            
            <h2 class="form_title">cadastrar pessoa</h2>
            
            <form method="POST">
                <label for="nome">nome</label>
                <input  type="text" 
                        value="<?php if(isset($resp)){echo $resp['nome'];} ?>"
                        name="nome" 
                        id = "nome" 
                        placeholder="Digite seu Nome" >
                
                <label for="telefone">telefone</label>
                <input  type="text"
                        value="<?php if(isset($resp)){echo $resp['telefone'];} ?>" 
                        name="telefone"
                        id = "telefone" 
                        placeholder="(xx) xxxxx-xxxx" >
                
                <label for="email">email</label>
                <input  type="text"
                        value="<?php if(isset($resp)){echo $resp['email'];} ?>" 
                        name="email" 
                        id = "email" 
                        placeholder="exemploemail@email.com">
                
                <input  type="submit" 
                        value="<?php if(isset($resp)){echo "Atualizar";}else{echo "Cadastrar";} ?>">
            </form>
       </div>
    </section>
    <section class="direita"> 
        <div class="direita_container">
                <table>
                    <tr class="table_title">
                        <td>Nome</td>
                        <td>Telefone</td>
                        <td colspan="2">Email</td>
                    </tr>
                <?php
                    $dados = $p->buscarDados();
                    if(count($dados) > 0)
                    {
                        for($i = 0; $i < count($dados); $i ++)
                        {   
                            echo"<tr>";
                            foreach($dados[$i] as $k => $v)
                            {
                                if($k != "id")
                                {
                                    echo"<td>".$v."</td>";
                                }
                            }
                            ?> 
                        <td class="buttons">

                            <div class="btn">
                                <a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">editar</a>
                            </div>
                            <div class="btn">
                                <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">excluir</a>
                            </div>    

                        </td>
                            <?php
                                 echo"</tr>";          
                        }
                    }
                    else// O BANCO ESTÁ VAZIO
                    {
                    ?>
            </table>
            
            <div class="aviso">
            <h4>Ainda não há pessoas cadastradas</h4>
            </div>
            <?php
        }
         ?>
        </div>
    </section>
</body>
</html>
