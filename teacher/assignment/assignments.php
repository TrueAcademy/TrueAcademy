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
    <title>Assignments</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../css/stylespage_temp.css">
    <link rel="stylesheet" href="../../css/navstyle.css">
    <link rel="stylesheet" href="../../css/sidebar-temp.css">
    <!-- <link rel="stylesheet" href="../css/page2.css">     -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>    
<body>

    <nav class="navbar">
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
            <h4 class="login_name"> <?php echo $_SESSION['email']?> </h4>
        <div>
    </nav>
    
   

    <div class="main-content">

        <!-- sidebar -->
        <div class="leftdiv">
                <div class="sidebar">
                    <center>
                        <img src="../../images/person.png" class="profile_image" alt="">
                        <h4 style="font-size: 12px; margin-bottom:5px"><?php echo $_SESSION['email']?></h4>
                        <h6 style="color: #ccc; margin-bottom:15px">Teacher</h6>
                    </center>
                    <a href="assignment/createassignment.php?classcode="<?php echo $_GET['classcode']?>"><i class="fas fa-desktop"></i><span>Assign Homework</span></a>
                    <a href="viewassignment.php?classcode=<?php echo $_GET['classcode'] ?>"><i class="fas fa-cogs"></i><span>View Homework</span></a>
                    <a href="#"><i class="fas fa-table"></i><span>Delete Homework</span></a>
                    <a href="#"><i class="fas fa-th"></i><span>Share Material</span></a>
                </div>
        </div>
        <!--sidebar end-->


        <main>
            
            <div class="rightdiv">
                <?php 
            
                    include('../../includes/dbconfig.php');
                    
            
                ?>
                            
                        <div class="recent-grid">
                            <!-- List of student joined -->
                            <div class="projects">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>List of Students</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
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

                                                                                            <tr>
                                                                                                <td><?php echo $studentkey['firstname']." ".$studentkey['lastname'] ?></td>
                                                                                                <td><?php echo $studentkey['email'] ?></td>
                                                                                                <td>not submitted</td>
                                                                                                <td><button id="viewassignment" class="viewassignment" disabled>View </button></td>
                                                                                                <td><input type="number" name="assignmentmarks" class="assignmentmarks" placeholder="put marks here" /></td>
                                                                                                <td><button id="assignmarks" class="assignmarks" disabled>Give Marks</button></td>
                                                                                       
                                                                                            </tr>

                                                                                            <?php 

                                                                                        }
                                                                                        else{

                                                                                            
                                                                                            ?>

                                                                                            <tr>
                                                                                                <td><?php echo $studentkey['firstname']." ".$studentkey['lastname'] ?></td>
                                                                                                <td><?php echo $studentkey['email'] ?></td>
                                                                                                <td>submitted</td>
                                                                                                <td><button id="viewassignment" class="viewassignment" data-studentemail="<?php echo $studentkey['email']?>" data-studentname="<?php echo $studentkey['firstname']." ".$studentkey['lastname'] ?>"  >View </button></td>
                                                                                                <td><input type="number" name="assignmentmarks" id="assignmentmarks" class="assignmentmarks" placeholder="put marks here" /></td>
                                                                                                <td><button id="assignmarks" class="assignmarks" data-studentemail="<?php echo $studentkey['email']?>">Give Marks</button></td>
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
            <div id="testing">Testing</div>     
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