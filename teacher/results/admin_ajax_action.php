<?php

    include("../../includes/dbconfig.php");

    if(isset($_POST['page'])){

        if($_POST['page'] == "viewresults"){

            if($_POST['action'] == "publishresults"){

                // echo "exam title = ". $_POST['examtitle'];
                // echo "classcode = ".  $_POST['classcode'];

                $examtitle = $_POST['examtitle'];
                $classcode = $_POST['classcode'];
                
                // echo "classcode = ". $classcode;

                $examdata = $database->getReference('Exam/')
                ->orderByChild('classcode')
                ->equalTo($classcode)
                ->getvalue();

                foreach($examdata as $examdatatoken => $examdatakey){

                    // var_dump($examdatakey);

                    if(strcmp($examdatakey['examtitle'],$examtitle) == 0 ){

                        $update = [
                            'resultdecleared' => "true"
                        ];

                        $database->getReference('Exam/'.$examdatatoken)->update($update);
                      

                    }

                }

            }

        }

    }


?>