<article>
    <div class="container">

        <h3>Leave a Reply</h3>
        <p id="comment-intro">Logged in as <?php echo $user->data()->publish_name; ?>. <a href="logout.php">Log out?</a></p>

        <div class="row">
        	<div class="col-lg-12">
        		<form role="form" method="post" action="" id="comment-form">
        			<div>
				    	<label for="message">Comment</label>
				    	<textarea name="message" id="comment-text"></textarea>
				  	</div>
				  	<div class="form-group pull-right">
				  		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		  				<button type="submit" class="btn btn-info" name="comment">Post Comment</button>
				  	</div>
        		</form>
        	</div>
        </div>
        
    </div>
</article>