        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Users <small>Registered Users</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-users"></i> Users
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

                <!--New row-->
                <div class="row">
                    <div class="col-lg-12">

                        <a href="#" class="btn btn-default pull-right new-cat">Change Role</a>
                        <a href="#" class="btn btn-info pull-right new-post">Add User</a>
                        
                    </div>
                </div>

                <!--Row-->
                <div class="row">

                    <div class="col-lg-12">
                        
                        <p class="filter-link"><a href="users.php">All</a> (<?php echo $user->countUsers(); ?>) | <a href="users.php?users=superAdmin">Super Administrator</a> (<?php echo $user->countUsers('superAdmin'); ?>) | <a href="users.php?users=admin">Administrator</a> (<?php echo $user->countUsers('admin'); ?>) | <a href="users.php?users=editor">Editor</a>  (<?php echo $user->countUsers('editor'); ?>) | <a href="users.php?users=author">Author</a>  (<?php echo $user->countUsers('author'); ?>) | <a href="users.php?users=public">Public</a>  (<?php echo $user->countUsers('public'); ?>)</p>
                        <!--Form-->
                        <form class="form-inline" role="form" method="get">

                            <div class="form-group">
                                <select class="form-control" id="post-action" name="action">
                                    <option>Bulk Action</option>
                                    <option value="remove">Remove</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default applybtn" name="apply">Apply</button>

                            <div class="form-group">
                                <select class="form-control" id="filter-date" name="userRole">
                                    <option>Change Role to..</option>
                                    <?php if($user->isOga()) { ?><option value="superAdmin">Super Administrator</option> <?php } ?>
                                    <option value="admin">Administrator</option>
                                    <option value="editor">Editor</option>
                                    <option value="author">Author</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default" name="change">Change</button>

                            <div class="table-responsive post-table">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" value=""></label>
                                                </div>
                                                Username
                                            </th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Post</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        for ($i=($postCount - 1); $i >= 0; $i--) {

                                            if ($postCount === 0) {
                                                 break;
                                             }

                                            $id = $allUsers[$i]->id;

                                            $username = $allUsers[$i]->username;

                                            $name = $allUsers[$i]->last_name . ' ' . $allUsers[$i]->first_name;

                                            $role = $allUsers[$i]->userType;

                                            $userEmail = $allUsers[$i]->email;
                                        ?>
                                            <tr<?php if($i % 2 === 0) {echo " class=\"active\"";}?>>

                                                <td>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="chkbox[]" value="<?php echo $id; ?>"></label>
                                                    </div>
                                                    <a href="profile.php?id=<?php echo($id); ?>"><?php echo $username; ?> </a> 
                                                </td>
                                                <td><?php echo $name; ?></td>
                                                <td><?php echo $userEmail; ?></td>
                                                <td><?php echo $role; ?></td>
                                                <td><?php echo $user->getUserPostCount($id); ?></td>
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