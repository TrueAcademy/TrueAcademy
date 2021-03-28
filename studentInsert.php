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
        $postdata = $database->getReference($collection)->push($data);

        try{

            $auth = $firebase->getAuth();
            $user = $auth->createUserWithEmailAndPassword($email,$password);    

            echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
            header("Location : index.html"); 


        }catch(Exception $e){
            echo "<script type='text/javascript'>alert('something went wrong!')</script>";
        }

       

        // if($postdata){
        //     echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
        //     header("Location : index.html"); 
        // }
        // else{
        //     echo "<script type='text/javascript'>alert('failed! try again .... ')</script>";
        // }



    }


?>