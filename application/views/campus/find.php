<h1>Campus Ratings</h1>

<?php if($user_profile) var_dump($user_profile); ?>

<p>Rate dorms, dining halls, libraries, bookstores, greek life, and everything else on your college campus:

<p></p>

<div id="homefind">

	<br /><br /><br /><br />
	
	<form action="campus.php" method="post">

			<select name="school">
				<option value="">Choose a School</option>
				<?php foreach($campuses as $campus): ?>
  				<option value="<?php echo $campus->university_id ?>"><?php echo $campus->university_name ?></option>
  			<?php endforeach ?>
			</select>

			<input type="submit" value="GO" class="bluebutton" />

	</form>

</div>

<br /><br />

<p></p>