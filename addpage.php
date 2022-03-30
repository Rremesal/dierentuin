<!DOCTYPE html>
<?php require("zoodatabase.php"); ?>
<html>
    <head>
        <title>Dieren toevoegen</title>
        <link rel="stylesheet" href="page.css"/>
    </head>

    <?php require("menu.php"); ?>
    <body class="background">
        <div id="addForm">
            <form method="POST">
                <h3>Toevoegen</h3>
                
                Naam dier:<br/>
                <input type="text" class="addInput" name="animalName" required/><br/>
                Diersoort:<br/> 
                <input type="text" class="addInput" name="species" required/><br/>
                Gedrag:<br/>
                <select name="behavior">
                    <option></option>
                    <option>kalm</option>
                    <option>aggresief</option>
                </select>
                <br/>
                Verblijfnummer:<br/>
                <select name="animalhouseNo">
                <?php
                    
                    $query = "SELECT animalhouse_no FROM animalhouse WHERE animalhouse_id NOT IN (SELECT animalhouse_id FROM animal_animalhouse);";
                    //$query = "SELECT animalhouse_no FROM animalhouse";
                    $stm = $conn->prepare($query);
                    if($stm->execute()) {
                        while($rows = $stm->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option>".$rows['animalhouse_no']."</option>";
                        }
                    }
                ?>
                </select>
                <br/>
                <br/>
                <input id="button" type="submit" name="submit" value="Toevoegen"/>
            </form>
        <?php
            //does something when the 'Toevoegen' button has been pressed
            if (isset($_POST['submit'])){
                //puts the inputted values by the user in a variable
                $name = $_POST['animalName'];
                $species = $_POST['species'];
                $behavior = $_POST['behavior'];

                //puts the inputted name,species and behavior in the "animal" table 
                $query="INSERT INTO animal (name,species,behavior) VALUES ('$name','$species','$behavior')";
                $stm = $conn->prepare($query);
                $stm->execute();

                $animalhouseNo = $_POST['animalhouseNo'];
                //puts ...(name) has been added on the screen
                echo "$name is toegevoegd";
        ?>
                </div>
        <?php

                // get the id from the "animal" table
                $query3="SELECT animal_id,animalhouse_id FROM animal,animalhouse WHERE name='$name' AND animalhouse_no='$animalhouseNo'" ;
                $stm = $conn->prepare($query3);
                $stm->execute();
                $dataset1=$stm->fetchAll(PDO::FETCH_OBJ);

                foreach($dataset1 as $anim) {
                    //put the animal_id and animalhouse_id value in the "animal_animalhouse" table
                    $query4="INSERT INTO animal_animalhouse (animal_id,animalhouse_id,date) VALUES ($anim->animal_id,$anim->animalhouse_id,now())";
                    $stm = $conn->prepare($query4);
                    $stm->execute();
                }
            }
        ?>

    </body>
</html>