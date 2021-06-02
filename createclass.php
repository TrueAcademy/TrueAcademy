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
            

            $collection = "teacherTable/";
            $teacherData = $database->getReference($collection)
                ->orderByChild('email')
                ->equalTo($_SESSION['email'])
                ->getvalue();

            echo $teacherData;

            foreach($teacherData as $token => $key){

                if($key['email'] == $_SESSION['email'] ){

                    $newToken = $collection.$token."/classcreated";

                    echo $newToken;
                    
                    $data = [
                        'classcode' => $classcode
                    ];

                    $database->getReference($newToken)->push($data);
                   
                }

            }

            echo "<script type='text/javascript'>alert('class created successfully!')</script>";
            header("Location:dashboard_teacher.php");
        
        }
        catch(Exception $e){
            // echo "<script type='text/javascript'>alert('something went wrong! please try again ... ')</script>";
        }

        
        



    }

?>