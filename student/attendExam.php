<?php 

    session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Attend Exam</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/sidebar.css"/>
    <link rel="stylesheet" href="../css/navbar.css"/>
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

            <a href="#" class="logo_url"><img src="../images/logo.png" alt="logo" class="logo"></a>
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

    <div class="main_container" style="height:fit-content;">
        <div class="left_div2" id="welcomediv" style="height: auto;">

            <div class="close_button" onclick="removediv()">
                <a href="#" class="close_btn_teacher" id="close_btn"><i id="close" class="far fa-times-circle"></i></a>
            </div>

            <div class="profile_name">
                <div class="imagediv" >
                    <img src="../images/person.png" alt="">
                </div>
                <h3><?php echo $_SESSION['email'] ?></h3>
                <h6>student</h6>
            </div>

            <div class="side_btn">
                <a href="attendExam.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Attend Exam</span></a>
                <a href="viewexam.php?classcode=<?php echo $_GET['classcode']?>"><i class="far fa-eye"></i><span>View Exam</span></a>
                <a href="viewresult.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-table"></i><span>View Result</span></a>
            </div>

        </div>

        <div class="right_div2" style="display: flex;flex-direction: column;align-items: center;height: fit-content;">
            <div class="white_div">
                <h3>Your Exams</h3>
                <table>
                    <thead>
                        <tr>
                            <td>Exam Title</td>
                            <td>Start Date</td>
                            <td>Start Time</td>
                            <td>End Time</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                            include("../includes/dbconfig.php");

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

                                    

                                        
                                    ?>
                                            
                                        <form action="attendExam.php?classcode=<?php echo $_GET['classcode']?>" method="POST">
                                            <tr>
                                                <td><?php echo $examkey['examtitle']?></td>
                                                <input type="hidden" name="examtitle" value="<?php echo $examkey['examtitle']?>">
                                                <input type="hidden" name="classcode" value="<?php echo $examkey['classcode']?>">
                                                
                                                <td><?php echo $examkey['examdate']?></td>
                                                <input type="hidden" name="examdate" value="<?php echo $examkey['examdate']?>">
                                                
                                                <td><?php echo $examkey['starttime']?></td>
                                                <input type="hidden" name="starttime" value="<?php echo $examkey['starttime']?>">
                                                
                                                <td><?php echo $examkey['endtime']?></td>
                                                <input type="hidden" name="endtime" value="<?php echo $examkey['endtime']?>">
                                                <td><button type="submit" name="startexam" class="attend">Attend</button></td>
                                            </tr>
                                        </form>

                                        <?php

                                }
                                    

                            }

                        ?>

                                            
                    </tbody>
                </table>
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


<?php

    date_default_timezone_set("Asia/Calcutta");

    if(isset($_POST['startexam'])){

        $examtitle = $_POST['examtitle'];
        $classcode = $_POST['classcode'];

        $examdate = new DateTime($_POST['examdate']);
        $starttimeObj = new DateTime($_POST['starttime'],new DateTimeZone("Asia/Calcutta"));
        $endtime = new DateTime($_POST['endtime']);

        
        $currentdate = new DateTime(date("Y-m-d"),new DateTimeZone('Asia/Calcutta'));
        
        $currenttime = new DateTime(date("H:i"));
        // // echo "</br> Current Time = ". $currenttime->format("H:i");
        
        // echo "</br> Current time : ". $currenttime->format("H:i");
        // echo "</br> Start time : ". $starttimeObj->format("H:i");
        // echo "</br> End time : ". $endtime->format("H:i");    
    
        
        if( $examdate->diff($currentdate)->format("%d") == 0 ){

            
            if($currenttime >= $starttimeObj){

                if($currenttime <= $endtime){
                    
                    ?>

                        <meta http-equiv = "refresh" content = "1; url = preExam.php?classcode=<?php echo $classcode?>&examtitle=<?php echo $examtitle?>" />

                    <?php
                }
                else{
                    echo "<script type='text/javascript'>alert('Your Exam is Ended Already!')</script>";
                }


            }
            else{
                echo "<script type='text/javascript'>alert('Your Exam time is due!')</script>";
            }
            

            
        }
        else if($examdate->diff($currentdate)->format("%d") < 0){

            echo "<script type='text/javascript'>alert('Your Exam is Ended Already!')</script>";            

        }
        else if($examdate->diff($currentdate)->format("%d") > 0){
            echo "<script type='text/javascript'>alert('Your Exam is Due!')</script>";
        }


    }


?>