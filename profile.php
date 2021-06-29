<?php
//Tilda Källström 2021 Webbutveckling 2 Mittuniversitetet
//starta session, inkludera filer
session_start();
include_once('config.php');
include('includes/header.php');
?>
<?php
//kontroll om sessionsvariabel finns
if (!isset($_SESSION['username']) && (!isset($_SESSION['id']))) {
    header("Location: login.php?message=2");
} else {
    // echo "<span class='loggedin'>Du är inloggad som " . $_SESSION['username'] . "</span>";
}
?>
<script src="https://cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>
<div class="welcome">
    <?php
    // om anv ej är inloggad, redirect
    if (!isset($_SESSION['username'])) {
        header("Location: login.php?message=2");
    } else {
        //annars skriv ut
        echo "<h1 class='h1top'>" . $_SESSION['username'] . "'s profil.</h1>";
    }
    ?>
</div>
<div class="main1">
<div class="main5">
    <div class="left1">
    


        <?php
        //profilbild
        $user = new Users();
//hämta blogpost från postid
$update_user = $user->getUserFromUsername($username);
$profileimg = $update_user['profileimg'];
        ?>
        <h2 class="h2profile">Byt profilbild</h2>
            <form method="post" enctype="multipart/form-data" class="profilechange">
                <label for="profileimg">Profilbild:</label>
                <?php echo "<img src='./profileimg/" . $profileimg . "' class='profileimg' alt='profileimg'>" ?><br>
                <br><input type="file" name="profileimg" id="profileimg"/> <br><br>
                <input type="submit" name="uploadprofile" value='Ladda upp' class="btnreg1"><br><br>
            </form><br>

            <?php
        $user = new Users();
        if (isset($_POST['uploadprofile'])) {

            if ($user->updateProfileimg()) {
                //vid lyckat resultat, alerta att det lyckats
                echo '<script type="text/javascript">
              alert("Uppladdning av profilbild lyckades.");
               window.location = "profile.php";
           </script>';
            } else {
                echo "<p class='red'>Fel vid uppladdning</p>";
            }
        }
        ?>


           
        </div>
        <div class="right1">
        <h2 class="h2profile">Ändra profil</h2>
        <?php
$users = new Users();
//kod för follow-knapp
if (isset($_POST['deleteuser'])) {
    if($users->deleteUser($username)) {
        session_destroy();
        header("Location: login.php");
} 
}
?> <form id='deleteuser' method='post' >
<button type='submit' value='deleteuser' name='deleteuser' class='deleteu'>Radera Användare</button>
</form>
        <?php
      
        $user = new Users();
//hämta blogpost från postid
$update_user = $user->getUserFromUsername($username);
$firstname = $update_user ['firstname'];
$lastname = $update_user ['lastname'];
$email = $update_user ['email'];
$profile = $update_user['profile'];
        ?>
        <form method="post" class="profileform">
            <label for="firstname">Förnamn</label><br>
            <input type="text" name="firstname" class="firstname" value="<?php echo $firstname; ?>" required /><br>
            <br> <label for="lastname">Efternamn</label><br>
            <input type="text" name="lastname" class="lastname" required value="<?php echo $lastname; ?>" /><br>
            <br> <label for="email">Email</label><br>
            <input type="email" name="email" class="email" required value="<?php echo $email; ?>" /><br>
            <br> <label for="profile">Profil</label><br>
            <textarea name="profile" class="profile" rows="10" cols="48"><?php echo $profile; ?></textarea>
            <br>
            <input type="submit" name="submit" value='Uppdatera profil' class="btnreg"><br><br>
        </form>

        
        <?php
        //uppdatera profil
        $user = new Users();
        //om knapp är klickat på
        if (isset($_POST['submit'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $profile = $_POST['profile'];
            //uppdatera
            if ($user->updateUser($firstname, $lastname, $email, $profile)) {
                echo "<p class='centerp'>Profilen är uppdaterad!</p>";
            } else {
                echo "<p class='centerp'>Fel vid uppdatering</p>";
            }
        }
        ?>
       
       
    </div>
    </div>
    
    <h2 class="h2profile">Skapa bloggpost</h2>
 

 <?php
 $blogpost = new Blogposts();
 //radera post
 if (isset($_GET['deleteid'])) {
     $postid = $_GET['deleteid'];
     //meddelar om radering funkat
     if ($blogpost->deleteBlogpost($postid)) {
         // header('Location: profile.php');
         echo "<p>Post raderad</p>";
     } else {
         echo "<p>Fel vid radering</p>";
     }
 }

 // lägg till post
 if (isset($_POST['title'])) {
     $author = $_SESSION['username'];
     $authorid = $_SESSION['id'];
     $title = $_POST['title'];
     $content = $_POST['content'];
     $img = $_FILES['image']['name'];

     //meddelar om artikel blivit skapad
     if ($blogpost->addBlogpost($author, $authorid, $title, $content, $img)) {
         echo "<p class='centerpp'>Blogginlägg skapad!</p>";
     } else {
         echo "<p class='errormessage'>Fel vid uppladdning av inlägg.</p>";
     }
 }
 ?>
 <form method="post" action="profile.php" enctype="multipart/form-data" class='profileform'>
     <label for="title">Titel: </label><br><input type="text" name="title" class="title"><br>
     <label for="content"> Brödtext: </label><br><textarea class="contentcontent" name="content" rows="10" cols="48"></textarea><br>
     <label for="image">Bild:</label><br>
     <input type="file" name="image" id="image"/>
     <input type="submit" value="Skapa inlägg" name="upload" class="btnreg">
 </form>

 <button onclick="topFunction()" id="topBtn" title="Go to top"><img src="./bilder/top.png" alt="Till toppen"></button>
    <?php
    $blogpost = new Blogposts();
    //hämta inloggad användares poster
    $blogpostslist = $blogpost->getBlogpostsFromAuthor();
    echo "<h2 class='h2profile'>Mina blogginlägg</h2>";
    $username = $_SESSION['username'];
    foreach ($blogpostslist as $post) {

        //Skriv ut skapade poster
        if ($post['author'] == $_SESSION['username']) {
            if ($post['img']) {
                // om posten har en bild:
                echo "<div class='postt'><a class='delete' href='profile.php?deleteid=" . $post['postid'] . "'>x</a><img src='./profileimg/" . $post['profileimg'] . "' class='profileimg' alt='profileimg' >" .
                    "<p class='userp'>" . "<a href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] . " " . $post['lastname'] . "</a></p>"
                    . "<p class='created'>" . $post['created'] .
                    "<h3>" . $post['title'] . "</h3><figure><img class='blogimg' src='./uploads/" . $post['img'] . "' alt='blogbild' ></figure><p class='contentp'>" . $post['content'] . "</p>
                <p><a class='readmore' href='blogpost.php?postid=" . $post['postid'] . "'>Visa mer</a>  
                <a class='btnupdate' href='update.php?postid=" . $post['postid'] . "'>Uppdatera</a></p></div>";
            } else {
                // om posten inte har en bild:
                echo "<div class='postt'><a class='delete' href='profile.php?deleteid=" . $post['postid'] . "'>x</a><img src='./profileimg/" . $post['profileimg'] . "' class='profileimg' alt='profileimg' >" . "<p class='userp'>" . "<a href='user.php?id=" . $post['id'] . "'>" . $post['firstname'] . " " . $post['lastname'] . "</a></p>" . "<p class='created'>" . $post['created'] .
                    "<h3>" . $post['title'] . "</h3><p class='contentp'>" . $post['content'] . "</p>
                <p><a class='readmore'' href='blogpost.php?postid=" . $post['postid'] . "'>Visa mer</a>
                <a class='btnupdate' href='update.php?postid=" . $post['postid'] . "'>Uppdatera</a></p></div>";
            }
        }
    }
    ?>
</div>
</div>
<!-- fixar fram en texteditor -->
<script>
    CKEDITOR.replace('content');
</script>
<script>
    CKEDITOR.replace('profile');
</script>
<?php
include('includes/footer.php');
?>