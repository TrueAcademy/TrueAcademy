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
    <title>Exam Dashboard</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
    <link rel="stylesheet" href="../css/cards.css">
    <link rel="stylesheet" href="../css/stylespage.css">
    <!-- <link rel="stylesheet" href="coursepage_student.css"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <h3 class="login_name"><?php echo $_SESSION['email']?></h3>
        </div>
    </div>

    <div class="main_container" style="height:fit-content;">

        <div class="left_div2" id="welcomediv" style="height: auto;">

            <div class="close_button" onclick="removediv()">
                <a href="#" class="close_btn_teacher" id="close_btn"><i id="close" class="far fa-times-circle"></i></a>
            </div>

            <div class="profile_name">
                <div class="imagediv">
                    <img src="../images/person.png" alt="">
                </div>
                <h3>
                    <?php echo $_SESSION['email']?>
                </h3>
                <h6>student</h6>
            </div>


            <div class="side_btn">
            <a href="viewassignments.php?classcode=<?php echo $_GET['classcode'] ?>"><i class="fas fa-cogs"></i><span>View Homework</span></a>
            <a href="#"><i class="fas fa-th"></i><span>Share Material</span></a>
            </div>

        </div>

        
        <div class="right_div2" style="display: flex;flex-direction: column;align-items: center;height: fit-content;">

            <div class="white_div" style="margin-bottom: 100px;">
                <h3>Assignment list</h3>
                <table>
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
                            <td style="display: flex;justify-content: left;">upload your work</td> 
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
                                                            <?php
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

    </div>

    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-storage.js"></script>

    <script>
        function showdiv() {
            document.getElementById('welcomediv').style.display = "block";
        }

        function removediv() {
            document.getElementById('welcomediv').style.display = "none";
        }

        

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
    </script>
</body>

</html>