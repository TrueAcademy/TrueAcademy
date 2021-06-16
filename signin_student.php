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

            try{

                if ($auth->verifyPassword($email, $password)) {

                    $collection = "studentTable/";
                    $studentData = $database->getReference($collection)
                    ->orderByChild('email')
                    ->equalTo($email)
                    ->getvalue();
    
                    if($studentData == null ){
    
                        echo "<script type='text/javascript'>alert('Sorry! Teacher can't be signin as student ... ')</script>";
                        //header("Location:index.html");
                        echo "<meta http-equiv='refresh' content='1; URL=index.html' />";
                        
                    }
                    else{
    
                        
                        session_start();
                
                        //$_SESSION['firebase_user_id']=$user->id;
                        $_SESSION['email'] = $email; 
    
                        //var_dump($email);
    
                        header("Location:dashboard_student.php");
                        exit;    
    
    
                    }
                }
                
                

            }
            catch(Exception $e){
                echo "<script type='text/javascript'>alert('Login Failed!')</script>";
                echo "<meta http-equiv='refresh' content='2; URL=index.html' />";
            }

    }

?>