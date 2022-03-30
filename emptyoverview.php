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
    <table>
        <th>Verblijfnummer</th>
        <th>Verblijfssoort</th>
        <th>Gebied</th>

        <?php
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
        ?>
    </table>


    
</body>
</html>