<?php

try {
  $pagesArray = $page->getLatestPages($amt);

  if (!is_array($pagesArray)) {
    throw new Exception("Could not get latest pages from the database");
    
  }

} catch (Exception $e) {
    echo $e->getMessage();
}

?>
<!--==========================
  Blog posts Section
============================-->
<section id="blog">
  <div class="container wow fadeIn">

    <div class="section-header">
      <h3 class="section-title">Our Blog</h3>
      <p class="section-description">Get the latest information on the latest web technologies, and projects here.</p>
    </div>

    <div class="row">

      <?php
      for ($i=0; $i < count($pagesArray); $i++) { 
      ?>

      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
        <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo $page->getAllPages()[$pagesArray[$i]]->title ?></h3>
        </div>
        <div class="panel-body">
          
          <a href="#"><img src="img/blog/blog-post-<?php echo($i + 1)?>.jpg" class="img-blog" alt="img"></a>
          
          <p>
          <?php
            echo $page->getIntro(150, $pagesArray[$i]);
          ?>
          </p>
        </div>
        <div class="panel-footer">
          <?php

          $author = clone $user;

          $id = $page->getAllPages()[$pagesArray[$i]]->creatorId;

          $authorData = $author->find($id);

          if ($authorData == false) {
            Redirect:to(409);
          }

          $authorName = $author->data()->username;

          $datePosted = $page->getAllPages()[$pagesArray[$i]]->dateAdded;

          $pageId = $page->getAllPages()[$pagesArray[$i]]->id;

          $datePosted = strtotime($datePosted);

          $datePosted = date("F d, Y", $datePosted);

          ?>
          <p><small>Posted by <?php echo $authorName; ?> on <?php echo $datePosted; ?><br><a href="page.php?id=<?php echo($pageId)?>">Read more...</a></small>
            </p>
        </div>
      </div>
      </div>

      <?php
      }

      unset($page);

      ?>

  </div>
</section><!-- #services -->