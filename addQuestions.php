<?php

    include("includes/dbconfig.php");

    if(true){

        $file = $_FILES["file"]["tmp_name"];

        if($_FILES["file"]["size"] > 0){

            //    echo "file upload done!";
            $quesfile = fopen($file,'r');
            
            while(($getData = fgetcsv($quesfile, 10000, ",")) !== FALSE){

                // echo $getData[0];
                // echo $getData[1];
                // echo $getData[2];
                // echo $getData[3];
                // echo $getData[4];

                
                $data = [
                    'question' => $getData[0],
                    'option 1' => $getData[1],
                    'option 2' => $getData[2],
                    'option 3' => $getData[3],
                    'option 4' => $getData[4],
                    'answer' => $getData[5]
                ];



                echo "</br>";

                var_dump($data);

                
            }

        }

    }


?>