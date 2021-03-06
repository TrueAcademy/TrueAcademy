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
    <title>Coursepage Teacher</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="css/stylespage.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel='stylesheet' href='css/cards.css'>
    <!-- <link rel="stylesheet" href="../css/page2.css">     -->
</head>    
<body>





   

    <div class="navbar">
        <div class="left_div">

            <button class="menu-toggler" onclick="showdiv()">
                <span onclick="removediv()"></span>
                <span></span>
                <span onclick="removediv()"></span>
            </button>

            <a href="#" class="logo_url"><img src="../images/logo.png" alt="logo" class="logo"></a>
            <h1 class="h1">True Academy</h1>
        </div>
        <div class="right_div">
            <a href="#" class="profile"><i class="fas fa-user"></i></a>

            <div class="profile_li">
                <a href="#" class="PROFILE">Profile</a>
                <a href="#" class="LOGOUT">Logout</a>
            </div>
            <h3 class="login_name">shinderushi327@gmail.com</h3>
        </div>
    </div>

    
   

    <div class="main_container" style="height:fit-content;">

        <!-- sidebar -->
        <div class="left_div2" id="welcomediv" style="height: auto;">

            <div class="close_button" onclick="removediv()">
                <a href="#" class="close_btn_teacher" id="close_btn"><i id="close" class="far fa-times-circle"></i></a>
            </div>

            <div class="profile_name">
                <div class="imagediv">
                    <img src="../images/person.png" alt="">
                </div>
                <h3>
                    <?php echo $_SESSION['email']?>
                </h3>
                <h6>student</h6>
            </div>


            <div class="side_btn">
                <a href="examdashboard.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Exam Conduction</span></a>
                <a href="assignmentdashboard.php?classcode=<?php echo $_GET['classcode']?>"><i class="far fa-eye"></i><span>Assignment Section</span></a>
            </div>

        </div>
        <!--sidebar end-->


        <div class="right_div2" style="display: flex;flex-direction: column;align-items: center;height: fit-content;">
            

            
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


                        <div class="cards"  style="margin-left: 75px;">
                            <div class="card-single">
                                <div>
                                    <h1><?php echo $classkey['totalExamConducted']?></h1>
                                    <span>Total Exam Conducted</span>
                                </div>
                            </div>


                            <div class="card-single">
                                <div>
                                    <h1><?php echo $classkey['totalAssignmentGiven']?></h1>
                                    <span>Total Assignment</span>
                                </div>
                            </div>

                            <div class="card-single">
                                <div>
                                    <h1 style="font-size: 16px; margin-top:20px"><?php echo $classkey['totalJoined']?></h1>
                                    <span>Total Student Joined</span>
                                </div>
                            </div>
                        </div>

                        <div class="white_div" style="margin-bottom: 100px;">

                            <h3>List Of Student In Class.</h3>

                            <table>
                                <thead>
                                    <tr>
                                        <td>First Name</td>
                                        <td style="display: flex;justify-content: left;">Last Name</td>
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
                                                        <td style="display: flex;justify-content: left;"><?php echo $tempkey['lastname'] ?></td>
                                                    </tr>     

                                                    <?php


                                                }

                                            }
                                                    
                                        }

                                    ?>

                                </tbody>
                            </table>

                        </div>

                            



                        <?php

                    }


                }
            ?>
            
               
           

        </div>
    </div>

   

</body>
</html>