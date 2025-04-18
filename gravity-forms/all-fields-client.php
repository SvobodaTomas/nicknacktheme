<?php

// Most email clients do not support <style> blocks. We'll define our styles here and output them inline in the markup below.
$styles = array(
	'table-heading'	=> 'text-align:left;color:#e2007a;font-size:20px;',
	'table'			=> 'border-collapse:collapse;width:100%;',
	'td-f'			=> 'border-bottom:1px solid black;text-align:left;width:70%;',
	'td-s'			=> 'border-bottom:1px solid black;text-align:left;width:30%;',
	'td-empty'		=> 'border-bottom:0;'
);

if ( ICL_LANGUAGE_CODE == 'cs' ) {
	$settings_page_id = 554;
} else {
	$settings_page_id = 1413;
}
$product_definition_raw = '';

foreach( $items as $item ) {

	// If field with product definitions
	if ( $item['field']->id==8 ) {

		// EXAMPLE:
		// ["0.5@@bez-potisku@@barevny@@-@@ČERVENÝ:150,<br>MODRÝ CYAN BLUE:200@@@@-","0.4@@bez-potisku@@univerzalni@@-@@-@@120@@-","0.3@@bez-potisku@@sada@@-@@-@@5@@-","0.25@@potisk@@iml@@-@@-@@1000@@1","0.5@@potisk@@sitotisk@@transparentni-kelimek@@-@@300@@1","0.5@@potisk@@sitotisk@@barevny-kelimek@@ZELENÝ:300@@@@5"]

		$product_definition_raw = $item['value'];
	}
} ?>

<?php if ( ICL_LANGUAGE_CODE == 'pl' ) : ?>

	<?php if ( $product_definition_raw ) :

		// Prepare the value
		$value_raw = $product_definition_raw;
		$value = str_replace( array("[","]"),"",$value_raw);
		$value_array = explode(',',$value);

		// Check which products were selected
		$has_iml = strpos($value,"iml")!==false ? true : false;
		$has_sitotisk = strpos($value,"sitotisk")!==false ? true : false;
		$has_bez_potisku = strpos($value,"bez-potisku")!==false ? true : false;
		$has_univerzal = strpos($value,"univerzalni")!==false ? true : false;
		$has_sada = strpos($value,"sada")!==false ? true : false;
		$has_color = strpos($value,"bez-potisku@@barevny")!==false ? true : false;
		// $has_transparent = strpos($value,"bez-potisku@@transparentni")>=0 ? true : false;

		$has_price_table = false;

		ob_start();

		foreach ($value_array as $product_definition) :

			// PRODUCT DEFINITION EXAMPLE:
			// 0.5@@bez-potisku@@barevny@@-@@ČERVENÝ:150,<br>MODRÝ CYAN BLUE:200@@@@-
			
			// Product definition
			$product_definition = str_replace("&quot;","",$product_definition);

			// Product definition heading
			// $product_definition_table_heading = str_replace("@@"," ",$product_definition);
			// $product_definition_table_heading = str_replace("€€",", ",$product_definition_table_heading);
			// $product_definition_table_heading = str_replace("&lt;br&gt;",", ",$product_definition_table_heading);
			
			$product_definition = explode('@@', $product_definition);

			// 0: volume
			// 1: variant
			// 2: product
			// 3: subproduct
			// 4: colors
			// 5: amount
			// 6: motive
			
			$volume = 'v' . str_replace(".","",$product_definition[0]);			// e.g. 0.5 -> v05 (field name in acf)
			$volume_text = str_replace(".",",",$product_definition[0]) . 'l';	// e.g. 0.5 -> 0,5l
			$variant = $product_definition[1];
			$product = $product_definition[2];
			$subproduct = $product_definition[3];

			$group = $product_title = $amount_text = $colors_text = $motive_text = '';
			$amount = $product_definition[5];
			$amount_text = $product_definition[5] . ' ' . __('ks','nicknack');
			$amount_limit = 2000;

			// Get the right group name
			if ( $variant == 'bez-potisku' ) {
				switch ($product) {
					case 'sada':
						$group = 'party_sada';
						$amount_limit = false;
						$product_title = __('Párty sada','nicknack');
						break;

					case 'barevny':
						$group = 'bez_potisku_color';
						$amount = 0;
						$amount_text = '';
						$colors_text_array = explode('€€', $product_definition[4]);
						foreach ( $colors_text_array as $key => $color ) {
							$color_array = explode(':', $color);	// array("ŽLUTÝ","250")
							$amount += intval($color_array[1]);
							$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
						}
						$colors_text = implode(", ",$colors_text_array);
						$product_title = __('Barevný bez potisku','nicknack');
						break;

					case 'univerzalni':
						$group = 'bez_potisku_transparent';
						$product_title = __('Transparentní bez potisku','nicknack');
						break;
					
					default:
						break;
				}
			} else {
				$amount_limit = 3000;

				switch ($product) {
					case 'iml':
						$group = 'iml';
						$motive_text = $product_definition[6] . ' grafických motivů';
						$product_title = __('Fotorealistický potisk (IML)','nicknack');
						break;

					case 'sitotisk':
						if ( $subproduct == 'transparentni-kelimek' ) {
							$group = 'sitotisk_transparent';
							$motive_text = $product_definition[6] . ' '. __('barev v motivu','nicknack');
							$product_title = __('Sítotisk transparentní kelímek','nicknack');
						} elseif ( $subproduct == 'barevny-kelimek' ) {
							$group = 'sitotisk_color';
							$amount = 0;
							$amount_text = '';
							$colors_text_array = explode('€€', $product_definition[4]);
							foreach ( $colors_text_array as $key => $color ) {
								$color_array = explode(':', $color);	// array("ŽLUTÝ","250")
								$amount += intval($color_array[1]);
								$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
							}
							$colors_text = implode(", ",$colors_text_array);
							$motive_text = $product_definition[6] . ' '. __('barev v motivu','nicknack');
							$product_title = __('Sítotisk barevný kelímek','nicknack');
						}
						break;
					
					default:
						break;
				}
			} ?>

			<br><h3 style="<?= $styles['table-heading']; ?>"><?= $volume_text .' '. $product_title .' '. $amount_text . $colors_text; ?></h3>

			<?php if ( ! $amount_limit || $amount < $amount_limit ) :
				
				$has_price_table = true;
				$additional = array(); ?>
				
				<!-- IF < 2000 RESP. 3000 -->
				<?php if ( have_rows($group,$settings_page_id) ) : ?>
					<?php while ( have_rows($group,$settings_page_id) ) : the_row(); ?>
				
						<?php $additional_1_rows = get_sub_field( 'prices_additional_1', $settings_page_id ); ?>
						<?php $additional_2_rows = get_sub_field( 'prices_additional_2', $settings_page_id ); ?>

						<?php if ( have_rows('prices',$settings_page_id) ) : ?>
							<?php while ( have_rows('prices',$settings_page_id) ) : the_row(); ?>

								<?php $row_index = get_row_index(); ?>
					
								<table style="<?= $styles['table']; ?>">
								
									<tr>
										<td style="<?= $styles['td-f']; ?>"><?php the_sub_field('level',$settings_page_id); ?> - <?= $volume_text; ?></td>
										<td style="<?= $styles['td-s']; ?>"><?php the_sub_field($volume,$settings_page_id); ?></td>
									</tr>
				
									<?php if ( $group == 'iml' ) : ?>
										
										<?php if ( ! empty($additional_1_rows[$row_index-1]) ) :
											$row1 = $additional_1_rows[$row_index-1]; ?>
											<tr>
												<td style="<?= $styles['td-f']; ?>"><?= $row1['level']; ?> - <?= $volume_text; ?></td>
												<td style="<?= $styles['td-s']; ?>"><?= $row1[$volume]; ?></td>
											</tr>
										<?php endif; ?>
				
									<?php endif; ?>
				
									<?php if ( $group == 'sitotisk_transparent' || $group == 'sitotisk_color' ) : ?>
										
										<?php if ( ! empty($additional_1_rows[$row_index-1]) ) :
											$row1 = $additional_1_rows[$row_index-1]; ?>
											<tr>
												<td style="<?= $styles['td-f']; ?>"><?= $row1['level']; ?> - <?= $volume_text; ?></td>
												<td style="<?= $styles['td-s']; ?>"><?= $row1[$volume]; ?></td>
											</tr>
										<?php endif; ?>
				
										<?php if ( ! empty($additional_2_rows[$row_index-1]) ) :
											$row2 = $additional_2_rows[$row_index-1]; ?>
											<tr>
												<td style="<?= $styles['td-f']; ?>"><?= $row2['level']; ?> - <?= $volume_text; ?></td>
												<td style="<?= $styles['td-s']; ?>"><?= $row2[$volume]; ?></td>
											</tr>
										<?php endif; ?>
				
									<?php endif; ?>

									<?php if ( $group == 'iml' || $group == 'sitotisk_transparent' || $group == 'sitotisk_color' ) : // empty row if there is a additional row; ?>
										<tr><td style="<?= $styles['td-empty']; ?>">&nbsp;</td><td style="<?= $styles['td-empty']; ?>">&nbsp;</td></tr>
									<?php endif; ?>

								</table>

							<?php endwhile; ?>
						<?php endif; ?>

					<?php endwhile; ?>
				<?php endif; ?>

			<?php else : ?>

				<!-- IF >= 2000 RESP. 3000 -->
				<?php if( have_rows('email-over-limit',$settings_page_id) ) : ?>
				
					<?php while ( have_rows('email-over-limit',$settings_page_id) ) : the_row(); ?>
				
						<?php if ( $group == 'iml' ) : ?>
							<?php the_sub_field('iml'); ?>

						<?php elseif ( $group == 'sitotisk_transparent' || $group == 'sitotisk_color' ) : ?>
							<?php the_sub_field('sitotisk'); ?>

						<?php elseif ( $group = 'bez_potisku_transparent' ) : ?>
							<?php the_sub_field('transparent'); ?>

						<?php elseif ( $group = 'bez_potisku_color' ) : ?>
							<?php the_sub_field('color'); ?>

						<?php elseif ( $group = 'sada' ) : ?>
							<?php the_sub_field('sada'); ?>

						<?php endif; ?>
				
					<?php endwhile; ?>
				
				<?php endif; ?>

			<?php endif; ?>

		<?php endforeach;

		$product_tables = ob_get_clean(); ?>

		<style>a{color:#e2007a!important;text-decoration:underline!important;}div.footer p{margin:0;}</style>

		<div id="email-wrapper" style="margin-left:24px;color:black;">

			<?php the_field('email-everytime-intro',$settings_page_id); ?>

			<?php if( have_rows('email-intro-info',$settings_page_id) ) : ?>
			
				<?php while ( have_rows('email-intro-info',$settings_page_id) ) : the_row(); ?>

					<?php if ( $has_sitotisk ) : ?>
						<!-- IF SITOTISK -->
						<?php the_sub_field('sitotisk',$settings_page_id); ?>
					<?php endif; ?>

					<?php if ( $has_iml ) : ?>
						<!-- IF IML -->
						<?php the_sub_field('iml',$settings_page_id); ?>
					<?php endif; ?>
			
				<?php endwhile; ?>
			
			<?php endif; ?>

			<?php if ( $has_price_table ) : ?>
				<!-- IF SOME PRICES -->
				<?php the_field('email-price-exists',$settings_page_id); ?>
			<?php endif; ?>

			<?= $product_tables; ?>

			<?php if ( $has_price_table ) : ?>
				<!-- IF SOME PRICES -->
				<?php the_field('email-price-info',$settings_page_id); ?>
			<?php endif; ?>

			<?php if( have_rows('email-delivery-info',$settings_page_id) ) : ?>

				<?php while ( have_rows('email-delivery-info',$settings_page_id) ) : the_row(); ?>

					<?php if ( $has_sitotisk ) : ?>
						<!-- IF SITOTISK -->
						<?php the_sub_field('sitotisk'); ?>

					<?php endif; ?>

					<?php if ( $has_iml ) : ?>
						<!-- IF IML -->
						<?php the_sub_field('iml'); ?>

					<?php endif; ?>

					<?php if ( $has_bez_potisku ) : ?>
						<!-- IF BEZ POTISKU -->
						<?php the_sub_field('transparent'); ?>

					<?php endif; ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( $has_iml || $has_sitotisk ) : ?>
				<?php the_field('email-print-info',$settings_page_id); ?>
			<?php endif; ?>

			<?php the_field('email-everytime-info',$settings_page_id); ?>

			<?php if ( $has_price_table ) : ?>
				<!-- IF SOME PRICES -->
				<?php the_field('email-price-accepting',$settings_page_id); ?>
			<?php endif; ?>

			<?php if ( $has_sitotisk || $has_iml ) : ?>
				<!-- IF SITOTISK || IML -->
				<?php the_field('email-print-data',$settings_page_id); ?>
			<?php endif; ?>

			<?php the_field('email-everytime-outro',$settings_page_id); ?>

		</div>

		<div class="footer" style="background:#f1f1f1;color:black;">
			<p style="margin:0;">&nbsp;</p><p style="margin:0;">&nbsp;</p>
			<table style="background:#f1f1f1;width:100%;">
				<tr style="background:#f1f1f1;">
					<td style="width:20px;background:#f1f1f1;">&nbsp;</td>
					<td style="width:calc(100% - 40px);background:#f1f1f1;">
						<div class="footer-content">&nbsp;&nbsp;<?= get_field('email-everytime-footer',$settings_page_id); ?></div>
					</td>
					<td style="width:20px;background:#f1f1f1;">&nbsp;</td>
				</tr>
			</table>
			<p style="margin:0;">&nbsp;</p><p style="margin:0;">&nbsp;</p>
		</div>

	<?php endif; ?>
	
<?php else : ?>

	<?php if ( $product_definition_raw ) :

		// Prepare the value
		$value_raw = $product_definition_raw;
		$value = str_replace( array("[","]"),"",$value_raw);
		$value_array = explode(',',$value);

		// Check which products were selected
		$has_nicknack = strpos($value,"nicknack")!==false ? true : false;
		$has_iml = strpos($value,"iml")!==false ? true : false;
		$has_sitotisk = strpos($value,"sitotisk")!==false ? true : false;
		$has_bez_potisku = strpos($value,"bez-potisku")!==false ? true : false;
		$has_bez_potisku_transparent = strpos($value,"bez-potisku@@univerzalni")!==false ? true : false;
		$has_univerzal = strpos($value,"univerzalni")!==false ? true : false;
		$has_sada = strpos($value,"sada")!==false ? true : false;
		$has_color = strpos($value,"bez-potisku@@barevny")!==false ? true : false;
		preg_match('/nicknack@@(...)@@bez-potisku@@barevny/', $value, $nicknack_bez_potisku_barevny);
		$nicknack_bez_potisku_barevny = ($nicknack_bez_potisku_barevny) ? true : false;
		// $has_transparent = strpos($value,"bez-potisku@@transparentni")>=0 ? true : false;

		// Has hot cup
		$has_hotcup = strpos($value,"hotcup")!==false ? true : false;
		// $has_hotcup_sitotisk = ($has_hotcup && strpos($value,"@@potisk@@")!==false) ? true : false;
		preg_match('/hotcup@@(...)@@potisk@@/', $value, $hotcup_sitotisk);
		$has_hotcup_sitotisk = ($has_hotcup && !empty($hotcup_sitotisk)) ? true : false;
		preg_match('/hotcup@@(...)@@bez-potisku@@/', $value, $hotcup_bez_potisku);
		$has_hotcup_bez_potisku = ($has_hotcup && !empty($hotcup_bez_potisku)) ? true : false;

		$has_price_table = false;

		ob_start();

		foreach ($value_array as $product_definition) :

			// PRODUCT DEFINITION EXAMPLE:
			// nicknack@@0.5@@bez-potisku@@barevny@@-@@ČERVENÝ:150,<br>MODRÝ CYAN BLUE:200@@@@-
			// hotcup@@0.2@@bez-potisku@@zakladni@@-@@BÍLÝ:150@@-@@-
			// hotcup@@0.2@@bez-potisku@@zakladni@@-@@BÉŽOVÝ:150<br>Víčka:<br>ZELENÉ:150@@-@@-

			// Product definition
			$product_definition = str_replace("&quot;","",$product_definition);

			// Product definition heading
			// $product_definition_table_heading = str_replace("@@"," ",$product_definition);
			// $product_definition_table_heading = str_replace("€€",", ",$product_definition_table_heading);
			// $product_definition_table_heading = str_replace("&lt;br&gt;",", ",$product_definition_table_heading);

			$product_definition = explode('@@', $product_definition);

			// 0: product_type
			// 1: volume
			// 2: variant
			// 3: product
			// 4: subproduct
			// 5: colors
			// 6: amount
			// 7: motive

			$product_type = strtoupper( $product_definition[0] );
			$volume = 'v' . str_replace(".","",$product_definition[1]);			// e.g. 0.5 -> v05 (field name in acf)
			$volume_text = str_replace(".",",",$product_definition[1]) . 'l';	// e.g. 0.5 -> 0,5l
			$variant = $product_definition[2];
			$product = $product_definition[3];
			$subproduct = $product_definition[4];

			$group = $product_title = $amount_text = $colors_text = $motive_text = '';
			$amount = $product_definition[6];
			$amount_text = $product_definition[6] . ' ' . __('ks','nicknack');
			$amount_limit = 2000;

			// Has hot cup a cap
			$has_hotcup_cap = strpos($product_definition[5],'Víčka:')!==false ? true : false;

			// NickNack
			if ( $product_type=='NICKNACK' ) {

				// Get the right group name
				if ( $variant == 'bez-potisku' ) {
					switch ($product) {
						case 'sada':
							$group = 'party_sada';
							$amount_limit = false;
							$product_title = __('Párty sada','nicknack');
							break;

						case 'barevny':
							$group = 'bez_potisku_color';
							$amount = 0;
							$amount_text = '';
							$colors_text_array = explode('€€', $product_definition[5]);
							foreach ( $colors_text_array as $key => $color ) {
								$color_array = explode(':', $color);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
								$amount += intval($color_array[1]);
								$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
							}
							$colors_text = implode(", ",$colors_text_array);

							$product_title = __('Barevný bez potisku','nicknack');
							break;

						case 'univerzalni':
							$group = 'bez_potisku_transparent';
							$product_title = __('Transparentní bez potisku','nicknack');
							break;

						default:
							break;
					}

				} else {
					$amount_limit = 3000;

					switch ($product) {
						case 'iml':
							$group = 'iml';
							$motive_text = $product_definition[7] . ' grafických motivů';
							$product_title = __('Fotorealistický potisk (IML)','nicknack');
							break;

						case 'sitotisk':
							if ( $subproduct == 'transparentni-kelimek' ) {
								$group = 'sitotisk_transparent';
								$motive_text = $product_definition[7] . ' '. __('barev v motivu','nicknack');
								$product_title = __('Sítotisk transparentní kelímek','nicknack');
							} elseif ( $subproduct == 'barevny-kelimek' ) {
								$group = 'sitotisk_color';
								$amount = 0;
								$amount_text = '';
								$colors_text_array = explode('€€', $product_definition[5]);
								foreach ( $colors_text_array as $key => $color ) {
									$color_array = explode(':', $color);	// array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
								}
								$colors_text = implode(", ",$colors_text_array);
								$motive_text = $product_definition[7] . ' '. __('barev v motivu','nicknack');
								$product_title = __('Sítotisk barevný kelímek','nicknack');
							}
							break;

						default:
							break;
					}
				}

			// Hotcup
			} else {

				$amount = 0;
				$amount_text = '';

				// Remove all <br>
				$product_definition[5] = str_replace('&lt;br&gt;','',$product_definition[5]);

				// Get the right group name
				if ( $variant == 'bez-potisku' ) {

					switch ($product) {

						case 'zakladni':

							$group = 'hotcup_bez_potisku_basic';

							$colors_text_array = explode('€€', $product_definition[5]);
							$colors_caps_final_amount = 0;

							foreach ( $colors_text_array as $key => $color ) {

								// Is there a cap?
								if ( strpos($color,'Víčka:')!==false ) {
									// $group = 'hotcup_bez_potisku_basic_cap';
									$group = 'hotcup_bez_potisku_basic';
									$color_array_cup_cap = explode('Víčka:', $color);	// ŠEDÝ:150Víčka:ŽLUTÁ:150 -> array("ŠEDÝ:150","ŽLUTÁ:150")

									// Cup color array
									$color_array = explode(':', $color_array_cup_cap[0]);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									// $colors_text_array[$key] = $color_array . ' ' . __('ks','nicknack');

									// Cap color array
									$colors_cap_array = explode('§§',$color_array_cup_cap[1]);
									foreach ( $colors_cap_array as $key => $color_cap ) {
										$color_cap_array = explode(':', $color_cap);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
										$colors_caps_final_amount += intval($color_cap_array[1]);
										$colors_cap_array[ $key ] = $color_cap . ' ' . __('ks','nicknack');
									}
									$colors_cap_text = implode( ', ', $colors_cap_array);

									$colors_text_array[$key] = $color_array_cup_cap[0] . ' ' . __('ks','nicknack') .', Víčka: '.$colors_cap_text;

								} else {
									$color_array = explode(':', $color);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
								}
							}
							$colors_text = implode(", ",$colors_text_array);

							$product_title = __('Základní bez potisku','nicknack');
							break;

						case 'barevny':

							$group = 'hotcup_bez_potisku_color';

							$colors_text_array = explode('€€', $product_definition[5]);
							$colors_caps_final_amount = 0;

							foreach ( $colors_text_array as $key => $color ) {

								// Is there a cap?
								if ( strpos($color,'Víčka:')!==false ) {
									// $group = 'hotcup_bez_potisku_color_cap';
									$group = 'hotcup_bez_potisku_color';
									$color_array_cup_cap = explode('Víčka:', $color);	// ŠEDÝ:150Víčka:ŽLUTÁ:150 -> array("ŠEDÝ:150","ŽLUTÁ:150")

									// Cup color array
									$color_array = explode(':', $color_array_cup_cap[0]);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									// $colors_text_array[$key] = $color_array . ' ' . __('ks','nicknack');

									// Cap color array
									$colors_cap_array = explode('§§',$color_array_cup_cap[1]);
									foreach ( $colors_cap_array as $key => $color_cap ) {
										$color_cap_array = explode(':', $color_cap);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
										$colors_caps_final_amount += intval($color_cap_array[1]);
										$colors_cap_array[ $key ] = $color_cap . ' ' . __('ks','nicknack');
									}
									$colors_cap_text = implode( ', ', $colors_cap_array);

									// $colors_text_array[$key] = $color_array_cup_cap[0] . ' ' . __('ks','nicknack') .', Víčka: '.$color_array_cup_cap[1] . ' ' . __('ks','nicknack');
									$colors_text_array[$key] = $color_array_cup_cap[0] . ' ' . __('ks','nicknack') .', Víčka: '.$colors_cap_text;

								} else {
									$color_array = explode(':', $color);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
								}

								// $color_array = explode(':', $color);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
								// $amount += intval($color_array[1]);
								// $colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
							}
							$colors_text = implode(", ",$colors_text_array);

							$product_title = __('Barevný bez potisku','nicknack');
							break;

						default:
							break;
					}

				} else {

					switch ($product) {

						case 'zakladni':

							$group = 'hotcup_sitotisk_basic';

							$motive_text = $product_definition[7] . ' '. __('barev v motivu','nicknack');

							$colors_text_array = explode('€€', $product_definition[5]);
							$colors_caps_final_amount = 0;

							foreach ( $colors_text_array as $key => $color ) {

								// Is there a cap?
								if ( strpos($color,'Víčka:')!==false ) {
									// $group = 'hotcup_sitotisk_basic_cap';
									$group = 'hotcup_sitotisk_basic';
									$color_array_cup_cap = explode('Víčka:', $color);	// ŠEDÝ:150Víčka:ŽLUTÁ:150 -> array("ŠEDÝ:150","ŽLUTÁ:150")

									// Cup color array
									$color_array = explode(':', $color_array_cup_cap[0]);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									// $colors_text_array[$key] = $color_array . ' ' . __('ks','nicknack');

									// Cap color array
									$colors_cap_array = explode('§§',$color_array_cup_cap[1]);
									foreach ( $colors_cap_array as $key => $color_cap ) {
										$color_cap_array = explode(':', $color_cap);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
										$colors_caps_final_amount += intval($color_cap_array[1]);
										$colors_cap_array[ $key ] = $color_cap . ' ' . __('ks','nicknack');
									}
									$colors_cap_text = implode( ', ', $colors_cap_array);

									$colors_text_array[$key] = $color_array_cup_cap[0] . ' ' . __('ks','nicknack') .', Víčka: '.$colors_cap_text;

								} else {
									$color_array = explode(':', $color);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
								}
							}
							$colors_text = implode(", ",$colors_text_array);

							$product_title = __('Základní s potiskem','nicknack');
							break;

						case 'barevny':

							$group = 'hotcup_sitotisk_color';

							$colors_text_array = explode('€€', $product_definition[5]);
							$colors_caps_final_amount = 0;

							foreach ( $colors_text_array as $key => $color ) {

								// Is there a cap?
								if ( strpos($color,'Víčka:')!==false ) {
									// $group = 'hotcup_sitotisk_color_cap';
									$group = 'hotcup_sitotisk_color';
									$color_array_cup_cap = explode('Víčka:', $color);	// ŠEDÝ:150Víčka:ŽLUTÁ:150 -> array("ŠEDÝ:150","ŽLUTÁ:150")

									// Cup color array
									$color_array = explode(':', $color_array_cup_cap[0]);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									// $colors_text_array[$key] = $color_array . ' ' . __('ks','nicknack');

									// Cap color array
									$colors_cap_array = explode('§§',$color_array_cup_cap[1]);
									foreach ( $colors_cap_array as $key => $color_cap ) {
										$color_cap_array = explode(':', $color_cap);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
										$colors_caps_final_amount += intval($color_cap_array[1]);
										$colors_cap_array[ $key ] = $color_cap . ' ' . __('ks','nicknack');
									}
									$colors_cap_text = implode( ', ', $colors_cap_array);

									$colors_text_array[$key] = $color_array_cup_cap[0] . ' ' . __('ks','nicknack') .', Víčka: '.$colors_cap_text;

								} else {
									$color_array = explode(':', $color);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
									$amount += intval($color_array[1]);
									$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
								}

								// $color_array = explode(':', $color);	// ŽLUTÝ:250 -> array("ŽLUTÝ","250")
								// $amount += intval($color_array[1]);
								// $colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
							}
							$colors_text = implode(", ",$colors_text_array);

							$product_title = __('Barevný s potiskem','nicknack');
							break;

						default:
							break;
					}
				}


				/*$motive_text = $product_definition[7] . ' '. __('barev v motivu','nicknack');
				$amount = 0;
				$amount_text = $colors_cap_text = '';
				$colors_all = str_replace( array("<br>","&lt;br&gt;"), "", $product_definition[5] );
				$colors_all_array = explode( 'Víčka:', $colors_all );

				// Cup colors
				$colors_text_array = explode('€€', $colors_all_array[0]);
				foreach ( $colors_text_array as $key => $color ) {
					$color_array = explode(':', $color);	// array("ŽLUTÝ","250")
					$amount += intval($color_array[1]);
					$colors_text_array[$key] = $color . ' ' . __('ks','nicknack');
				}
				$colors_text = implode(", ",$colors_text_array);

				if ( !empty($colors_all_array[1]) ) {
					// Cap colors
					$colors_cap_text_array = explode('€€', $colors_all_array[1]);
					foreach ( $colors_cap_text_array as $key => $color ) {
						$color_cap_array = explode(':', $color);	// array("ŽLUTÝ","250")
						// $amount += intval($color_array[1]);
						$colors_cap_text_array[$key] = $color . ' ' . __('ks','nicknack');
					}
					$colors_cap_text = implode(", ",$colors_cap_text_array);
				}

				if ( $colors_cap_text ) {
					$colors_text .= '; VÍČKA: '. $colors_cap_text;
				}*/
			} ?>

			<br><h3 style="<?= $styles['table-heading']; ?>"><?= $product_type .' '. $volume_text .' '. $product_title .' '. $amount_text . $colors_text; ?></h3>

			<?php if ( ! $amount_limit || $amount < $amount_limit ) :

				$has_price_table = true;
				$additional = array(); ?>

				<!-- IF < 2000 RESP. 3000 -->
				<?php if ( have_rows($group,$settings_page_id) ) : ?>
					<?php while ( have_rows($group,$settings_page_id) ) : the_row(); ?>

						<?php $additional_1_rows = get_sub_field( 'prices_additional_1', $settings_page_id ); ?>
						<?php $additional_2_rows = get_sub_field( 'prices_additional_2', $settings_page_id ); ?>

						<?php // Level name specification
						$level_name_specification = get_field( $group.'_titles_'.$volume, $settings_page_id );

						// Or just volume
						if ( !$level_name_specification ) {
							$level_name_specification = '- '.$volume_text;
						} ?>

						<?php if ( have_rows('prices',$settings_page_id) ) : ?>
							<?php while ( have_rows('prices',$settings_page_id) ) : the_row(); ?>

								<?php $row_index = get_row_index(); ?>
					
								<table style="<?= $styles['table']; ?>">

									<tr>
										<td style="<?= $styles['td-f']; ?>"><?= get_sub_field('level',$settings_page_id) .' '. $level_name_specification; ?></td>
										<td style="<?= $styles['td-s']; ?>"><?php the_sub_field($volume,$settings_page_id); ?></td>
									</tr>

									<?php if ( $group == 'iml' ) : ?>

										<?php if ( ! empty($additional_1_rows[$row_index-1]) ) :
											$row1 = $additional_1_rows[$row_index-1]; ?>
											<tr>
												<td style="<?= $styles['td-f']; ?>"><?= $row1['level']; ?> - <?= $volume_text; ?></td>
												<td style="<?= $styles['td-s']; ?>"><?= $row1[$volume]; ?></td>
											</tr>
										<?php endif; ?>

									<?php endif; ?>

									<?php if ( $group == 'sitotisk_transparent' || $group == 'sitotisk_color' || $group == 'hotcup_sitotisk_basic' || $group == 'hotcup_sitotisk_basic_cap' || $group == 'hotcup_sitotisk_color' || $group == 'hotcup_sitotisk_color_cap' ) : ?>

										<?php if ( ! empty($additional_1_rows[$row_index-1]) ) :
											$row1 = $additional_1_rows[$row_index-1]; ?>
											<tr>
												<td style="<?= $styles['td-f']; ?>"><?= $row1['level']; ?> - <?= $volume_text; ?></td>
												<td style="<?= $styles['td-s']; ?>"><?= $row1[$volume]; ?></td>
											</tr>
										<?php endif; ?>

										<?php if ( ! empty($additional_2_rows[$row_index-1]) ) :
											$row2 = $additional_2_rows[$row_index-1]; ?>
											<tr>
												<td style="<?= $styles['td-f']; ?>"><?= $row2['level']; ?> - <?= $volume_text; ?></td>
												<td style="<?= $styles['td-s']; ?>"><?= $row2[$volume]; ?></td>
											</tr>
										<?php endif; ?>

									<?php endif; ?>

									<?php if ( $group == 'iml' || $group == 'sitotisk_transparent' || $group == 'sitotisk_color' || $group == 'hotcup_sitotisk_basic' || $group == 'hotcup_sitotisk_basic_cap' || $group == 'hotcup_sitotisk_color' || $group == 'hotcup_sitotisk_color_cap' ) : // empty row if there is a additional row; ?>
										<tr><td style="<?= $styles['td-empty']; ?>">&nbsp;</td><td style="<?= $styles['td-empty']; ?>">&nbsp;</td></tr>
									<?php endif; ?>

								</table>

							<?php endwhile; ?>
						<?php endif; ?>

						<?php if ( $has_hotcup_cap ) : ?>

							<table style="<?= $styles['table']; ?>">
								<tr><td style="<?= $styles['td-empty']; ?>">&nbsp;</td><td style="<?= $styles['td-empty']; ?>">&nbsp;</td></tr>
								<tr>
									<td style="border-top:1px solid black;<?= $styles['td-f']; ?>"><?= get_field('hotcup_cap_title',$settings_page_id) .' '. $colors_caps_final_amount . ' ' . __('ks','nicknack'); ?></td>
									<td style="border-top:1px solid black;<?= $styles['td-s']; ?>"><?php the_field('hotcup_cap_'.$volume,$settings_page_id); ?></td>
								</tr>
							</table>

						<?php endif; ?>

					<?php endwhile; ?>
				<?php endif; ?>

			<?php else : ?>

				<!-- IF >= 2000 RESP. 3000 -->
				<?php if( have_rows('email-over-limit',$settings_page_id) ) : ?>

					<?php while ( have_rows('email-over-limit',$settings_page_id) ) : the_row(); ?>
				
						<?php if ( $group == 'iml' ) : ?>
							<?php the_sub_field('iml'); ?>

						<?php elseif ( $group == 'sitotisk_transparent' || $group == 'sitotisk_color' ) : ?>
							<?php the_sub_field('sitotisk'); ?>

						<?php elseif ( $group == 'bez_potisku_transparent' ) : ?>
							<?php the_sub_field('transparent'); ?>

						<?php elseif ( $group == 'bez_potisku_color' ) : ?>
							<?php the_sub_field('color'); ?>

						<?php elseif ( $group == 'sada' ) : ?>
							<?php the_sub_field('sada'); ?>

						<?php elseif ( $group == 'hotcup_bez_potisku_basic' || $group == 'hotcup_bez_potisku_basic_cap' || $group == 'hotcup_bez_potisku_color' || $group == 'hotcup_bez_potisku_color_cap' || $group == 'hotcup_sitotisk_basic' || $group == 'hotcup_sitotisk_basic_cap' || $group == 'hotcup_sitotisk_color' || $group == 'hotcup_sitotisk_color_cap' ) : ?>
							<?php the_sub_field('hotcup'); ?>

						<?php endif; ?>

					<?php endwhile; ?>

				<?php endif; ?>

			<?php endif; ?>

		<?php endforeach;

		$product_tables = ob_get_clean(); ?>

		<style>a{color:#e2007a!important;text-decoration:underline!important;}div.footer p{margin:0;}</style>

		<div id="email-wrapper" style="margin-left:24px;color:black;">

			<?php the_field('email-everytime-intro',$settings_page_id); ?>

			<?php if( have_rows('email-intro-info',$settings_page_id) ) : ?>

				<?php while ( have_rows('email-intro-info',$settings_page_id) ) : the_row(); ?>

					<?php if ( $has_sitotisk ) : ?>
						<!-- IF SITOTISK -->
						<?php the_sub_field('sitotisk',$settings_page_id); ?>
					<?php endif; ?>

					<?php if ( $has_iml ) : ?>
						<!-- IF IML -->
						<?php the_sub_field('iml',$settings_page_id); ?>
					<?php endif; ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( $has_price_table ) : ?>
				<!-- IF SOME PRICES -->
				<?php the_field('email-price-exists',$settings_page_id); ?>
			<?php endif; ?>

			<?= $product_tables; ?>

			<?php if ( $has_price_table ) : ?>
				<!-- IF SOME PRICES -->
				<?php the_field('email-price-info',$settings_page_id); ?>
			<?php endif; ?>

			<?php if( have_rows('email-delivery-info',$settings_page_id) ) : ?>

				<?php while ( have_rows('email-delivery-info',$settings_page_id) ) : the_row(); ?>

					<?php if ( $has_sitotisk ) : ?>
						<!-- IF SITOTISK -->
						<?php the_sub_field('sitotisk'); ?>

					<?php endif; ?>

					<?php if ( $has_iml ) : ?>
						<!-- IF IML -->
						<?php the_sub_field('iml'); ?>

					<?php endif; ?>

					<?php if ( $nicknack_bez_potisku_barevny ) : ?>
						<!-- IF COLOR -->
						<?php the_sub_field('color'); ?>

					<?php endif; ?>

					<?php if ( $has_sada ) : ?>
						<!-- IF SADA -->
						<?php the_sub_field('sada'); ?>

					<?php endif; ?>

					<?php if ( $has_bez_potisku_transparent ) : ?>
						<!-- IF BEZ POTISKU TRANSPARENT -->
						<?php the_sub_field('transparent'); ?>

					<?php endif; ?>

					<?php if ( $has_hotcup_sitotisk ) : ?>
						<!-- IF BEZ POTISKU -->
						<?php the_sub_field('hotcup_sitotisk'); ?>

					<?php endif; ?>

					<?php if ( $has_hotcup_bez_potisku ) : ?>
						<!-- IF BEZ POTISKU -->
						<?php the_sub_field('hotcup_bez_potisku'); ?>

					<?php endif; ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( $has_iml || $has_sitotisk || $has_hotcup_sitotisk ) : ?>
				<?php the_field('email-print-info',$settings_page_id); ?>
			<?php endif; ?>

			<?php the_field('email-everytime-info',$settings_page_id); ?>

			<?php if ( $has_price_table ) : ?>
				<!-- IF SOME PRICES -->
				<?php the_field('email-price-accepting',$settings_page_id); ?>
			<?php endif; ?>

			<?php if ( $has_sitotisk || $has_iml || $has_hotcup_sitotisk ) : ?>
				<!-- IF SITOTISK || IML -->
				<?php the_field('email-print-data',$settings_page_id); ?>
			<?php endif; ?>

			<?php the_field('email-everytime-outro',$settings_page_id); ?>

		</div>

		<div class="footer" style="background:#f1f1f1;color:black;">
			<p style="margin:0;">&nbsp;</p><p style="margin:0;">&nbsp;</p>
			<table style="background:#f1f1f1;width:100%;">
				<tr style="background:#f1f1f1;">
					<td style="width:20px;background:#f1f1f1;">&nbsp;</td>
					<td style="width:calc(100% - 40px);background:#f1f1f1;">
						<div class="footer-content">&nbsp;&nbsp;<?= get_field('email-everytime-footer',$settings_page_id); ?></div>
					</td>
					<td style="width:20px;background:#f1f1f1;">&nbsp;</td>
				</tr>
			</table>
			<p style="margin:0;">&nbsp;</p><p style="margin:0;">&nbsp;</p>
		</div>

	<?php endif; ?>

<?php endif; ?>