<?php
//Tilda Källström 2021 Webbutveckling 2 Mittuniversitetet
//starta session
session_start();
include_once('config.php');
include('includes/header.php');
?>
    <?php
            //kontroll om sessionsvariabel finns
if(!isset($_SESSION['username'])) {
    header("Location: login.php?message=2");
} else {
   // echo "<span class='loggedin'>Du är inloggad som " . $_SESSION['username'] . "</span>";
}
?>
<script src="https://cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>
<div class="welcome">
  <h1 class='h1top'>Favoriter</h1>
  <button onclick="topFunction()" id="topBtn" title="Go to top"><img src="./bilder/top.png" alt="Till toppen"></button>
</div>
<div class='main3'>

<div class='left'>

<div class='searchforuser'>
<form method="post" action="#">
    <label for="searchcriteria">Sök efter användare: </label><br><input type="text" name="searchcriteria" id="searchcriteria" class="firstname"><br> 
   <input type="submit" value="Sök" name="search" class="btnreg">
</form>
</div>
    <?php
    //sök efter användare
if (isset($_POST['search'])) {
if (!empty($_REQUEST['searchcriteria'])) {
    $searchcriteria=$_POST['searchcriteria'];
    $sql ="Select * from user where firstname or lastname or username like '%$searchcriteria%'";
    $result = mysqli_query($conn, $sql); 
    //skriv ut hittade användare
    if($row = mysqli_fetch_array($result)){  
        echo ' <div class="searchforuser"><p class="centerp"><a href="user.php?id=' .$row["id"]. '">' . $row["username"] . '</a><br>';   
    echo ' Förnamn: ' .$row['firstname'];   
    echo '<br> Efternamn: '.$row['lastname'] . "</p></div>";  
    }   else {
        echo "<p class='centerp'>Kunde inte hitta någon användare med det namnet.</p>";
    }
    }
}
$user = New Users();
//hämta de användare man följer
$userlist = $user->getFollowers();
foreach($userlist as $user) {
  //skriv ut användare
        echo "<div class='user'><img src=profileimg/" . $user['profileimg'] . " alt='Profilbild' class='profileimg'> <p class='userp'><a class='postuser' href='user.php?id=" . $user['id'] . "'>" . $user['firstname'] . " " . $user['lastname'] . "</a></p></div>";
}
?>


</div>
<div class='right'>
<?php

$blogpost = New Blogposts();
//hämta poster från anv man följer
$blogpostlist = $blogpost->getFollowedPosts();
foreach($blogpostlist as $post) {
    if ($post['img']) {
        echo "<div class='post'><img src=profileimg/" . $post['profileimg'] . " alt='Profilbild' class='profileimg'> <p class='userp'><a class='postuser' href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] . $post['lastname'] . "</a></p><p class='created'> " . $post['created'] . "</p>
        <h3>"  . $post['title'] . "</h3> <figure><img class='blogimg' src='./uploads/" . $post['img'] . "' alt='blogbild' ></figure>" . 
        $post['content'] . "<p><a href='blogpost.php?postid=" . $post['postid'] . "' class='readmore'>Läs mer/Kommentera</a>" . " </p></div>";
    } else {
        echo "<div class='post'><img src=profileimg/" . $post['profileimg'] . " alt='Profilbild' class='profileimg'> <p class='userp'><a class='postuser' href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] . $post['lastname'] . "</a></p><p class='created'> " . $post['created'] . "</p><h3>"  . $post['title'] . "</h3>" . 
        $post['content'] . "<p><a href='blogpost.php?postid=" . $post['postid'] . "' class='readmore'>Läs mer/Kommentera</a>" . " </p></div>";
    }       
}

?>

</div>
</div>
<?php
include('includes/footer.php');
    ?>