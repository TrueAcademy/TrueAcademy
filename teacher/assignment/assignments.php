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
    <title>Assignments</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../css/stylespage.css">
    <link rel="stylesheet" href="../../css/navstyle.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
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
                        <img src="\images\book.png" class="profile_image" alt="">
                        <h4 style="font-size: 12px; margin-bottom:5px"><?php echo $_SESSION['email']?></h4>
                        <h6 style="color: #ccc; margin-bottom:15px">Teacher</h6>
                    </center>
                    <a href="exam/createExam.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Create Exam</span></a>
                    <a href="#"><i class="fas fa-cogs"></i><span>Manage Exam</span></a>
                    <a href="#"><i class="fas fa-table"></i><span>View Result</span></a>
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
                                        <h3>List of Students</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>Student Name</td>
                                                        <td>Email</td>
                                                        <td>status</td>
                                                        <td>View assignment</td>
                                                        <td>Give marks</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <?php
                                                    
                                                        $assignmentdata = $database->getReference('assignments/')
                                                        ->orderByChild('classcode')
                                                        ->equalTo($_GET['classcode'])
                                                        ->getvalue();

                                                        foreach($assignmentdata as $assignmenttoken => $assignmentkey){

                                                            if($assignmentkey['assignmenttitle'] == $_GET['assignmenttitle'] ){

                                                                $classdata = $database->getReference('classes/')
                                                                ->orderByChild('classcode')
                                                                ->equalTo($_GET['classcode'])
                                                                ->getvalue();

                                                                foreach($classdata as $classtoken => $classkey){

                                                                    if($classkey['classcode'] == $_GET['classcode']){

                                                                        $joineddatalist = $database->getReference('classes/'.$classtoken.'/JoinedStudent')->getvalue();

                                                                        foreach($joineddatalist as $joineddatatoken => $joineddatakey){

                                                                            $studentdata = $database->getReference('studentTable/')
                                                                            ->orderByChild('email')
                                                                            ->equalTo($joineddatakey['studentemail'])
                                                                            ->getvalue();

                                                                            foreach($studentdata as $studenttoken => $studentkey){

                                                                                $studentassignmentdata = $database->getReference('studentTable/'.$studenttoken.'/assignedHomework')->getvalue();

                                                                                foreach($studentassignmentdata as $studentassignmentdatatoken => $studentassignmentdatakey){

                                                                                    if($studentassignmentdatakey['assignmenttitle'] == $_GET['assignmenttitle'] ){

                                                                                        if($studentassignmentdatakey['submission'] == "false" ){

                                                                                            ?>

                                                                                            <tr>
                                                                                                <td><?php echo $studentkey['firstname']." ".$studentkey['lastname'] ?></td>
                                                                                                <td><?php echo $studentkey['email'] ?></td>
                                                                                                <td>not submitted</td>
                                                                                                <td><button id="viewassignment" class="viewassignment" disabled>View </button></td>
                                                                                                <td><input type="number" name="assignmentmarks" class="assignmentmarks" placeholder="put marks here" /></td>
                                                                                                <td><button id="assignmarks" class="assignmarks" disabled>Give Marks</button></td>
                                                                                       
                                                                                            </tr>

                                                                                            <?php 

                                                                                        }
                                                                                        else{

                                                                                            
                                                                                            ?>

                                                                                            <tr>
                                                                                                <td><?php echo $studentkey['firstname']." ".$studentkey['lastname'] ?></td>
                                                                                                <td><?php echo $studentkey['email'] ?></td>
                                                                                                <td>not submitted</td>
                                                                                                <td><button id="viewassignment" class="viewassignment" disabled>View </button></td>
                                                                                                <td><input type="number" name="assignmentmarks" class="assignmentmarks" placeholder="put marks here" /></td>
                                                                                                <td><button id="assignmarks" class="assignmarks" disabled>Give Marks</button></td>
                                                                                       
                                                                                            </tr>

                                                                                            <?php 



                                                                                        }

                                                                                    }

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