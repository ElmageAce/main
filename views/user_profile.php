
<div id="page-wrapper">

    <div class="container-fluid">

    	 <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Profile <small>Edit Profile</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </li>
                    <li class="active">
                        <i class="fa fa-users"></i>Profile
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

     <div class="row">
		<div class="col-lg-6">
			<form role="form" method="post" action="">
				<h2>Name</h2>

				<div class="form-group">
	                <label>Username <small>(Cannot be changed)</small></label>
	                <input class="form-control" name="username" value="<?php echo $user->data()->username; ?>" disabled>
	            </div>

	            <div class="form-group">
	                <label>First Name <small>(required)</small></label>
	                <input type="text" class="form-control" name="first_name" value="<?php echo $user->data()->first_name; ?>">
	            </div>

	            <div class="form-group">
	                <label>Last Name <small>(required)</small></label>
	                <input type="text" class="form-control" name="last_name" value="<?php echo $user->data()->last_name; ?>">
	            </div>

	            <div class="form-group">
	                <label>User Group </label>
	                <input type="text" class="form-control" name="usergroup" value="<?php echo $user->data()->userType; ?>" disabled>
	            </div>

	            <div class="form-group">
	                <label>Display name publicly as <small>(required)</small></label>
	                <input type="text" class="form-control" name="publish_name" value="<?php echo $user->data()->publish_name; ?>">
	            </div>

	            <h2>Contact Info</h2>

	            <div class="form-group">
	                <label>Email Address <small>(required)</small></label>
	                <input type="email" class="form-control" name="email" value="<?php echo $user->data()->email; ?>">
	            </div>

	            <h2>About Yourself</h2>

	            <div class="form-group">
	                <label>Biographical Info</label>
	                <textarea class="form-control" rows="5" id="comment" name="bio"><?php echo $user->data()->bio; ?></textarea>
	            </div>

	            <div class="form-group">
	                <label>Profile Picture</label>
	                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
	            </div>

	            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		  		<button type="submit" class="btn btn-info" id="login-button">Update Profile</button>

			</form>
		</div>
	</div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->