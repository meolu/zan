<hr />
<?php foreach ($comments as $comment) { ?>
	<blockquote>
	<p><em><?= $comment['name'] ?></em><?= $comment['comment'] ?></p>
	</blockquote>
<?php } ?>