<?php

    include("includes/dbconfig.php");

    if(true){

        $examiner = "sapkal.shubham2002@gmail.com"; 
        $examtitle = "test 1";
        $course = "ADT";
        $classcode = "CO16312";
        $timeduration = "1000";
        $questionno = "10";
        $examdate = "06/03/2021";
        $starttime = "15:00:00";
        $examtype = "objective";
        $status = "Yet to be Held";

        $collection = "Exam/";
        $data = [
            "examtitle" => $examtitle,
            "course" => $course,
            "classcode" => $classcode,
            "timeduration" => $timeduration,
            "examdate" => $examdate,
            "starttime" => $starttime,
            "examtype" => $examtype,
            "status" => $status 
        ];
        
        $createExam = $database->getReference($collection)->push($data);

        // updating teacher data 
        $collection = "teacherTable/";
        $teacherData = $database->getReference($collection)
        ->orderByChild('email')
        ->equalTo($examiner)
        ->getvalue();

        foreach($teacherData as $token => $key ){

            $teacherExamCollection = $collection.$token."/examcreated";
            $data = [
                'examtitle' => $examtitle,
                'classcode' => $classcode
            ];
            $database->getReferencse($teacherExamCollection)->push($data);

        }

        // Updating student data
        $collection = "studentTable/";
        $studentData = $database->getReference($collection)->getvalue();

        foreach($studentData as $token => $key){

            $subcollection = $collection.$token."/classjoined";
            $classdata1 = $database->getReference($subcollection)->getvalue();

            foreach($classdata1 as $classtoken => $classkey ){

                // echo $classkey['classcode']."\n";

                if($classkey['classcode'] == $classcode){

                    echo $classkey['classcode']."\n";

                    var_dump($key['email']);


                    $studentToken = $collection.$token."/assignedExam"; 
                    $examdata = [
                        'examtitle' => $examtitle,
                        'examdate' => $examdate,
                        'examiner' => $examiner
                    ];
                    $database->getReference($studentToken)->push($examdata); 

                }

            }

        }



    }


?>