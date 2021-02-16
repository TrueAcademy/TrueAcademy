<?php
    require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Auth;

    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/trueacademy-13962-firebase-adminsdk-cmins-96aa6aea7a.json');
    $firebase = (new Factory())
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri("https://trueacademy-13962-default-rtdb.firebaseio.com")
        ->create();

    $database = $firebase -> getDatabase();

    // $database = $factory->createDatabase();

    // var_dump($database);

?>