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
    <title>Create Exam</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../css/sidebar.css"/>
    <link rel="stylesheet" href="../../css/navbar.css"/>
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

            <a href="#" class="logo_url"><img src="../../images/logo.png" alt="logo" class="logo"></a>
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
    

    <div class="main_container" style="height:80vh;">
        <div class="left_div2" id="welcomediv" style="height: auto;">

            <div class="close_button" onclick="removediv()">
                <a href="#" class="close_btn_teacher" id="close_btn"><i id="close" class="far fa-times-circle"></i></a>
            </div>

            <div class="profile_name">
                <div class="imagediv" >
                    <img src="../../images/person.png" alt="">
                </div>
                <h3><?php echo $_SESSION['email'] ?></h3>
                <h6>student</h6>
            </div>

            <div class="side_btn">
                <a href="createExam.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Create Exam</span></a>
                <a href="#"><i class="fas fa-cogs"></i><span>Manage Exam</span></a>
                <a href="../results/viewresults.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-table"></i><span>View Result</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Delete Exam</span></a>
            </div>

        </div>

        <div class="right_div2" style="display:flex;align-items:center;justify-content:center;width:900px;margin-right:300px;height
        100vh">
        <div style="background:white; height: 100%;padding:50px;margin-bottom:100pxdisplay: flex;flex-direction: column;align-items: center;height: fit-content;">

            <div style="text-align:center; margin-top:5px">
                <h2>Create Exam</h2>
            </div>

            <div style="margin-left:60px; margin-top:40px ">
                
                <form action="pushExam.php" method="POST" style="width:350px">
                    
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