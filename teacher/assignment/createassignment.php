<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accusoft admin</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- <link rel="stylesheet" href="page10.css"> -->
    <link rel="stylesheet" href="../../css/sidebar.css">
    <link rel="stylesheet" href="../../css/navstyle.css">
    <link rel="stylesheet" href="../../css/stylespage.css">
</head>

<body>  

    <nav>
        <div class="left_div">
            <a href="#" class="hamberg"><i class="fas fa-bars"></i></a>
            <a href="#" class="logo_url"><img src="../images/logo.png" alt="logo" class="logo"></a>
            <h1 class="h1">True Academy</h1>
        </div>
        <div class="right_div">
            <a href="#" class="profile"><i class="fas fa-user"></i></a>
            <div class="profile_li">
                <a href="#" class="PROFILE">Profile</a>
                <a href="logout.php" class="LOGOUT">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-content">

        <!-- sidebar -->
        <div class="leftdiv">
            <div class="sidebar">
                <center>
                  <img src="\images\logo.png" class="profile_image" alt="">
                  <h4>True Academy</h4>
                </center>
                <a href="assignment/createassignment.php?classcode="<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Assign Homework</span></a>
                <a href="#"><i class="fas fa-cogs"></i><span>View Homework</span></a>
                <a href="#"><i class="fas fa-table"></i><span>Delete Homework</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Share Material</span></a>
              </div>
        </div>
       <!-- Sidebar end  -->
        <div class="rightdiv">
               
            <div style="background:white; height: 100%;">

                <div style="text-align:center; margin-top:20px">
                    <h2>Assignment Form</h2>
                </div>
                <div style="margin-left:60px; margin-top:40px ">

                    <form action="" method="POST">

                        <table>

                            <tr>
                                <td><label>Homework Title</label></td>
                                <td><input type="text" name="assignmenttitle" placeholder=""/></td>
                            </tr>

                            <tr>
                                <td><label>Homework Topic</label></td>
                                <td><input type="text" name="assignmenttopic" placeholder=""/></td>
                            </tr>
                       
                            <tr>
                                <td><label for="date">End Date</label></td>
                                <td><input type="date" name="enddate" placeholder=""/></td>
                            </tr>
                        
                            <tr>
                                <td><label for="text">Description</label></td>
                                <td><textarea id="text" name="description" placeholder="Write something.." style="height:100px"></textarea></td>
                            </tr>

                            <tr>
                                <td><label>Total Marks</label></td>
                                <td><input type="number" name="totalmarks" placeholder=""/></td>
                            </tr>
                        
                   
                        </table>

                        <button type="submit" name="createassignment" style="margin-left: 15px; padding: 5px 10px; margin-top:10px">Assign</button>
                        <button type="reset" style="padding: 5px 10px; margin-left: 40px;">clear</button>
                    </form>



                        
                       
                    </div>

            </div>

        </div>


    </div>

</body>

</html>

<?php

    include("../../includes/dbconfig.php");

    session_start();

    if(isset($_POST['createassignment'])){


        $assignmentitle = $_POST['assignmenttitle'];
        $assignmenttopic = $_POST['assignmenttopic'];
        $enddate = $_POST['enddate'];
        $description = $_POST['description'];
        $totalmarks = $_POST['totalmarks'];

        // echo $assignmenttile." ".$assignmenttopic." ".$enddate." ".$description." ".$totalmarks;

        $assignmentdata = [
            'assignmenttitle' => $assignmentitle,
            'assignmenttopic' => $assignmenttopic,
            'enddate' => $enddate,
            'description' => $description,
            'totalmarks' => $totalmarks,
            'teacher' => $_SESSION['email'],
            'totalsubmission' => 0
        ];

        $database->getReference('assignments/')->push($assignmentdata);

        $classdata = $database->getReference('classes/')
        ->orderByChild('classcode')
        ->equalTo($_GET['classcode'])
        ->getvalue();

        foreach($classdata as $classtoken => $classkey){

            if($classkey['classcode'] == $_GET['classcode']){

                $joindata = $database->getReference('classes/'.$classtoken.'/JoinedStudent')->geetvalue();

                $data = [
                    'assignmenttitle' => $assignmentitle,
                    'classcode' => $_GET['classcode'],
                    'enddate' => $enddate,
                    'marksobtain' => 0
                ];

                foreach($joindata as $joindatatoken => $joindatakey){

                    $teachedata = $database->getReference('teacherTable/')
                    ->orderByChild('email')
                    ->equalTo($_SESSION['email'])
                    ->getvalue();

                    foreach($teachedata as $teachertoken => $teacherkey){

                        if($teacherkey['email'] ==$_SESSION['email'] ){


                            $teacherpush = [
                                'assignmenttitle' => $assignmentitle,
                                'classcode' => $classtoken,
                                'enddate' => $enddate
                            ];

                            $database->getReference('teacherTable/'.$teachertoken.'/assignmentcreated')->push($teacherpush);

                        }

                    }

                    $studentdata = $database->getReference('studentTable/')
                    ->orderByChild('email')
                    ->equalTo($joindatakey['studentemail'])
                    ->getvalue();

                    foreach($studentdata as $studentdatatoken => $studentdatakey){

                        $database->getReference('studentTable/'.$studentdatatoken.'/assignedHomework')->push($data);

                    }
                    


                }

                $temp = $classkey['totalAssignmentGiven'] + 1;
                $update = [
                    'totalAssignmentGiven' => $temp
                ];

                try{
                    $database->getReference('classes/'.$classtoken)->update($update);
                    echo "<script type='text/javascript'>alert('assignment created successfully!')</script>";
                }
                catch(Exception $e){
                    echo "<script type='text/javascript'>alert('something went wrong!')</script>";
                }
                finally{

                }


            }


        }

    }


?>