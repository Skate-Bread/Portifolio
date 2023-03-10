<?php
// Start økt
session_start();
 
// Sjekk om brukeren allerede er logget in hvis så omdirigerer vi til velkommen siden
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// inkluder konfigurasjons filen
require_once "config.php";
 
// Deklarer variabler 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Prosseser informasjon fra klient siden
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Sjekk om brukernavn feltet er tomt.
    if(empty(trim($_POST["username"]))){
        $username_err = "Vennligst skriv in brukernavn.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Sjekk om passordet er tomt
    if(empty(trim($_POST["password"]))){
        $password_err = "Vennligst skriv in passord.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valider legitimasjon
    if(empty($username_err) && empty($password_err)){
        // Gjør klar et "Select Statment"
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variabler til den forberedte setningen som parametere
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parametere
            $param_username = $username;
            
            // Kjør den klargjorte "Select Statmenten"
            if(mysqli_stmt_execute($stmt)){
                // Lagre resultat 
                mysqli_stmt_store_result($stmt);
                
                // Sjekk om brukernavnet finne hvis ja sjekk passordet
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // bind resulatet til variabler
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Hvis passordet er riktig start en økt
                            session_start();
                            
                            // Lagre data i variabler
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Send brukeren til velkommen siden
                            header("location: welcome.php");
                        } else{
                            // Hvis passordet er feil vis følgende error
                            $login_err = "Feil brukernavn eller passord.";
                        }
                    }
                } else{
                    // Hvis brukernavnet ikke finnes vis følgende error
                    $login_err = "Feil brukernavn eller passord.";
                }
            } else{
                //hvis noen annet skulle gått galt vis denne meldingen
                echo "Oops! Noe gikk galt prøv igjen senere.";
            }

            // Lukk statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Koble fra databasen
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>

      <header class="p-3 text-bg-dark">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
              <img src="assets/b.jpg" height="60px" style="padding-right: 30px">
            </a>
    
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
              <li><a href="index.php" class="nav-link px-3 text-secondary">Hjem</a></li>
              <li><a href="#" class="nav-link px-3 text-white">Om meg</a></li>
              <li><a href="#" class="nav-link px-3 text-white">Prosjekter</a></li>
            </ul>  
            <div class="text-end">
              <a href="login.php"><button type="button" class="btn btn-outline-light me-2">Login</button></a>
              <a href="register.php"><button type="button" class="btn btn-primary">Registrer</button></a>
            </div>
          </div>
        </div>
      </header>
    <center>

    
    <div class="wrapper">
        <h2>Login</h2>
        <p>Vennligst fyll inn innloggins informasjon.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Brukernavn</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Passord</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Har du ikke en bruker fra før av? <a href="register.php">Registrer deg nå</a>!</p>
            
        </form>
    </div>
    </center>
</body>
</html>