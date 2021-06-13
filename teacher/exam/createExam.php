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
    <link rel="stylesheet" href="../../css/stylespage.css">
    <link rel="stylesheet" href="../../css/navstyle.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
    <!-- <link rel="stylesheet" href="../css/page2.css">     -->
</head>    
<body>

    <nav class="navbar">
        <div class="left_div">
                <a href="#" class="hamberg"><i class="fas fa-bars"></i></a>
                <a href="#" class="logo_url"><img src="../../images/logo.png" alt="logo" class="logo"></a>
                <h1 class="h1">True Academy</h1>


                <div class="navbar-menu" style="display:flex; justify-content:center; margin:40px">
                    <a style="color:#38d39f; padding:5px; border-radius:50px" href="#">Exam</a>
                    <a style="color:#38d39f; padding:5px; border-radius:50px"href="#">Assignment</a>
                </div>
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
                        <h6 style="color: #ccc; margin-bottom:15px">Teacher</h6>
                    </center>
                    <a href="exam/createExam.php"><i class="fas fa-desktop"></i><span>Create Exam</span></a>
                    <a href="#"><i class="fas fa-cogs"></i><span>Manage Exam</span></a>
                    <a href="#"><i class="fas fa-table"></i><span>View Result</span></a>
                    <a href="#"><i class="fas fa-th"></i><span>Delete Exam</span></a>
                </div>
        </div>
        <!--sidebar end-->


        <main class="rightdiv">
            

            <div style="background:white; height: 100%;">

                    <div style="text-align:center; margin-top:5px">
                        <h2>Create Exam</h2>
                    </div>

                    <div style="margin-left:60px; margin-top:40px ">
                        
                        <form action="pushExam.php" method="POST">
                            
                            <table>

                                <tr>
                                    <td><label>Exam Title</label></td>
                                    <td><input type="text" name="exam_title" id="name" placeholder=""></td>
                                </tr>

                                <tr>
                                    <td><label>Course Name</label></td>
                                    <td><input type="text" name="course_name"id="name" placeholder=""></td>
                                </tr>

                                <input type="hidden" name="classcode" value="<?php echo $_GET['classcode']?>">

                                <tr>
                                    <td><label for="date">Date</label></td>
                                    <td><input name="examdate" type="date" id="date" placeholder=""></td>
                                </tr>

                                <tr>
                                    <td><label for="time">Exam Time</label></td>
                                    <td><input type="time" name="starttime" id="time" placeholder=""></td>
                                </tr>

                                <tr>
                                    <td><label for="noofques">No of question</td>
                                    <td><input type="text" name="questionno" placeholder=""></td>   
                                <tr>
                                    <td><label for="time">Time Duration</label></td>
                                    <td><input type="text" name="timeduration" id="time" placeholder=""></td>
                                </tr>

                                <tr>
                                    <td><label>Exam Type</label></td>
                                    <td>
                                        <select id="text" name="examtype">
                                            <option value="objective">Objective</option>
                                            <option value="subjective">Subjective</option>
                                        </select>
                                    </td>
                                </tr>

                            </table>
                        
                        
                            <button type="submit" name="createExam" style="margin-left: 15px; padding: 5px 10px; margin-top:10px">Create</button>
                            <button type="reset" style="padding: 5px 10px; margin-left: 40px;">Reset</button>

                        </form>

                    </div>

            </div>

        </main>
    </div>

</body>
</html>