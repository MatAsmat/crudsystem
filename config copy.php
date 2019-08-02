<!-- (file1) connect database -->
<?php
//(1)ติดต่อฐานข้อมูล
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'crudsystem');
//(2) connect mysql database
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
//(3) check connection , error function
    if($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>

<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'test');

    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>