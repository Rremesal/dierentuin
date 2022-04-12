<?php require("zoodatabase.php") ?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="page.css"/>
</head>
<body id="emptyOverviewPage">
    <?php require("menu.php"); ?>
    <h1 class="header">Overzicht lege verblijven</h1>
    <div class="toolsDiv">
        <form method="POST">
            Zoeken: <input type="text" name="searchbar"/>
            <input class="submitButton" type="submit" name="btnSubmit" value="Zoeken"/>
        </form>
    </div>
    <br/>
    <table>
        <th>Verblijfnummer</th>
        <th>Verblijfssoort</th>
        <th>Gebied</th>

        <?php 
            if(isset($_POST['btnSubmit'])) {
                $searched = $_POST['searchbar'];
                //gets all the relevant data from the animal, animal_animalhouse and animalhouse
                $query="SELECT * FROM animalhouse WHERE area LIKE '%$searched%' OR animalhouse_sort LIKE '%$searched%'";
                $stm=$conn->prepare($query);
                $stm->execute();

                while($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                    //places every record in a row and every piece of data in a table data (<td>)
                    echo "<tr>".
                    "<td>".$rows['animalhouse_no']."</td>".
                    "<td>".$rows['animalhouse_sort']."</td>".
                    "<td>".$rows['area']."</td>".
                    "</tr>";
                }
            } else {
                $query = "SELECT animalhouse_no,animalhouse_sort,area FROM animalhouse WHERE animalhouse_id NOT IN (SELECT animalhouse_id FROM animal_animalhouse);";
                $stm = $conn->prepare($query);
                if($stm->execute()) {
                    while($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>". 
                        "<td>".$rows['animalhouse_no']."</td>". 
                        "<td>".$rows['animalhouse_sort']."</td>". 
                        "<td>".$rows['area']."</td>";
                    }
                }
            }

            
        ?>
    </table>


    
</body>
</html>