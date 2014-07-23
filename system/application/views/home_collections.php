<table cellpadding='0' cellspacing='0'>
	<tr>
		<td width='225'>
			<ul>
			<?

				foreach($collections as $id => $title) {
					$anchor = anchor("collections/index/$id", $title);
					echo "<li> $anchor</li>";
				}

			?>
			</ul>
		</td>
		<td valign='top'>
			<form action='<?=$this->config->item('base_url').$this->config->item('index_page');?>/welcome/search' method='post'>
				<input type='text' name='q'> <input type='submit' value='Search'>
			</form>
		</td>
	</tr>
</table>
