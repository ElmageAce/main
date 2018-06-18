<!--banner img-->
<div class="container-fluid" id="blog-post">

    <div class="post-heading">
        <h1><?php echo $pageData->title; ?></h1>
        <h2 class="subheading"><?php echo $pageData->subtitle; ?></h2>
        <span class="meta">Posted by <a href="#"><?php echo $authorName; ?></a>, on <?php echo $datePosted; ?></span>
    </div>

</div>

<!-- Post Content -->
<article>
    <div class="container">

        <?php

        echo $pageData->content;

        ?>
        
    </div>
</article>