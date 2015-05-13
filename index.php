<?php 
session_start();


if ($_SESSION['logged_in'] != 'ok') {

    if($_POST) {

        $check = ($_POST['honeypot']);
        $errors = array();

        if($check != ''){
            die("bien éssayé...");

        }

            $username = strip_tags(trim($_POST['username']));
            $password = strip_tags(trim($_POST['password']));

            if( $username == '' ) {
                $errors['username'] = "Vous n'avez pas indiqué de pseudo";
            }
            if ( $password == '' ) {
                $errors['password'] = "Vous n'avez pas indiqué de mot de passe";
            }

            if(count($errors) < 1) {

                require_once ('db-connect.php');
                $newpass = md5($password);
                $query = "SELECT id, username, password FROM users WHERE username = :username";
                $preparedStatement = $connexion->prepare($query);
                $preparedStatement->execute(array(':username' => $username));
                $result = $preparedStatement->fetch(PDO::FETCH_ASSOC);  

                if($result['user'] != $username ) {
                    $error['notregistered'] = "<div class='log_error'><p>Désolé, aucun utilisateur n'a été trouvé...</p></div>";
                }

                if( $result['password'] == $newpass ) {
                    $_SESSION['logged_in'] = 'ok';
                    die ("it's good !");
                } 
            }

    }
} else {
    die ('connecté');
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimal-ui">
    <title>Accueil | SC!BC</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body id="home">
   
   <main>
       <h1>SC!BC</h1>
       <section>
           <h1>Se connecter</h1>
           <form method="post">
                <?php echo $error['notregistered']; ?></p>
               <ol>
                   <li>
                       <label for="pseudo">Votre pseudo
                           <input type="text" name="username" id="pseudo" required />
                           <p class="error"><?php echo $errors['username']; ?></p>
                       </label>
                   </li>
                   <li>
                       <label for="motdepasse">Votre mot de passe
                           <input type="password" name="password" id="motdepasse" required />
                           <p class="error"><?php echo $errors['password']; ?></p>
                       </label>
                   </li>
                   <li>
                       <label for="honeypot">Laissez vide
                           <input type="text" name="honeypot" id="honeypot" />
                       </label>
                   </li>
                   <li>
                        <input type="submit" name="submit" id="submit" value="Se connecter" />
                   </li>
               </ol>
           </form>
           <a href="inscription.php">Je n'ai pas encore de compte</a>
       </section>
   </main>
    
</body>
</html>