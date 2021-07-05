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
    <title>Attend Exam</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/stylespage.css">
    <link rel="stylesheet" href="../css/navstyle.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <h4 class="login_name">
                <?php echo $_SESSION['email']?>
            </h4>
            <div>
    </nav>



    <div class="main-content">

        <!-- sidebar -->
        <div class="leftdiv">
            <div class="sidebar">
                <center>
                    <img src="\images\book.png" class="profile_image" alt="">
                    <h4 style="font-size: 12px; margin-bottom:5px">
                        <?php echo $_SESSION['email']?>
                    </h4>
                    <h6 style="color: #ccc; margin-bottom:15px">student</h6>
                </center>
                <a href="attendExam.php?classcode=<?php echo $_GET['classcode'] ?>"><i
                        class="fas fa-desktop"></i><span>Attend Exam</span></a>
                <a href="viewexam.php?classcode=<?php echo $_GET['classcode']?>"><i class="far fa-eye"></i><span>View
                        Exam</span></a>
                <a href="viewresult.php?classcode=<?php echo $_GET['classcode']?>"><i
                        class="fas fa-table"></i><span>View Result</span></a>
            </div>
        </div>
        <!--sidebar end-->


        <main class="rightdiv">
            <div class="cards" style="margin-top: -50px; width: 100%">

                <div style="width: 650px;height: 500px; background-color: white;margin-top: 90px;margin-left: 200px;display: flex;align-items: center;
                    justify-content: space-around;flex-direction: column;">

                    <div class="topdiv" style="width: 400px;height: 400px;">

                        <video autoplay=" true" id="videoElement" style="width: 400px;height: 400px;">
                        </video>


                    </div>

                    <div class=" bottomdiv"">
                            <button class="startexam" id="startexam" onclick="confirmproceed()" style="width: 400px;height:50px;
                            background-color:lightgreen;outline: none;font-size: 18px;border: none;cursor: pointer;">
                        Proceed</button>
                    </div>

                    <div id="testing">testing</div>



                </div>


            </div>
        </main>
    </div>

    <script src="../js/camera.js"></script>

    <script>

        var sessionemail = "<?php echo $_SESSION['email'] ?>";
        var classcode = "<?php echo $_GET['classcode'] ?>";
        var examtitle = "<?php echo $_GET['examtitle'] ?>";
    
        function confirmproceed(){

            if(confirm('You are sure to proceed ??')){

                console.log('OK');
                var Email = prompt("\n Marking your attendance ... \nPlease enter email to confrim:", "Harry Potter");
                if (Email == null || Email == "") {

                   console.log("User cancelled the prompt ...");

                } else {
                    console.log("email = "+ Email);

                    if(Email.localeCompare(sessionemail) == 0 ){

                        $.ajax({
                            url:'user_ajax_action.php',
                            method:'POST',
                            data:{examtitle:examtitle,classcode:classcode,page:'preExam',action:'makeattendance'},
                            success:function(data)
                            {
                                // $('#testing').html(data);

                                if(confirm("Attendance is marked!\nYour exam is starting .... ")){

                                    window.location.href = "giveExam.php?classcode="+classcode+"&examtitle="+examtitle;    

                                }
                                else{
                                    alert("You can't cancel now!\nRedirecting to Exam page ... ");
                                    window.location.href = "giveExam.php?classcode="+classcode+"&examtitle="+examtitle;
                                }


                            },
                            error:function()
                            {
                                alert('Something went wrong! Try again ... ');
                            }
                        })

                    }
                    else{
                        alert("Your email doesnt matched! try again ... ");
                        confirmproceed();
                    }


                }

            }
            else{
                console.log('Cancel');
            }

        }
    
    
    </script>

</body>

</html>