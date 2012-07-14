<div style="float:left;"><h1>BEST OF</h1></div>

	<div id="bestofsearch">

		<form action="/campus/view" method="post">

			<select name="school">
				<option value="">All Schools</option>
				<?php foreach($campuses as $campus): ?>
  				<option value="<?php echo $campus->university_slug ?>"><?php echo $campus->university_name ?></option>
  			<?php endforeach ?>
			</select>

			<input type="submit" value="GO" class="bluebutton" />

	    </form>

	</div>

		<br /><br />

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
					<td width="148"><a href="/<?php echo $best->university_slug ?>/<?php echo $category->category_slug ?>/<?php echo $best->item_slug ?>"><?php echo $best->item_name ?></a></td>
					<td width="240"><a href="/<?php echo $best->university_slug ?>" style="text-decoration:none;font-weight:normal;"><?php echo $best->university_name ?></a></td>
					<td width="" align="right"><?php echo number_format($best->score, 1, '.', ',') ?></td>
				</tr>
        <?php $j++; endforeach ?>
			</table>	

		</div>
		<?php echo ($i % 2 == 1) ? '<div id="clear" style="clear:both;"></div>' : '' ?>
		<?php $i++; endif ?>
    <?php endforeach ?>

<br /><br />

<p></p>
