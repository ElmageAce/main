        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Comments <small>Moderate Comments</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-comment"></i> Comments
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <?php

                if (!empty($errorMsg)) {
                    echo $errorMsg;
                }

                ?>
                <!--Row-->
                <div class="row">

                    <div class="col-lg-12">
                        
                        <p class="filter-link"><a href="comments.php">All</a> (<?php echo $postCountAll; ?>) | <a href="comments.php?pending=1">Pending</a> (<?php echo $page->getAllComments('pending')[0]; ?>) | <a href="comments.php?approved=1">Approved</a> (<?php echo $page->getAllComments('approved')[0]; ?>) | <a href="comments.php?spam=1">Spam</a>  (<?php echo $page->getAllComments('spam')[0]; ?>) | <a href="comments.php?trash=1">Trash</a>  (<?php echo $page->getAllComments('trash')[0]; ?>)
                        <!--Form-->
                        <form class="form-inline" role="form" method="get">
                        <?php

                        if ($user->canAddPost()) {

                        ?>
                            <div class="form-group">
                                <select class="form-control" id="post-action" name="action">
                                    <option>Bulk Action</option>
                                    <?php if($user->canEditPost()) { ?><option value="approve">Approve</option><?php } ?>
                                    <option value="isSpam">Mark as Spam</option>
                                    <?php if($user->canEditPost()) { ?><option value="isTrash">Move to Trash</option><?php } ?>
                                    <?php if($user->isAdmin()) { ?><option value="delete">Delete</option><?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default applybtn" name="apply">Apply</button>

                        <?php

                        }

                        ?>

                            <div class="table-responsive post-table">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                            <?php
                                                if($user->canAddPost()) {
                                            ?>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" value=""></label>
                                                </div>
                                            <?php
                                                }
                                            ?>
                                                Author
                                            </th>
                                            <th>Comment</th>
                                            <th>Response To</th>
                                            <th>Date Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        for ($i=($postCount - 1); $i >= 0; $i--) {

                                            if ($postCount === 0) {
                                                 break;
                                             }

                                             $id = $allComments[$i]->id;

                                            $authorName = $allComments[$i]->name;

                                            $msg = $allComments[$i]->comment;

                                            $replyTo = (int) $allComments[$i]->pageId;

                                            $dateSubmitted = $allComments[$i]->dateAdded;

                                            $email = $allComments[$i]->email;
                                        ?>
                                            <tr<?php if($i % 2 === 0) {echo " class=\"active\"";}?>>

                                                <td>
                                                    <?php
                                                        if($user->canAddPost()) {
                                                    ?>
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" name="modComment[]" value="<?php echo $id; ?>"></label>
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                                    <?php echo $authorName; ?>
                                                    <br><br>
                                                    <a href="#"><?php echo $email; ?></a>
                                                </td>
                                                <td class="comment-msg"><?php echo $msg; ?></td>
                                                <td class="comment-post"><a href="<?php echo 'page.php?id=' . $replyTo; ?>"><?php echo $page->getPost($replyTo)->title; ?></a></td>
                                                <td><?php echo $page->formatDate($dateSubmitted, true); ?></td>
                                            </tr>
                                        <?php
                                            //for end
                                            if ($i == ($postCount - $limit)) {
                                                
                                                break;

                                            }
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