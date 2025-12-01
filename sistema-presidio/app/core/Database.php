<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "sistema_presidio";
    private $port = "3306"; 

    protected $dbh;
    protected $stmt;

    public function __construct() {
        // String de Conexão (DSN)
        // Adicionei ';port=' . $this->port para garantir que conecte na porta certa
        $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname . ';charset=utf8';
        
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Criar instância do PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            // Se der erro, para tudo e mostra a mensagem
            die("Erro na conexão com o Banco de Dados: " . $e->getMessage());
        }
    }

    // Preparar query
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Vincular valores (para evitar SQL Injection)
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Executar a query
    public function execute() {
        return $this->stmt->execute();
    }

    // Obter vários resultados (ex: lista de produtos)
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Obter um único resultado (ex: login de usuário)
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    
    // Obter o ID do último item inserido
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }
}
