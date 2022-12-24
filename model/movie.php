<?php
    class Movie{
        public $id;
        public $name;
        public $language;
        public $year;
        public $running_time;       
        public $user_id;
        public $category_id;

        public function __construct($id=null, $name=null, $language=null, $year=null, $running_time, $user_id, $category_id){
            $this->id=$id;
            $this->name=$name;
            $this->language=$language;
            $this->year=$year;
            $this->running_time=$running_time;
            $this->user_id=$user_id;
            $this->category_id=$category_id;
        }

    }

?>