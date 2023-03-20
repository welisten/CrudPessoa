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


    }

?>