<?php

require_once "model/dataToReturn.php"

?>

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
                
               // header('Location: movieList.php');
                
                exit('success');
                 
            }
            else{
                exit('Failed to login!');
            }
        }
        else if($data->num_rows > 0 ){
            $this->setUser($username, $password);
            exit('success');
        }
        else{
            exit('Failed to login, username already exist');
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

    //insert
    public function insert(Movie $movie){
        $name = $this->conn->real_escape_string($movie->name);
        $language = $this->conn->real_escape_string($movie->language);
        $year = $movie->year;
        $running_time = $movie->running_time;
        $user_id = $movie->user_id;
        $category_id = $movie->category_id;

        $data = $this->conn->query("SELECT * FROM movies WHERE name='$name' AND language='$language'");

        if($data->num_rows > 0){
            exit("Movie with this name and on this language already exist");
        }
        else{
            $result = $this->conn->query("INSERT INTO movies(name, language, year, running_time, user_id, category_id) VALUES('$name', '$language', '$year', '$running_time', '$user_id', '$category_id')");

            if($result){
                exit('success');
            }
        }

    }

    //UPDATE
    public function update(int $id, Movie $movie){

        $name = $this->conn->real_escape_string($movie->name);
        $language = $this->conn->real_escape_string($movie->language);
        $year = $movie->year;
        $running_time = $movie->running_time;
        $user_id = $movie->user_id;
        $category_id = $movie->category_id;

        $data = $this->conn->query("UPDATE movies SET name='$name', language='$language', year='$year', running_time=$running_time, user_id=$user_id, category_id=$category_id WHERE id=$id");


        if($data){
            exit('success');
        }

    }

    //delete
    public function delete(int $id){
        $data = $this->conn->query("DELETE FROM movies WHERE id=$id");

        if($data){
            $data_to_return = array(
                'success'=>true,
                'message'=>'Successfully deleted'
            );
        }else{
            $data_to_return = array(
                'success'=>false,
                'message'=>'Error with deleting'
            );
        }

        exit(json_encode($data_to_return));
    }

    //get all
    public function getAllMovies(){
        $user_id=intval($_SESSION['user_id']);

        $data=$this->conn->query("SELECT id, name, language FROM movies WHERE user_id=$user_id");
        echo $numrows;
        $return_array = array();

        if($data->num_rows>0){
            while($row = $data->fetch_array()){
                $row_array['id'] = intval($row['id']);
                $row_array['name'] = $row['name'];
                $row_array['language'] = $row['language'];

                array_push($return_array, $row_array);
            }

            $data_to_return = new DataToReturn();
            $data_to_return->data = $return_array;
            $_SESSION['json_data'] = json_encode($data_to_return);
            exit("success");
        }
        else{
            $_SESSION['json_data'] = json_encode($return_array);
        }

    }

    //get by id
    public function getMovieById(int $id){
        $data = $this->conn->query("SELECT * FROM movies WHERE id=$id");

        $result = $data->fetch_array();

        $data_to_return = array(
            'name'=>$result['name'],
            'language'=>$result['language'],
            'year'=>$result['year'],
            'runningTime'=>$result['running_time'],
            'category'=>$result['category_id']
        );

        exit(json_encode($data_to_return));
    }


    //getCategories
    public function getCategories(){
        $user_id=intval($_SESSION['user_id']);
        
       $data=$this->conn->query("SELECT c.name AS category, COUNT(*) AS number FROM movies m JOIN categories c ON (m.category_id=c.id) WHERE m.user_id = $user_id GROUP BY m.category_id");
        
        return $data;

    }


}
?>