<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assignments</title>
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
                <a href="../../logout.php" class="LOGOUT">Logout</a>
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
                <a href="viewassignment.php?classcode=<?php echo $_GET['classcode'] ?>"><i class="fas fa-cogs"></i><span>View Homework</span></a>
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
                                <td><input type="text" name="assignmenttitle" id="assignmenttitle" placeholder=""/></td>
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

                       
                            <!-- <td><label for="file">Upload Question file</lable></td> -->
                            <table>
                                <tr>
                                    <td><button id="upload">Upload Question</button></td>
                                    <td><label id="showProgress"></label></td>
                                    <td><button id="submit" style="margin-left: 15px; padding: 5px 10px; margin-top:10px">Upload</button></td>
                                </tr>
                                <tr>
                               
                                <tr>
                            </table>



                        
                       
                </div>

            </div>

        </div>


    </div>

    <!-- <span id="result">Show</span> -->

    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-storage.js"></script>

    <script id="MainScript">

        

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
       
        var FileName, FileURL;
        var files = [];
        var reader = new FileReader();
        var classcode = "<?php echo $_GET['classcode'] ?>";
        var owner = "<?php echo $_SESSION['email']?>";



        document.getElementById('upload').onclick = function(e){

            console.log('in fun');

            var input = document.createElement('input');
            input.type='file';
        
            input.onchange = e =>{
                files = e.target.files;
                reader = new FileReader();
                reader.onload = function(){

                }
                reader.readAsDataURL(files[0]);
            }
            input.click();

            document.getElementById('showProgress').innerHTML = "<?php echo $_POST['assignmenttitle']?>";
            
        }


        // Upload file to storage
        document.getElementById('submit').onclick = function(e){

            FileName = "<?php echo $_POST['assignmenttitle']?>";
            var uploadTask = firebase.storage().ref('assignmentDocument/'+classcode+"/"+FileName+"/question/"+FileName+".pdf").put(files[0]);

            // document.getElementById('showProgress').innerHTML = files[0];

            uploadTask.on('state_changed', function(snapshot){

               var progress = (snapshot.bytesTranferred / snapshot.totalBytes) * 100;

                document.getElementById('showProgress').innerHTML = '('+progress+') uploading ... ';

            },
            function(error){
                alert('Something went wrong! cant able to upload file ... ');
            },
            function(){
                uploadTask.snapshot.ref.getDownloadURL().then(function(url){
                    FileURL = url;
               

                    firebase.database().ref("AssignmentDocument/"+classcode+"/"+FileName).set({
                        Assignmenttitle: FileName,
                        classcode: classcode,
                        teacher: owner,
                        link: FileURL
                    });

                    alert("File Uploaded Successfully!");


                });


            });
            

        }


    </script>

</body>

</html>


<?php

    echo "<script>document.getElementById('upload').style.visibility = 'hidden'</script>";
    echo "<script>document.getElementById('submit').style.visibility = 'hidden'</script>";

    include("../../includes/dbconfig.php");
    

    if(isset($_POST['createassignment'])){


        $assignmentitle = $_POST['assignmenttitle'];
        $assignmenttopic = $_POST['assignmenttopic'];
        $enddate = $_POST['enddate'];
        $description = $_POST['description'];
        $totalmarks = $_POST['totalmarks'];

       
        // echo $assignmentitle." ".$assignmenttopic." ".$enddate." ".$description." ".$totalmarks;

        

        $assignmentdata = [
            'assignmenttitle' => $assignmentitle,
            'assignmenttopic' => $assignmenttopic,
            'enddate' => $enddate,
            'description' => $description,
            'totalmarks' => $totalmarks,
            'teacher' => $_SESSION['email'],
            'totalsubmission' => 0,
            'classcode' => $_GET['classcode']
        ];

        $database->getReference('assignments/')->push($assignmentdata);

        $classdata = $database->getReference('classes/')
        ->orderByChild('classcode')
        ->equalTo($_GET['classcode'])
        ->getvalue();

        foreach($classdata as $classtoken => $classkey){

            if($classkey['classcode'] == $_GET['classcode']){

                $data = [
                    'assignmenttitle' => $assignmentitle,
                    'enddate' => $enddate,
                ];

                $database->getReference('classes/'.$classtoken.'/AssignmentForClass')->push($data);

                $joindata = $database->getReference('classes/'.$classtoken.'/JoinedStudent')->getvalue();

                $data = [
                    'assignmenttitle' => $assignmentitle,
                    'classcode' => $_GET['classcode'],
                    'enddate' => $enddate,
                    'marksobtain' => 0,
                    'submission' => "false",
                    'status' => 'unmarked'
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
                    echo "<script>document.getElementById('upload').style.visibility = 'visible';</script>";
                    echo "<script>document.getElementById('submit').style.visibility = 'visible';</script>";

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