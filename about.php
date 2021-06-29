<?php
//Tilda Källström 2021 Webbutveckling 2 Mittuniversitetet
//inkludera fil
include('includes/header.php');
?>
<div class='welcome'>
    <h1 class='h1top'>Om Hunddagboken</h1>
</div>
<div class="main1">
<div class="main4">
<div class='left'>
    <div class='about'>
<h2>Hunddagboken</h2>
<p class="p1">Hunddagboken är ett fiktivt företag som låter dig som användare skapa din egen blogg. Idén bakom Hunddagboken ligger i att du som användare skall ha möjligheten att blogga om livet med hund. Här kan du uppdatera dina följare om hur det går för dig och dina hundar med träning, tävling och allt som hör vardagen med hund till.</p>
</div>
</div>
<div class='right'>
    <h2 class="centerh2">Kontakta oss gärna!</h2>
<?php 
//kontaktformulär
if(isset($_POST['submit'])){ //om submit-knapp är klickad på
    $to = "tildakallstrom@gmail.com"; // email som meddelande skickas till
    $from = $_POST['email']; // avsändarens email
    $first_name = $_POST['first_name']; //inskrivet namn
    $last_name = $_POST['last_name'];
    $subject = "Form submission";
    $subject2 = "Copy of your form submission";
    $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "<p>Ditt meddelande: " . $_POST['message'] . "</p>";

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // skickar kopia av meddelande till avsändaren
    echo "<p>Mailet är skickat. Tack " . $first_name . ", vi återkommer så snart vi kan.</p>";
    echo $message2;
    }
?>
<!-- formuläret -->
<form action="#" method="post" class="contactform">
<label for="first_name">Förnamn:</label><br> <input type="text" name="first_name" id="first_name" class="firstname1"><br>
<label for="last_name">Efternamn:</label><br><input type="text" name="last_name" id="last_name" class="firstname1"><br>
<label for="email">Email:</label><br> <input type="text" name="email" id="email" class="firstname1"><br>
<label for="message2">Meddelenade:</label><br><textarea rows="5" name="message" id="message2" cols="30"></textarea><br><br>
<input type="submit" name="submit" value="Skicka meddelande" class="btnreg">
</form>
</div>
</div>
</div>
<?php
include('includes/footer.php');
?>