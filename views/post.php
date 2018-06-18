        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Posts <small>Post Editor</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-pencil"></i> Posts
                            </li>
                            <li class="active">
                                <i class="fa fa-pencil"></i> Add / Edit Post
                            </li>
                        </ol>
                    </div>
                </div>
                <?php

                if (!empty($errorMsg)) {
                    echo $errorMsg;
                }

                ?>

                <!--form-->
                <form method="post" role="form" action="">

                    <div class="row">
                        <div class="col-lg-12">
                            <h1><?php echo (empty(Input::get('editPost'))) ? 'Add New Post' : 'Edit Post'; ?></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control" id="title" value="<?php echo (empty($pageData)) ? '' : $pageData->title; ?>" placeholder="Enter Blog Title">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="subtitle" class="form-control" id="subtitle" value="<?php echo (empty($pageData)) ? '' : $pageData->subtitle; ?>" placeholder="Enter Blog Subtitle">
                                </div>
                                
                                <textarea id="mytextarea" name="mytextarea"><?php echo (empty($pageData)) ? '' : $pageData->content; ?></textarea>
                        </div>
                        <div class="col-lg-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>Publish</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <input type="submit" name="saveDraft" class="btn btn-default" value="Save Draft">
                                    </div>
                                    <select class="form-control" name="publishOption">
                                        <option>Post Status</option>
                                        <option value="draft">Draft</option>
                                        <option value="reviewPending">Pending Review</option>
                                    </select>
                                </div>
                                <div class="panel-footer">
                                    <input type="submit" name="publish" class="btn btn-primary" value="<?php echo (empty(Input::get('editPost'))) ? 'Publish' : 'Publish Edit'; ?>">
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>Categories</h4>
                                </div>
                                <div class="panel-body">
                                    <h5>All Categories</h5>
                                    <div class="form-group">
                                        <ul class="category-list">
                                        <?php

                                            $allCategories = $page->getAllCategories();

                                            if ($allCategories === false) {
                                                Redirect::to(409);
                                            }

                                            $catCnt = count($allCategories);

                                            for ($i=0; $i < $catCnt; $i++) { 

                                                if ($allCategories[$i]->isParentCategory == true) {
                                        ?>         
                                                <li>  
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="chkbox[]" value="<?php echo $allCategories[$i]->id; ?>" <?php if(!empty($pageData) && $pageData->post_category == $allCategories[$i]->id) echo "checked";?>><?php echo $allCategories[$i]->category_name; ?>
                                                        </label>
                                                    </div>
                                        <?php

                                                for ($j=0; $j < $catCnt; $j++) { 

                                                    if ($allCategories[$j]->parentCategoryId == $allCategories[$i]->id) {
                                        ?>
                                                        <ul class="category-list">
                                                            <li>
                                                                <div class="checkbox">
                                                                    <label><input type="checkbox" name="subChkbox[]" value="<?php echo $allCategories[$j]->id; ?>" <?php if(!empty($pageData) && $pageData->post_category == $allCategories[$j]->id) echo "checked";?>><?php echo $allCategories[$j]->category_name; ?></label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                        <?php
                                                    }
                                                }
                                        ?>
                                                </li>
                                        <?php
                                                }
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <a href="#">+ Add New Category</a>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>Feature Image</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Set Feature Image</label>
                                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="imgChkbox[]" value="1" checked>Use default Feature Image</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </form>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->