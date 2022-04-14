<?php include("zoodatabase.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>dierentuin overzicht</title>
        <link rel="stylesheet" href="page.css"/>
    </head>

    <body id="overviewPage">
        <?php require("menu.php"); ?>

        <h1 class="header">Overzicht</h1>
        <form method="POST" id="searchform">
            <label><input type="radio" class="overviewRadio" name="radio" value="Op diersoort"/> Op diersoort</label><br/>
            <label><input type="radio" class="overviewRadio" name="radio" value="Op gebied"></input>Op gebied</label><br/>
            <br/>
            <label id="searchLabel">Zoeken: <input type="text" name="searchfield" id="searchfield"/></label>
            <input type="submit" name="searchButton" class="submitButton" value="Zoeken"/>
        </form>
        <br/>
        <table>
            <th>Naam</th>
            <th>Diersoort</th>
            <th>Gedrag</th>
            <th>verblijfsnummer</th>
            <th>Verblijfssoort</th>
            <th>Gebied</th>
            <th>Datum Plaatsing</th>
    <?php 
        
        //does something when the 'Zoeken' button has been pressed
        if (isset($_POST['searchButton'])) {
            //puts the value inputted by the user in a variable
            $searchedValue = $_POST['searchfield'];
            //checks if the value of the radiobutton is 'Op diersoort' and if there is no input in $searchedValue
            if(array_key_exists("radio",$_POST) && empty($searchedValue)) {
                if($_POST['radio'] == "Op diersoort") {
                    $query="SELECT * FROM animal an LEFT JOIN animal_animalhouse anah ON anah.animal_id = an.animal_id LEFT JOIN animalhouse ah ON ah.animalhouse_id = anah.animalhouse_id ORDER BY species";

                } else $query="SELECT * FROM animal an LEFT JOIN animal_animalhouse anah ON anah.animal_id = an.animal_id LEFT JOIN animalhouse ah ON ah.animalhouse_id = anah.animalhouse_id ORDER BY area";

                //gets all the relevant data from the animal, animal_animalhouse and animalhouse
                
                $stm=$conn->prepare($query);
                $stm->execute();
                while($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                    //places every record in a row and every piece of data in a table data (<td>)
                    echo "<tr>".
                    "<td>".$rows['name']."</td>".
                    "<td>".$rows['species']."</td>".
                    "<td>".$rows['behavior']."</td>".
                    "<td>".$rows['animalhouse_no']."</td>".
                    "<td>".$rows['animalhouse_sort']."</td>".
                    "<td>".$rows['area']."</td>".
                    "<td>".$rows['date']."</td>".
                    "</tr>";
                }
    ?>              
    <?php
                
            //checks if there is a value in the searchbar and what that value is
            } else if (isset($searchedValue)) {
                $searched = $_POST['searchfield'];
                //gets all the relevant data from the animal, animal_animalhouse and animalhouse
                $query2="SELECT * FROM animal an LEFT JOIN animal_animalhouse anah ON anah.animal_id = an.animal_id LEFT JOIN animalhouse ah ON ah.animalhouse_id = anah.animalhouse_id WHERE name LIKE '%$searched%' OR area LIKE '%$searched%' OR animalhouse_sort LIKE '%$searched%'";
                $stm=$conn->prepare($query2);
                $stm->execute();

                while($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                    //places every record in a row and every piece of data in a table data (<td>)
                    echo "<tr>".
                    "<td>".$rows['name']."</td>".
                    "<td>".$rows['species']."</td>".
                    "<td>".$rows['behavior']."</td>".
                    "<td>".$rows['animalhouse_no']."</td>".
                    "<td>".$rows['animalhouse_sort']."</td>".
                    "<td>".$rows['area']."</td>".
                    "<td>".$rows['date']."</td>".
                    "</tr>";
                }
            }
    ?>              
    <?php
                    
                
             
        } else {
            //gets all the relevant data from the animal, animal_animalhouse and animalhouse
            $query3="SELECT * FROM animal an LEFT JOIN animal_animalhouse anah ON anah.animal_id = an.animal_id LEFT JOIN animalhouse ah ON ah.animalhouse_id = anah.animalhouse_id ORDER BY name ASC";
            $stm=$conn->prepare($query3);
            $stm->execute();

            while($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                //places every record in a row and every piece of data in a table data (<td>)
              echo "<tr>".
                    "<td>".$rows['name']."</td>".
                    "<td>".$rows['species']."</td>".
                    "<td>".$rows['behavior']."</td>".
                    "<td>".$rows['animalhouse_no']."</td>".
                    "<td>".$rows['animalhouse_sort']."</td>".
                    "<td>".$rows['area']."</td>".
                    "<td>".$rows['date']."</td>".
                    "</tr>";
    ?>
    <?php
            }
        }
    ?>
        </table>
        <h2 class="header">Verplaatsen</h2>
        <div id="moveDiv">
            <form method="POST">
                <select name="animalName">
                    <?php
                        $query4 = "SELECT name FROM animal";
                        $stm = $conn->prepare($query4);
                        if($stm->execute()) {
                            while($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                                <option><?php echo $rows['name']; ?></option>
                    <?php           
                            }
                        } else echo "er is iets misgegaan het uitvoeren van query4";
                    ?>
                    
                </select>
                <select name="behaviorChange">
                    <option>-- gedrag --</option>
                    <option>kalm</option>
                    <option>aggressief</option>
                </select>
                <select name="animalhouseNoChange">
                <?php
                    
                    $query = "SELECT * FROM animalhouse WHERE animalhouse_id NOT IN (SELECT animalhouse_id FROM animal_animalhouse);";
                    //$query = "SELECT animalhouse_no FROM animalhouse";
                    $stm = $conn->prepare($query);
                    if($stm->execute()) {
                        while($rows = $stm->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='".$rows['animalhouse_no']."'>".$rows['animalhouse_no']." - ".$rows['animalhouse_sort']."</option>";
                        }
                    }
                ?>
                </select>
                <input type="date" name="changedDate"/>
                <input type="submit" name="btnChange" class="submitButton" value="Verplaats"/>
            </form>
        </div>
        <?php
            if(isset($_POST['btnChange'])) {
                $newBehavior = $_POST['behaviorChange'];
                $name = $_POST['animalName'];
                $newAnimalhouseNumber = $_POST['animalhouseNoChange'];
                

                $animalquery = "SELECT * FROM animal an LEFT JOIN animal_animalhouse anah ON anah.animal_id = an.animal_id LEFT JOIN animalhouse ah ON ah.animalhouse_id = anah.animalhouse_id WHERE name='$name'";
                $stm = $conn->prepare($animalquery);
                if($stm->execute()) {
                    $data = $stm->fetch(PDO::FETCH_OBJ);
                    
                    $animalHistoryQuery = "INSERT INTO history (animal_id,name,animal_sort,behavior,animalhouse_no,animalhouse_sort,area,date_placed) VALUES ($data->animal_id,'$data->name','$data->species', '$data->behavior',$data->animalhouse_no,'$data->animalhouse_sort','$data->area','$data->date')";
                    $stm = $conn->prepare($animalHistoryQuery);
                    if($stm->execute()) {
                        $queryAnimalhouseId = "SELECT animalhouse_id FROM animalhouse WHERE animalhouse_no=$newAnimalhouseNumber";
                        $stm = $conn->prepare($queryAnimalhouseId);
                        if($stm->execute()) {
                            $data = $stm->fetch(PDO::FETCH_OBJ);
                            $queryAnimalId = "SELECT animal_id FROM animal WHERE name='$name'";
                            $stm = $conn->prepare($queryAnimalId);
                            if($stm->execute()) {
                                $dataAnimalId = $stm->fetch(PDO::FETCH_OBJ);
                                if(isset($_POST['changedDate'])) {
                                    $changedDate = $_POST['changedDate'];
                                    $queryUpdate = "UPDATE animal_animalhouse SET animalhouse_id=$data->animalhouse_id WHERE animal_id=$dataAnimalId->animal_id";
                                } else {
                                    $queryUpdate = "UPDATE animal_animalhouse SET animalhouse_id=$data->animalhouse_id,date='$changedDate' WHERE animal_id=$dataAnimalId->animal_id";
                                }
                                $stm = $conn->prepare($queryUpdate);
                                if($stm->execute()) {
                                    echo "verblijfplaats geüpdatet";
                                    $queryUpdateBehavior = "UPDATE animal SET behavior='$newBehavior' WHERE animal_id=$dataAnimalId->animal_id";
                                    $stm = $conn->prepare($queryUpdateBehavior);
                                    if($stm->execute()) {
                                    }
                                }
                            }
                            
                        } 
                    } else echo "data niet geupload naar geschiedenis";
                } else echo "iets is misgegaan!";
                header("Refresh:0");
            }

        

        ?>
    </body>
</html>