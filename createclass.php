<?php

    include("includes/dbconfig.php");

    

    if(isset($_POST['createclass'])){


        session_start();

        $classcode = $_POST["classcode"];
        $classname = $_POST["classname"];

        // $classcode = "test123";
        // $classname = "create class";

        $collection = "classes/";

        $email = $_SESSION['email'];

        //var_dump($email);

        $data = [
            'classowner' => $email,
            'classcode' => $classcode,
            'classname' => $classname
        ];

        try {

            $postdata = $database->getReference($collection)->push($data);
            echo "<script type='text/javascript'>alert('class created successfully!')</script>";
            header("Location:dashboard_teacher.php");
        
        }
        catch(Exception $e){
            echo "<script type='text/javascript'>alert('something went wrong! please try again ... ')</script>";
        }

        
        



    }

?>