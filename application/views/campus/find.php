<h1>Campus Ratings</h1>

<p>Rate dorms, dining halls, libraries, bookstores, greek life, and everything<br />else on your college campus:</p>

<div id="homeleft">

			<div id="homefind">

				<br /><br /><br /><br />
			
				<form action="/campus/view" method="post">

			<select name="school">
				<option value="">Choose a School</option>
				<?php foreach($campuses as $c): ?>
  				<option value="<?php echo $c->university_slug ?>"><?php echo $c->university_name ?></option>
  			<?php endforeach ?>
			</select>

			<input type="submit" value="GO" class="bluebutton" />

      </form>

			</div>
			
			<div id="directory">
			
				<strong>School Directory</strong>
        <br />
				<?php
				foreach (range('A', 'Z') as $letter) {
				  echo '<a href="/directory/#'.$letter.'">'.$letter.'</a>&nbsp;&nbsp;';
			  }
        ?>
			
			</div>

		</div>

	<div id="homeright">

		<br /><table cellpadding="0" cellspacing="0" border="0">

	  	<?php foreach($recent_campuses as $campus): ?>
  		<tr valign="top"><td width="25"><img src="images/activity_check.png" width="21" height="21" hspace="5" border="0" alt="new" /></td>
  			<td><a href="/<?php echo $campus->university_slug ?>" class="homerightname">
  			<?php echo $campus->university_name ?></a></td>
  		</tr>
  			
  		<?php endforeach ?>
  		</table>

  </div>

<div id="clear" style="clear:both;"></div>

<br /><br />

<p></p>
