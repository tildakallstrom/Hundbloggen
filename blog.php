<?php
//Tilda Källström 2021 Webbutveckling 2 Mittuniversitetet
include('includes/header.php');
?>
<div class='welcome'>
    <h1 class='h1top'>Läs de senaste inläggen från våra användare</h1>
</div>

    <!-- to the top button skriven med javascript-->
<button onclick="topFunction()" id="topBtn" title="Go to top"><img src="./bilder/top.png" alt="Till toppen"></button>



<div class='main'>
<div class='left'>
  <h2 class="centerh2">De senaste inläggen:</h2>
  <?php
$blogpost = new Blogposts();
$blogpostlist = $blogpost->getBlogposts();
//skriv ut blogposter
foreach($blogpostlist as $post) {
    if ($post['img']) {
        echo "<div class='post'><img src=profileimg/" . $post['profileimg'] . " alt='Profilbild' class='profileimg'> <p class='userp'><a class='postuser' href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] ." ". $post['lastname'] . "</a></p><p class='created'> " . $post['created'] . "</p>
        <h3>"  . $post['title'] . "</h3> <figure><img class='blogimg' src='./uploads/" . $post['img'] . "' alt='blogbild' ></figure>" . 
       $post['content'] . "<p class='showmore'><a href='blogpost.php?postid=" . $post['postid'] . "' class='readmore'>Läs mer/Kommentera</a>" . " </p></div>";
    } else {
        echo "<div class='post'><img src=profileimg/" . $post['profileimg'] . " alt='Profilbild' class='profileimg'> <p class='userp'><a class='postuser' href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] ." ". $post['lastname'] . "</a></p><p class='created'> " . $post['created'] . "</p><h3>"  . $post['title'] . "</h3>" . 
        $post['content'] . "<p class='showmore'><a href='blogpost.php?postid=" . $post['postid'] . "' class='readmore'>Läs mer/Kommentera</a>" . " </p></div>";
    }   
}
?>
</div>
<div class='right'>
<h2 class="centerh2">Våra användare:</h2>
    <?php
$user = New Users();
$userlist = $user->getUsers();
//hämta användare och skriv ut
foreach($userlist as $user) {
    echo "<div class='user'><img src=profileimg/" . $user['profileimg'] . " alt='Profilbild' class='profileimg'>
    <p class='userp'> <a class='userlink' href='user.php?id=" . $user['id'] . "'>" . $user['firstname'] . " " . $user['lastname'] . "</a></p></div>";       
}
?>
</div>
</div>
<?php
include('includes/footer.php');
?>