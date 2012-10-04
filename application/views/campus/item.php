<div id="icon"><img src="<?php echo base_url(); ?>images/icon_large_<?=str_replace(" ","", $category->category_name)?>.gif" border="0" height="67" width="67" /></div>

<div id="breadcrumbs" style="margin-top:1px;">
	<span class="breadcrumbs"><a href="/<?php echo $campus->university_slug ?>"><? echo $campus->university_name ?></a> > <a href="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>"><? echo $category->category_name ?></a></span><br />
</div>

<div id="itemcontainer">

	<div id="itemratingscontainer">

		<h1><?php echo $item->item_name ?></h1>

		<br />

		<div id="overallrating"><span class="overallrating"><?php echo number_format($overall_rating->score, 1, '.', ',') ?></span><br />OVERALL QUALITY<br />OUT OF 5</div>

    <?php foreach($item_ratings as $item_rating): ?>
  		<div id="otherrating"><span class="otherrating"><?php echo number_format($item_rating->score, 1, '.', ',')  ?></span><br /><?php echo $item_rating->attribute_name ?></div>
  	<?php endforeach ?>

		<div id="clear" style="clear:both;"></div>

    <br /><strong>#<?php echo $ranking ?> rated <?php echo substr(strtolower($category->category_name), 0, -1) ?> at Syracuse University</strong>

	</div>

	<div id="iteminfocontainer">

		<br /><br />
		<?php echo $item->item_description ?>
		<p />

		<div style="width:25px;float:left;"><a href="" target="_new"><img src="<?php echo base_url() ?>images/icon_location.png" height="24" width="25" alt="map it" border="0" /></a></div>
		
		<div id="address" style="float:left;">
		  <?php echo nl2br($item->item_address) ?>
		  <?php if(!empty($item->item_address2)) echo "<br />".nl2br($item->item_address) ?>
		  <br /><?php echo $item->item_city.", ".$item->item_state." ".$item->item_zip ?><br />
		  <?php echo $item->item_phone ?>
		</div>

		<div style="float:right;">
      <a class="heart item <?php echo $is_favorite ? 'active' : '' ?>" href="<?php echo base_url(); ?>toggle_favorite/<?php echo $item->item_id ?>">toggle favorite</a>
			<a href="/<?php echo $campus->university_slug."/".$category->category_slug."/".$item->item_slug."/upload" ?>" class="camera"><img src="<?php echo base_url() ?>images/icon_camera.png" border="0" height="24" width="29" alt="photos" /></a>
		</div>

		<div id="clear" style="clear:both;"></div>

	</div>	
	
	<div id="clear" style="clear:both;"></div>

</div>	

<a href="/forms/submit-correction"><img src="<?php echo base_url() ?>images/submit_correction.gif" alt="submit correction" width="137" border="0" height="20" align="right" vspace="5" /></a>


<div id="ratingscontainer">

	<br />

	<a href="/<?php echo $campus->university_slug."/".$category->category_slug."/".$item->item_slug."/rate" ?>"><img src="<?php echo base_url() ?>images/rate_it_large.gif" alt="rate this" border="0" height="42" width="150" /></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=""><img src="<?php echo base_url() ?>images/share_facebook_large.gif" height="31" width="31" border="0" alt="share it this on facebook" /></a>
	<a href=""><img src="<?php echo base_url() ?>images/share_twitter_large.gif" hspace="5px" height="31" width="31" border="0" alt="share it this on twitter" /></a>
	<a href=""><img src="<?php echo base_url() ?>images/share_email_large.gif" height="31" width="31" border="0" alt="share it this by email" /></a>

	<p><strong>(<?php echo $num_ratings ?> ratings)</strong></p>

	<table cellpadding="3" cellspacing="0" border="0">

		<tr>
			<td width="90" class="theader">DATE</td>
			<td width="205" class="theader">RATINGS</td>
			<td width="390" class="theader">COMMENTS</td>
			<td width="15">&nbsp;</td>
			<td width="172" class="theader">SHARE</td>
		</tr>

    <?php $i = 0; ?>
    <?php foreach($comments as $comment): ?>
		  <tr valign="top" bgcolor="<?php echo $i % 2 == 0 ? "#e1e1e1" : "#ffffff"?>">
  			<td class="ratingscopy"><?php echo date("n/j/Y", strtotime($comment->rating_date)) ?></td>
  			<td>
  				<table cellpadding="0" cellspacing="0" border="0">
  				<?php foreach($comment->ratings as $rating): ?>
  					<tr>
  						<td class="ratingslabel"><?php echo $rating->attribute_name ?></td>
  						<td>&nbsp;&nbsp;&nbsp;</td>
  						<td width="110" height="13" class="ratingslabel">
  						  <div class="rating_bar">
  						    <span style="width: <?php echo ($rating->attributerating_rating / 5.0) * 100 ?>%"><?php echo $rating->attributerating_rating ?></span>
  						  </div>
  						</td>
  					</tr>
          <?php endforeach ?>
  				</table>
  			</td>
  			<td class="ratingscopy"><span class="ratingsauthor">by a parent</span><br />
  			<?php echo nl2br($comment->comment_text) ?>
  			</td>
  			<td>&nbsp;</td>
  			<td>
  				<a href=""><img src="<?php echo base_url() ?>images/share_facebook.gif" border="0" height="24" width="24" alt="share to facebook" /></a><a
  				href=""><img src="<?php echo base_url() ?>images/share_twitter.gif" border="0" height="24" width="24" alt="share to twitter" hspace="5" /></a><a
  				href=""><img src="<?php echo base_url() ?>images/share_email.gif" border="0" height="24" width="24" alt="share to email" /></a>

  				<a href=""><img src="<?php echo base_url() ?>images/flag_this.png" align="right" border="0" height="23" width="61" alt="flag this" /></a>
  			</td>
  		</tr>
  		<?php $i++; ?>
    <?php endforeach ?>
	</table>

</div>
