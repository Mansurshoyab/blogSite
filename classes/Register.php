<?php

    include_once '../lib/Database.php';
    include_once '../helpers/Format.php';

    include_once'../PHPmailer/PHPMailer.php';
    include_once'../PHPmailer/SMTP.php';
    include_once'../PHPmailer/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    

    class Register{

        public $db;
        public $fr;

        public function __construct()
        {
            $this->db = new Database();
            $this->fr = new Format();
        }

        public function AddUser($data){

            function sendemail_varifi($name, $email, $v_token){
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth   = true;

                $mail->Host       = 'smtp.example.com';
                $mail->Username   = 'shoyabmolla420@gmail.com'; 
                $mail->Password   = 'Molla420'; 

                $mail->SMTPSecure = 'tls';  
                $mail->Port       = 587; 

                $mail->setFrom('shoyabmolla420@gmail.com', $name);
                $mail->addAddress($email);

                $mail->isHTML(true);   
                $mail->Subject = 'Email Verification form web master';

                $email_template = "
                <h2> You have rigister web master</h2>
                <h5> Verifi your email address to login please click the link below </h5>
                <a 'http://localhost/PHP-project/pweb/admin/verifi-email.php?token=$v_token'>Click Here</a>
                ";

                $mail->Body    = $email_template;
                $mail->send();
            };

            $name = $this->fr->validation($data['name']);
            $phone = $this->fr->validation($data['phone']);
            $email = $this->fr->validation($data['email']);
            $password = $this->fr->validation($data['password']);
            $v_token = md5(rand());



            if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($v_token)) {
                $error = "Fild Must not Be Empty";
                return $error;
            }else{
                $e_query = "SELECT * FROM tbl_user WHERE email='$email'";
                $check_query = $this->db->select($e_query);
    
                if ($check_query > 0) {
                    $error = "This Email Is Already Exisit";
                    return $error;
                    header('location:register.php');
                }else{
                    $insert_query = "INSERT INTO tbl_user(name, email, phone, password, v_token) value ('$name', '$email', '$phone', '$password', '$v_token')";

                    $insert_row = $this->db->insert($insert_query);

                    if ($insert_row) {
                        sendemail_varifi($name, $email, $v_token);
                        $success = "Resistration successful. Please check Your Email inbox for varifi email";
                        return $success;
                    }else{
                        $error = "Registration Failed";
                        return $error;
                    }
                }
            }
        }
    }

?>