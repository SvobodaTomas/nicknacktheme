<?php if ( $button = get_field('section_button') ) : ?>
	<footer class="clear columns">
		<a
			href="<?= $button['url']; ?>"
			class="button"
			<?= ($button['target']) ? ' target="'.$button['target'].'"' : ''; ?>
		>
			<?= $button['title']; ?>
		</a>
	</footer>
<?php endif; ?>