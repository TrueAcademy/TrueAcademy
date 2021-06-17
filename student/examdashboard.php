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
    <title>Exam dashboard</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/stylespage.css">
    <link rel="stylesheet" href="../css/navstyle.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <!-- <link rel="stylesheet" href="../css/page2.css">     -->
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
    
   

    <div class="main-content">

        <!-- sidebar -->
        <div class="leftdiv">
                <div class="sidebar">
                    <center>
                        <img src="\images\book.png" class="profile_image" alt="">
                        <h4 style="font-size: 12px; margin-bottom:5px"><?php echo $_SESSION['email']?></h4>
                        <h6 style="color: #ccc; margin-bottom:15px">student</h6>
                    </center>
                    <a href="attendExam.php?classcode=<?php echo $_GET['classcode'] ?>"><i class="fas fa-desktop"></i><span>Attend Exam</span></a>
                    <a href="viewexam.php?classcode=<?php echo $_GET['classcode']?>"><i class="far fa-eye"></i><span>View Exam</span></a>
                    <a href="viewresult.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-table"></i><span>View Result</span></a>
                </div>
        </div>
        <!--sidebar end-->


        <main class="rightdiv">
            <div class="cards">
                <?php 
                
                    include('../includes/dbconfig.php');
                    $collection = "classes/";
                    $classdata = $database->getReference($collection)
                    ->orderByChild('classcode')
                    ->equalTo($_GET['classcode'])
                    ->getvalue();

                    foreach($classdata as $classtoken => $classkey){

                         ?>
                         
                         <div class="card-single">
                                <div>
                                    <h1><?php echo $classkey['totalExamConducted'] ?></h1>
                                    <span>Total Exam Conducted</span>
                                </div>
                            </div>
                            <div class="card-single">
                                <div>
                                    <h1><?php echo $classkey['totalJoined'] ?></h1>
                                    <span>Total Examines</span>
                                </div>
                            </div>


                         <?php

                    }

                ?>
                
                            
                        </div>
                        <div class="recent-grid">
                            <!-- List of student joined -->
                            <div class="projects">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Upcoming Exams</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>Exam Title</td>
                                                        <td>Start Date</td>
                                                        <td>Time</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                
                                                    $exam = $database->getReference("Exam/")
                                                    ->orderByChild('classcode')
                                                    ->equalto($_GET['classcode'])
                                                    ->getvalue();

                                                    if($exam == null){
                                                         ?>
                                                            <tr> <td> No Exam is Upcoming </td> <tr>
                                                         <?php

                                                    }
                                                    else{

                                                        foreach($exam as $examtoken => $examkey){
 
                                                            if($examkey['status'] == "Not Held" ){

                                                            
                                                                ?>
                                                                
                                                                <tr>
                                                                    <td><?php echo $examkey['examtitle']?></td>
                                                                    <td><?php echo $examkey['examdate']?></td>
                                                                    <td><?php echo $examkey['starttime']?></td>
                                                                </tr>

                                                                <?php

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


        </main>
    </div>

</body>
</html>