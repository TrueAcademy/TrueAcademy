<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accusoft admin</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/stylespage.css">
    <link rel="stylesheet" href="../css/nav-css.css">
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
        <div>
    </nav>
    
   

    <div class="main-content">
        
        <main>

            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1>54</h1>
                        <span>Total Exam Conducted</span>
                    </div>
                </div>


                <div class="card-single">
                    <div>
                        <h1>124</h1>
                        <span>Total Assignment</span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>$6k</h1>
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
                                    <tbody>
                                        <tr>
                                            <td>UI/UX Design</td>
                                            <td>UI Team</td>
                                            <td>
                                                <span class="status purple"></span>
                                                review
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Web developement</td> 
                                            <td>Frontend</td>
                                            <td>
                                                <span class="status pink"></span>
                                                in progress
                                            </td>                                       
                                        </tr>
                                        <tr>
                                            <td>Ushop app</td>
                                            <td>Mobile Team</td>
                                            <td>
                                                <span class="status orange"></span>
                                                pending
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>    
                        </div>
                    </div>
                </div>

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