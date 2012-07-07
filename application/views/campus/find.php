<h1>Campus Ratings</h1>

<p>Rate dorms, dining halls, libraries, bookstores, greek life, and everything<br />else on your college campus:</p>

<div id="homeleft">

			<div id="homefind">

				<br /><br /><br /><br />
			
				<form action="/campus/post_find" method="post">

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

	<a href="" class="homerightname">Dellplain Hall</a>
	<br />at <a href="" class="homerightlink">Syracuse University</a>
	<div style="margin-top:5px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tincidunt, purus non sodales lorem...</div>

</div>

<div id="clear" style="clear:both;"></div>

<br /><br />

<p></p>
