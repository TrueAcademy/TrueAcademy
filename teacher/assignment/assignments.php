<?php

    session_start();


    
    if( $_SESSION['email'] == null ){

        echo "<script type='text/javascript'>alert('Cant open user is not authorized!')</script>";
        header("Location:index.html"); 

    }
    include('../../includes/dbconfig.php');
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
            <a href="createassignment.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Assign Homework</span></a>
                <a href="viewassignment.php?classcode=<?php echo $_GET['classcode']?>"><i class="fas fa-cogs"></i><span>View Homework</span></a>
                <a href="#"><i class="fas fa-table"></i><span>Delete Homework</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Share Material</span></a>
            </div>

        </div>


        <div class="right_div2" style="display:flex;flex-direction:column;width:900px;margin-right:300px;height
        100%;">

        <div style="background:white; height: 100%;padding:50px;margin-bottom:100pxdisplay: flex;flex-direction: column;align-items: center;height: fit-content;width:1200px;margin-top:80px;margin-left:0pxpx">

                        <div class="recent-grid" style="background-color:white;height:fit-content">
                            <!-- List of student joined -->
                            <div class="projects">
                                <div class="card">
                                    <div class="card-header" style="padding:20px">
                                        <h3>List of Students</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr style="height:50px">
                                                        <td>Student Name</td>
                                                        <td>Email</td>
                                                        <td>status</td>
                                                        <td>View assignment</td>
                                                        <td>Give marks</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <?php
                                                    
                                                        $assignmentdata = $database->getReference('assignments/')
                                                        ->orderByChild('classcode')
                                                        ->equalTo($_GET['classcode'])
                                                        ->getvalue();

                                                        foreach($assignmentdata as $assignmenttoken => $assignmentkey){

                                                            if($assignmentkey['assignmenttitle'] == $_GET['assignmenttitle'] ){

                                                                $classdata = $database->getReference('classes/')
                                                                ->orderByChild('classcode')
                                                                ->equalTo($_GET['classcode'])
                                                                ->getvalue();

                                                                foreach($classdata as $classtoken => $classkey){

                                                                    if($classkey['classcode'] == $_GET['classcode']){

                                                                        $joineddatalist = $database->getReference('classes/'.$classtoken.'/JoinedStudent')->getvalue();

                                                                        foreach($joineddatalist as $joineddatatoken => $joineddatakey){

                                                                            $studentdata = $database->getReference('studentTable/')
                                                                            ->orderByChild('email')
                                                                            ->equalTo($joineddatakey['studentemail'])
                                                                            ->getvalue();

                                                                            foreach($studentdata as $studenttoken => $studentkey){

                                                                                $studentassignmentdata = $database->getReference('studentTable/'.$studenttoken.'/assignedHomework')->getvalue();

                                                                                foreach($studentassignmentdata as $studentassignmentdatatoken => $studentassignmentdatakey){

                                                                                    if($studentassignmentdatakey['assignmenttitle'] == $_GET['assignmenttitle'] ){

                                                                                        if($studentassignmentdatakey['submission'] == "false" ){

                                                                                            ?>

                                                                                            <tr style="height:50px">
                                                                                                <td><?php echo $studentkey['firstname']." ".$studentkey['lastname'] ?></td>
                                                                                                <td><?php echo $studentkey['email'] ?></td>
                                                                                                <td>not submitted</td>
                                                                                                <td><button style="padding:5px 10px 5px 10px;background-color:#2ac95a;color:white;font-size:16px;border:none;cursor:pointer"id="viewassignment" class="viewassignment" disabled>View </button></td>
                                                                                                <td><input type="number" name="assignmentmarks" class="assignmentmarks" placeholder="put marks here" /></td>
                                                                                                <td><button style="padding:5px 10px 5px 10px;background-color:#2ac95a;color:white;font-size:16px;border:none;cursor:pointer"id="assignmarks" class="assignmarks" disabled>Give Marks</button></td>
                                                                                       
                                                                                            </tr>

                                                                                            <?php 

                                                                                        }
                                                                                        else{

                                                                                            
                                                                                            ?>

                                                                                            <tr>
                                                                                                <td><?php echo $studentkey['firstname']." ".$studentkey['lastname'] ?></td>
                                                                                                <td><?php echo $studentkey['email'] ?></td>
                                                                                                <td>submitted</td>
                                                                                                <td><button style="padding:5px 10px 5px 10px;background-color:#2ac95a;color:white;font-size:16px;border:none;cursor:pointer"id="viewassignment" class="viewassignment" data-studentemail="<?php echo $studentkey['email']?>" data-studentname="<?php echo $studentkey['firstname']." ".$studentkey['lastname'] ?>"  >View </button></td>
                                                                                                <td><input type="number" name="assignmentmarks" id="assignmentmarks" class="assignmentmarks" placeholder="put marks here" /></td>
                                                                                                <td><button style="padding:5px 10px 5px 10px;background-color:#2ac95a;color:white;font-size:16px;border:none;cursor:pointer"id="assignmarks" class="assignmarks" data-studentemail="<?php echo $studentkey['email']?>">Give Marks</button></td>
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

    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-storage.js"></script>


    <script>

         // Configuration
         var firebaseConfig = {
            apiKey: "AIzaSyBhBIN6KmoYCje575Ls5ybl4uKxXntVF-k",
            authDomain: "trueacademy-13962.firebaseapp.com",
            databaseURL: "https://trueacademy-13962-default-rtdb.firebaseio.com/",
            projectId: "trueacademy-13962",
            storageBucket: "gs://trueacademy-13962.appspot.com",
            messagingSenderId: "32348987090",
            appId: "1:32348987090:web:2bb2808f8f99e28c02570b",
            measurementId: "G-8QZCS8BSE0"
        };
        firebase.initializeApp(firebaseConfig);


        $(document).ready(function(){

            var classcode = "<?php echo $_GET['classcode'] ?>";
            var assignmenttitle = "<?php echo $_GET['assignmenttitle']?>";

            console.log('classcode = '+ classcode);
            console.log('title = '+ assignmenttitle);

            $(document).on('click','.viewassignment',function(){

                var studentname = $(this).data('studentname');
                // console.log("student name = "+ studentname);

                console.log('link = AssignmentDocument/'+classcode+"/"+assignmenttitle+"/submissions/"+studentname);

                firebase.database().ref('AssignmentDocument/'+classcode+"/"+assignmenttitle+"/submissions/"+studentname).on('value',function(snapshot){

                    DownloadFile(snapshot.val().link,studentname);

                });

               
            });

            function DownloadFile(url,fileName) { 
                //Set the File URL.
                // var url = "Files/" + fileName;
            
                //Create XMLHTTP Request.
                var req = new XMLHttpRequest();
                req.open("GET", url, true);
                req.responseType = "blob";
                req.onload = function () {
                    //Convert the Byte Data to BLOB object.
                    var blob = new Blob([req.response], { type: "application/octetstream" });
            
                    //Check the Browser type and download the File.
                    var isIE = false || !!document.documentMode;
                    if (isIE) {
                                window.navigator.msSaveBlob(blob, fileName);
                    } else {
                        var url = window.URL || window.webkitURL;
                        link = url.createObjectURL(blob);
                        var a = document.createElement("a");
                        a.setAttribute("download", fileName);
                        a.setAttribute("href", link);
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }
                };
                req.send();
            };

            $(document).on('click','.assignmarks', function (){

                var marks = document.getElementById('assignmentmarks').value;
                var studentemail = $(this).data('studentemail');

                console.log('marks = '+ marks);
                console.log('email = '+ studentemail);

                $.ajax({
                    url:'assignment_ajax_action.php',
                    method:'POST',
                    data:{classcode:classcode,assignmenttitle:assignmenttitle,studentemail:studentemail,marks:marks,page:"assignments",action:"assignmarks"},
                    success:function(data){
                        $('#testing').html(data);
                        alert('marks updated sucessfully ... ');
                    },
                    error:function(){
                        alert('Something went wrong!')
                    }
                })

            });



        });
        

    </script>

</body>
</html>