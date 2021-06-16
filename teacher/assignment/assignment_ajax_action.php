<?php

    include("../../includes/dbconfig.php");

    if(isset($_POST['page'])){

        if($_POST['page'] == 'assignments'){

            if($_POST['action'] == 'assignmarks'){

                // echo "helo";
                // echo $_POST['classcode']." ". $_POST['assignmenttitle']." ".$_POST['studentemail']." ". $_POST['marks'];

                $studentdata = $database->getReference('studentTable/')
                ->orderByChild('email')
                ->equalTo($_POST['studentemail'])
                ->getvalue();

                foreach($studentdata as $studenttoken => $studentkey){

                    if($studentkey['email'] == $_POST['studentemail']){

                        $studentassignmentdata = $database->getReference('studentTable/'.$studenttoken."/assignedHomework")
                        ->getvalue();

                        if($studentassignmentdata !== null){

                            foreach($studentassignmentdata as $studentassignmenttoken => $studentassignmentkey){

                                if($studentassignmentkey['classcode'] == $_POST['classcode'] and $studentassignmentkey['assignmenttitle'] == $_POST['assignmenttitle'] ){

                                    $update = [
                                        'marksobtain' => (int)$_POST['marks'],
                                        'status' => 'marked'
                                    ];

                                    try{

                                        $database->getReference('studentTable/'.$studenttoken."/assignedHomework/".$studentassignmenttoken)->update($update);
                                        echo "Done";

                                    }catch(Exception $e){
                                        echo "</br>Error";
                                        echo "<script type='text/javascript'>alert('Something went wrong!')</script>";
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