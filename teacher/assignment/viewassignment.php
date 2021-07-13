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
            <h3 class="login_name">shubhamsapkal70@gmail.com </h3>
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
                <a href="assignment/createassignment.php?classcode="<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Assign Homework</span></a>
                <a href="viewassignment.php?classcode=<?php echo $_GET['classcode'] ?>"><i class="fas fa-cogs"></i><span>View Homework</span></a>
            </div>

        </div>


        <div class="right_div2" style="display:flex;flex-direction:column;width:900px;margin-right:300px;height
        100%;">

        <div style="background:white; height: 100%;padding:50px;margin-bottom:100pxdisplay: flex;flex-direction: column;align-items: center;height: fit-content;width:900px;margin-top:80px;margin-left:100px">

                <div class="recent-grid" style="background-color:white;height:fit-content">
                    <!-- List of student joined -->
                    <div class="projects">
                        <div class="card">
                            <div class="card-header" style="padding:20px">
                                <h3>List of assign homework</h3>
                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table width="100%">
                                        <thead>
                                            <tr style="height:50px">
                                                <td>SR.NO</td>
                                                <td>Homework Title</td>
                                                <td>Submission End Date</td>  
                                                <td>Submission Till yet</td>
                                                <td></td>                       
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                            include("../../includes/dbconfig.php");
                                        
                                            $assignmentdata = $database->getReference('assignments/')
                                            ->orderByChild('classcode')
                                            ->equalTo($_GET['classcode'])
                                            ->getvalue();

                                            $count = 1;
                                            foreach($assignmentdata as $assignmenttoken => $assignmentkey){

                                                ?>
     
                                                    <tr style="height:50px">
                                                        <td><?php echo $count?></td>
                                                        <td><?php echo $assignmentkey['assignmenttitle']?></td>
                                                        <td><?php echo $assignmentkey['enddate']?></td>
                                                        <td><?php echo $assignmentkey['totalsubmission']?>
                                                        <td><button style="padding:5px 10px 5px 10px;background-color:#2ac95a;color:white;font-size:16px;border:none;cursor:pointer"name="viewassignment" class='viewassignment' data-assignmenttitle="<?php echo $assignmentkey['assignmenttitle']?>" > view </button></td>
                                                    </tr>

                                                <?php 

                                            }
                                            
                                        
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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

            var classcode = "<?php echo $_GET['classcode']?>";

            $(document).on('click','.viewassignment',function(){

                // console.log('In fun');

                var assignmenttitle = $(this).data('assignmenttitle');
                console.log('title='+assignmenttitle);
                window.location.href = "assignments.php?classcode="+classcode+"&assignmenttitle="+assignmenttitle;

            });

        });

    </script>

</body>

</html>