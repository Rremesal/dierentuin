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
            <input type="submit" name="searchButton" id="search" value="Zoeken"/>
        </form>
        <table>
            <th>Naam</th>
            <th>Diersoort</th>
            <th>Gedrag</th>
            <th>verblijfsnummer</th>
            <th>Verblijfssoort</th>
            <th>Gebied</th>
            <th>Datum Plaatsing</th>
    <?php 
        include("zoodatabase.php");
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
                $searchedName = $_POST['searchfield'];
                //gets all the relevant data from the animal, animal_animalhouse and animalhouse
                $query2="SELECT * FROM animal an LEFT JOIN animal_animalhouse anah ON anah.animal_id = an.animal_id LEFT JOIN animalhouse ah ON ah.animalhouse_id = anah.animalhouse_id WHERE name LIKE '%$searchedName%'";
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
                <input  id="animalhouseNoChange" type="text" name="animalhouseNoChange" placeholder="verblijfsnummer"/>
                <select name="areaChange">
                        <option>----- gebied -----</option>
                        <option>Afrika</option>
                        <option>Australië</option>
                        <option>Azië</option>
                        <option>Europa</option>
                        <option>Noord-Amerika</option>
                        <option>Oceanium</option>
                        <option>Zuid-Amerika</option>
                        <option>Riviera</option>
                </select>
                <input type="submit" name="btnChange" id="btnSubmit" value="Verplaats"/>
            </form>
        </div>
        <?php
            if(isset($_POST['btnChange'])) {
                $newBehavior = $_POST['behaviorChange'];
                $name = $_POST['animalName'];
                $newAnimalhouseNumber = $_POST['animalhouseNoChange'];
                $newArea = $_POST['areaChange'];

                $animalquery = "SELECT * FROM animal an LEFT JOIN animal_animalhouse anah ON anah.animal_id = an.animal_id LEFT JOIN animalhouse ah ON ah.animalhouse_id = anah.animalhouse_id WHERE name='$name'";
                $stm = $conn->prepare($animalquery);
                if($stm->execute()) {
                    $data = $stm->fetch(PDO::FETCH_OBJ);
                    
                    $animalHistoryQuery = "INSERT INTO history (animal_id,name,animal_sort,behavior,animalhouse_no,animalhouse_sort,area,date_placed) VALUES ($data->animal_id,'$data->name','$data->species', '$data->behavior',$data->animalhouse_no,'$data->animalhouse_sort','$data->area',now())";
                    echo $animalHistoryQuery;
                    $stm = $conn->prepare($animalHistoryQuery);
                    if($stm->execute()) {
                        echo "toegevoegd aan geschiedenis";
                        $animalquery = "UPDATE animal an LEFT JOIN animal_animalhouse anah ON anah.animal_id = an.animal_id LEFT JOIN animalhouse ah ON ah.animalhouse_id = anah.animalhouse_id SET an.behavior='$newBehavior', ah.animalhouse_no=$newAnimalhouseNumber, ah.area='$newArea' WHERE name='$name'";
                        $stm = $conn->prepare($animalquery);
                        $stm->execute();
                    } else echo "data niet geupload naar geschiedenis";
                } else echo "iets is misgegaan!";
                
                

            }

        

        ?>
    </body>
</html>