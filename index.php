<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="page.css"/>
    </head>

    <body id="loginpage">
        <form id="login" method="POST">
            <h2>Inloggen</h2>
            <b>Gebruikersnaam</b> <br/>
            <input class="input" type="text" name="user"/> <br/>
            <b>Wachtwoord</b> <br>
            <input class="input" type="password" name="passw"/> <br/>
            <br/>
            <div id="btnDiv">
                <input id="loginButton" type="submit" name="loginButton" value="Inloggen"/><br>
                <input id="createButton" type="submit" name="userButton" value="Registreren"/>
            </div>	
        <?php
            include("zoodatabase.php");
            session_start();
            
            //checks if the 'Inloggen' button has been pressed
            if(isset($_POST['loginButton'])) {
                //puts the values inputted by the user in a variable
                $username = $_POST['user'];
                $password = $_POST['passw'];
                //gets the password from the login table in the database where the username 
                //is the same as the one that was inputted by the user
                $query = "SELECT password FROM login WHERE username='$username'";
                $stm = $conn->prepare($query);
                if($stm->execute()) {
                    $data = $stm->fetchAll(PDO::FETCH_OBJ);
                    foreach($data as $user) {
                        //put the username of the user in a session variable
                        $_SESSION['username'] = $username;
                        //checks if the inputted password is the same as the one in the database
                        if($user->password == $password){
                            //puts the password of the user in a session variable
                            $_SESSION['password'] = $user->password;
                            //goes to the home.php page
                            header("Location: home.php");
                        } else echo "wachtwoord komt niet overeen";
                    }
                    
                } else echo "iets ging verkeerd met het ophalen van de login-gegevens";
                //gets the admin-state from the database where the username is the same as 
                //the one inputted by the user
                $query2 = "SELECT admin FROM login WHERE username='$username'";
                $stm  = $conn->prepare($query2);
                if($stm->execute()) {
                    $data = $stm->fetchAll(PDO::FETCH_OBJ);
                    foreach($data as $user) {
                        //puts the admin-state of the user in a session variable 
                        $_SESSION['isAdmin'] = $user->admin;
                    }
                }
            //checks if the 'Registreren' button has been pressed
            } else if(isset($_POST['userButton'])) {
                //goes to the user.php page
                header("Location: user.php");
            }
        ?>
        </form>
    </body>
</html>