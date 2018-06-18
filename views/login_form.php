<!--==========================
    Hero Section
  ============================-->
  <section id="hero">
    <div class="hero-container">
      	<form role="form" id="login-form" method="post" action="">

		 	<div class="form-group">
		    	<label for="username">Username:</label>
		    	<input type="text" name="username" class="form-control" id="username">
		  	</div>

		  	<div class="form-group">
		    	<label for="pwd">Password:</label>
		    	<input type="password" name="password" class="form-control" id="pwd">
		  	</div>

		  	<div class="checkbox">
		    	<label><input type="checkbox" name="remember"> Remember me</label>
		  	</div>
		  	
		  	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		  	<button type="submit" class="btn btn-link btn-get-started" id="login-button">Submit</button>

		</form>
    </div>
  </section><!-- #hero -->