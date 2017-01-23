<div id="build">
	<div class="elements">
		<h2>Elements</h2>
		<?php
		/**
		 * Filters elements
		 */
		$elements = apply_filters();

		foreach ( $elements as $element ) {
			$element = wp_parse_args( $element, [
				'name' => 'Untitled',
				'icon' => 'fa-star'
			] );
			echo "
			";
		}
		?>
	</div>
	<div class="properties">
		<h2 title="Click to open">Properties</h2>
		<?php

		?>
	</div>
</div>