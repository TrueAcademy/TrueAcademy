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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Attend Exam</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="css/cards.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="css/stylespage.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .topdiv {
            width: 400px;
            height: 400px;
        }

        .topdiv .camera {
            width: 400px;
            height: 400px;
        }

        .video {
            width: 650px;
            height: auto;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-direction: column;
        }

        .right_div2 {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .bottomdiv {
            width: 400px;
            height: 100px;
        }

        .bottomdiv button {
            width: 400px;
            height: 50px;
            background-color: lightgreen;
            outline: none;
            font-size: 18px;
            border: none;
            cursor: pointer;
        }

        @media screen and (max-width: 650px) {
            .video {
                width: 400px;
                height: 400px;
                background-color: white;
            }

            .topdiv {
                width: 200px;
                height: 200px;
                display: flex;
                justify-content: center;
            }

            .topdiv .camera {
                width: 250px;
                height: 250px;
            }

            .bottomdiv {
                width: 300px;
                height: 40px;
                display: flex;
                justify-content: center;
            }

            .bottomdiv button {
                width: 300px;
                height: 35px;
                background-color: lightgreen;
                outline: none;
                font-size: 15px;
                border: none;
                cursor: pointer;
            }
        }

        @media screen and (max-width:375) {
            .video {
                width: 200px;
                height: 200px;
                background-color: white;
            }

            .topdiv {
                width: 250px;
                height: 250px;
                display: flex;
                justify-content: center;
            }

            .topdiv .camera {
                width: 250px;
                height: 100px;
            }

            .bottomdiv {
                width: 200px;
                height: 40px;
                display: flex;
                justify-content: center;
            }

            .bottomdiv button {
                width: 200px;
                height: 35px;
                background-color: lightgreen;
                outline: none;
                font-size: 15px;
                border: none;
                cursor: pointer;
            }

            .right_div2 {
                display: flex;
                flex-direction: column;
                align-items: center;
                height: 100%;
            }
        }
    </style>
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
            <h3 class="login_name"><?php echo $_SESSION['email']?></h3>
        </div>
    </div>

    <div class="main_container" style="height:621px;">
        <div class="left_div2" id="welcomediv" style="height: 621px;">

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
                <a href="attendExam.php?classcode=<?php echo $_GET['classcode'] ?>"><i
                        class="fas fa-desktop"></i><span>Attend Exam</span></a>
                <a href="viewexam.php?classcode=<?php echo $_GET['classcode']?>"><i class="far fa-eye"></i><span>View
                        Exam</span></a>
                <a href="viewresult.php?classcode=<?php echo $_GET['classcode']?>"><i
                        class="fas fa-table"></i><span>View Result</span></a>
            </div>

        </div>

        <div class="right_div2">


            <div class="video">

                <div class="topdiv">

                    <video class="camera" autoplay="true" id="videoElement">
                    </video>
                </div>

                <div class=" bottomdiv">
                    <button class=" startexam" id="startexam" onclick="confirmproceed()">
                        Proceed</button>
                </div>
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
    <script src="../js/camera.js"></script>
</body>

</html>