<?php
//checks whether a user is an admin, if so it puts the 'admin menu' on the page
//if not it puts the normal menu on the page
    session_start();
    
    if($_SESSION['isAdmin'] == 1) {

?>
    <div class="menu">
        <a href="logout.php" class="logout">LOG UIT</a>
        <a href="home.php">HOME</a>
        <a href="addpage.php">DIEREN TOEVOEGEN</a>
        <a href="registerpage.php">VERBLIJF REGISTREREN</a> 
        <a href="overview.php">OVERZICHT</a>
        <a href="emptyoverview.php">LEGE VERBLIJVEN</a>
        <a href="placinghistory.php">GESCHIEDENIS PLAATSING</a>
    </div>
    

    

<?php } else {  ?>
    <div class="menu">
    <a href="logout.php" class="logout">LOG UIT</a>
        <a href="home.php">HOME</a>
        <a href="addpage.php">DIEREN TOEVOEGEN</a>
        <a href="overview.php">OVERZICHT</a>
        <a href="placinghistory.php">GESCHIEDENIS PLAATSING</a>
    </div>
<?php } ?>






