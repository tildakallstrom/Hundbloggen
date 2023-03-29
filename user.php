<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?message=2");
} else {
    //echo "<span class='loggedin'>Du är inloggad som " . $_SESSION['username'] . "</span>";
}
include_once('config.php');
include('includes/header.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: index.php');
}
?>
<div class="welcome">
    <?php
    $user = new Users();
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $profileimg = $_POST['profileimg'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $profile = $_POST['profile'];
    }
    $show_user = $user->getUserFromId($id);
    $username = $show_user['username'];
    $profileimg = $show_user['profileimg'];
    $firstname = $show_user['firstname'];
    $lastname = $show_user['lastname'];
    $profile = $show_user['profile'];
    echo "<h1 class='h1top'>" . $username . "'s profil.</h1>";
    ?>
</div>
<div class="mainblog">
    <div class="profile">
        <?php
        $users = new Users();
        if ($_SESSION['id'] != $_GET['id']) {
            if (isset($_GET['id'])) {
                $username = $_SESSION['username'];
                $userid = $_GET['id'];
                if ($users->isThisFollowed($username, $userid)) {
                    echo '  <form id="unfollow" method="post" >
        <button type="submit" value="unfollow" name="unfollow" class="btnreg">Avfölj</button>
        </form>';
                } else {
                    echo "<form id='follow' method='post' >
        <button type='submit' value='follow' name='follow' class='btnreg'>Följ</button>
        </form>";
                }
            }
        }
        echo "<img src=profileimg/" . $profileimg . " alt='Profilbild' class='profileimg1'><p>$firstname $lastname</p>";
        echo "<h3>Om mig:</h3> $profile ";
        if (isset($_POST['follow'])) {
            if ($users->followUser($username, $userid)) {
                echo "<p class='follow'>Du följer nu denna användare.</p>";
            }
        }
        if (isset($_POST['unfollow'])) {
            if ($users->unfollowUser($username, $userid)) {
                echo "<p class='follow'>Du har avföljt denna användare.</p>";
            }
        }
        ?>
    </div>
    <button onclick="topFunction()" id="topBtn" title="Go to top"><img src="./bilder/top.png" alt="Till toppen"></button>
    <?php
    $user = new Users();
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $profileimg = $_POST['profileimg'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $profile = $_POST['profile'];
    }
    $show_user = $user->getUserFromId($id);
    $username = $show_user['username'];
    $profileimg = $show_user['profileimg'];
    $firstname = $show_user['firstname'];
    $lastname = $show_user['lastname'];
    $profile = $show_user['profile'];
    echo "<h2 class='h2profile'>" . $username . "'s inlägg.</h2>";
    ?>
    <?php
    $blogpost = new Blogposts();
    $blogpostslist = $blogpost->getBlogpostsFromThisAuthor();
    foreach ($blogpostslist as $post) {
        if ($post['authorid'] = $_GET['id']) {
            if ($post['img']) {
                echo "<div class='post'><img src='./profileimg/" . $post['profileimg'] . "' class='profileimg' alt='profileimg' >" . "<p class='userp'>" . "<a href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] . " " . $post['lastname'] . "</a></p>" . "<p class='created'>" . $post['created'] .
                    "</p><h3>" . $post['title'] . "</h3><figure><img class='blogimg' src='./uploads/" . $post['img'] . "' alt='blogbild' ></figure>" . $post['content'] . "
                <p><a class='readmore' href='blogpost.php?postid=" . $post['postid'] . "'>Visa mer</a> </div> ";
            } else {
                echo "<div class='post'><img src='./profileimg/" . $post['profileimg'] . "' class='profileimg' alt='profileimg' >" . "<p class='userp'>" . "<a href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] . " " . $post['lastname'] . "</a></p>" . "<p class='created'>" . $post['created'] .
                    "<h3>" . $post['title'] . "</h3>" . $post['content'] . "
                <p><a class='readmore' href='blogpost.php?postid=" . $post['postid'] . "'>Visa mer</a>
                </p></div>";
            }
        }
    }
    ?>
</div>
<script>
    CKEDITOR.replace('content');
</script>
<script>
    CKEDITOR.replace('profile');
</script>
<?php
include('includes/footer.php');
?>