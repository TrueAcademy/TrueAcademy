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
    <title>Coursepage student</title>
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
                    <a href="assignments/assignmentsdashboard.php?classcode=<?php echo $_GET['classcode'] ?>"><i class="fas fa-th"></i><span>Assignment Section</span></a>
                </div>
        </div>
        <!--sidebar end-->
        
        <main class="rightdiv">
            <?php
                include("../includes/dbconfig.php");

                $collection = "classes/";
                $classdata = $database->getReference($collection)
                ->orderByChild('classcode')
                ->equalTo($_GET['classcode'])
                ->getvalue();

                foreach($classdata as $classtoken => $classkey){

                    if($classkey['classcode'] == $_GET['classcode'] ){


                        ?>


                        <div class="cards">

                                <div class="card-single">
                                    <div>
                                        <h1><?php echo $classkey['totalExamConducted']?></h1>
                                        <span>Total Exam Conducted</span>
                                    </div>
                                </div>


                                <div class="card-single">
                                    <div>
                                        <h1><?php echo $classkey['totalAssignmentGiven']?></h1>
                                        <span>Total Assignment assigned</span>
                                    </div>
                                </div>

                                <div class="card-single">
                                    <div>
                                        <h1 style="font-size: 16px; margin-top:20px"><?php echo $classkey['classowner']?></h1>
                                        <span>Teacher</span>
                                    </div>
                                </div>
                         </div>

                        
                         <div class="recent-grid">
                             <!-- List of student joined -->

                            <div class="projects">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>List Of Student In Class</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>First Name</td>
                                                        <td>Last Name</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    
                                                        $joinedclasstoken = $collection.$classtoken."/JoinedStudent";
                                                        $innercollection = $database->getReference($joinedclasstoken)->getvalue();


                                                        if($innercollection == null){

                                                            ?> 
                                                                <tr><td> Something went wrong! </td></tr>
                                                            <?php

                                                        }
                                                        else{    


                                                            foreach($innercollection as $intertoken => $innerkey){

                                                                // var_dump($innerkey);

                                                                $temp = $database->getReference('studentTable')
                                                                ->orderByChild('email')
                                                                ->equalTo($innerkey['studentemail'])
                                                                ->getvalue();

                                                                foreach($temp as $temptoken => $tempkey){

                                                                ?>                    
                                                                    
                                                                        <tr>
                                                                            <td><?php echo $tempkey['firstname']?></td>
                                                                            <td><?php echo $tempkey['lastname'] ?></td>
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

                            
                            

                        <?php

                    }


                }
            ?>
            

            

                <div class="messages">
                    <div class="card">
                        <div class="card-header">
                            <h3>Messages</h3>
                        </div>

                        <div class="card-body">
                            <div class="message">
                                <div class="message_box">
                                    no message yet ... 
                                </div>
                                <div class="message_send">
                                   <input type="text" name="text"/><button>SEND</button>
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