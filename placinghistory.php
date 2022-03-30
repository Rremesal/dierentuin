<?php include("zoodatabase.php");?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Plaatsingsgeschiedenis</title>
    <link rel="stylesheet" href="page.css"/>
</head>
<body>
    <?php require("menu.php");?>
    <h1 class="header">Geschiedenis Plaatsing</h1>
    <table>
        <th>Dieren ID</th>
        <th>Naam</th>
        <th>Diersoort</th>
        <th>gedrag</th>
        <th>verblijfsnummer</th>
        <th>Soort verblijf</th>
        <th>Gebied</th>
        <th>datum plaatsing</th>

    <?php 
        $query = "SELECT * FROM history";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            while($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>". 
                "<td>".$rows['animal_id']."</td>". 
                "<td>".$rows['name']."</td>". 
                "<td>".$rows['animal_sort']."</td>". 
                "<td>".$rows['behavior']."</td>". 
                "<td>".$rows['animalhouse_no']."</td>". 
                "<td>".$rows['animalhouse_sort']."</td>". 
                "<td>".$rows['area']."</td>". 
                "<td>".$rows['date_placed']."</td>". 
                "</tr>";
                
            }
        }
    ?>
    </table>
</body>
</html>