<?php 

    include("includes/dbconfig.php");

    // $classcode = $_POST["classcode"];

    if(true){

        
        $classcode = "code123"; // checking class code

        //Remove after some time 
        // $collection = "/classes";

        // $data = [
        //     'classcode' => "code123",
        //     'classname' => "checking class"
        // ];
        // $temp = $database->getReference($collection)->push($data);

        // till here 

        $classdata = $database->getReference($collection)->getValue();

        if($classdata == null){
            echo "class not found!";
        }
        else if($classdata['classcode'] == $classcode ){
            echo "class found!";
        }
            
    }


?>