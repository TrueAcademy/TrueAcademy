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

                        $studentjoindata = $database->getReference($studentToken)->getvalue();

                        if($studentjoindata == null){


                            
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
                                
                                
                                }
                                catch(Exception $e){
                                    echo "<script type='text/javascript'>alert('something went wrong! please try again ... ')</script>";
                                }
                                
                            }

                            $examdata = $database->getReference('Exam/')
                            ->orderByChild('classcode')
                            ->equalTo($classcode)
                            ->getvalue();

                            if($examdata == null){
                                header("Location:dashboard_student.php");
                            }
                            else{
                                foreach($examdata as $examtoken => $examkey){

                                    if($examkey['classcode'] == $classcode and new Datetime($examkey['examdate']) >= new DateTime(date("Y-m-d"),new DateTimeZone('Asia/Calcutta')) ){
                                        // echo "push data";
                                        $data = [
                                            'examtitle' => $examkey['examtitle'],
                                            'examdate' => $examkey['examdate'],
                                            'examiner' => $examkey['examiner'],
                                            'classcode' => $classcode,
                                            'attandance' => "No attended"
                                        ];
        
                                        try{
                                            $database->getReference('studentTable/'.$token.'/assignedExam')->push($data);
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
                        else{

                            $flag = "false";
                            foreach($studentjoindata as $studentjointoken => $studentjoinkey){


                                if($studentjoinkey['classcode'] == $classcode ){

                                    $flag="true";
                                    break;

                                }


                            }

                            if($flag == "true"){
                                echo "<script>alert('You already joined this class ... ')</script>";
                                echo "<script>window.location.href='joinclass.php'</script>";
                            }else{

                                            
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
                                        
                                        
                                    }
                                    catch(Exception $e){
                                        echo "<script type='text/javascript'>alert('something went wrong! please try again ... ')</script>";
                                    }
                                        
                                }

                                $examdata = $database->getReference('Exam/')
                                ->orderByChild('classcode')
                                ->equalTo($classcode)
                                ->getvalue();

                                if($examdata == null){
                                    header("Location:dashboard_student.php");
                                }
                                else{

                                    foreach($examdata as $examtoken => $examkey){

                                        if($examkey['classcode'] == $classcode and new Datetime($examkey['examdate']) >= new DateTime(date("Y-m-d"),new DateTimeZone('Asia/Calcutta')) ){
                                            // echo "push data";
                                            $data = [
                                                'examtitle' => $examkey['examtitle'],
                                                'examdate' => $examkey['examdate'],
                                                'examiner' => $examkey['examiner'],
                                                'classcode' => $classcode,
                                                'attandance' => "No attended",
                                                'resultcalculated' => 'false'
                                            ];
                
                                            try{
                                                $database->getReference('studentTable/'.$token.'/assignedExam')->push($data);
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

                        

                    }

                }


            

               

                


        }
            
    }


?>