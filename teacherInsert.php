<?php

    include("includes/dbconfig.php");

    if(isset($_POST["done"])){

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $mobileno = $_POST['mobileno'];
        $gender = $_POST['gender'];
        $password = $_POST['password'];

        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'mobileno' => $mobileno,
            'gender' => $gender,
            'password' => $password,
        ];

        $collection = "teacherTable/";
        
        $teacherdata = $database->getReference($collection)
        ->orderByChild('email')
        ->equalTo($email)
        ->getvalue();

        if($teacherdata == null){

            $postdata = $database->getReference($collection)->push($data);
            try{

                $auth = $firebase->getAuth();
                $user = $auth->createUserWithEmailAndPassword($email,$password);  

                echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
                 

            }
            catch(exception $e){
                echo "<script type='text/javascript'>alert('Something went wrong! ')</script>";
            }
            finally{
                echo "<script>window.location.href='index.html'</script>";
            }

        }
        else{

            $flag = "false";
            foreach($teacherdata as $teachertoken => $teacherkey){

                if($teacherkey['email'] ==$email ){
                    $flag = "true";
                }

            }

            if($flag == "true"){
                echo "<script type='text/javascript'>alert('Email already in use!')</script>";
                echo "<script>window.location.href='index.html'</script>";
            }
            else{

               
                try{
    
                    $auth = $firebase->getAuth();
                    $user = $auth->createUserWithEmailAndPassword($email,$password);  

                    $postdata = $database->getReference($collection)->push($data);
    
                    echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
    
                }
                catch(exception $e){
                    echo "<script type='text/javascript'>alert('Something went wrong! ')</script>";
                }
                finally{
                    echo "<script>window.location.href='index.html'</script>";
                }

            }

        }

        


    }


?>