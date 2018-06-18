<article>
	<div class="container" id="comment">
		<h4>Comments</h4>
	<?php

	$comments = $page->getPageComments();

	$cnt = count($comments);

	if ($cnt === 0) {
		echo "<p>No comment has been added. Be the first to comment!</p>";
	}

	for ($i= ($cnt - 1); $i >= 0 ; $i--) { 

	?>
		<div class="row" id="comment-<?php echo $comments[$i]->id; ?>">
			<div class="col-lg-1 user-avatar"><i class="fa fa-fw fa-user"></i></div>
			<div class="col-lg-10">
				<span class="commentPost post-info"><?php echo $comments[$i]->name; ?>
					<br>
					<small><?php echo $page->formatDate($comments[$i]->dateAdded, 'time'); ?></small>
				</span>
				<p class="commentPost main-post"><?php echo $comments[$i]->comment; ?><br><span class="edit-post"><i class="fa fa-fw fa-reply"></i><a href="#" class="edit-post"> Reply</a></span></p>
			</div>
		<?php
			if($user->isLoggedIn() && $user->canEditPost()) {
		?>
			<div class="col-lg-1 admin-options"><a href="#" class="edit-post">Edit</a></div>
		<?php
			}
		?>
		</div>
		<hr>
	<?php
	}

	?>
	</div>
</article>