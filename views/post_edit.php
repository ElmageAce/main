        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Posts <small>Published Posts</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-pencil"></i> Posts
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <?php if(!empty($errorMsg)) echo $errorMsg; 

                if ($user->canAddPost()) {

                ?>
                    <!--New row-->
                    <div class="row">
                        <div class="col-lg-12">

                        <?php
                        if ($user->canEditPost()) {
                        ?>

                            <a href="edit.php?modCategory=true" class="btn btn-default pull-right new-cat">New Category</a>

                        <?php
                        }

                        ?>
                            <a href="new_post.php" class="btn btn-info pull-right new-post">New Post</a>
                            
                        </div>
                    </div>
                <?php

                }

                ?>

                <!--Row-->
                <div class="row">

                    <div class="col-lg-12">
                        
                        <p class="filter-link"><a href="edit.php">All</a> (<?php echo $page->getPostCount(); ?>) | <a href="edit.php?author=<?php echo $user->data()->id; ?>">My Posts</a> (<?php echo $page->getPostCount(array('author', $user->data()->id), 'all'); ?>) | <a href="edit.php?isPublished=true">Published</a> (<?php echo $page->getPostCount(array('isPublished', true), 'all'); ?>) | <a href="edit.php?isPublished=false">Draft</a>  (<?php echo $page->getPostCount(array('isPublished', false), 'all'); ?>)</p>
                        <!--Form-->
                        <form class="form-inline" role="form" method="get" action="">
                        <?php
                        if ($user->canEditPost()) {
                         
                        ?>
                            <div class="form-group">
                                <select class="form-control" id="post-action" name="actions">
                                    <option>Bulk Action</option>
                                    <option value="edit">Edit</option>
                                    <option value="trash">Trash</option>
                            <?php if($user->isAdmin()) { ?> <option value="delete">Delete</option> <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default applybtn" name="apply" value="post">Apply</button>
                        <?php

                        }
                        ?>

                            <div class="form-group">
                                <select class="form-control" id="filter-date" name="dateFilter">
                                    <option>All Dates</option>
                                    <option value="May 2018">May 2018</option>
                                    <option value="June 2018">June 2018</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" id="filter-category" name="cat">
                                    <option value="0">All Categories</option>
                                <?php

                                $allCategories = $page->getAllCategories();

                                $cnt = count($allCategories);

                                for ($i=0; $i < $cnt; $i++) { 
                              
                                ?>
                                    <option value="<?php echo $allCategories[$i]->id; ?>"><?php echo $allCategories[$i]->category_name; ?></option>
                                <?php
                                }   

                                ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default" name="filter" value="true">Filter</button>

                            <div class="table-responsive post-table">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                <?php

                                                if($user->canEditPost()) {

                                                ?>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value=""></label>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                
                                                Title
                                            </th>
                                            <th>Review Status</th>
                                            <th>Post Rating</th>
                                            <th>Author</th>
                                            <th>Categories</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        for ($i=($postCount - 1); $i >= 0; $i--) { 

                                            $postTitle = $allPosts[$i]->title;

                                            $postCat = (int) $allPosts[$i]->post_category;

                                            $postPublisher = $allPosts[$i]->creatorId;

                                            $isReviewed = ($allPosts[$i]->isReviewed == true) ? 'Reviewed' : 'Pending';

                                            $postRating = ($isReviewed === 'Reviewed') ? $allPosts[$i]->rating . ' star!' : 'Unrated'; 

                                            $authorData = $user->getAuthor($postPublisher);

                                            $authorName = (strlen($authorData->publish_name) === 0)? $authorData->username : $authorData->publish_name;
                                            
                                            $postDate = ($allPosts[$i]->isPublished == true)? $allPosts[$i]->dateAdded : $allPosts[$i]->dateUpdated;

                                            $postType = ($allPosts[$i]->isPublished == true)? 'Published ' : 'Last Modified ';

                                            $formattedDate = $page->formatDate($postDate);
                                        ?>
                                            <tr<?php if($i % 2 === 0) {echo " class=\"active\"";}?>>

                                                <td>
                                                <?php

                                                if($user->canEditPost()) {

                                                ?>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="chkbox[]" value="<?php echo $allPosts[$i]->id; ?>"></label>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                    <a href="page.php?id=<?php echo $allPosts[$i]->id; ?>"><?php echo $postTitle; ?> </a> 
                                                </td>
                                                <td><?php echo $isReviewed; ?></td>
                                                <td><?php echo $postRating; ?></td>
                                                <td><?php echo $authorName; ?></td>
                                                <td><?php echo ($postCat > 0)? $page->getCategoryName($postCat) : 'Uncategorized'; ?></td>
                                                <td><?php echo $postType . '<br>' . $formattedDate; ?></td>
                                            </tr>
                                        <?php
                                            if ($i == ($postCount - $limit)) {
                                                
                                                break;

                                            }
                                            //for end
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <!--- End form -->

                    </div>

                </div>
                <!--End row-->

                <div class="row">
                    <div class="col-lg-12">
                        <ul class="pager">
                            <?php
                                if ($currentPage > 1) {
                            ?>
                                    <li class="previous"><a href="<?php echo (Input::exists('get')) ? $_SERVER["REQUEST_URI"] . "&page=" . ($currentPage - 1) : $_SERVER["REQUEST_URI"] . "?page=" . ($currentPage - 1);?>">Previous</a></li>
                            <?php
                                }
                            ?>
                            <?php
                                if (($postCount - $limit) > 0) {
                            ?>
                                    <li class="next"><a href="<?php echo (Input::exists('get')) ? $_SERVER["REQUEST_URI"] . "&page=" . ($currentPage + 1) : $_SERVER["REQUEST_URI"] . "?page=" . ($currentPage + 1);?>">Next</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
