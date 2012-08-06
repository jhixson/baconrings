<h1><?php echo $campus->university_name ?></h1>

<img src="<?php echo base_url(); ?>images/rss.gif" border="0" height="25" width="25" alt="rss" align="right" />

<div id="campusinfo">

	<div style="float:left;"><img src="<?php echo base_url(); ?>images/icon_campus.png" height="41" width="41" border="0" alt="campus" /></div>

	<div id="campusinfooverall">
		OVERALL CAMPUS RATING:
		<br />TOTAL RATINGS:
	</div>

	<div id="campusinforatings">
		4.5
		<br />1,207
	</div>

	<div id="campusinfoline">
		<img src="<?php echo base_url(); ?>images/pixel_black.gif" height="41" width="1" border="0" />
	</div>	

	<div style="float:right;">

		<div id="campusinfobest">
		BEST THING HERE:
		<br />WORST THING HERE:
		</div>

		<div id="campusinfobest2">
		<?php echo $best_thing; ?>
		<br /><?php echo $worst_thing; ?>
		</div>
	</div>

</div>

<br /><br />


<div id="ratingsboxcontainer">

	<div style="background-image:url('<?php echo base_url(); ?>images/ratingsbox_bg.gif');"><img src="<?php echo base_url(); ?>images/ratingsbox_header.gif" height="70" width="497" border="0" alt="ratings" /></div>

	<div id="ratingsbox">
	
		<table cellpadding="3" cellspacing="0" border="0">
		<?php foreach($category_ratings as $k => $v): ?>
			<tr>
				<td align="right" width="45" style="color:#<?php echo $v->color ?>;font-size:26pt;line-height:25px;">&#8226;</td>
				<td width="210"><a href="/<?php echo $campus->university_slug."/".$v->slug ?>"><?php echo $k ?></a></td>
				<td width="50"><?php echo number_format($v->score, 1, '.', ',') ?></td>
				<td width="120" align="right"><?php echo $v->total ?></td>
			</tr>
      <?php endforeach ?>
			<tr>
				<td></td>
				<td colspan="3" style="font-size:11pt;text-transform:capitalize;"><br />Don't see what you are looking for? <a style="font-size:10pt;" href="/forms/add-category">Add it here</a></td>
			</tr>

		</table>	
	</div>
	
	<div><img src="<?php echo base_url(); ?>images/ratingsbox_footer.gif" height="19" width="497" border="0" /></div>

</div>

<div id="activitycontainer">
	<div style="background-image:url('<?php echo base_url(); ?>images/activity_bg.gif');"><img src="<?php echo base_url(); ?>images/activity_header.gif" height="70" width="413" border="0" alt="activity feed" /></div>

	<div id="activity">

		<table cellpadding="3" cellspacing="0" border="0" style="margin-left:55px; width:305px;">
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
  	  <!--
			<tr>
				<td><img src="<?php echo base_url(); ?>images/activity_check.png" height="21" width="21" border="0" alt="rated" /></td>
				<td><a href="" class="mainlink">Dellplain Hall</a> rated under <a href="">dorms</a>.</td>
			</tr>
			<tr>
				<td><img src="<?php echo base_url(); ?>images/activity_camera.png" height="21" width="21" border="0" alt="photo" /></td>
				<td>Photo added for <a href="" class="mainlink">Dellplain Hall</a>.</td>
			</tr>
			<tr>
				<td><img src="<?php echo base_url(); ?>images/activity_check.png" height="21" width="21" border="0" alt="rated" /></td>
				<td><a href="" class="mainlink">Ernie Davis</a> rated under <a href="">dining halls</a>.</td>
			</tr>
			<tr>
				<td width="25"><img src="<?php echo base_url(); ?>images/activity_plus.png" height="21" width="21" border="0" alt="added" /></td>
				<td><a href="" class="mainlink">Grocery Stores</a> added.</td>
			</tr>
			-->
		</table>	

	</div>

	<div><img src="<?php echo base_url(); ?>images/activity_footer.gif" border="0" height="19" width="413" /></div>
</div>

<div id="clear" style="clear:both;"></div>	
