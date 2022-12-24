<?php

require_once "db.php";
include "model/user.php";
include "model/movie.php";

session_start();

$db = new Db();

if (isset($_POST['key'])) {
    switch($_POST['key']){
        case 'login':
            if(isset($_POST['username']) && isset($_POST['password'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                $user = new User(null, $username, $password);
        
                $db->login($user);

                //header('Location: movieList.php');
            }
            break;
        case 'logout':
            $db->logout();
            break;    
        case 'addNew':
                $name = $_POST['name'];
                $language = $_POST['language'];
                $year = $_POST['year'];
                $running_time = intval($_POST['runningTime']);
                $user_id = intval($_SESSION['user_id']);
                $category_id = intval($_POST['selectedValue']);

                
                $movie = new Movie(null, $name, $language, $year, $running_time, $user_id, $category_id);
                
                $db->insert($movie);
            /*if(isset($_POST['name']) && isset($_POST['language']) && isset($_POST['year']) && isset($_POST['runningTime']) && isset($_POST['selectedValue']))
            {   
                
            }
            else
            {         
                echo 'Failed to add new movie!';
            }*/
            break;
        case 'getAllMovies':
            $db->getAllMovies();
            break;
        case 'getMovieById':
            if(isset($_POST['movieId']))
            {
                $id = $_POST['movieId'];
                $db->getMovieById($id);

            }
            else
            {         
                echo 'Failed to load movie data!';
            }
            break;
        case 'update':
            $id = $_POST['movieId'];
                $name = $_POST['name'];
                $language = $_POST['language'];
                $year = $_POST['year'];
                $running_time = intval($_POST['runningTime']);
                $user_id = intval($_SESSION['user_id']);
                $category_id = intval($_POST['selectedValue']);

               
                 $movie = new Movie(null, $name, $language, $year, $running_time, $user_id, $category_id);

                $db->update($id, $movie);
           /* if(isset($_POST['movieId']) && isset($_POST['name']) && isset($_POST['language']) && isset($_POST['year']) && isset($_POST['runningTime']) && isset($_POST['selectedValue']))
            {   
                
            }*/
            break;
        case 'deleteMovie':
            if(isset($_POST['movieId']))
            {
                $id = $_POST['movieId'];

                $db->delete($id);
            }
            break;
    }
}
?>