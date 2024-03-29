<?php
include_once("config.php");
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $users = new Users();
    if ($id = $users->loginUser($username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['profile'] = $profile;
        header("Location: profile.php");
    } else {
        $message = "Fel användarnamn/lösenord!";
    }
}
include('includes/header.php');
?>
<div class='welcome'>
    <h1 class='h1top'>Logga in</h1>
</div>
<div class='mainblog'>
    <div class="loginform">
        <?php
        if (isset($_GET['message'])) {
            if ($_GET['message'] == "1") {
                $message = "Du loggade ut";
            }
            if ($_GET['message'] == "2") {
                $message = "Du måste logga in";
            }
        }
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form method="post" action="#" class="regform">
            <label for="username">Användarnamn:</label>
            <br>
            <input type="text" name="username" class="username" id="username">
            <br>
            <label for="password">Lösenord:</label>
            <br>
            <input type="password" name="password" class="password" id="password">
            <br>
            <br>
            <input type="submit" value="Logga in" class="btnreg">
        </form>
        <p class="centerp">
            <a href="register.php" id="register">Registrera användare</a>
        </p>
    </div>
</div>
<?php
include('includes/footer.php');
?>