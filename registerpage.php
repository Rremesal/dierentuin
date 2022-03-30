<!DOCTYPE html>
<html>
    <head>
        <title>Verblijf registreren</title>
        <link rel="stylesheet" href="page.css"/>
    </head>

    <body class="background">
        <?php require("menu.php"); ?>
        
        <div id="registerForm">
            <h3>Verblijf Registreren</h3>
            <form method="POST">
                Verblijfnummer:<br/>
                <input class="input" type="text" name="animalhouse_no"/>
                <br>
                Soort Verblijf:<br/>
                <input class="input" type="text" name="animalhouse_sort"/>
                <br/>
                Gebied:<br/>
                <select name="area">
                    <option></option>
                    <option>Afrika</option>
                    <option>Australië</option>
                    <option>Azië</option>
                    <option>Europa</option>
                    <option>Noord-Amerika</option>
                    <option>Oceanium</option>
                    <option>Zuid-Amerika</option>
                    <option>Riviera</option>
                </select> 
                <br/>
                <br/>
                <input type="submit" id="registerButton" name="registerButton" value="Toevoegen"/>
            </form>
            <?php 
                include("zoodatabase.php");
                //does something when the 'Toevoegen' button has been pressed
                if (isset($_POST['registerButton'])){
                    //puts the inputted values by the user in a variable
                    $animalhouseNumber = $_POST['animalhouse_no'];
                    $animalhouseSort = $_POST['animalhouse_sort'];
                    $area = $_POST['area'];

                    $query1 = "SELECT count(*) as aantal FROM animalhouse WHERE animalhouse_no = $animalhouseNumber";
                    $stm = $conn->prepare($query1);
                    if ($stm->execute()) {
                        $data = $stm->fetch(PDO::FETCH_OBJ);
                        if($data->aantal > 0) {
                            $animalhouse->animalhouse;
                        } else {
                            //executes a query to fill the values inputted by the user in the database table 'animalhouse'
                            $query2 = "INSERT INTO animalhouse (animalhouse_no,animalhouse_sort,area) VALUES ($animalhouseNumber,'$animalhouseSort','$area')";
                            $stm = $conn->prepare($query2);
                            if ($stm->execute()){
                                //puts 'verblijf aangemaakt' on the screen
                                echo "verblijf aangemaakt";
                            }
                        }
                
                    } else echo "Het verblijfnummer bestaat al";

                }
                    
            ?>
        </div>
    </body>
</html>
