<?php

    include("includes/dbconfig.php");

    if(isset($_POST['done'])){

            $email = $_POST['email'];
            $password = $_POST['password'];

            $auth = $firebase->getAuth();
            

            try {

                if ($auth->verifyPassword($email, $password)) {


                    $collection = "teacherTable/";
                    $teacherData = $database->getReference($collection)
                    ->orderByChild('email')
                    ->equalTo($email)
                    ->getvalue();
    
                    if($teacherData == null ){
    
                        echo "<script type='text/javascript'>alert('Your are not teacher .. try to login with student!')</script>";
                        echo "<meta http-equiv='refresh' content='2; URL=index.html' />";
                        
                    }
                    else{
    
                        
                        session_start();
                
                        //$_SESSION['firebase_user_id']=$user->id;
                        $_SESSION['email'] = $email; 
    
                        //var_dump($email);
    
                        header("Location:dashboard_teacher.php");
                        exit;    
    
    
                    }
                    
                }
                


            }catch(Exception $e){
                
                echo "<script type='text/javascript'>alert('Login Failed!')</script>";
                echo "<meta http-equiv='refresh' content='1; URL=index.html' />";

            }
            

    }

?>