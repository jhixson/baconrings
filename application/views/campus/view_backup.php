<?php if(isset($_SESSION['alert'])): ?>
  <p class="alert"><?php echo $_SESSION['alert'] ?></p>
<?php unset($_SESSION['alert']); endif; ?>
<h1 class="left"><?php echo $campus->university_name ?></h1>

<div class="extra">
  <img src="<?php echo base_url(); ?>images/rss.gif" border="0" height="25" width="25" alt="rss" align="right" />
  <a href="/toggle_favorite/<?php echo $campus->university_id ?>" class="heart item <?php echo $is_favorite ? 'active' : '' ?>">Add favorite</a>
</div>
<div style="clear:both;"></div>
<div id="campusleft">

	<div id="campusphoto">
	  <?php if($campus->university_photo): ?>
		<img src="<?php echo base_url(); ?>photos/campus/<?php echo $campus->university_photo ?>" alt="<?php echo $campus->university_name ?>" height="120" width="584" />
		<?php else: ?>
		<img src="<?php echo base_url(); ?>photos/default_university.gif" alt="<?php echo $campus->university_name ?>" height="120" width="584" />
		<?php endif ?>
	</div>

	<div id="campusinfo">

		<span class="overalllabel">OVERALL RATING</span>

		<a href="<?php echo base_url(); ?><?php echo $campus->university_slug ?>/rate"><img src="<?php echo base_url(); ?>images/rate_it_large.png" vspace="10" alt="rate this" border="0" height="42" width="150" align="right" /></a>

		<div id="overallbig">
		  <span style="width: <?php echo ($overall_rating->score / 5.0) * 100 ?>%"><?php echo number_format($overall_rating->score, 1, '.', ',') ?></span>
		</div>

		<br /><strong style="font-size:14pt"><?php echo $overall_rating->total ?> TOTAL RATINGS</strong>

		<br /><br />
		
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
		<?php $i = 1; ?>
		<?php foreach($campus_ratings as $rating): ?>
			<td width="196"><?php echo $rating->attribute_name ?></td>
			<td width="85"><?php echo number_format($rating->score, 1, '.', ',') ?></td>
			<?php
			if($i % 2 == 0)
			  echo "</tr><tr>\n";
			$i++;
			?>
		<?php endforeach ?>
		</tr>
		</table>

	</div>

	<p><strong>COMMENTS</strong></p>

	<div id="campuscomment">

		
		<?php foreach($campus_rating_comments as $cc): ?>
		  <div id="campuscommentcopy">
  		  <?php echo date("m/d/Y",strtotime($cc->rating_date)) ?>
  		  
  		  <?php
  		  if(isset($cc->account_type) && $cc->account_type == "Alumni")
    	    $who = "an alumnus";
    	  else
      	  $who = isset($cc->account_type) ? strtolower("a ".$cc->account_type) : "a user";
  		  ?>
  		  <span class="ratingsauthor">by <?php echo $who ?></span><br />
  		  <?php echo $cc->rating_comments ?>
  		</div>
	

		  <div id="campuscommentview">
  			
  			<a href="<?php echo $campus->university_slug."/rating/".$cc->rating_id ?>"><img src="images/view_rating.png" border="0" width="102" height="36" alt="view rating" /></a>
  			<a href="<?php echo $campus->university_slug."/".$cc->rating_id."/flag" ?>"><img src="images/flag_this.png" vspace="6" width="61" height="23" border="0" alt="flag this" /></a>
  		</div>

  		<div id="clear" style="clear:both;"><br /></div>
		
			<?php endforeach ?>

	</div>
	<!-- hide for now...
	<div id="paging">

		1 &middot;
		<a href="">2</a> &middot;
		<a href="">3</a> &middot;
		<a href="">4</a>

	</div>
	-->

</div>

<div id="campusright">
  <strong>EVEN MORE RATINGS</strong></p>

		<div id="ratingsboxcontainer">

		<div style="background-image:url('images/ratingsbox_bg.gif');"><img src="images/ratingsbox_header.gif" height="55" width="346" border="0" alt="ratings" /></div>

		<div id="ratingsbox">

		<table cellpadding="3" cellspacing="0" border="0">
  			
  				<?php if (empty($category_ratings)): ?>
  					<tr>
  						<td width="43"></td>
  						<td width="215" style="font-style:italic;font-weight:normal;text-transform:capitalize;">No categories yet.</td>
  					</tr>
  				<?php endif?>

  				<?php foreach($category_ratings as $k => $v): ?>
  					<tr>
  						<td align="right" width="43" style="color:#<?php echo $v->color ?>;font-size:26pt;line-height:25px;">&#8226;</td>
  						<td width="215"><a href="/<?php echo $campus->university_slug."/".$v->slug ?>"><?php echo $k ?></a></td>
  						<td width="50"><?php echo number_format($v->score, 1, '.', ',') ?></td>
  					</tr>
   		     	<?php endforeach ?>

  			<tr>
  				<td width="30"></td>
  				<td colspan="2" width="265" style="font-size:11pt;text-transform:capitalize;"><br />Don't see what you are looking for? <a style="font-size:10pt;" href="/<?php echo $campus->university_slug ?>/add-category">Add a category here</a></td>
  			</tr>

  		</table>
  	</div>

  	<div><img src="<?php echo base_url(); ?>images/ratingsbox_footer.gif" height="19" width="346" border="0" /></div>

  </div>
  <div id="activitycontainer">
  	<div style="background-image:url('<?php echo base_url(); ?>images/ratingsbox_bg.gif');"><img src="<?php echo base_url(); ?>images/activity_header.gif" height="55" width="346" border="0" alt="activity feed" /></div>

  	<div id="activity">

  		<table cellpadding="3" cellspacing="0" border="0" style="margin-left:30px;">
  		  
  		  <?php if (empty($recent_activity)): ?>
  		  		<tr>
  		  			<td width="265" style="font-style:italic;">No recent activity for this school.</td>
  		  		</tr>
  		  <?php endif ?>

  		  <?php foreach($recent_activity as $activity): ?>
  		    <?php if(isset($activity->rating_id)): ?>
  			    <tr>
      				<td width="25"><img src="<?php echo base_url(); ?>images/activity_check.png" height="21" width="21" border="0" alt="rated" /></td>
      				<td><a href="/<?php echo $campus->university_slug ?>/<?php echo $activity->category_slug ?>/<?php echo $activity->item_slug ?>" class="mainlink"><?php echo $activity->item_name ?></a> rated under <a href="/<?php echo $campus->university_slug ?>/<?php echo $activity->category_slug ?>"><?php echo strtolower($activity->category_name) ?></a>.</td>
      			</tr>
      		<?php elseif(isset($activity->item_id)): ?>
  			    <tr>
      				<td width="25"><img src="<?php echo base_url(); ?>images/activity_plus.png" height="21" width="21" border="0" alt="added" /></td>
      				<td><a href="/<?php echo $campus->university_slug ?>/<?php echo $activity->category_slug ?>/<?php echo $activity->item_slug ?>" class="mainlink"><?php echo $activity->item_name ?></a> added to <a href="/<?php echo $campus->university_slug ?>/<?php echo $activity->category_slug ?>"><?php echo strtolower($activity->category_name) ?></a>.</td>
      			</tr>
      		<?php endif ?>
    		<?php endforeach ?>
  		</table>	
  	</div>

  	<div><img src="<?php echo base_url(); ?>images/ratingsbox_footer.gif" border="0" height="16" width="346" /></div>
  </div>
</div>

<div id="clear" style="clear:both;"></div>