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
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../css/exam_question.css">
    <link rel="stylesheet" href="../css/navstyle.css">
    <link rel="stylesheet" href="../css/TimeCircles.css">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>exam</title>
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

    <div class="main_container">
        
        <div class="center_div">

            <div class="main_left_div" style="margin-bottom:-500px;">
                <?php

                    

                    $examtitle = $_GET['examtitle'];
                    $classcode = $_GET['classcode'];

                    // echo "exam title = ". $examtitle;

                    $examdata = $database->getReference("Exam/")
                    ->orderByChild("classcode")
                    ->equalTo($classcode)
                    ->getvalue();   

                    foreach($examdata as $examtoken => $examkey){

                        if(strcmp($examkey['examtitle'] , $examtitle ) == 0 ){

                            // $questiondata = $database->getReference("Exam/".$examtoken."/questions")->getvalue();
                            // var_dump($questiondata);

                            $examstatus = $examkey['status'];
                            $starttime = $examkey['starttime'];
                            $timeduration = $examkey['timeduration'];
                            $endtime = $examkey['endtime'];
                            $remaingingtime = strtotime($endtime) - time();

                        }

                    }

                    $studentdata = $database->getReference("studentTable/")
                    ->orderByChild("email")
                    ->equalTo($_SESSION['email'])
                    ->getvalue();

                    foreach($studentdata as $studenttoken => $studentkey){

                        if($studentkey['email'] == $_SESSION['email'] ){

                            $examassign = $database->getReference("studentTable/".$studenttoken."/assignedExam")->getvalue();

                            foreach($examassign as $examassigntoken => $examassignkey){

                                if(strcmp($examassignkey['examtitle'],$examtitle) == 0){
                                    
                                    $update = [
                                        'attendance' => "attended"
                                    ];
                                    try{
                                        $database->getReference("studentTable/".$studenttoken."/assignedExam/".$examassigntoken)->update($update);
                                    }
                                    catch(Exception $e){

                                    }
                                    
                                }

                            }    

                        }

                    }
                
                ?>
                <div class = "topdiv" id="single_question_area">
                        
               
                </div>

                <div class="bottom" id="question_navigation_area">
                    
                </div>
            </div>


            <div class="main_right_div" >
                <div class="time_bar">
                    <video autoplay="true" id="videoElement" >
                    </video>
                    <h4 style="text-align:center;"> Yash Sahane </h4>
                    
                </div>
                <div class="question_bar">
                    <div id="exam_timer" data-timer="<?php echo $remaingingtime; ?>" ></div>
                    
                    <h4 style="margin-top:85px; text-align:center;"> Remaining Time </h4>
                </div>
            </div>

        </div>
        

    </div>


    <script>

       
        $(document).ready(function(){

           

            var examtitle = "<?php echo $examtitle ?>";
            var classcode = "<?php echo $classcode?>";    

	        load_question();
            question_navigation();
	


	        function load_question(question_id = '')
	        {
                $.ajax({
                    url:"user_ajax_action.php",
                    method:"POST",
                    data:{examtitle:examtitle, classcode:classcode, question_id:question_id, page:'giveExam', action:'load_question'},
                    success:function(data)
                    {
                        $('#single_question_area').html(data);
                    }
                })
            }

            $(document).on('click', '.next', function(){
                console.log("in fun");
                var question_id = $(this).attr('id');
                load_question(question_id);
            });

            $(document).on('click', '.previous', function(){
                var question_id = $(this).attr('id');
                load_question(question_id);
            });


            function question_navigation()
            {
                $.ajax({
                    url:"user_ajax_action.php",
                    method:"POST",
                    data:{examtitle:examtitle,classcode:classcode, page:'giveExam', action:'question_navigation'},
                    success:function(data)
                    {
                        $('#question_navigation_area').html(data);
                    }
                })
            }

            $(document).on('click', '.question_navigation', function(){
                console.log("in fun");
                var question_id = $(this).data('question_id');
                load_question(question_id);
            });

            $("#exam_timer").TimeCircles({ 
                time:{
                    Days:{
                        show: false
                    },
                    Hours:{
                        show: false
                    }
                }
            });

            setInterval(function(){
                var remaining_second = $("#exam_timer").TimeCircles().getTime();
                if(remaining_second < 1)
                {
                    alert('Exam time over');
                    location.href("attendExam.php?<?php echo $classcode?>");
                }
            }, 1000);


        });

    </script>

    <script src="../js/TimeCircles.js"></script>
    <script src="../js/camera.js"></script>

</body>

</html>