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

        $collection = "studentTable/";
        
        $studenttable = $database->getReference($collection)
        ->orderByChild('email')
        ->equalTo($email)
        ->getvalue();

        if($studenttable == null){

           

            try{

                $auth = $firebase->getAuth();
                $user = $auth->createUserWithEmailAndPassword($email,$password);
                
                $postdata = $database->getReference($collection)->push($data);

                echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
                // header("Location:index.html"); 


            }catch(Exception $e){
                echo "<script type='text/javascript'>alert('something went wrong!')</script>";
            }finally{
                echo "<script>window.location.href='index.html'</script>";
            }

        }
        else{

            $flag = "false";

            foreach($studenttable as $studenttoken => $studentkey){

                if($studentkey['email'] == $email ){

                    $flag = "true";

                }

            }

            if($flag == "true"){
                echo "<script type='text/javascript'>alert('Email already in use!')</script>";
                echo "<script>window.location.href='index.html'</script>";
            }
            else{

                $postdata = $database->getReference($collection)->push($data);

                try{

                    $auth = $firebase->getAuth();
                    $user = $auth->createUserWithEmailAndPassword($email,$password);    

                    echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
                    // header("Location : index.html"); 


                }catch(Exception $e){
                    echo "<script type='text/javascript'>alert('something went wrong!')</script>";
                }
                finally{
                    echo "<script>window.location.href='index.html'</script>";
                }


            }


        }

       



    }


?>