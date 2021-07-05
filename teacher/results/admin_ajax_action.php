<?php

    include("../../includes/dbconfig.php");

    if(isset($_POST['page'])){

        if($_POST['page'] == "viewresults"){

            if($_POST['action'] == "publishresults"){

                // echo "exam title = ". $_POST['examtitle'];
                // echo "classcode = ".  $_POST['classcode'];

                $examtitle = $_POST['examtitle'];
                $classcode = $_POST['classcode'];
                

                $classdata = $database->getReference('classes/')
                ->orderByChild('classcode')
                ->equalTo($classcode)
                ->getvalue();

                foreach($classdata as $classtoken => $classkey){

                    // var_dump($classkey);

                    if(strcmp($classkey['classcode'],$classcode) == 0 ){

                        $joindata = $database->getReference('classes/'.$classtoken.'/JoinedStudent')->getvalue();


                        foreach($joindata as $joindatatoken => $joindatakey){

                            // var_dump($joindatakey);    

                            $studentTableData = $database->getReference('studentTable/')
                            ->orderbychild('email')
                            ->equalTo($joindatakey['studentemail'])
                            ->getvalue();

                            foreach($studentTableData as $studenTabletoken => $studentTablekey){

                                // var_dump($studentTablekey);

                                $studentexamdata = $database->getReference("studentTable/".$studenTabletoken."/assignedExam")->getvalue();
                                // var_dump($studentexamdata);

                                if($studentexamdata == null){


                                }
                                else{

                                    foreach($studentexamdata as $studentexamtoken => $studentexamkey){

                                        // var_dump($studentexamkey['attandance']);

                                        if( strcmp($studentexamkey['examtitle'],$examtitle) == 0  and strcmp($studentexamkey['classcode'],$classcode) == 0   ){


                                            if($studentexamkey['attandance'] == 'attended' and $studentexamkey['resultcalculated'] == 'false' ){


                                                                                            
                                                $quesdata = $database->getReference("Exam/")
                                                ->orderByChild("classcode")
                                                ->equalto($classcode)
                                                ->getvalue();

                                                foreach($quesdata as $questoken => $queskey){

                                                    if(strcmp($queskey['examtitle'],$examtitle) == 0 ){

                                                        $answer = $database->getReference("Exam/".$questoken."/questions")->getvalue();

                                                        foreach($answer as $answertoken => $answerkey){

                                                            // var_dump($answerkey);
                                                            $answersheet = $database->getReference("studentTable/".$studenTabletoken."/assignedExam/".$studentexamtoken."/results/answersheet" )->getvalue();
                                                            // var_dump($answersheet[1]);

                                                            $totalcorrect = 0;

                                                            for($question_id=1; $question_id<=10; $question_id++){



                                                                // echo $answersheet[$question_id]
                                                                if($answersheet[$question_id] == ''){

                                                                    $update = [
                                                                        $question_id => "Not Attended"
                                                                    ];
                                                                    try{
                                                                        $database->getReference("studentTable/".$studenTabletoken."/assignedExam/".$studentexamtoken."/results/answersheet" )->update($update);
                                                                    }catch(Exception $e){

                                                                    }

                                                                }elseif( strcmp( $answersheet[$question_id], $answerkey[$question_id]['answer'] ) == 0  ){

                                                                    $totalcorrect = $totalcorrect + 1;
                                                                }

                                                            }

                                                            $update = [
                                                                'marks' => $totalcorrect,
                                                                'totalcorrect' => $totalcorrect
                                                            ];

                                                            var_dump($update);

                                                            try{
                                                                $resultupdate = [
                                                                    'resultdecleared' => "true"
                                                                ];
                                                                $database->getReference('Exam/'.$questoken)->update($resultupdate);
                                                                $database->getReference("studentTable/".$studenTabletoken."/assignedExam/".$studentexamtoken."/results")->update($update);
                                                                $update1 = [
                                                                    'resultcalculated' => 'true'
                                                                ];
                                                                $database->getReference("studentTable/".$studenTabletoken."/assignedExam/".$studentexamtoken)->update($update1);

                                                            }
                                                            catch(Exception $e){
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

                    }

                }

                

            }

        }

    }


?>