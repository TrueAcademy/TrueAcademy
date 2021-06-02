<?php

    include("includes/dbconfig.php");

    if(isset($_POST['done'])){

            $email = $_POST['email'];
            $password = $_POST['password'];

            // $ref = "teacherTable/";
            // $fetchdata = $database ->getReference($ref) ->getValue();

            $auth = $firebase->getAuth();
            // $user = $auth->getUserWithEmailAndPassword($email,$password);

            // if($user!=null){
            //     session_start();
            //     $_SESSION['user'] = true;
                
            // }

            if ($auth->verifyPassword($email, $password)) {
                session_start();
            
                $_SESSION['email'] = $email;
            
                header("Location:dashboard_student.php");
                exit;
            }
            

    }

?>