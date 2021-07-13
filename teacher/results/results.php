<?php

    session_start();


    
    if( $_SESSION['email'] == null ){

        echo "<script type='text/javascript'>alert('Cant open user is not authorized!')</script>";
        header("Location:index.html"); 

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>results</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../css/sidebar.css"/>
    <link rel="stylesheet" href="../../css/navbar.css"/>
    <link rel="stylesheet" href="css/stylespage.css"/>
    <link rel="stylesheet" href="../css/cards.css"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<style>
        @media screen and (max-width: 600px) {
            .white_div {
                width: 375px;
                height: fit-content;
                background-color: white;
                margin-top: 100px;
            }

            .right_div2 {
                width: 375px;
                padding: 0px;
                margin: 0px
            }

        }

        @media screen and (max-width: 400px) {
            .cards {
                display: grid;
                grid-template-columns: repeat(1, 1fr);
                height: fit-content;
                grid-gap: 3rem;
                padding: 0px;
                margin: 30px 40px 0px 0px;
            }

            .card-single {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                width: 100%;
                background: #fff;
                padding: 2rem;
                border-radius: 2px;
            }

            .main_container {
                width: 100vw;
                padding: 0px;
                margin: 0px;
            }
        }
    </style>
<body style="background-color:#f1f5f9">

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
            <h3 class="login_name">shubhamsapkal70@gmail.com</h3>
        </div>
    </div>
    
    <div class="main_container" style="height:100vh;">
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
                <a href="../exam/createExam.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Create Exam</span></a>
                <a href="#"><i class="fas fa-cogs"></i><span>Manage Exam</span></a>
                <a href="viewresults.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-table"></i><span>View Result</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Delete Exam</span></a>
            </div>

        </div>

        <div class="right_div2" style="display:flex;flex-direction:column;width:900px;margin-right:300px;height
        100%;">
                <?php 
                
                    include('../../includes/dbconfig.php');
            
                ?>
                            
                        <div class="recent-grid" style="background-color:white;height:fit-content;margin-left:80px;margin-top:100px">
                            <!-- List of student joined -->
                            <div class="projects">
                                <div class="card">
                                    <div class="card-header" style="padding:20px">
                                        <h3>Results are available for Students</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%" style="padding-left:20px">
                                                <thead>
                                                    <tr style="height:50px">
                                                        <td>Student Name</td>
                                                        <td>Email</td>
                                                        <td>Exam Date</td>
                                                        <td>attendance</td>
                                                        <td>Marks</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        
                                                           
                                                        $classdata = $database->getReference('classes/')
                                                        ->orderByChild('classcode')
                                                        ->equalTo($_GET['classcode'])
                                                        ->getvalue();

                                                        foreach($classdata as $classtoken => $classkey){

                                                            // var_dump($classkey);

                                                            if(strcmp($classkey['classcode'],$_GET['classcode']) == 0 ){

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

                                                                                if( strcmp($studentexamkey['examtitle'],$_GET['examtitle']) == 0  and strcmp($studentexamkey['classcode'],$_GET['classcode']) == 0   ){


                                                                                    if($studentexamkey['attandance'] == 'attended' and $studentexamkey['resultcalculated'] == 'false' ){


                                                                                                                                    
                                                                                        $quesdata = $database->getReference("Exam/")
                                                                                        ->orderByChild("classcode")
                                                                                        ->equalto($_GET['classcode'])
                                                                                        ->getvalue();
    
                                                                                        foreach($quesdata as $questoken => $queskey){
    
                                                                                            if(strcmp($queskey['examtitle'],$_GET['examtitle']) == 0 ){
    
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
    
                                                                                                    // var_dump($update);
    
                                                                                                    try{
                                                                                                        $database->getReference("studentTable/".$studenTabletoken."/assignedExam/".$studentexamtoken."/results")->update($update);
                                                                                                        $update1 = [
                                                                                                            'resultcalculated' => 'true'
                                                                                                        ];
                                                                                                        $database->getReference("studentTable/".$studenTabletoken."/assignedExam/".$studentexamtoken)->update($update);
    
                                                                                                    }
                                                                                                    catch(Exception $e){
                                                                                                    }
    
                                                                                                }
    
    
    
                                                                                                
                                                                                            }    
    
                                                                                        }
    
    
    
                                                                                    }
                                                                                    
                                                                                    $studentresult = $database->getReference("studentTable/".$studenTabletoken."/assignedExam/".$studentexamtoken."/results")->getvalue();

                                                                                    // var_dump($studentresult);

                                                                                    ?>
                                                                                        <tr style="height:50px;">
                                                                                            <td><?php echo $studentTablekey['firstname']." ".$studentTablekey['lastname']  ?></td>   
                                                                                            <td><?php echo $studentTablekey['email']?></td>
                                                                                            <td><?php echo $studentexamkey['examdate']?></td>
                                                                                            <td><?php echo $studentexamkey['attandance']?></td>
                                                                                            <td><?php echo $studentresult['marks']?></td>
                                                                                        </tr>

                                                                                    <?php
                                                                                    

                                                                              
    


                                                                                }
                                                                                

                                                                            }   

                                                                        }

                                                                    }


                                                                }

                                                            }

                                                        }


                                                    ?>

                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
            
                        </div>
            </div>

        </main>
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