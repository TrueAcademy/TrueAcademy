<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accusoft admin</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/stylespage.css">
    <link rel="stylesheet" href="../css/navstyle.css">
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
            <h4 class="login_name"> <?php echo $_SESSION['email']?> </h4>
        <div>
    </nav>
    
   

    <div class="main-content">
        
        <main>
            <?php
                include("../includes/dbconfig.php");

                $collection = "classes/";
                $classdata = $database->getReference($collection)
                ->orderByChild('classcode')
                ->equalTo($_GET['classcode'])
                ->getvalue();

                foreach($classdata as $classtoken => $classkey){

                    if($classkey['classcode'] == $_GET['classcode'] ){


                        ?>


                        <div class="cards">
                                <div class="card-single">
                                    <div>
                                        <h1><?php echo $classkey['totalExamConducted']?></h1>
                                        <span>Total Exam Conducted</span>
                                    </div>
                                </div>


                                <div class="card-single">
                                    <div>
                                        <h1><?php echo $classkey['totalAssignmemtGiven']?></h1>
                                        <span>Total Assignment</span>
                                    </div>
                                </div>

                                <div class="card-single">
                                    <div>
                                        <h1><?php echo $classkey['totalJoined']?></h1>
                                        <span>Total Student Joined</span>
                                    </div>
                                </div>
                         </div>

                        
                         <div class="recent-grid">
                             <!-- List of student joined -->

                            <div class="projects">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>List Of Student Joined</h3>
                                            </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>First Name</td>
                                                        <td>Last Name</td>
                                                        <td>Email</td>
                                                    </tr>
                                                </thead>
                                                    <?php
                                                    
                                                        $joinedclasstoken = $collection.$classtoken."/JoinedStudent";
                                                        $innercollection = $database->getReference($joinedclasstoken)->getvalue();

                                                        foreach($innercollection as $intertoken => $innerkey){

                                                            // var_dump($innerkey);

                                                            $temp = $database->getReference('studentTable')
                                                            ->orderByChild('email')
                                                            ->equalTo($innerkey['studentemail'])
                                                            ->getvalue();

                                                            foreach($temp as $temptoken => $tempkey){

                                                            ?>                    
                                                                <tbody>
                                                                    <tr>
                                                                        <td><?php echo $tempkey['firstname']?></td>
                                                                        <td><?php echo $tempkey['lastname'] ?></td>
                                                                        <td><?php echo $tempkey['email'] ?></td>
                                                                    </tr>         
                                                                </tbody>
                                              


                                                            <?php


                                                        }
                                                        
                                                    }

                                                    ?>

                                                 </table>
                                            </div>    
                                        </div>
                                     </div>
                            </div>  

                            
                            

                        <?php

                    }


                }
            ?>
            

            

                <div class="messages">
                    <div class="card">
                        <div class="card-header">
                            <h3>Messages</h3>
                        </div>

                        <div class="card-body">
                            <div class="message">
                                <div class="message_box">
                                    no message yet ... 
                                </div>
                                <div class="message_send">
                                   <input type="text" name="text"/><button>SEND</button>
                                </div>
                            </div>
                        </div>
                            
                        
                    </div>    
                </div>
            </div>

        </main>
    </div>

</body>
</html>