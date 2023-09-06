<?php

    include_once '../lib/Database.php';
    include_once '../helpers/Format.php';
    

    class Register{

        public $db;
        public $fr;

        public function __construct()
        {
            $this->db = new Database();
            $this->fr = new Format();
        }

        public function AddUser($data){
            $name = $this->fr->validation($data['name']);
            $phone = $this->fr->validation($data['phone']);
            $email = $this->fr->validation($data['email']);
            $password = $this->fr->validation($data['password']);
            $v_token = md5(rand());

            // $e_query = "SELECT * FROM tbl_user WHERE email='$email'";
            // $check_query = $this->db->select($e_query);

            // if ($check_query > 0) {
            //     $error = "This Email Is Already Exisit";
            //     return $error;
            //     header('location:register.php');
            // }

            if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($v_token)) {
                $error = "Fild Must not Be Empty";
                return $error;
            }
        }
    }

?>