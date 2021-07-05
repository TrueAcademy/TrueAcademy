<?php

    date_default_timezone_set("Asia/Calcutta");
    include("../includes/dbconfig.php");
    session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/exam_question.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <!-- <link rel="stylesheet" href="../js/TimeCircles.js"> -->
    <link rel="stylesheet" type="text/css" href="css/TimeCircles.css">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>exam</title>
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
            <h3 class="login_name"><?php echo $_SESSION['email'] ?></h3>
        </div>
    </div>

    <div class="main_container">

        <div class="center_div">

             <?php  

                    $examtitle = $_GET['examtitle'];
                    $classcode = $_GET['classcode'];

                    // echo "title = ". $examtitle;

                    // echo "exam title = ". $examtitle;

                    $examdata = $database->getReference("Exam/")
                    ->orderByChild("classcode")
                    ->equalTo($classcode)
                    ->getvalue();   

                    foreach($examdata as $examtoken => $examkey){

                        // echo "databae title = ". $examkey['examtitle'];

                    //    var_dump(strcmp($examkey['examtitle'] , $examtitle ) == 0);

                        if(strcmp($examkey['examtitle'] , $examtitle ) == 0 ){

                            // var_dump($examkey);
                            // $questiondata = $database->getReference("Exam/".$examtoken."/questions")->getvalue();
                            // var_dump($questiondata);

                            $examstatus = $examkey['status'];
                            $starttime = $examkey['starttime'];
                            $timeduration = $examkey['timeduration'];
                            $endtime = $examkey['endtime'];
                            $questionno = $examkey['questionno'];
                            $remaingingtime = strtotime($endtime) - time();

                            $update = [
                                "status" => "Helded"
                            ];
                            $database->getReference("Exam/".$examtoken)->update($update);

                        }

                    }

                    
                
                ?>

            <div class="main_left_div">

                <div class="topdiv" id="single_question_area">
                   

                </div>

                <div class="bottom" id="question_navigation_area">
                    
                </div>

                <div class="submit_btn">
                    <button class="submit submitexam">submit</button>
                </div>


            </div>




            <div class="main_right_div">
                <div class="time_bar">
                    <video autoplay="true" id="videoElement">
                    </video>
                    <h4 style="text-align:center;"> <?php echo $_SESSION['email']?> </h4>

                </div>
                <div class="question_bar" style="display: flex;justify-content: center;align-items: center;">
                    <div id="app" ></div>
                </div>

                <h4 style=" text-align:center;"> Remaining Time </h4>
            </div>

        </div>

        <div id="testing_area">
        </div>


    </div>

    
    <script src="js/TimeCircles.js"></script>

    <script>

       

        $(document).ready(function () {

            

            var examtitle = "<?php echo $examtitle ?>";
            var classcode = "<?php echo $classcode?>";

            var remainingtime = "<?php echo $remaingingtime?>";    
            setTime(remainingtime,classcode);

            load_question();
            question_navigation();

           

            function load_question(question_id = '') {
                console.log("in fun");
                $.ajax({
                    url: "user_ajax_action.php",
                    method: "POST",
                    data: { examtitle: examtitle, classcode: classcode, question_id: question_id, page: 'giveExam', action: 'load_question' },
                    success: function (data) {
                        // console.log('in console');
                        $('#single_question_area').html(data);
                    }
                })
            }

            $(document).on('click', '.next', function () {
                var question_id = $(this).attr('id');
                load_question(question_id);
            });

            $(document).on('click', '.previous', function () {
                var question_id = $(this).attr('id');
                load_question(question_id);
            });


            function question_navigation() {
                $.ajax({
                    url: "user_ajax_action.php",
                    method: "POST",
                    data: { examtitle: examtitle, classcode: classcode, page: 'giveExam', action: 'question_navigation' },
                    success: function (data) {
                        $('#question_navigation_area').html(data);
                    }
                })
            }

            $(document).on('click', '.question_navigation', function () {
                var question_id = $(this).data('question_id');
                load_question(question_id);
            });

            
            $(document).on('click', '.answer_option', function () {
                console.log("in fun");
                var question_id = $(this).data('question_id');
                var answer_option = $(this).data('ans_id');
                var option_id = $(this).data('option_id');
                $.ajax({
                    url: "user_ajax_action.php",
                    method: "POST",
                    data: {
                        examtitle: examtitle, classcode: classcode, question_id: question_id, answer_option: answer_option, option_id: option_id, page:'giveExam', action: 'answer'},
                    success: function (data) {
                        $('#testing_area').html(data);
                    }
                })
            });

            $(document).on('click', '.submitexam', function () {
                console.log('in submit exam');
                window.location.href="attendExam.php?classcode="+classcode;
            });

                        
            
        });

    </script>

    <script src="../js/camera.js"></script>

</body>

</html>