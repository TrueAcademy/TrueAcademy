<?php

    include("../../includes/dbconfig.php");

    if(isset($_POST['addquestions'])){

        $file = $_FILES["file"]["tmp_name"];

        $classcode = $_POST['classcode'];
        $examtitle = $_POST['examtitle'];

        // echo "code = ".$classcode."title = ".$examtitle;

       

        if($_FILES["file"]["size"] > 0){

            //    echo "file upload done!";
            $quesfile = fopen($file,'r');
            
            $i=1;

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

                // var_dump($data);

                $maindata[$i] = $data; 
                $i++;
                    


                // echo "</br>";

                // var_dump($data);

                

                
            }

           

            $examdata = $database ->getReference('Exam/')
            ->orderByChild('classcode')
            ->equalTo(trim($classcode," "))
            ->getvalue();
    
            // var_dump($examdata);
    
            foreach($examdata as $examtoken => $examkey){

                echo "cmp = ".strcmp($examkey['examtitle'],$examtitle  );
    
                if(strcmp($examkey['examtitle'],$examtitle) == 0) {
                    
                    echo "Inside";
                    $examinnertoken = "Exam/".$examtoken."/questions";
                    $database->getReference($examinnertoken)->push($maindata);
                    echo "<script>window.location.href='../examdashboard.php?classcode=".$classcode."'</script>";
                }
    
            }
            
            // var_dump($maindata);
            
        }

    }


?>