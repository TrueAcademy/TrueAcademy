<?php 

    include("includes/dbconfig.php");

    

    if(isset($_POST['done'])){

        $classcode = $_POST["classcode"];
        
     
        $collection = "/classes";

        $classdata = $database->getReference($collection)
        ->orderByChild('classcode')  // 
        ->equalTo($classcode)
        ->getValue();

       
        
        if($classdata == null){
            echo "class not found!";
        }
        else {

                session_start();
                

                // echo "Email : ". $_SESSION['email'];

                echo "class found!";

                $collection = "studentTable/";
                $studentData = $database->getReference($collection)
                ->orderByChild('email')
                ->equalTo($_SESSION['email'])
                ->getvalue();

               
                

                foreach($studentData as $token => $key ){
               
                    if($key['email'] == $_SESSION['email'] ){


                        $studentToken = $collection.$token."/classjoined";
                        $joinedclass = [
                            'classcode' => $classcode
                        ];

                         $database->getReference($studentToken)->push($joinedclass);
 
                            

                        // Classes
                        foreach($classdata as $classtoken => $classkey){

                            $totaljoin = $classkey['totalJoined']+1;
                 
                            $updateField = [
                                'totalJoined' => $totaljoin
                            ];


                            
                            $newtoken = "classes/".$classtoken."/JoinedStudent";
                            $data = [
                                'studentemail' => $_SESSION['email']
                            ];
                            $database->getReference($newtoken)->push($data); 

                            try{
                                
                                $database->getReference('classes/'.$classtoken)->update($updateField);
                            
                                echo "<script type='text/javascript'>alert('class joined successfully!')</script>";

                            }
                             catch(Exception $e){
                                echo "<script type='text/javascript'>alert('something went wrong! please try again ... ')</script>";
                            }
                            finally{
                                header("Location:dashboard_student.php");
                            }

                        }

                        

                    }

                }


            

               

                


        }
            
    }


?>