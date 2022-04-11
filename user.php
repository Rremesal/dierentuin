<!DOCTYPE html>
<html>
    <head>
        <title>Account aanmaken</title>
        <link rel="stylesheet" href="page.css"/>
    </head>

    <body class="background">
        <form id="newUser" method="POST">
            <h2>Creëer Account</h2>
            Gebruikersnaam
            <input class="input" name="username" type="text"/>
            <br/>
            Wachtwoord
            <br/>
            <input class="input" name="password" type="password"/>
            <br/>
            <br/>
            <input id="userButton" type="submit" name="userButton" value="Maak account"/>
        </form>
        <?php
            include("zoodatabase.php");
            session_start();
            //checks if the 'Maak account' button has been pressed
            if(isset($_POST['userButton'])) {
                //puts the values inputted by the user in a variable
                $username = $_POST['username'];
                $password = $_POST['password'];
                //executes a query to put the username,password and admin-state (is not admin) in the database
                $query = "INSERT INTO login (username,password,admin) VALUES ('$username','$password',0)";
                
                $stm = $conn->prepare($query);
                if($stm->execute()){
                    //goes to the login.php
                    header("Location: index.php");
                } else echo "er is iets fout gegaan met het verzenden van de gebruikers-gegevens";
            }
        ?> 
    </body>
</html>