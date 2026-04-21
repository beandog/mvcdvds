			<ul>
			<?php

				foreach($collections as $id => $title) {
					$anchor = anchor("collections/index/$id", $title);
					echo "<li> $anchor</li>";
				}

			?>
			</ul>
