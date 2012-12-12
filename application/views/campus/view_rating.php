<h1><?php $campus->university_name ?></h1>

		<p><strong>RATED ON <?php echo date("n/d/Y", strtotime($rating->rating_date)) ?></strong></p>

		<div id="ratingcontainer">
			
			<a href="/<?php echo $campus->university_slug ?>"><img src="<?php echo base_url(); ?>images/back.gif" border="0" alt="back" height="37" width="102" /></a>

			<a href="/<?php echo $campus->university_slug ?>/rate"><img src="<?php echo base_url(); ?>images/rate_it_large.gif" border="0" alt="rate this" height="42" width="150" align="right" /></a>

			<br /><br /><br />

			<table cellpadding="0" cellspacing="0" border="0">
  		<tr>
  		<?php $i = 1; ?>
  		<?php foreach($campus_ratings as $campus_rating): ?>
  			<td width="320" valign="top"><?php echo $campus_rating->attribute_name ?></td>
  			<td valign="top">
    			<div id="otherrating">
    			  <span style="width: <?php echo ($campus_rating->score / 5.0) * 100 ?>%"><?php echo number_format($campus_rating->score, 1, '.', ',') ?></span>
    			</div>
    		</td>
    		<?php
  			if($i % 2 == 0)
  			  echo "</tr><tr>\n";
  			else
           echo "<td width=127>&nbsp;</td>";
  			$i++;
        ?>
  		<?php endforeach ?>
  		</tr>
  		</table>

			<p>

      <div style="background-color:#e1e1e1;padding:10px;">

         <?php echo $rating->rating_comments ?></p>

      </div>

      <p align="right"><a href="/<?php echo $campus->university_slug ?>/<?php echo $rating->rating_id ?>/flag"><img src="<?php echo base_url(); ?>images/flag_this.png" height="23" width="61" border="0" alt="flag this" /></a></p>

			<p><a href="/<?php echo $campus->university_slug ?>"><img src="<?php echo base_url(); ?>images/back.gif" border="0" alt="back" height="37" width="102" /></a></p>

		</div>


			
		<br /><br />

		<p></p>