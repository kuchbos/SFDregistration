<!DOCTYPE HTML>  
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  



<?php
// Based on examples from
// http://www.w3schools.com/php
// http://myphpform.com
// http://stackoverflow.com/questions/7711466/checking-if-form-has-been-submitted-php
// http://stackoverflow.com/questions/7266935/how-to-send-utf-8-email#7267251
// Further interesting example
// http://code.tutsplus.com/tutorials/how-to-implement-email-verification-for-new-members--net-3824

// define variables and set to empty values

$nameErr = $emailErr = $tutorialErr = $computerErr = "";
$name = $email = $tutorial =  $computer = $comment =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Nimi on vajalik / Имя требуется / Name is required";
  } else {
    $name = test_input($_POST["name"]);
  } 
  
  if (empty($_POST["email"])) {
    $emailErr = "e-posti on valjak / Требуется адрес электронной почты /email is required";
  } else {
    $email = test_input($_POST["email"]);
  }
    
  if (empty($_POST["tutorial"])) {
    $tutorialErr = "Õppetund valik on vajalik / Учебник выбор требуется / Tutorial choice is required";
  } else {
    $tutorial = test_input($_POST["tutorial"]);
  }

  if (empty($_POST["computer"])) {
    $computerErr = "Arvuti olemasolu vajalik / требуется наличие компьютера / Computer availability required";
  } else {
    $computer = test_input($_POST["computer"]);
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<h2>SFD Narva 2016</h2>

<p><span class="error">* nõutud väli / Обязательное поле / required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  nimi / имя / name:<br />
  <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  e-post / Эл. адрес / email:<br />
  <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  õppetund / урок / tutorial:<br />
  <input type="radio" name="tutorial" <?php if (isset($tutorial) && $tutorial=="Digitaalne joonistamine ja fototöötlus /
 Цифровая живопись и управление фотографиями / Digital painting and photo management") echo "checked";?> value="Digitaal
ne joonistamine ja fototöötlus / Цифровая живопись и управление фотографиями / Digital painting and photo management">Di
gitaalne joonistamine ja fototöötlus / Цифровая живопись и управление фотографиями / Digital painting and photo manageme
nt<br />
  <input type="radio" name="tutorial" <?php if (isset($tutorial) && $tutorial=="Disain ja raamatupidamine / Дизайн и бух
галтерский учет / Design and accounting") echo "checked";?> value="Disain ja raamatupidamine / Дизайн и бухгалтерский уч
ет / Design and accounting">Disain ja raamatupidamine / Дизайн и бухгалтерский учет / Design and accounting
  <span class="error">* <?php echo $tutorialErr;?></span>
  <br><br>
  Saan tuua oma arvuti / Я могу взять мой собственный компьютер / I can bring my own computer:<br />
  <input type="radio" name="computer" <?php if (isset($computer) && $computer=="Yes") echo "checked";?> value="Yes">jah 
/ да / yes
  <input type="radio" name="computer" <?php if (isset($computer) && $computer=="No") echo "checked";?> value="No">ei / Н
ет / no
  <span class="error">* <?php echo $computerErr;?></span>
  <br><br>
  kommentaar / комментарий / comment:<br />
  <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
  juurdepääsukood / код доступа / access code:<br />
  <input type="text" name="code" /><br />
  Palun sisesta <b>EISPAM</b> eespool. / Пожалуйста, введите <b>EISPAM</b> выше. / Please enter <b>EISPAM</b> above. <br
 />
  <br><br>
  <input type="submit" name="formsubmit" value="Saada / Отправить / Submit"/>  

</form>



<?php
// Check for submission of entered data
if (isset($_POST['formsubmit'])){
 // Check for spam prevention code entry
 if (strtolower($_POST['code']) != 'eispam' ) {die('vale koodi / неверный код доступа / Wrong access code');}
  else{ 
   // Set e-mail recipient 
   $myemail  = "me@mylocaldomain.mytopdomain";

   // Set subject 
   $subject = "Narva avatud tarkvara";

   // Let's prepare the message for the e-mail 
   $message = "

   nimi / имя / name, $name ,
   e-post / Эл. адрес / email, $email ,
   õppetund / урок / tutorial, $tutorial
   tuua arvuti / принести компьютер / bring computer, $computer ,
   kommentaarid / Комментарии / comments, $comment ,

   ";
   // Ensure have language encoding support
   $headers = "Content-Type: text/html; charset=UTF-8";

   // Send the message using mail() function 
   mail($myemail, $subject, $message, $headers);
   // Give user feedback 
   echo "<h2>Teie panus / Ваш вклад / Your input:</h2>";
   echo $name;
   echo "<br>";
   echo $email;
   echo "<br>";
   echo $tutorial;
   echo "<br>";
   echo $computer;
   echo "<br>";
   echo $comment;
   echo "<br>";
   echo "On esitatud, siis peaks saama kinnituse 1 tööpäeva jooksul";
   echo "<br>";
   echo "Был представлен, вы должны получить подтверждение в течение 1 рабочего дня";
   echo "<br>";
   echo "Has been submitted, you should receive an acknowledgement within 1 working day";
   echo "<br>";
 }
}
?>

</body>
</html>
