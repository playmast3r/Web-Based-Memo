<?php

//Google ReCAPTCHA to kill bots and spam
if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
        // site secret key
        $secret = 'xxxxxxxxxxxxxx';    //your Google ReCAPTCHA secret key
        // get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){

		//config.php has db connection
		require("config.php");

		$text1 = trim(htmlentities(mysqli_real_escape_string($db,$_POST["text1"]), ENT_QUOTES , "UTF-8"));
		$text1 = substr($text1, 0, 99998);
		$sql = "INSERT INTO memo (text) VALUES ('$text1');";
		mysqli_query($db,$sql); // or die(mysqli_error($db));

        $msg = "Content saved successfully";
        }
else {
	    $msg = "Invalid Captcha";}
     }
else if(isset($_POST["text1"])){
	    $msg = "Invalid Captcha! Please try again.";
     }
/*
Truncate table code in case its needed


require("config.php");
$sql = "DELETE FROM memo;";
mysqli_query($db,$sql) or die(mysqli_error($db));

*/
?>
<!-- 


      +-+-+-+-+-+-+-+-+ +-+-+-+ +-+-+-+ +-+ +-+-+-+-+-+-+-+-+-+-+-+-+-+
      |D|e|s|i|g|n|e|d| |B|y|:| |S|I|D| |-| |w|w|w|.|i|a|m|s|i|d|.|t|k|
      +-+-+-+-+-+-+-+-+ +-+-+-+ +-+-+-+ +-+ +-+-+-+-+-+-+-+-+-+-+-+-+-+	
	

	
-->
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Text sharing Platform</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
	<body>
		<div class="container">
			<h3>Store any text forever. Max. text length 1,00,000.</h3>
			<?php
			if(isset($msg))
			{
				echo '<center><a style="color:red;"><span style="color:red;">' . $msg . '</span></a></center>'; 
			}
			?>
			<form action="memo.php" method="post">
			<div class="form-group">
				<label for="text">Text:</label>
				<input type="text" class="form-control" id="text1" name="text1" required>
			</div>
			<div class="g-recaptcha" data-sitekey="xxxxxxxxxxxxxx"></div>  <!-- Replace xxxxxxxx with your Google ReCAPTCHA public key -->
			<button type="submit" class="btn btn-default">Store</button>
			</form>
			<br><br><br>
			<h2>Content Posted till now:</h2>
			<table class="table table-striped">
				<thead>
				<tr>
				<th>Id</th>
				<th>Text</th>
				</tr>
				</thead>
				<tbody>
<?php
require("config.php");
$sql = "SELECT * FROM memo;";

$result = mysqli_query($db, $sql);
while($row = mysqli_fetch_assoc($result)){
	$f1 = $row["id"];
	$f2 = $row["text"];
?>
				<tr>
						<td>
							<?php echo $f1 ?>
						</td>
						<td>
							<?php echo $f2 ?>
						</td>
				</tr>
<?php
}
?>
				</tbody>
			</table>
		</div>
	</body>
</html>