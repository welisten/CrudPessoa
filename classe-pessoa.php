<?php
$servidor = "localhost";
$bancoDados = "crudpdo";
$usuario = "postgres";
$senha = "welisten369";


    Class Pessoa{
        private $pdo;
        //  possuirá 6 métodos


        //1° - construtor (Conexão com Banco de dados)
        public function __construct($servidor, $bancoDados, $usuario, $senha)
        {
            try{
                 //sgbd:host;port;bdname
                 //usuario
                 //senha
                 //errmode
                $this->pdo = new PDO("pgsql:host=$servidor;port=5432;dbname=$bancoDados", $usuario, $senha, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);   
            } 
            catch(PDOException $e) {
                echo"Erro com o Banco de Dados: ".$e->getMessage();
                exit();
            }
            catch(Exception $e) {
                echo"Erro genérico: ".$e->getMessage();
                exit();
            }
        }

        //2° buscar os dados no banco de dados(colocar no canto direito da tela)
        public function buscarDados()
        {
            $resp = array();
            $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
            $resp = $cmd->fetchAll(PDO::FETCH_ASSOC); 
            return $resp;
        }

        //3° botão cadastrar
        //função de cadastrar a pessoa no Banco de dados
        public function cadastrarPessoa($nome, $telefone, $email)
        {   
            //ANTES DE CADASTRAR VAMOS VERIFICAR SE JÁ POSSUI EMAIL CADASTRADO
            $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            if($cmd->rowCount() > 0)// EMAIL JA EXISTE
            {

                return false;
            } else // caso contrario
                {
                //Cadatra a Pessoa
                $cmd = $this->pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES (:n, :t, :e)");
                $cmd->bindValue(":n", $nome);
                $cmd->bindValue(":t", $telefone);
                $cmd->bindValue(":e", $email);
                $cmd->execute();
                return true;

            }
        }
        // FUNÇÃO REFERENTE AO BOTÃO DE EXCLUSÃO
        public function excluirPessoa($id)
        {
            $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }

        //BUSCAR DADOS DE UMA PESSOA
        // 5
        public function buscarDadosPessoa($id)
        {
            $resp = array();
            $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id= :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $resp = $cmd->fetch(PDO::FETCH_ASSOC);
            return $resp;
 
        }

        //ATUALIZAR DADOS NO bANCO DE DADOS
        // 6
        public function altualizarDados($id, $nome, $telefone, $email)
        {   

            $cmd = $this->pdo->prepare("UPDATE pessoa SET nome= :n, telefone= :t , email= :e WHERE id= :id");
            $cmd->bindValue(":id", $id);
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            return true;

        }
    }

?>