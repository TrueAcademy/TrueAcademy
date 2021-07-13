<?php

    include("../../includes/dbconfig.php");

    session_start();

    if(isset($_POST['createExam'])){

        $examiner = $_SESSION['email'];
        $examtitle = $_POST['exam_title'];
        $course = $_POST['course_name'];
        $classcode = $_POST['classcode'];
        $timeduration = $_POST['timeduration'];  // 10 Mins
        $questionno = $_POST['questionno'];
        $examdate = $_POST["examdate"];
        $starttime = $_POST["starttime"];
        $examtype = $_POST["examtype"];
        $status = "Not Held";

        $collection = "Exam/";

        // echo "</br>Examiner = ".$examiner;
        // echo "</br>exam title = ".$examtitle;
        // echo "</br>course =".$course;
        // echo "</br>classcode = ". $classcode;
        // echo "</br>timeduration = ". $timeduration;
        // echo "</br>questionno = ". $questionno;
        // echo "</br>examdate = ". $examdate;
        // echo "</br>starttime = ". $starttime;
        // echo "</br>examtype = ". $examtype;

        // echo "</br>examdate = ". $examdate;
        // echo "current date = ". date("Y-m-d");

        if($examdate < date("Y-m-d") and $starttime <= time()){

            echo "Exam cant be created as time and date is over!";
            echo "<script>window.location.href='../examdashboard.php?classcode=".$classcode."'</script>";

        }else{

            $endtime = new DateTime($starttime);
            $endtime->add(new DateInterval("PT".$timeduration."S"));

            $data = [
                "examiner" => $examiner,
                "examtitle" => $examtitle,
                "course" => $course,
                "classcode" => $classcode,
                "timeduration" => $timeduration,
                "examdate" => $examdate,
                "starttime" => $starttime,
                "questionno" => $questionno,
                "endtime" => $endtime->format("H:i"),
                "examtype" => $examtype,
                "status" => $status,
                "resultdecleared" => "false" 
            ];
            
            $examtable = $database->getReference('Exam/')
            ->orderByChild('examtitle')
            ->equalTo($examtitle)
            ->getvalue();

            if($examtable == null){

                
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
                    $database->getReference($teacherExamCollection)->push($data);
        
                }
        
                // Updating student data
                $collection = "studentTable/";
                $studentData = $database->getReference($collection)->getvalue();
        
                foreach($studentData as $token => $key){
        
                    $subcollection = $collection.$token."/classjoined";
                    $classdata1 = $database->getReference($subcollection)->getvalue();
        
                    if($classdata1 != null){

                        foreach($classdata1 as $classtoken => $classkey){
        
                            // echo $classkey['classcode']."\n";
            
                            if($classkey['classcode'] == $classcode){
            
                                // echo $classkey['classcode']."\n";
            
                                // var_dump($key['email']);
            
            
                                $studentToken = $collection.$token."/assignedExam"; 
                                $examdata = [
                                    'examtitle' => $examtitle,
                                    'examdate' => $examdate,
                                    'examiner' => $examiner,
                                    'classcode' => $classcode,
                                    'attandance' => "No attended",
                                    'resultcalculated' => 'false'
                                ];
                                $database->getReference($studentToken)->push($examdata); 
            
                            }
            
                        }

                    }
        
                }

                // Adding info to classes
                $collection = "classes/";
                $classref = $database->getReference($collection)
                ->orderByChild('classcode')
                ->equalTo($classcode)
                ->getvalue();

                foreach($classref as $classreftoken => $classrefkey){

                    $examdata = [
                        'examtitle' => $examtitle,
                        'examdate' => $examdate,
                        'examiner' => $examiner
                    ];

                    
                    $totalexam = [
                        'totalExamConducted' => $classrefkey['totalExamConducted']+1
                    ];

                    // echo "<script type='text/javascript'>alert('class created successfully!')</script>";

                    try{

                        $database->getReference($collection.$classreftoken)->update($totalexam);

                        $database->getReference($collection.$classreftoken."/ExamForClass")->push($data);


                    }
                    catch(Exception $e){

                    }
                    
                }



            }else{

                $flag = "false";

                foreach($examtable as $examtabletoken => $examtablekey){

                    if($examtablekey['examtitle'] == $examtitle and $examtablekey['classcode'] == $classcode ){
                        $flag = "true";
                    }

                }

                if($flag == "true"){
                    echo "<script type='text/javascript'>alert('Exam title in exists!')</script>";
                    echo "<script>window.location.href='../examdashboard.php?classcode=".$classcode."'</script>";
                }
                else{

                    
                     
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
                        $database->getReference($teacherExamCollection)->push($data);
            
                    }
            
                    // Updating student data
                    $collection = "studentTable/";
                    $studentData = $database->getReference($collection)->getvalue();
            
                    foreach($studentData as $token => $key){
            
                        $subcollection = $collection.$token."/classjoined";
                        $classdata1 = $database->getReference($subcollection)->getvalue();
            
                        if($classdata1 != null){

                            foreach($classdata1 as $classtoken => $classkey){
            
                                // echo $classkey['classcode']."\n";
                
                                if($classkey['classcode'] == $classcode){
                
                                    // echo $classkey['classcode']."\n";
                
                                    // var_dump($key['email']);
                
                
                                    $studentToken = $collection.$token."/assignedExam"; 
                                    $examdata = [
                                        'examtitle' => $examtitle,
                                        'examdate' => $examdate,
                                        'examiner' => $examiner,
                                        'classcode' => $classcode,
                                        'attandance' => "No attended"
                                    ];
                                    $database->getReference($studentToken)->push($examdata); 
                
                                }
                
                            }

                        }
            
                    }

                    // Adding info to classes
                    $collection = "classes/";
                    $classref = $database->getReference($collection)
                    ->orderByChild('classcode')
                    ->equalTo($classcode)
                    ->getvalue();

                    foreach($classref as $classreftoken => $classrefkey){

                        $examdata = [
                            'examtitle' => $examtitle,
                            'examdate' => $examdate,
                            'examiner' => $examiner
                        ];

                        
                        $totalexam = [
                            'totalExamConducted' => $classrefkey['totalExamConducted']+1
                        ];

                        // echo "<script type='text/javascript'>alert('class created successfully!')</script>";

                        try{

                            $database->getReference($collection.$classreftoken)->update($totalexam);

                            $database->getReference($collection.$classreftoken."/ExamForClass")->push($data);


                        }
                        catch(Exception $e){

                        }
                        
                    }

                }




                


            }

        }

        



    }


?>


<?php

    
    if( $_SESSION['email'] == null ){

        echo "<script type='text/javascript'>alert('Cant open user is not authorized!')</script>";
        header("Location:index.html"); 

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Exam</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../css/sidebar.css"/>
    <link rel="stylesheet" href="../../css/navbar.css"/>
    <link rel="stylesheet" href="css/stylespage.css"/>
    <link rel="stylesheet" href="css/cards.css"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

<div class="navbar">
        <div class="left_div">

            <button class="menu-toggler" onclick="showdiv()">
                <span onclick="removediv()"></span>
                <span></span>
                <span onclick="removediv()"></span>
            </button>

            <a href="#" class="logo_url"><img src="../../images/logo.png" alt="logo" class="logo"></a>
            <h1 class="h1">True Academy</h1>
        </div>
        <div class="right_div">
            <a href="#" class="profile"><i class="fas fa-user"></i></a>

            <div class="profile_li">
                <a href="#" class="PROFILE">Profile</a>
                <a href="#" class="LOGOUT">Logout</a>
            </div>
            <h3 class="login_name"> <?php echo $_SESSION['email'] ?> </h3>
        </div>
    </div>
    

    <div class="main_container" style="height:80vh;">
        <div class="left_div2" id="welcomediv" style="height: auto;">

            <div class="close_button" onclick="removediv()">
                <a href="#" class="close_btn_teacher" id="close_btn"><i id="close" class="far fa-times-circle"></i></a>
            </div>

            <div class="profile_name">
                <div class="imagediv" >
                    <img src="../../images/person.png" alt="">
                </div>
                <h3><?php echo $_SESSION['email'] ?></h3>
                <h6>student</h6>
            </div>

            <div class="side_btn">
                <a href="exam/createExam.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Create Exam</span></a>
                <a href="#"><i class="fas fa-cogs"></i><span>Manage Exam</span></a>
                <a href="results/viewresults.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-table"></i><span>View Result</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Delete Exam</span></a>
            </div>

        </div>

        <div class="right_div2" style="display:flex;align-items:center;justify-content:center;width:900px;margin-right:300px;height
        100vh">
      <div style="background:white; width:100%;">
                <h3 style="text-align:center; margin-left:30px"> Select The file </h3>   

                <div style="margin-left:50px; margin-top:30px">

                    <form action="addquestions.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="classcode" value="<?php echo $_POST['classcode'] ?> ">
                        <input type="hidden" name="examtitle" value="<?php echo $examtitle?>" >
                        Select file : <input type="file" name="file"/></br>
                        <button type="submit" name="addquestions">submit</button>
                    </form>

                </div>  
                
                <div style="margin-left:50px;margin-top:30px">
                    <p>
                        Note :</br> 
                            <i style="font-size:10px;" class="fas fa-circle"></i> Please Select the file of your questions and answers.</br>
                            <i style="font-size:10px;" class="fas fa-circle"></i> The Column 'A' is states the questions. Column 'B' 'C' 'D' and 'E' states options.</br>
                            <i style="font-size:10px;" class="fas fa-circle"></i> The Column 'F' states the answer.</br>
                            <i style="font-size:10px;" class="fas fa-circle"></i> Dont give option latter, instead use whole answer only.</br> 
                    </p>
                </div>
                

            </div>




</div>

    <script>
        function showdiv() {
            document.getElementById('welcomediv').style.display = "block";
        }

        function removediv() {
            document.getElementById('welcomediv').style.display = "none";
        }
    </script>

</body>
</html>