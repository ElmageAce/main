<!--banner img-->
<div class="container-fluid" id="blog-post">

    <div class="post-heading">
        <h1 class="main">Trending News</h1>
    </div>

</div>

<!--Content-->
<div class="container" id="blog-post-container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

		<?php
			try {
			
				$page = new Page();

				$postCount = $page->getPostCount();

				if (!empty(Input::get('page'))) {
			
					$currentPage = (int) Input::get('page');

					$iteration = $limit * ($currentPage - 1);

					$postCount = ($postCount == 0) ? $page->getPostCount() - $iteration : $postCount - $iteration;

				}

				if (is_null($postCount)) {

					throw new Exception("Error getting posts from database");
					
				}

				$latestPost = $postCount - 1;

				$pages = $page->getAllPages();

				for ($i=$latestPost; $i >= 0; $i--) {

				$author = clone $user;

				$author->find($pages[$i]->creatorId); 

				?>

				<div class="post-preview">
		            <a href="page.php?id=<?php echo $pages[$i]->id; ?>">
		                <h2 class="post-title">
		                    <?php echo $pages[$i]->title; ?>
		                </h2>
		                <h3 class="post-subtitle">
		                    <?php echo $pages[$i]->subtitle; ?>
		                </h3>
		            </a>
		            <p class="post-meta">Posted by <a href="#"><?php echo $author->data()->username; ?></a> on <?php echo date("F d, Y", strtotime($pages[$i]->dateAdded)); ?></p>
		        </div>
		        <hr>

		    <?php
		    	unset($author);

		    	if ($i == ($postCount - $limit)) {
                                                
                    break;

                }

				}

		    ?>

		</div>
	</div>

	<!-- Pager -->
	<?php

	if (($postCount - $limit) > 0) {
	?>
	    <ul class="pager pull-right home-pager">
	        <li class="next">
	            <a href="blog.php?page=<?php echo ($currentPage + 1);?>">Older Posts &rarr;</a>
	        </li>
	    </ul>
    <?php
	}

	?>
	<?php

	if ($currentPage > 1) {
	?>
	    <ul class="pager pull-left home-pager">
	        <li class="previous">
	            <a href="blog.php?page=<?php echo ($currentPage - 1);?>">&larr; Newer Posts</a>
	        </li>
	    </ul>
    <?php
	}

	?>
    <?php


	} catch (Exception $e) {

		echo $e->getMessage();

	}

    ?>
</div>
<hr class="last">