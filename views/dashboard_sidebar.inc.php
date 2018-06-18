<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li<?php echo $dashboard; ?>>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li<?php echo $posts; ?>>
                        <a href="edit.php"><i class="fa fa-fw fa-pencil"></i>Posts</a>
                    </li>
                <?php
                    if ($user->isAdmin()) {
                ?>
                    <li<?php echo $users; ?>>
                        <a href="users.php"><i class="fa fa-fw fa-users"></i>Users</a>
                    </li>
                <?php
                    }
                ?>
                    <li<?php echo $profile; ?>>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Profile <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li<?php echo $profile; ?>>
                                <a href="profile.php?id=<?php echo (empty($visitor)) ? $user->data()->id : $visitor->data()->id; ?>">Your Profile</a>
                            </li>

                        <?php
                            if ($user->isAdmin()) {
                        ?>
                            <li>
                                <a href="register.php">Add User</a>
                            </li>
                        <?php
                            }
                        ?>
                        </ul>
                    </li>
                    <li<?php echo $webpages; ?>>
                        <a href="#"><i class="fa fa-fw fa-edit"></i> Pages</a>
                    </li>
                    <li<?php echo $comments; ?>>
                        <a href="comments.php"><i class="fa fa-fw fa-comment"></i> Comments</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-file"></i> Media</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-wrench"></i> Tools</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-dashboard"></i> Settings</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>