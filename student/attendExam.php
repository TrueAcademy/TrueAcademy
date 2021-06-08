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
                    <a href="#"><i class="fas fa-desktop"></i><span>Attend Exam</span></a>
                    <a href="#"><i class=""></i><span>View Exam</span></a>
                    <a href="#"><i class="fas fa-table"></i><span>View Result</span></a>
                </div>
        </div>
        <!--sidebar end-->


        <main class="rightdiv" >
            <div class="cards" style="margin-top: -50px; width: 100%">
                           
                        </div>
                        <div class="recent-grid" style="width:100%; heigth:100%">
                            <!-- List of student joined -->
                            <div class="projects">
                                <div class="card" style="width:100%; heigth:100%" >
                                    <div class="card-header">
                                        <h3>Your Exams</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">    
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
    
                                                            if($examkey['status'] == "Not Held" ){

                                                                
                                                                ?>
                                                                    
                                                                    <form action="attendExam.php?classcode=<?php echo $_GET['classcode']?>" method="POST">
                                                                        <tr>
                                                                            <td><?php echo $examkey['examtitle']?></td>
                                                                            <td><?php echo $examkey['examdate']?></td>
                                                                            <input type="hidden" name="examdate" value="<?php echo $examkey['examdate']?>">
                                                                            <td><?php echo $examkey['starttime']?></td>
                                                                            <input type="hidden" name="starttime" value="<?php echo $examkey['starttime']?>">
                                                                            <td><?php echo $examkey['endtime']?></td>
                                                                            <input type="hidden" name="endtime" value="<?php echo $examkey['endtime']?>">
                                                                            <td><button type="submit" name="startexam">Attend</button></td>
                                                                        </tr>
                                                                    </form>

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

<?php

    date_default_timezone_set("Asia/Calcutta");

    if(isset($_POST['startexam'])){

        $examdate = new DateTime($_POST['examdate']);
        $starttimeObj = new DateTime($_POST['starttime'],new DateTimeZone("Asia/Calcutta"));
        $endtime = new DateTime($_POST['endtime']);

        // echo "date = ".$examdate;?\'
        // echo "</br>time = ".date("H:i");

        $currentdate = new DateTime(date("Y-m-d"),new DateTimeZone('Asia/Calcutta'));
        // echo "current = ". $currentdate->format('Y-m-d');
        // echo "</br> date diff = ". $examdate->diff($currentdate)->format("%d");

        $currenttime = new DateTime(date("H:i"), new DateTimeZone("Asia/Calcutta"));
        // echo "</br> Current Time = ". $currenttime->format("H:i");
        
        echo "</br> Start time = ". $starttimeObj->format("%H:%i");
        echo "</br> start diff = ". $starttimeObj->diff($currenttime)->format("%R%H:%i");
        // echo "</br> strcmp = ". strcmp($starttimeObj->diff($currenttime)->format("%H:%i"),"00:00");
        echo "</br> end time = ". $endtime->format("%H:%i");
        echo "</br> end diff = ". $endtime->diff($currenttime->add(new DateInterval("PT600S")))->format("%R%H:%i");

        // echo "time diff = ". strcmp( $endtime->format("H:i") ,$currentdate->format("H:i"));
        var_dump($starttimeObj->diff($currenttime)->format("%H:%i") > "+00:00" );
        var_dump($endtime->diff($currenttime->add(new DateInterval("PT600S")))->format("%H:%i") < "+00:00");
        
        if( $examdate->diff($currentdate)->format("%d") == 0 ){

            
            // if($starttimeObj->diff($currentdate)->format("%H:%i") > strtotime("+00:00") && $endtime->diff($currenttime->add(new DateInterval("PT600S")) )->format("%H:%i") < strtotime("+00:00") ){
                
                
         
            //         echo "<script type='text/javascript'>alert('Your Exam is runing!!')</script>";
               
               
            //         // echo "<script type='text/javascript'>alert('Your Exam ended Already !!')</script>";
               
                
            // }
            // elseif($starttimeObj->diff($currentdate)->format("%H:%i") < "+00:00" ) {

            //     echo "<script type='text/javascript'>alert('Your Exam time is due !!')</script>";
            // }
            // else {
            //     echo "<script type='text/javascript'>alert('Your Exam ended Already !!')</script>";
            // }


            // if($currenttime->format("%H:%i") < $starttimeObj->format("%H:%i")) 
            // {
            //     echo "<script type='text/javascript'>alert('Your Exam will be start !!')</script>";
            // }
            // if($currenttime->format("%H:%i") > $starttimeObj->format("%H:%i") &&  $currenttime->format("%H:%i") < $endtime->format("%H:%i"))
            // {
            //     echo "<script type='text/javascript'>alert('Your Exam is running !!')</script>";
            // }
            
            // if($currenttime->format("%H:%i") > $endtime->format("%H:%i"))
            // {
            //     echo "<script type='text/javascript'>alert('Your Exam already end !!')</script>";
            // }


            
            

            
        }
        else if($examdate->diff($currentdate)->format("%d") < 0){

            echo "<script type='text/javascript'>alert('Your Exam is Ended Already!')</script>";            

        }
        else if($examdate->diff($currentdate)->format("%d") > 0){
            echo "<script type='text/javascript'>alert('Your Exam is Due!')</script>";
        }


    }


?>