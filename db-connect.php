<?php 
header("Content-type: text/html; charset=UTF-8");

try{
    $host = 'localhost';
    $dbname = '________________';
    $user = '________________';
    $dbpassword = '________________';
    $connexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $dbpassword);
    $connexion->exec('SET CHARACTER SET utf8');
}catch(PDOException $e){
    echo $e->getMessage();
}

?>


