<?php

    session_start();


    
    if( $_SESSION['email'] == null ){

        echo "<script type='text/javascript'>alert('Cant open! user is not authorized...')</script>";
        header("Location:index.html"); 

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assignment dashboard</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- <link rel="stylesheet" href="page10.css"> -->
    <link rel="stylesheet" href="../../css/sidebar.css">
    <link rel="stylesheet" href="../../css/navstyle.css">
    <link rel="stylesheet" href="../../css/stylespage.css">
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
                <a href="../../logout.php" class="LOGOUT">Logout</a>
            </div>
            <div>
    </nav>
    <div class="main-content">

        <!-- sidebar -->
        <div class="leftdiv">
            <div class="sidebar">
                <center>
                  <img src="\images\logo.png" class="profile_image" alt="">
                  <h4>True Academy</h4>
                </center>
                <a href="viewassignments.php?classcode=<?php echo $_GET['classcode'] ?>"><i class="fas fa-cogs"></i><span>View Homework</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Share Material</span></a>
              </div>
        </div>
        <main class="min-page">
            
            <!--sidebar end-->
            <?php

                include("../../includes/dbconfig.php");
            
                $classdata = $database->getReference('classes/')
                ->orderByChild('classcode')
                ->equalTo($_GET['classcode'])
                ->getvalue();

                foreach($classdata as $classtoken => $classkey){

                }
            
            ?>

            <div class="rightdiv">
                <div class="cards">
                    <div class="card-single">
                        <div>
                            <h1><?php echo $classkey['totalJoined']?></h1>
                            <span>Total Students</span>
                        </div>
                    </div>
                    <div class="card-single">
                        <div>
                            <h1><?php echo $classkey['totalAssignmentGiven']?></h1>
                            <span>Homework Assigned</span>
                        </div>
                    </div>
                    <div class="card-single">
                        <div>
                            <h1><?php echo $classkey['totalstudymaterial']?></h1>
                            <span>Study Material</span>
                        </div>
                    </div>
                </div>
                <div class="recent-grid">
                    <!-- List of student joined -->
                    <div class="projects">
                        <div class="card">
                            <div class="card-header">
                                <h3>List of Upcoming Asignments</h3>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table width="100%">
                                        <thead>
                                            <tr>
                                                <td>SR.NO</td>
                                                <td>Homework Title</td>
                                                <td>Date OF Assignment</td>                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                            $assignmentdata = $database->getReference('assignments/')
                                            ->orderByChild('classcode')
                                            ->equalTo($_GET['classcode'])
                                            ->getvalue();

                                            if($assignmentdata == null ){

                                               echo "<tr><td colspan='3'>No work assigned till yet</td></tr>";

                                            }
                                            else{
                                                $count=1;
                                                foreach($assignmentdata as $assignmenttoken => $assignmentkey){

                                                    if(new DateTime($assignmentkey['enddate']) > new DateTime(date("Y-m-d"),new DateTimeZone('Asia/Calcutta')) ){

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $count?></td>
                                                                <td><?php echo $assignmentkey['assignmenttitle']?></td>
                                                                <td><?php echo $assignmentkey['enddate']?></td>
                                                            </tr>
                                                        <?php
                                                        $count = $count+1;

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

</body>

</html>