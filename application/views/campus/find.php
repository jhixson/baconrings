<h1>Campus Ratings</h1>

<p>Rate dorms, dining halls, libraries, bookstores, greek life, and everything<br />else on your college campus:</p>

<div id="homeleft">

			<div id="homefind">

				<br /><br /><br /><br />
			
				<form action="/campus/view" method="post">

			<select name="school">
				<option value="">Choose a School</option>
				<?php foreach($campuses as $campus): ?>
  				<option value="<?php echo $campus->university_slug ?>"><?php echo $campus->university_name ?></option>
  			<?php endforeach ?>
			</select>

			<input type="submit" value="GO" class="bluebutton" />

      </form>

			</div>

		</div>

	<div id="homeright">
	  <?php foreach($recent_campuses as $campus): ?>
  		<br /><a href="/<?php echo $campus->university_slug ?>" class="homerightname"><?php echo $campus->university_name ?></a>
  	<?php endforeach ?>
  </div>

<div id="clear" style="clear:both;"></div>

<br /><br />

<p></p>
