<?php include("zoodatabase.php");?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Geschiedenis plaatsing</title>
    <link rel="stylesheet" href="page.css"/>
</head>
<body>
    <?php require("menu.php");?>
    <h1 class="header">Geschiedenis Plaatsing</h1>
    <div class="toolsDiv">
        <form method="POST">
        <input type="radio" name="radioDate"/> Laatste datum eerst <br/>
        <br/>
            Zoeken: <input type="text" name="searchbar"/>
            <input type="submit" name="btnSubmit" value="Filteren"/>


        </form>

    </div>
    <br/>

    <?php 
        
    ?>

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
        if(isset($_POST['btnSubmit'])) {
            if(isset($_POST['searchbar']) && isset($_POST['radioDate'])) {
                $search = $_POST['searchbar'];
                $searchQuery = "SELECT * FROM history WHERE name LIKE '%$search%' OR area LIKE '%$search%' ORDER BY date_placed DESC";
                $stm = $conn->prepare($searchQuery);
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

                

            } else if(isset($_POST['searchbar']) && empty($_POST['radioDate'])) {
                $search = $_POST['searchbar'];
                $searchQuery = "SELECT * FROM history WHERE name LIKE '%$search%' OR area LIKE '%$search%'";
                $stm = $conn->prepare($searchQuery);
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
            } else {
                $searchQuery = "SELECT * FROM history ORDER BY date DESC";
                $stm = $conn->prepare($searchQuery);
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
            }
        } else {
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
        }
    


        
    ?>
    </table>
</body>
</html>