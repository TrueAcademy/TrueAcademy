<?php 

    include("includes/dbconfig.php");

    

    if(true){

        // $classcode = $_POST["classcode"];
        
        $classcode = "code123"; // checking class code

      
        $collection = "/classes";

        //Remove after some time 

        // $data = [
        //     'classcode' => "code123",
        //     'classname' => "checking class"
        // ];
        // $temp = $database->getReference($collection)->push($data);

        // till here 

        $classdata = $database->getReference($collection)
        ->orderByChild('classcode')  // 
        ->equalTo($classcode)
        ->getValue();
        // $classkey = $classdata->getKey();

        var_dump($classdata);

        if($classdata == null){
            echo "class not found!";
        }
        else {

                echo "class found!";

        }
            
    }


?>