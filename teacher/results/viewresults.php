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
    <title>results</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../css/sidebar.css"/>
    <link rel="stylesheet" href="../../css/navbar.css"/>
    <link rel="stylesheet" href="css/stylespage.css"/>
    <link rel="stylesheet" href="../css/cards.css"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<style>
        @media screen and (max-width: 600px) {
            .white_div {
                width: 375px;
                height: fit-content;
                background-color: white;
                margin-top: 100px;
            }

            .right_div2 {
                width: 375px;
                padding: 0px;
                margin: 0px
            }

        }

        @media screen and (max-width: 400px) {
            .cards {
                display: grid;
                grid-template-columns: repeat(1, 1fr);
                height: fit-content;
                grid-gap: 3rem;
                padding: 0px;
                margin: 30px 40px 0px 0px;
            }

            .card-single {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                width: 100%;
                background: #fff;
                padding: 2rem;
                border-radius: 2px;
            }

            .main_container {
                width: 100vw;
                padding: 0px;
                margin: 0px;
            }
        }
    </style>
<body style="background-color:#f1f5f9">

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
   

    <div class="main_container" style="height:100vh;">
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
                <a href="../exam/createExam.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Create Exam</span></a>
                <a href="#"><i class="fas fa-cogs"></i><span>Manage Exam</span></a>
                <a href="viewresults.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-table"></i><span>View Result</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Delete Exam</span></a>
            </div>

        </div>

        <div class="right_div2" style="display:flex;flex-direction:column;width:900px;margin-right:300px;height
        100%;">
          <div class="cards" style="margin-left: 75px;margin-top:80px;margin-bottom:80px">
                
                <?php 
                    
                    include('../../includes/dbconfig.php');
                    $collection = "classes/";
                    $classdata = $database->getReference($collection)
                    ->orderByChild('classcode')
                    ->equalTo($_GET['classcode'])
                    ->getvalue();

                    foreach($classdata as $classtoken => $classkey){

                        ?>
                        
                        <div class="card-single">
                                <div>
                                    <h1><?php echo $classkey['totalExamConducted'] ?></h1>
                                    <span>Total Exam Conducted</span>
                                </div>
                            </div>
                            <div class="card-single">
                                <div>
                                    <h1><?php echo $classkey['totalJoined'] ?></h1>
                                    <span>Total Examines</span>
                                </div>
                            </div>


                        <?php

                    }

                ?> 
            
            </div>
                        <div class="recent-grid" style="background-color:white;height:fit-content;margin-left:80px">
                            <!-- List of student joined -->
                            <div class="projects">
                                <div class="card">
                                    <div class="card-header" style="padding:20px">
                                        <h3>Results are available for following</h3>
                                    </div>
                                    <div class="card-body" id="testing">
                                        <div class="table-responsive">
                                            <table width="100%" style="padding-left:20px">
                                                <thead>
                                                    <tr style="height:50px">
                                                        <td>Exam Title</td>
                                                        <td>Start Date</td>
                                                        <td>Time</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                
                                                    $exam = $database->getReference("Exam/")
                                                    ->orderByChild('classcode')
                                                    ->equalto($_GET['classcode'])
                                                    ->getvalue();

                                                    if($exam == null){
                                                         ?>
                                                            <tr> <td> No Exam is Done </td> <tr>
                                                         <?php

                                                    }
                                                    else{

                                                        foreach($exam as $examtoken => $examkey){
                                                            
                                                            // $examtitle = $examkey['examtitle'];
                                                            $classcode = $_GET['classcode'];

                                                            if($examkey['status'] == "Helded" ){

                                                            
                                                                ?>
                                                                
                                                                <tr style="height:50px">
                                                                    <td><?php echo $examkey['examtitle']?></td>
                                                                    <td><?php echo $examkey['examdate']?></td>
                                                                    <td><?php echo $examkey['starttime']?></td>
                                                                    <td><button style="padding:5px 20px 5px 20px;background-color:#2ac95a;font-size:16px;color:white;outline:none;border:none"class="view" name="view" data-examtitle="<?php echo $examkey['examtitle']?>" >View</button></td>
                                                                    <td><button style="padding:5px 20px 5px 20px;background-color:#2ac95a;font-size:16px;color:white;outline:none;border:none"class="publish" name="publish" data-examtitle="<?php echo $examkey['examtitle'] ?>" >publish</button></td> 
                                                                </tr>

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
</div>

    <script>
        function showdiv() {
            document.getElementById('welcomediv').style.display = "block";
        }

        function removediv() {
            document.getElementById('welcomediv').style.display = "none";
        }
    </script>
           
    <script>

        $(document).ready(function(){


            var classcode = "<?php echo $classcode ?>";

            $(document).on('click','.view', function(){
                // console.log("in fun");
                var examtitle = $(this).data('examtitle');
                window.location.href = 'results.php?examtitle='+examtitle+"&classcode="+classcode;
            });

            $(document).on('click','.publish',function(){
                console.log("in fun");
                var examtitle = $(this).data('examtitle');
                $.ajax({
                    url:'admin_ajax_action.php',
                    method:"POST",
                    data:{examtitle:examtitle,classcode:classcode,page:"viewresults",action:"publishresults"},
                    success:function(data){
                        // $('#testing').html(data);
                        alert("Results Published successfully!");
                        // header.location="viewresults.php?classcode="+classcode;
                    },
                    error:function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        alert("Something went wrong");
                    }
                })
            });


        });

    </script>

</body>
</html>