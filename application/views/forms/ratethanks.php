<?php
require_once('recaptchalib.php');
$privatekey = "6Lc27NgSAAAAAH1q-aJOpzUAESS30J-E5I_WV1Q_";
$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
// What happens when the CAPTCHA was entered incorrectly?>

	<h1>Whooops</h1>

	<p>The reCAPTCHA wasn't entered correctly. Go back and try it again.</p>

	<p>
		<form action="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>/<?php echo $item->item_slug ?>/rate" method="post">
			<button type="submit" name="submit" class="bluebutton">Go Back</button>
		</form>
	</p>

<?} else {
// code here to handle a successful verification
?>

	<h1>Your Rating for <?php echo $item->item_name ?> Has Been Submitted</h1>

	<br /><br />

	<p> 

	<form action="/<?php echo $campus->university_slug ?>">
		<button type="submit" name="submit" class="bluebutton">Rate more stuff at <?php echo $campus->university_name ?></button>
	</form>

	</p>

<?}
?>


<br /><br /><br /><br />
