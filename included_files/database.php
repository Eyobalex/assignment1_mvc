<?php
/**
 * Created by Eyob.
 * Date: 8/23/2018
 * Time: 4:15 AM
 */


class MySQLDatabase{

    private $connection;
    private $last_query;
    function __construct($username, $password, $database_name)
    {
        $this->open_connection($username, $password, $database_name);
    }
    public function open_connection($username, $password, $database_name) {
        $this->connection = mysqli_connect("localhost", $username, $password,$database_name);
        if (!$this->connection){
            die("Database connection failed: ".mysqli_error($this->connection));
        }
    }
    public function close_connection() {
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }
    public function query($sql){
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }
    public function escape_value($string) {
        $escaped_string = mysqli_real_escape_string($this->connection, $string);
        return $escaped_string;
    }
    public function fetch_assoc($result){
        return mysqli_fetch_assoc($result);
    }
    public function num_rows($result){
        return mysqli_num_rows($result);
    }
    public function insert_id(){
        return mysqli_insert_id($this->connection);
    }
    public function affected_rows(){
        return mysqli_affected_rows($this->connection);
    }
    private function confirm_query($result) {
        if (!$result) {
            $output = "Database query failed: " . mysqli_error($this->connection) . "<br><br>";
            $output.= "Last SQL query: " . $this->last_query;
            die($output);
        }
    }
}

$database = new MySQLDatabase("root", "", "photo_upload");