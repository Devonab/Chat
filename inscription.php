<?php 


//form processing
if($_POST) {
	
    $check = ($_POST['honeypot']);
    $errors = array();
    
    if($check != ''){
        die("bien éssayé...");
        
    }
    
        $username = strip_tags(trim($_POST['username']));
        $password = strip_tags(trim($_POST['password']));
        $passwordConfirm = strip_tags(trim($_POST['confirmepassword']));
        
        if( $username == '' ) {
            $errors['username'] = "Vous n'avez pas indiqué de pseudo";
        }
        if ( $password == '' ) {
            $errors['password'] = "Vous n'avez pas indiqué de mot de passe";
        }
        if ( $passwordConfirm == '' ) {
            $errors['passwordConfirm'] = "Vous n'avez pas confirmé votre mot de passe";
        }
    
        if ( $password != $passwordConfirm ) {
            $errors['passNotSame'] = "les mots de passes ne correspondent pas";
        }
        if(count($errors) < 1) {
            $newPass = md5($password);
            require_once ('db-connect.php');
            
            $query = "INSERT INTO users (username,password) VALUES (:username,:password)";
            $preparedStatement = $connexion->prepare($query);
            $preparedStatement->execute(array(':username' => $username, ':password' => $newPass));
            $result = $preparedStatement->fetch();  
        }
    
        
        

    
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
<body id="inscription">
   
   <main>
       <h1>SC!BC</h1>
       <section>
           <h1>S'inscrire</h1>
           <form method="post">
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
                       <label for="confirmermotdepasse">Confirmer votre mot de passe
                           <input type="password" name="confirmepassword" id="confirmermotdepasse" required />
                           <p class="error"><?php echo $errors['passwordConfirm']; ?></p>
                           <p class="error"><?php echo $errors['passNotSame']; ?></p>
                       </label>
                   </li>
                   <li>
                       <label for="honeypot">Laissez vide
                           <input type="text" name="honeypot" id="honeypot" />
                       </label>
                   </li>
                   <li>
                        <input type="submit" name="submit" id="submit" value="s'inscrire" />
                   </li>
               </ol>
           </form>
           <a href="index.php">J'ai déjà un compte</a>
       </section>
   </main>
    
</body>
</html>