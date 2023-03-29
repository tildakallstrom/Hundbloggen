<?php
include('includes/header.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "<div class='welcome'>
    <h1 class='h1top'>Hej $username!</h1>
</div>";
} else {
    echo "<div class='welcome'>
    <h1 class='h1top'>Bli medlem på Sveriges största hunddagbok idag -> <a href='register.php'>Bli medlem</a></h1>
</div>";
}
?>
<div class='main'>
    <div class='left'>
        <h2 class="centerh2">De senaste inläggen:</h2>
        <?php
        $blogpost = new Blogposts();
        $blogpostlist = $blogpost->getFiveBlogposts();
        foreach ($blogpostlist as $post) {
            if ($post['img']) {
                echo "<div class='post'><img src=profileimg/" . $post['profileimg'] . " alt='Profilbild' class='profileimg'> <p class='userp'><a class='postuser' href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] . " " . $post['lastname'] . "</a></p><p class='created'> " . $post['created'] . "</p>
        <h3>"  . $post['title'] . "</h3> <figure><img class='blogimg' src='./uploads/" . $post['img'] . "' alt='blogbild' ></figure><p class='content'>" .
                    $post['content'] . "<p class='showmore'><a href='blogpost.php?postid=" . $post['postid'] . "' class='readmore'>Läs mer/Kommentera</a>" . " </p></div>";
            } else {
                echo "<div class='post'><img src=profileimg/" . $post['profileimg'] . " alt='Profilbild' class='profileimg'> <p class='userp'><a class='postuser' href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] . " " . $post['lastname'] . "</a></p><p class='created'> " . $post['created'] . "</p><h3>"  . $post['title'] . "</h3> <p class='content'>" .
                    $post['content'] . "<p class='showmore'><a href='blogpost.php?postid=" . $post['postid'] . "' class='readmore'>Läs mer/Kommentera</a>" . " </p></div>";
            }
        }
        ?>
    </div>
    <div class='right'>
        <h2 class="centerh2">Våra användare:</h2>
        <?php
        $user = new Users();
        $userlist = $user->getUsers();
        foreach ($userlist as $user) {
            echo "<div class='user'><img src=profileimg/" . $user['profileimg'] . " alt='Profilbild' class='profileimg'>
    <p class='userp'> <a class='userlink' href='user.php?id=" . $user['id'] . "'>" . $user['firstname'] . " " . $user['lastname'] . "</a></p></div>";
        }
        ?>
    </div>
</div>
<?php
include('includes/footer.php');
?>