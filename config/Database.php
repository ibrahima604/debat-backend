<?php
require_once('vendor/autoload.php');
//Charger le fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
class Database{
    private $host;
    private $db_name;
    private $db_user;
    private $password;
    private $conn;
    public function __construct(){
        $this->host=getenv('DB_HOST');
        $this->db_name=getenv('DB_NAME');
        $this->db_user=getenv('DB_USER');
        $this->password=getenv('DB_PASSWORD');

    }
    public function getConnection(){
        try{
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->db_user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        }
        catch(PDOException $e){
            die('Error:'.$e->getMessage());

        }
    }
  
        
    }
    
