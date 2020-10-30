<?php
$host = "localhost";
$root = "root";
$root_password = "password";

$user = "newuser";
$pass = "newpass";
$db = "newdb";


try {
    $dbh = new PDO("mysql:host=$host", $root, $root_password, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
));
    $dbh->exec("CREATE DATABASE IF NOT EXISTS `$db`;
            CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
            GRANT ALL ON `$db`.* TO '$user'@'localhost';
            FLUSH PRIVILEGES;");
    $dbh = null;
}
catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}


try {
     $dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pass, array(
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
     
     $dbh->exec("CREATE TABLE IF NOT EXISTS email(
        id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR( 50 ) NOT NULL UNIQUE,
        domain_counter TINYINT);") ;

} catch(PDOException $e) {
    echo $e->getMessage();
}

function insert_email($dbh, $email, $counter)
{    
    $counter = ($counter > 1) ? $counter : 0;
    try{
        $sth = $dbh->prepare("INSERT IGNORE INTO email(email, domain_counter) VALUES(:email, :domain_counter)");
        $sth->bindParam(":email", $email);
        $sth->bindParam(":domain_counter", $counter);
        $sth->execute();
    } catch(PDOException $e) {
        echo $e->getMessage();
        
    }
}
