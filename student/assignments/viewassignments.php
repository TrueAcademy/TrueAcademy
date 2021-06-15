<?php

    session_start();


    
    if( $_SESSION['email'] == null ){

        echo "<script type='text/javascript'>alert('Cant open! user is not authorized...')</script>";
        header("Location:index.html"); 

    }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accusoft admin</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- <link rel="stylesheet" href="page10.css"> -->
    <link rel="stylesheet" href="../../css/sidebar.css">
    <link rel="stylesheet" href="../../css/navstyle.css">
    <link rel="stylesheet" href="../../css/stylespage.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <div>
    </nav>
    <div class="main-content">

        <!-- sidebar -->
        <div class="leftdiv">
            <div class="sidebar">
                <center>
                  <img src="\images\logo.png" class="profile_image" alt="">
                  <h4>True Academy</h4>
                </center>
                <a href="viewassignments.php?<?php echo $_GET['classcode'] ?>"><i class="fas fa-cogs"></i><span>View Homework</span></a>
                <a href="#"><i class="fas fa-th"></i><span>Share Material</span></a>
              </div>
        </div>
        <main class="min-page">
            
            <!--sidebar end-->
            <div class="rightdiv">

            <?php ?>
                
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
                                                <td>Assignment Title</td>
                                                <td>Assignment topic</td>
                                                <td>Description</td>
                                                <td>Submission End Date</td>  
                                                <td>Total marks<td>
                                                <td>Download Question</td>
                                                <td>status</td>
                                                <td>Marks You got</td> 
                                                <td>upload your work</td>                       
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                            include("../../includes/dbconfig.php");
                                        
                                            $assignmentdata = $database->getReference('assignments/')
                                            ->orderByChild('classcode')
                                            ->equalTo($_GET['classcode'])
                                            ->getvalue();

                                            $studentname = "";

                                            $count = 1;
                                            foreach($assignmentdata as $assignmenttoken => $assignmentkey){

                                                $studentdata = $database->getReference('studentTable/')
                                                ->orderByChild('email')
                                                ->equalTo($_SESSION['email'])
                                                ->getvalue();

                                                foreach($studentdata as $studenttoken => $studentkey){

                                                    if($studentkey['email'] == $_SESSION['email'] ){

                                                        $studentname = $studentkey['firstname']." ".$studentkey['lastname'];

                                                        $studentassignmentdata = $database->getReference('studentTable/'.$studenttoken.'/assignedHomework')->getvalue();


                                                        $count = 1;
                                                        foreach($studentassignmentdata as $studentassignmenttoken => $studentassignmentkey){

                                                            if($studentassignmentkey['assignmenttitle'] == $assignmentkey['assignmenttitle'] ){

                                                                if($studentassignmentkey['submission'] == "false"){

                                                                    ?>
                 
                                                                        <tr>
                                                                            <td><?php echo $count?></td>
                                                                            <td><?php echo $assignmentkey['assignmenttitle']?></td>
                                                                            <td><?php echo $assignmentkey['assignmenttopic']?></td>
                                                                            <td><?php echo $assignmentkey['description']?></td>
                                                                            <td><?php echo $assignmentkey['enddate']?></td>  
                                                                            <td><?php echo $assignmentkey['totalmarks']?><td>
                                                                            <td><button id="downloadques" class="downloadques" data-assignmenttitle="<?php echo $assignmentkey['assignmenttitle']?>">Downlaod</button></td>
                                                                            <td>Not submitted</td>
                                                                            <td>Unmarked</td>    
                                                                            <td><button id="upload" class="upload" data-assignmenttitle="<?php echo $assignmentkey['assignmenttitle']?>">upload</button></td>                       
                                                                        </tr>


                                                                    <?php

                                                                }else{

                                                                    ?>
                 
                                                                        <tr>
                                                                            <td><?php echo $count?></td>
                                                                            <td><?php echo $assignmentkey['assignmenttitle']?></td>
                                                                            <td><?php echo $assignmentkey['assignmenttopic']?></td>
                                                                            <td><?php echo $assignmentkey['description']?></td>
                                                                            <td><?php echo $assignmentkey['enddate']?></td>  
                                                                            <td><?php echo $assignmentkey['totalmarks']?><td>
                                                                            <td><button id="downloadques" class="downloadques" data-assignmenttitle="<?php echo $assignmentkey['assignmenttitle']?>">Downlaod</button></td>
                                                                            <td>submitted</td>
                                                                            <?
                                                                                if($studentassignmentkey['status'] == "unmarked"){
                                                                                    echo "<td>unmarked</td>";
                                                                                }
                                                                                else{
                                                                                    echo "<td>".$studentassignmentkey['marksobtain']."</td>";
                                                                                }
                                                                            ?>    
                                                                            <td><button id="upload" class="upload" disabled>upload</button></td>                       
                                                                        </tr>


                                                                    <?php

                                                                }
                                                                $count = $count+1;

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
                            <div id="testing">Testing</div>
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

            var classcode = "<?php echo $_GET['classcode']?>";
            var email = "<?php echo $_SESSION['email'] ?>";

            $(document).on('click','.downloadques',function(){
                console.log('in fun')
                var assignmenttitle = $(this).data('assignmenttitle');

                firebase.database().ref("AssignmentDocument/"+classcode+"/"+assignmenttitle).on('value', function(snapshot){
                    console.log('in ref = '+snapshot.val().link);
                    // document.getElementById('downloadques').src = snapshot.val().link;
                    DownloadFile(snapshot.val().link,assignmenttitle);
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

            var files = [];
            var studentname = "<?php echo $studentname?>";


            $(document).on('click','.upload',function(){

                console.log('in fun');

                var assignmenttitle = $(this).data('assignmenttitle');

                console.log("assignment title = "+ assignmenttitle);

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

                // Uploading file to firebase storage
                var uploadTask = firebase.storage().ref('assignmentDocument/'+classcode+"/"+assignmenttitle+"/submission/"+ studentname +".pdf").put(files[0]);


                uploadTask.on('state_changed', function(snapshot){

                    var progress = (snapshot.bytesTranferred / snapshot.totalBytes) * 100;
                    console.log('('+progress+') uploading ... ');

                },
                function(error){
                    alert('Something went wrong! cant able to upload file ... ');
                },
                function(){
                    uploadTask.snapshot.ref.getDownloadURL().then(function(url){
                        FileURL = url;


                        firebase.database().ref("AssignmentDocument/"+classcode+"/"+assignmenttitle+"/submissions/"+studentname).set({
                            Assignmenttitle: assignmenttitle,
                            classcode: classcode,
                            submitBy: email,
                            link: FileURL
                        });

                        $.ajax({

                            url:"assignment_ajax.php",
                            method:"POST",
                            data:{assignmenttitle:assignmenttitle,classcode:classcode,email:email,page:"viewassignments",action:"submitassignment"},
                            success:function(data){
                                $('#testing').html(data);
                                alert("Successfully Uploaded Successfully!");
                            }

                        })

                        


                    });


                });


            });

            

        });

    </script>

</body>

</html>