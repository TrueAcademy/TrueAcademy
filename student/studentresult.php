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
    <title>Accusoft admin</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/stylespage.css">
    <link rel="stylesheet" href="../css/navstyle.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>    
<body>

    <nav>
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
    
   

    <div class="main-content">


        <!-- sidebar -->
        <div class="leftdiv">
                <div class="sidebar">
                    <center>
                        <img src="\images\book.png" class="profile_image" alt="">
                        <h4 style="font-size: 12px; margin-bottom:5px"><?php echo $_SESSION['email']?></h4>
                        <h6 style="color: #ccc; margin-bottom:15px">student</h6>
                    </center>
                    <a href="examdashboard.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Exam Conduction</span></a>
                    <a href="#"><i class="fas fa-th"></i><span>Assignment Section</span></a>
                </div>
        </div>
        <!--sidebar end-->
        
        <main class="rightdiv">
            <?php   

                include('../includes/dbconfig.php');
                
                $examdata = $database->getReference("Exam/")
                ->orderbyChild('classcode')
                ->equalTo($_GET['classcode'])
                ->getvalue();

                foreach($examdata as $examtoken => $examkey){

                    if($examkey['examtitle'] == $_GET['examtitle'] ){

                        $quespaper = $database->getReference('Exam/'.$examtoken.'/questions')->getvalue();

                        foreach($quespaper as $quespapertoken => $quespaperkey){

                            $studentTable =$database->getReference('studentTable/')
                            ->orderByChild("email")
                            ->equalTo($_SESSION['email'])
                            ->getvalue();

                            foreach($studentTable as $studentTabletoken => $studentTablekey){

                                if($studentTablekey['email'] == $_SESSION['email']){

                                    // var_dump($studentTablekey);

                                    $studentexamdata = $database->getReference('studentTable/'.$studentTabletoken.'/assignedExam')->getvalue();

                                    foreach($studentexamdata as $studentexamtoken => $studentexamkey){

                                        if($studentexamkey['examtitle'] == $_GET['examtitle'] and $studentexamkey['classcode'] == $_GET['classcode']  ){

                                            // var_dump($studentexamkey['results']['marks']);
                                            // echo $studentexamkey['results']['marks'];

                                            ?>

                                                <div class="cards">
                                                    <div class="card-single">
                                                        <div>
                                                            <h1><?php echo $examkey['questionno']?></h1>
                                                            <span>Total marks</span>
                                                        </div>
                                                    </div>


                                                    <div class="card-single">
                                                        <div>
                                                            <h1><?php echo $studentexamkey['results']['marks']?></h1>
                                                            <span>Total Marks Obtained</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="recent-grid">
                                                    <!-- List of student joined -->

                                                    <div class="projects">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h3>Your Answer Sheet</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>Question</td>
                                                                                <td>Answer You Choice</td>
                                                                                <td>Correct Answer</td>
                                                                                <td>Marks Obtained</td>
                                                                            </tr>
                                                                        </thead>

                                                                            <tbody>

                                                                                <?php

                                                                                // echo $studentexamkey['results']['answersheet'][2];
                                                                                for($question_id=1;$question_id<=10;$question_id++){

                                                                                    ?>
                                                                                        <tr>
                                                                                            <td> <?php echo $quespaperkey[$question_id]['question'] ?> </td>
                                                                                            <td> <?php echo $studentexamkey['results']['answersheet'][$question_id] ?> </td>
                                                                                            <td> <?php echo $quespaperkey[$question_id]['answer']?></td>
                                                                                            <?php
                                                                                                if( strcmp($studentexamkey['results']['answersheet'][$question_id],$quespaperkey[$question_id]['answer']) == 0 ){
                                                                                                    echo "<td>1</td>";
                                                                                                }
                                                                                                else{
                                                                                                    echo "<td>0</td>";
                                                                                                }
                                                                                            ?> 
                                                                                        </tr>  

                                                                                    <?php


                                                                                }


                                                                                ?>
                                                                            </tbody>
                                                                          
                                                                    </table>
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    </div>  

                                                                                <?php


                                        }

                                    }


                                }

                            }

                        }

                    }

                }

            ?>
            

            

                
            </div>

        </main>
    </div>

</body>
</html>