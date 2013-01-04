<div id="icon"><img src="<?php echo base_url(); ?>images/icon_large_<?=str_replace(" ","", $category->category_name)?>.gif" border="0" height="67" width="67" /></div>

<div id="breadcrumbs" style="margin-top:1px;">
	<span class="breadcrumbs"><a href="/<?php echo $campus->university_slug ?>"><? echo $campus->university_name ?></a> ></span><br /> 
	<h1><?php echo $campus->university_name ?> <?php echo $category->category_name ?></h1>  
</div>

<div id="listingcontainer">


	<strong>(<?php echo(count($items)) ?> listed)</strong>

	<table cellpadding="3" cellspacing="0" border="0">

		<tr>
			<td width="25"></td>
			<td width="245" class="theader" valign="bottom">NAME</td>
			<td width="90" class="theader" align="center">TOTAL RATINGS</td>
			<td width="95" class="theader" align="center">AVERAGE RATING</td>
			<td width="100"></td>
			<td width="96" class="theader" valign="bottom" align="right">SHARE</td>
		</tr>

		<?php
		$bgcolor="#e1e1e1";
		foreach($item_ratings as $k => $v): ?>
			<tr bgcolor="<?php echo $bgcolor ?>">
				<td align="right"><a href="/<?php echo $campus->university_slug."/".$category->category_slug."/".$v->slug ?>"><img src="/images/arrow_black.png" height="15" width="8" alt="" hspace="2" /></a></td>
				<td><a href="/<?php echo $campus->university_slug."/".$category->category_slug."/".$v->slug ?>" class="categorylink" style="color:#<?php echo $category->category_color1 ?>;"><?php echo $k ?></a></td>
				<td align="center"><?php echo $v->total ?></td>
				<td align="center"><?php echo number_format($v->score, 1, '.', ',') ?></td>
				<td align="center"><a href="/<?php echo $campus->university_slug."/".$category->category_slug."/".$v->slug."/rate" ?>"><img src="<?php echo base_url(); ?>images/rate_it_small.png" border="0" width="76" height="21" alt="rate it" /></a></td>
				<td align="right">
					<a href="https://www.facebook.com/dialog/feed?app_id=<?php echo $this->facebook->getAppId() ?>&amp;link=<?php echo base_url().$campus->university_slug."/".$category->category_slug."/".$v->slug ?>&amp;caption=See how it stacks up against other <?php echo strtolower($category->category_name) ?> at <?php echo $campus->university_name ?>&amp;redirect_uri=<?php echo base_url().$campus->university_slug."/".$category->category_slug."/".$v->slug ?>"><img src="<?php echo base_url(); ?>images/share_facebook.gif" border="0" height="24" width="24" alt="share to facebook" /></a>
					<a href="https://twitter.com/intent/tweet?original_referer=http://twitter.com/about/resources/buttons&amp;source=tweetbutton&amp;text=Check out the ratings for <?php echo $k ?> at <?php echo $campus->university_name ?>&amp;url=<?php echo base_url().$campus->university_slug."/".$category->category_slug."/".$v->slug ?>"><img src="<?php echo base_url(); ?>images/share_twitter.gif" border="0" height="24" width="24" alt="share to twitter" hspace="5" /></a><a
					href=""><img src="<?php echo base_url(); ?>images/share_email.gif" border="0" height="24" width="24" alt="share to email" /></a></td>
			</tr>
		<?
			if ($bgcolor=="#e1e1e1")
				{
				$bgcolor="#ffffff";
			}
			else
				{
					$bgcolor="#e1e1e1";
				}
		endforeach; 
		?>

	</table>	

	<p><strong>Don't see the one you are looking for? <a href="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>/add-item"><span class="bluelink">ADD IT HERE</span></a></strong></p>

</div>