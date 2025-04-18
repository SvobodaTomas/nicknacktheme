<?php

// Most email clients do not support <style> blocks. We'll define our styles here and output them inline in the markup below.
$styles = array(
	'ul'         => 'border-top: 1px solid #eee;margin:0;padding:0;',
	'li'         => 'border-bottom: 1px solid #eee; padding: 10px 10px 15px; margin: 0; list-style-type: none; overflow: hidden;',
	'span'       => 'vertical-align: top; display: block; margin-left:30%;',
	'span.label' => 'float: left; vertical-align: top; font-weight: bold; width: 30%;'
);

// Make a back-up of the styles we've just defined. This allows us to make temporary changes to the styles below and then
// reset the styles for the next item.
$reset_styles = $styles;
?>

<strong><?= __('NOVÁ POPTÁVKA - ID záznamu','nicknack'); ?>: <?= $entry['id']; ?></strong><br>
<div>
	<i><?= __('Jméno/firma','nicknack'); ?>:</i> {:3}<br>
	<i><?= __('Email','nicknack'); ?>:</i> {:11}<br>
	<i><?= __('Telefon','nicknack'); ?>:</i> {:5}<br>
	<i><?= __('Zpráva','nicknack'); ?>:</i> {:6}<br>
	<i><?= __('Soubory','nicknack'); ?>:</i>
	{:12}<br>
</div>
<br>

<p><?= __('Poptávané produkty','nicknack'); ?>:</p><br>
<table>
	<tr><th><?= __('Produkt','nicknack'); ?></th><th><?= __('Objem','nicknack'); ?></th><th><?= __('Varianta','nicknack'); ?></th><th><?= __('Produkt','nicknack'); ?></th><th><?= __('Podprodukt','nicknack'); ?></th><th><?= __('Barva','nicknack'); ?></th><th><?= __('Počet kusů','nicknack'); ?></th><th><?= __('Počet barev/motivů','nicknack'); ?></th></tr>
	<?php foreach( $items as $item ):

		if ( $item['field']->id==8 ) {
			$value_raw = $item['value'];
			$value = str_replace("[","",$value_raw);
			$value = str_replace("]","",$value);
			$value_array = explode(',',$value);
			foreach ($value_array as $product_definition) {
				$product_definition = str_replace("&quot;","",$product_definition);
				$product_definition = str_replace("€€","; ",$product_definition);
				$product_definition = str_replace("§§","; ",$product_definition);
				// $product_definition = str_replace("<br>","\n",$product_definition);
				$product_definition = str_replace("&lt;br&gt;","<br>",$product_definition);
				$product_definition = str_replace("@@","</td><td>",$product_definition);
				echo '<tr><td>' . $product_definition . '</td></tr>';
			}
		}

		// Reset any temporary changes we made to our core styles.
		$styles = $reset_styles;
	endforeach; ?>
</table>