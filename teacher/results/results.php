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
    <link rel="stylesheet" href="../../css/stylespage_temp.css">
    <link rel="stylesheet" href="../../css/navstyle.css">
    <link rel="stylesheet" href="../../css/sidebar-temp.css">
    <!-- <link rel="stylesheet" href="../css/page2.css">     -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>    
<body>

    <nav class="navbar">
        <div class="left_div">
                <a href="#" class="hamberg"><i class="fas fa-bars"></i></a>
                <a href="#" class="logo_url"><img src="../../images/logo.png" alt="logo" class="logo"></a>
                <h1 class="h1">True Academy</h1>
        </div>
        <div class="right_div">
            <a href="#" class="profile"><i class="fas fa-user"></i></a>
           
            <div class="profile_li">
                <a href="#" class="PROFILE">Profile</a>
                <a href="../../logout.php" class="LOGOUT">Logout</a>  
            </div>
            <h4 class="login_name"> <?php echo $_SESSION['email']?> </h4>
        <div>
    </nav>
    
   

    <div class="main-content">

        <!-- sidebar -->
        <div class="leftdiv">
                <div class="sidebar">
                    <center>
                        <img src="../../images/person.png" class="profile_image" alt="">
                        <h4 style="font-size: 12px; margin-bottom:5px"><?php echo $_SESSION['email']?></h4>
                        <h6 style="color: #ccc; margin-bottom:15px">Teacher</h6>
                    </center>
                    <a href="../exam/createExam.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Create Exam</span></a>
                    <a href="#"><i class="fas fa-cogs"></i><span>Manage Exam</span></a>
                    <a href="viewresults.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-table"></i><span>View Result</span></a>
                    <a href="#"><i class="fas fa-th"></i><span>Delete Exam</span></a>
                </div>
        </div>
        <!--sidebar end-->


        <main>
            
            <div class="rightdiv">
                <?php 
                
                    include('../../includes/dbconfig.php');
            
                ?>
                            
                        <div class="recent-grid">
                            <!-- List of student joined -->
                            <div class="projects">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Results are available for Students</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
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
    
                                                                                                    var_dump($update);
    
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
                                                                                        <tr>
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

        

    </script>

</body>
</html>