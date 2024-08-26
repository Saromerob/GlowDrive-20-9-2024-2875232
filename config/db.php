<?php
class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $caracteres;
//_construct: Dar valores a las variables de la clase "Database"
    public function __construct() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "autosplash";
        $this->caracteres = 'utf8';
    }
    public function conectar() {
            try {
                $urlConexion = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->caracteres;
                $opciones = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES  => false];
                $conn = new PDO($urlConexion, $this->username, $this->password, $opciones);
                return $conn;
            } catch(PDOException $error) {
                echo 'Error en la conexion:  '.$error->getMessage();
            }
        }
}
?>