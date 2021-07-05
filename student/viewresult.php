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
            <h3 class="login_name"><?php echo $_SESSION['email'] ?></h3>
        </div>
    </div>

    <div class="main_container">
        <div class="left_div2" id="welcomediv">

            <div class="close_button" onclick="removediv()">
                <a href="#" class="close_btn_teacher" id="close_btn"><i id="close" class="far fa-times-circle"></i></a>
            </div>

            <div class="profile_name">
                <div class="imagediv" >
                    <img src="../images/person.png"  alt="">
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

        <div class="right_div2">
            <div class="white_div">
                <h3>Your Exams</h3>
                <table>
                    <thead>
                        <tr>
                            <td>Exam Title</td>
                            <td>Start Date</td>
                            <td>Start Time</td>
                            <td>End Time</td>
                            <td>status</td>
                            <td></td>
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

                        }
                        else{

                            foreach($exam as $examtoken => $examkey){

                                $studentTabledata = $database->getReference('studentTable/')
                                ->orderByChild('email')
                                ->equalTo($_SESSION['email'])
                                ->getvalue();

                                foreach($studentTabledata as $studenttoken => $studentkey){

                                    if(strcmp($_SESSION['email'],$studentkey['email']) == 0){

                                        $studentexamdata = $database->getReference('studentTable/'.$studenttoken.'/assignedExam')->getvalue();

                                        if($studentexamdata == null){
                                            echo "error in student data";
                                        }
                                        else{

                                            foreach($studentexamdata as $studentexamtoken => $studentexamkey){

                                                if( strcmp($studentexamkey['examtitle'],$examkey['examtitle']) == 0 ){

                                                    if( strcmp($examkey['resultdecleared'],"false") == 0 ){

                                                        ?>

                                                            <tr> 
                                                                <td><?php echo $examkey['examtitle']?></td>
                                                                <td><?php echo $examkey['examdate']?></td> 
                                                                <td><?php echo $examkey['starttime'] ?></td>
                                                                <td><?php echo $examkey['endtime']?></td>
                                                                <td><?php echo $examkey['status']?></td>
                                                                <td>No decleared</td>
                                                            <tr>


                                                        <?php

                                                    }
                                                    else{


                                                        ?>
                                                        <tr>
                                                            <td><?php echo $examkey['examtitle']?></td>
                                                            <td><?php echo $examkey['examdate']?></td>
                                                            <td><?php echo $examkey['starttime']?></td>
                                                            <td><?php echo $examkey['endtime']?></td>
                                                            <td><?php echo $examkey['status']?></td>
                                                            <td>Decleared</td>

                                                            <td><button name="showresult" class="showresult attend" data-examtitle="<?php echo $examkey['examtitle']?>" >View</button> </td>
                                                        </tr>
                                                        <?php


                                                    }


                                                }  


                                            }


                                        }

                                    }

                                }



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

        
    
        $(document).ready(function(){

            var classcode = '<?php echo $_GET['classcode']?>';

            $(document).on('click','.showresult',function(){
                console.log("in fun");
                var examtitle = $(this).data('examtitle');
                window.location.href='studentresult.php?classcode='+classcode+"&examtitle="+examtitle;                
            });


        });

    </script>
</body>

</html>

