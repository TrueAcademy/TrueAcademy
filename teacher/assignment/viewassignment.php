<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assignments</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- <link rel="stylesheet" href="page10.css"> -->
    <link rel="stylesheet" href="../../css/sidebar-temp.css">
    <link rel="stylesheet" href="../../css/navstyle.css">
    <link rel="stylesheet" href="../../css/stylespage_temp.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>  

    <nav>
        <div class="left_div">
            <a href="#" class="hamberg"><i class="fas fa-bars"></i></a>
            <a href="#" class="logo_url"><img src="../../images/logo.png" alt="logo" class="logo"></a>
            <h1 class="h1">True Academy</h1>
        </div>
        <div class="right_div">
            <a href="#" class="profile"><i class="fas fa-user"></i></a>
            <div class="profile_li">
                <a href="#" class="PROFILE">Profile</a>
                <a href="../../logout.php" class="LOGOUT">Logout</a>
            </div>
            <div>
    </nav>
    <div class="main-content">

        <!-- sidebar -->
        <div class="leftdiv">
            <div class="sidebar">
                <center>
                  <img src="../../images/person.png" class="profile_image" alt="">
                  <h4>True Academy</h4>
                </center>
                <a href="createassignment.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Assign Homework</span></a>
                <a href="viewassignment.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-cogs"></i><span>View Homework</span></a>
                <a href="#"><i class="fas fa-table"></i><span>Delete Homework</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Share Material</span></a>
              </div>
        </div>
        <main class="min-page">
            
            <!--sidebar end-->
            <div class="rightdiv">
                
                <div class="recent-grid">
                    <!-- List of student joined -->
                    <div class="projects">
                        <div class="card">
                            <div class="card-header">
                                <h3>List of assign homework</h3>
                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table width="100%">
                                        <thead>
                                            <tr>
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
     
                                                    <tr>
                                                        <td><?php echo $count?></td>
                                                        <td><?php echo $assignmentkey['assignmenttitle']?></td>
                                                        <td><?php echo $assignmentkey['enddate']?></td>
                                                        <td><?php echo $assignmentkey['totalsubmission']?>
                                                        <td><button name="viewassignment" class='viewassignment' data-assignmenttitle="<?php echo $assignmentkey['assignmenttitle']?>" > view </button></td>
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