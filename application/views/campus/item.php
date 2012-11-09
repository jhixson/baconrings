<div id="icon"><img src="<?php echo base_url(); ?>images/icon_large_<?=str_replace(" ","", $category->category_name)?>.gif" border="0" height="67" width="67" /></div>

<div id="breadcrumbs" style="margin-top:1px;">
	<span class="breadcrumbs"><a href="/<?php echo $campus->university_slug ?>"><? echo $campus->university_name ?></a> > <a href="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>"><? echo $category->category_name ?></a></span><br />
</div>

<div id="itemcontainer">

	<div id="itemratingscontainer">

		<h1><?php echo $item->item_name ?></h1>

		<br />
		
		<div id="overallratinglabel">OVERALL</div>
		<div id="overallrating">
		  <span style="width: <?php echo ($overall_rating->score / 5.0) * 100 ?>%"><?php echo number_format($overall_rating->score, 1, '.', ',') ?></span>
		</div>
		<div id="clear" style="clear:both;"></div>

    <?php foreach($item_ratings as $item_rating): ?>
  		<div id="otherratinglabel"><?php echo $item_rating->attribute_name ?></div>
			<div id="otherrating">
			  <span style="width: <?php echo ($item_rating->score / 5.0) * 100 ?>%"><?php echo number_format($item_rating->score, 1, '.', ',') ?></span>
			</div>
			<div id="clear" style="clear:both;"></div>
  	<?php endforeach ?>

		<div id="clear" style="clear:both;"></div>

	</div>
	
	<div id="ranking" style="text-align:right;margin-bottom:10px;"><strong>#<?php echo $ranking ?> rated <?php echo substr(strtolower($category->category_name), 0, -1) ?> at <?php echo $campus->university_name ?></strong></div>
  

	<div id="iteminfocontainer">

    <div id="itemcopy">
  		
  		<?php if ($item->item_description): ?>
  			<?php echo $item->item_description ?>
  		<?php else: ?>
  			<em>There is no description for this item. You may submit one by clicking on the Submit Correction button below.</em>
  		<?php endif ?>

		</div>
		
		<div id="itemphoto">
			<?php if($item->item_photo): ?>
				<img src="<?php echo base_url(); ?>photos/<?php echo $campus->university_slug ?>/<?php echo $item->item_photo ?>" border="0" height="115" width="160" alt="<?php echo $item->item_name ?>" />
			<?php else: ?>
				<img src="<?php echo base_url(); ?>photos/default_item.gif" border="0" height="115" width="160" alt="<?php echo $item->item_name ?>" />
			<?php endif ?>
			<div style="text-align:right;padding-top:8px;">
				
				<div style="float:left;">
					<a href="" target="_new"><img src="<?php echo base_url(); ?>images/icon_location.png" height="24" width="25" alt="map it" border="0" /></a>
				</div>	

				<div id="addressinfo">
				<?php if ($item->item_address): ?><?php echo $item->item_address ?><?php endif?>
				<?php if ($item->item_address2): ?><br /><?php echo $item->item_address2 ?><?php endif?>
				
				<?php if (($item->item_city) || ($item->item_state) ||($item->item_zip)): ?><br /><?php endif?>

				<?php if ($item->item_city): ?><?php echo $item->item_city ?><?php endif?>

				<?php if ($item->item_state): ?>,<?php endif?>
				
				<?php if ($item->item_state): ?><?php echo $item->item_state ?>&nbsp;<?php endif?>
				<?php if ($item->item_zip): ?><?php echo $item->item_zip ?><?php endif?>
				
				<?php if ($item->item_phone): ?><br /><?php echo $item->item_phone ?><?php endif?>
				</div>

				<!--<a href="/<?php// echo $campus->university_slug."/".$category->category_slug."/".$item->item_slug."/upload" ?>"><img src="<?php// echo base_url(); ?>images/icon_camera.png" border="0" height="24" width="29" alt="photos" /></a>-->
			</div>

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


		<?php if($num_ratings == 0):?> 

			<tr>
				<td colspan="5">
					<em>There are no ratings for this item, be the first to rate it!</em> <a href="/<?php echo $campus->university_slug."/".$category->category_slug."/".$item->item_slug."/rate" ?>"><img src="/images/rate_it_small.png" height="21" hspace="10" width="76" alt="rate it" border="0" /></a>
				</td>
			</tr>

		<?php else:?>
		
    		<?php $i = 0; ?>
    		<?php foreach($comments as $k => $comment): ?>
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
  					<td class="ratingscopy"><span class="ratingsauthor">by (users type here)</span><br />
  					<?php echo nl2br($comment->comment_text) ?>
  					</td>
  					<td>&nbsp;</td>
  					<td>
  						<a href=""><img src="<?php echo base_url() ?>images/share_facebook.gif" border="0" height="24" width="24" alt="share to facebook" /></a><a
  						href=""><img src="<?php echo base_url() ?>images/share_twitter.gif" border="0" height="24" width="24" alt="share to twitter" hspace="5" /></a><a
  						href=""><img src="<?php echo base_url() ?>images/share_email.gif" border="0" height="24" width="24" alt="share to email" /></a>

  						<a href="/<?php echo $campus->university_slug."/".$category->category_slug."/".$item->item_slug."/".$k."/flag" ?>"><img src="<?php echo base_url() ?>images/flag_this.png" align="right" border="0" height="23" width="61" alt="flag this" /></a>
  					</td>
  				</tr>
  				<?php $i++; ?>
    		<?php endforeach?>

		<?php endif ?>    

	</table>

</div>
