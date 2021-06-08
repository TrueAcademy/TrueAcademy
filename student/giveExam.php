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
    <title>Accusoft admin</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/stylespage.css">
    <link rel="stylesheet" href="../css/navstyle.css">
    <link rel="stylesheet" href="../css/sidebar.css">
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
                <a href="../logout.php" class="LOGOUT">Logout</a>  
            </div>
            <h4 class="login_name"> <?php echo $_SESSION['email']?> </h4>
        <div>
    </nav>
    
   

    <div class="main-content">


        
        
        <main class="rightdiv">
            

                        
                        
                         <div class="recent-grid">
                             <!-- List of student joined -->

                            <div class="projects">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>List Of Student In Class</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>First Name</td>
                                                        <td>Last Name</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    

                                                  
                                                 </tbody>
                                                 </table>
                                            </div>    
                                        </div>
                                     </div>
                            </div>  

                            
                            

                        <?php

                    }


                }
            ?>
            

            

                
                </div>
            </div>

        </main>
    </div>

</body>
</html>