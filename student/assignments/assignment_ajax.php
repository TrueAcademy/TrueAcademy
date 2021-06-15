<?php

    session_start();
    include("../../includes/dbconfig.php");


    if(isset($_POST['page'])){


        if($_POST['page'] == "viewassignments"){

            if($_POST['action'] == 'submitassignment' ){

                // echo "email = ". $_POST['classcode'];
                // echo "title = ". $_POST['assignmenttitle'];

                $studentdata = $database->getReference('studentTable/')
                ->orderByChild('email')
                ->equalTo($_POST['email'])
                ->getvalue();

                foreach($studentdata as $studenttoken => $studentkey){

                    if($studentkey['email'] == $_POST['email']){

                        $studentassignmentdata = $database->getReference('studentTable/'.$studenttoken.'/assignedHomework')->getvalue();

                        if($studentassignmentdata == null){

                            echo "<script type='text/javascript'> alert('Data not recorded!') </scripy> ";

                        }
                        else{

                            foreach($studentassignmentdata as $studentassignmenttoken => $studentassignmentkey){

                                echo $studentassignmentkey['assignmenttitle'];

                                if($studentassignmentkey['assignmenttitle'] == $_POST['assignmenttitle'] and $studentassignmentkey['classcode'] == $_POST['classcode']  ){

                                    echo "In if";

                                    try{

                                        $update = [
                                            'submission' => 'true'
                                        ];

                                        $database->getReference('studentTable/'. $studenttoken ."/assignedHomework/". $studentassignmenttoken)->update($update);


                                        $assignmentdata = $database->getReference('assignments/')
                                        ->orderByChild('classcode')
                                        ->equalTo($_POST['classcode'])
                                        ->getvalue();

                                        foreach($assignmentdata as $assignmenttoken => $assignmentkey){

                                            if($assignmentkey['assignmenttitle'] == $_POST['assignmenttitle'] ){

                                                $temp =$assignmentkey['totalsubmission'] + 1;
                                                $data = [
                                                    'totalsubmission' => $temp
                                                ];

                                                $database->getReference('assignments/'.$assignmenttoken)->update($data);

                                            }

                                        }


                                    }catch(Exception $e){
                                        echo "<script type='text/javascript'> alert('Data not recorded! Something went wrong ... ') </scripy> ";
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