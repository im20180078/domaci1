<?php

class Db{
    public $conn;

    function __construct(){

        $this->conn=new mysqli('localhost','root','','domaci1');

        if($this->conn->connect_errno){
            exit("Connection failed: " . $this->conn->connect_error);
        }

    }


    //Login

    public function login(User $user){

        $username = $this->conn->real_escape_string($user->username);
        $password = $this->conn->real_escape_string($user->password);

        $data = $this->conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

        if($data->num_rows == 0){
            $query = $this->conn->query("INSERT INTO users (username,password) VALUES('$username', '$password')");

            if($query){
                $this->setUser($username, $password);
                exit('success');
            }
            else{
                exit('Failed to login!');
            }
        }
        else if($data->num_rows > 0){
            $this->setUser($username, $password);
            exit('success');
        }
        else{
            exit('Failed to login!');
        }

    }

    private function setUser($username, $password){
        $sql = $this->conn->query("SELECT id FROM users WHERE username='$username' AND password='$password'");
        $result = $sql->fetch_row();
        $_SESSION['user_id'] = $result[0];
        $_SESSION['username'] = $username;
    }

    //logout  

    public function logout(){

        unset($_SESSION['loggedIn']);
        session_destroy();
        exit('success');

    }





}
?>