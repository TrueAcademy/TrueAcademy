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

        $classdata = $database->getReference($collection)
        ->orderByChild('classcode')
        ->equalTo($classcode)
        ->getvalue();

        if($classdata == null){

            $totalJoined = 0;
            $totalExamCoducted = 0;
            $totalAssignmentGiven = 0;
            $totalstudymaterial = 0;

            $data = [
                'classowner' => $email,
                'classcode' => $classcode,
                'classname' => $classname,
                'totalJoined' => $totalJoined,
                'totalExamConducted' => $totalExamCoducted,
                'totalAssignmentGiven' => $totalAssignmentGiven,
                'totalstudymaterial' => $totalstudymaterial
            ];

            try {

                $postdata = $database->getReference($collection)->push($data);
                

                $collection = "teacherTable/";
                $teacherData = $database->getReference($collection)
                    ->orderByChild('email')
                    ->equalTo($_SESSION['email'])
                    ->getvalue();

                // echo $teacherData;

                foreach($teacherData as $token => $key){

                    if($key['email'] == $_SESSION['email'] ){

                        $newToken = $collection.$token."/classcreated";

                        // echo $newToken;
                        
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
            finally{
                header("Location:dashboard_teacher.php");
            }

        

        }
        else{

            $flag = "false";

            foreach($classdata as $classtoken => $classkey){

                if($classkey['classcode'] == $classcode ){
                    $flag = "true";
                }

            }

            if($flag == "true"){
                echo "<script>alert('You already created this class ... ')</script>";
                echo "<script>window.location.href='dashboard_teacher.php'</script>";
            }else{

                $totalJoined = 0;
                $totalExamCoducted = 0;
                $totalAssignmentGiven = 0;
                $totalstudymaterial = 0;

                $data = [
                    'classowner' => $email,
                    'classcode' => $classcode,
                    'classname' => $classname,
                    'totalJoined' => $totalJoined,
                    'totalExamConducted' => $totalExamCoducted,
                    'totalAssignmentGiven' => $totalAssignmentGiven,
                    'totalstudymaterial' => $totalstudymaterial
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
                    
                
                }
                catch(Exception $e){
                    // echo "<script type='text/javascript'>alert('something went wrong! please try again ... ')</script>";
                }
                finally{
                    header("Location:dashboard_teacher.php");
                }

            }

            


        }
        



    }

?>