<div style="float:left;"><h1>BEST OF</h1></div>

	<div id="bestofsearch">

		<form action="/best-of" method="post">

			<select name="school">
				<option value="">All Schools</option>
				<?php foreach($campuses as $aCampus): ?>
          <?php if($campus->university_id == $aCampus->university_id): ?>
            <option value="<?php echo $aCampus->university_slug ?>" selected="selected"><?php echo $aCampus->university_name ?></option>
          <?php else: ?>
            <option value="<?php echo $aCampus->university_slug ?>"><?php echo $aCampus->university_name ?></option>
          <?php endif ?>
  			<?php endforeach ?>
			</select>

			<input type="submit" value="GO" class="bluebutton" />

	    </form>

	</div>

		<br /><br />

    <?php if(isset($best_campuses)): ?>
		<div id="bestoflist" style="float:none;width:100%;">
		<table cellpadding="3" cellspacing="0" border="0" align="center">

			<tr bgcolor="#9cc24d">
				<td colspan="4" width="457"><span class="bestofheader">OVERALL BEST CAMPUS</span></td>
			</tr>
			<?php $rank = 1; ?>
			<?php foreach($best_campuses as $bCampus): ?>
        <tr valign="top">
  				<td width="25" align="right"><?php echo $rank ?>.</td>
  				<td width="288"><a href="/<?php echo $bCampus->university_slug ?>"><?php echo $bCampus->university_name ?></a></td>
  				<td width="100"><?php echo $bCampus->state_abbr ?></td>
  				<td width="" align="right"><?php echo number_format($bCampus->score, 1, '.', ',') ?></td>
  			</tr>
      <?php $rank++; endforeach ?>
    </table>
  	</div>
    <?php endif ?>

		<br />
		
		<?php if(isset($campus) && empty($empty_best_of)): ?>
		  <p>This school has no ratings yet.</p>
		  
		  <p>&nbsp;</p>

		  <form action="/<?php echo $campus->university_slug ?>">
	  		<p><button type="submit" name="submit" class="bluebutton">Rate <?php echo $campus->university_name ?></button></p>
		  </form>
		  
		<?php endif ?>

    <?php $i = 0; ?>
    <?php foreach($categories as $category): ?>
    <?php if(!empty($category->best_of)): ?>
		<div id="bestoflist" class="<?php echo ($i % 2 == 1) ? 'bestofright' : '' ?>">

			<table cellpadding="3" cellspacing="0" border="0">

				<tr bgcolor="<?php echo $category->category_color2 ?>">
					<td colspan="4" width="457"><span class="bestofheader"><?php echo $category->category_name ?></span></td>
				</tr>
				<?php $j = 1; ?>
				<?php foreach($category->best_of as $best): ?>
				<tr valign="top">
					<td width="25" align="right"><?php echo $j ?>.</td>
					<td width="188"><a href="/<?php echo $best->university_slug ?>/<?php echo $category->category_slug ?>/<?php echo $best->item_slug ?>"><?php echo substr($best->item_name,0,23) ?><?php if (strlen($best->item_name) > 23) echo "..."?></a></td>
					<td width="200"><a href="/<?php echo $best->university_slug ?>" style="text-decoration:none;font-weight:normal;"><?php echo $best->university_name ?></a></td>
					<td width="" align="right"><?php echo number_format($best->score, 1, '.', ',') ?></td>
				</tr>
        <?php $j++; endforeach ?>
			</table>	

		</div>
		<?php echo ($i % 2 == 1) ? '<div id="clear" style="clear:both;"></div>' : '' ?>
		<?php $i++; ?>
		<?php endif ?>
    <?php endforeach ?>

<br /><br />

<p></p>
