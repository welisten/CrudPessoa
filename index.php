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
    <link rel="stylesheet" href="style.css">
    <title>CRUD-PESSOA</title>
</head>
<body>
    <section class="esquerda">
       <div class="esquerda_container">
            <h2 class="form_title">cadastrar pessoa</h2>
            <form action="">
                <label for="nome">nome</label>
                <input type="text" name="nome" id = "" placeholder="Digite seu Nome" >
                <label for="telefone">telefone</label>
                <input type="text" name="telefone" id = "" placeholder="(xx) xxxxx-xxxx" >
                <label for="email">email</label>
                <input type="text" name="email" id = "" placeholder="exemploemail@email.com">
                <input type="submit" value="cadastrar">
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
                                    <div class="btn"><a href="#">editar</a></div>
                                    <div class="btn"><a href="#">excluir</a></div>    
                                </td>
                            <?php
                            echo"</tr>";          
                        }
                    }
                ?>
            </table>
        </div>
    </section>
    
</body>
</html>