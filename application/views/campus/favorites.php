<h1>My Schools</h1>

		<p></p>
    <?php if(count($favorites) > 0): ?>
		<table cellpadding="3" cellspacing="0" border="0">
		
		
			<tr class="header">
				<td colspan="2"><strong>NAME</strong></td>
				<td class="theader">RATING</td>
				<td class="theader">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

				<?php foreach($favorites as $favorite): ?>
				<tr>
					<td width="20">&nbsp;</td>
					<td width="300"><a href="<?php echo base_url(); ?><?php echo $favorite->university_slug ?>" class="favlink"><?php echo $favorite->university_name ?></a></td>
          <td width="100"><?php echo isset($favorite->score) ? number_format($favorite->score, 1, '.', ',') : 'n/a' ?></td>
          <td width="25"><a class="heart" href="<?php echo base_url(); ?>toggle_favorite/<?php echo $favorite->university_id ?>"><img src="<?php echo base_url(); ?>images/icon_favorite_remove.png" border="0" height="18" width="20" alt="remove from favorites" /></a></td>
				</tr>
				<?php endforeach ?>

		</table>
		<?php else: ?>
		  <p>You don't have any favorites yet. <a href="/">Go discover some schools.</a></p>
		<?php endif ?>

		<br /><br />

		<p></p>
