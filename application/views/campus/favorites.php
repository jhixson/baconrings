<h1>My Favorites</h1>

		<p></p>

		<table cellpadding="3" cellspacing="0" border="0">

			<?php foreach($favorites as $k => $fave): ?>

			<tr class="header">
				<td colspan="2"><strong><a style="text-decoration:none;color:#000000;" href="<?php echo base_url(); ?><?php echo $fave[0]->university_slug ?>"><?php echo $fave[0]->university_name ?></a></strong></td>
				<td class="theader">&nbsp;</td>
				<td class="theader">RATING</td>
				<td>&nbsp;</td>
			</tr>

				<?php foreach($fave as $favorite): ?>
				<tr>
					<td width="20">&nbsp;</td>
					<td width="300"><a href="<?php echo base_url(); ?><?php echo $favorite->university_slug ?>/<?php echo $favorite->category_slug ?>/<?php echo $favorite->item_slug ?>" class="favlink"><?php echo $favorite->item_name ?></a></td>
					<td width="200"><a href="<?php echo base_url(); ?><?php echo $favorite->university_slug ?>/<?php echo $favorite->category_slug ?>" class="favlink"><?php echo $favorite->category_name ?></a></td>
          <td width="100"><?php echo isset($favorite->score) ? number_format($favorite->score, 1, '.', ',') : 'n/a' ?></td>
          <td width="25"><a class="heart" href="<?php echo base_url(); ?>toggle_favorite/<?php echo $favorite->item_id ?>"><img src="<?php echo base_url(); ?>images/icon_favorite_remove.png" border="0" height="18" width="20" alt="remove from favorites" /></a></td>
				</tr>
				<?php endforeach ?>

			<?php endforeach ?>

		</table>

		<br /><br />

		<p></p>
