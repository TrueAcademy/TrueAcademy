<?php
 
    session_start();

    if( $_SESSION['email'] == null ){

    

        echo "<script type='text/javascript'>alert('Cant open user is not authorized!')</script>";
        header("Location:index.html"); 
   

    }else{
        
        // echo "Session is running !! ";
        // echo "Email : ". $_SESSION['email'];
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Dashboard.css">
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Dash_board</title>
</head>

<body>
    <div class="main_div">
        <nav>
            <div class="left_div">
                <a href="#" class="hamberg"><i class="fas fa-bars"></i></a>
                <a href="#" class="logo_url"><img src="images/logo.png" alt="logo" class="logo"></a>
                <h1 class="h1">True Academy</h1>
            </div>
            <div class="right_div">
                <a href="#" class="add" onclick="openForm()"><i class="fas fa-plus-circle"></i></a>
                <div class="create_class_hover">Join Class</div>
                <a href="#" class="profile"><i class="fas fa-user"></i></a>
                <div class="profile_li">
                    <a href="#" class="PROFILE">Profile</a>
                    <a href="logout.php" class="LOGOUT">Logout</a>
                </div>
            </div>
        </nav>



        
        <?php
        
            include("includes/dbconfig.php");

            $studentcollection = "studentTable/";
            $studentRef = $database->getReference($studentcollection)
            ->orderByChild('email')  
            ->equalTo($_SESSION['email'])
            ->getValue();

            foreach($studentRef as $token => $key ){


                 if($key['email'] == $_SESSION['email']){

                    $studentToken = $studentcollection.$token."/classjoined";
                    $joinedclass = $database->getReference($studentToken)->getvalue();

                    $classcollection = "classes";
                   
                    ?>
                    
                    <div class="sub_card">
                        <div class="center_div">
                    
                                <?php

                                if($joinedclass == null){
                                    echo "No class Joined yet!";
                                }
                                else{

                               

                                    foreach($joinedclass as $row => $key ){


                                        $classdata = $database->getReference($classcollection)
                                        ->orderByChild('classcode')
                                        ->equalTo($key['classcode'])
                                        ->getvalue();

                                        // var_dump($classdata);

                                        foreach($classdata as $row1 => $classkey){


                                            // echo $classkey['classname'];

                                            // echo "\n\n";

                                            ?>


                                        
                                                    <div class="card" onclick="window.location.href='student/coursepage_student.php?classcode=<?php echo $classkey['classcode'] ?> '">
                                                        <div class="top_div top_div_1">
                                                            <h3 class="h3"><?php echo $classkey['classname'] ?></h3>
                                                            <img src="images/card_acc.jpg" alt="">
                                                        </div>
                                                    </div>
                                            


                                            <?php

                                        }


                                    }

                                }


                            }   


                        }
                    
                ?>

                        </div>
                    </div>


        
       
    </div>


   
    </div>
    <!-- /********************************************************************************************* -->
    <!-- /********************************************************************************************* -->
    <!-- /********************************************************************************************* -->
    <!-- /********************************************************************************************* -->


    <div class="create_class_form" id="myForm">
        <form action="joinclass.php" method="POST" class="mainformdiv">

            <div class="close_button">
                <a href="#" onclick="closeForm()" id="close_btn"><i id="close" class="far fa-times-circle"></i></a>
            </div>


            <div class="input_divtwo">
                <div>
                    <h4>Class Code</h4>
                    <input class="input_CC" type="text" name="classcode">
                </div>
            </div>


            <div class="btn_Create_class">
                <input type="Submit" class="btn" value="done" name="done">
            </div>
        </form>

        <script>
            function openForm() {
                document.getElementById("myForm").style.display = "block";
            }

            function closeForm() {
                document.getElementById("myForm").style.display = "none";
            }
        </script>
</body>

</html>