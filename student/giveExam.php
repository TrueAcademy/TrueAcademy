<?php

date_default_timezone_set("Asia/Calcutta");
include("../includes/dbconfig.php");
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/exam_question.css" />
    <link rel="stylesheet" href="../css/navstyle.css">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <title>exam</title>
</head>

<body>

    <nav class="navbar">
        <div class="left_div">
                <a href="#" class="hamberg"><i class="fas fa-bars"></i></a>
                <a href="#" class="logo_url"><img src="../images/logo.png" alt="logo" class="logo"></a>
                <h1 class="h1">True Academy</h1>
        </div>
        <div class="right_div">
            <a href="#" class="profile"><i class="fas fa-user"></i></a>
           
            <div class="profile_li">
                <a href="#" class="PROFILE">Profile</a>
                <a href="../logout.php" class="LOGOUT">Logout</a>  
            </div>
            <h4 class="login_name"> <?php echo $_SESSION['email']?> </h4>
        <div>
    </nav>

    <div class="main_container">
        
            <div class="main_left_div">
                <?php

                    

                    $examtitle = $_GET['examtitle'];
                    $classcode = $_GET['classcode'];

                    $examdata = $database->getReference("Exam/")
                    ->orderByChild("classcode")
                    ->equalTo($classcode)
                    ->getvalue();   

                    foreach($examdata as $examtoken => $examkey){

                        if(strcmp($examkey['examtitle'] , $examtitle ) == 0 ){

                            // $questiondata = $database->getReference("Exam/".$examtoken."/questions")->getvalue();
                            // var_dump($questiondata);

                            $examstatus = $examkey['status'];
                            $starttime = $examkey['starttime'];
                            $timeduration = $examkey['timeduration'];
                            $endtime = $examkey['endtime'];
                            $remaingingtime = strtotime($endtime) - time();

                        }

                    }

                    $studentdata = $database->getReference("studentTable/")
                    ->orderByChild("email")
                    ->equalTo($_SESSION['email'])
                    ->getvalue();

                    foreach($studentdata as $studenttoken => $studentkey){

                        if($studentkey['email'] == $_SESSION['email'] ){

                            $examassign = $database->getReference("studentTable/".$studenttoken."/assignedExam")->getvalue();

                            foreach($examassign as $examassigntoken => $examassignkey){

                                if(strcmp($examassignkey['examtitle'],$examtitle) == 0){
                                    $update = [
                                        'attendance' => "attended"
                                    ];
                                    try{
                                        $database->getReference("studentTable/".$studenttoken."/assignedExam".$examassigntoken)->update($update);
                                    }
                                    catch(Exception $e){

                                    }
                                    
                                }

                            }    

                        }

                    }
                
                ?>
                <div class="top">
                    <div class="ques">
                        <h4>This is question no 1?This is question no 1?This is question no 1?This is question no 1?This
                            is question no 1?This is question no 1?This is question no 1?This is question no 1?This is
                            question no 1?This is question no 1?</h4>
                    </div>
                </div>


                <div class="center">
                    <div class="question_left">
                        <li><input type="radio">A].Option A</li>
                        <li><input type="radio">C].Option C</li>
                    </div>
                    <div class="question_right">
                        <li><input type="radio">B].Option B</li>
                        <li><input type="radio">D].Option D</li>
                    </div>
                </div>

                <div class="center2">
                    <a href="#" class="previous">Previous</a>
                    <a href="#" class="next">Next</a>
                </div>

                <div class="bottom">
                    <span>1</span>
                    <span>2</span>
                    <span>3</span>
                    <span>4</span>
                    <span>5</span>
                    <span>6</span>
                    <span>7</span>
                    <span>8</span>
                    <span>9</span>
                    <span>10</span>
                </div>
            </div>


            <div class="main_right_div">
                <div class="time_bar">
                    <video autoplay="true" id="videoElement" >
	
                    </video>
                </div>
                <div class="question_bar">
                    <figure class="clock">
                        <div class="mins">0</div>
                        <div>:</div>
                        <div class="secs">00</div>
                        <audio src="http://soundbible.com/mp3/service-bell_daniel_simion.mp3"></audio>
                        <svg class="progress-ring" height="120" width="120">
                            <circle class="progress-ring__circle" stroke-width="8" fill="transparent" r="50" cx="60"
                                cy="60" />
                        </svg>
                    </figure>
                </div>
            </div>
        

    </div>

    <script src="../js/settings.js"></script>
    <script src="../js/timer.js"></script>
    <script src="../js/progress.js"></script>
    <script src="../js/camera.js"></script>

</body>

</html>