<article>
    <div class="container">

        <h3>Leave a Reply</h3>
        <p id="comment-intro">Your email address will not be published. Required fields are marked *</p>

        <div class="row">
        	<div class="col-lg-12">
        		<form role="form" method="post" action="" id="comment-form">
        			<div class="form-group">
				    	<label for="name">Name *</label>
				    	<input type="text" name="name" class="form-control" id="name">
				  	</div>
				  	<div class="form-group">
				    	<label for="email">Email *</label>
				    	<input type="email" name="email" class="form-control" id="email">
				  	</div>
				  	<div class="form-group">
				    	<label for="website">Website</label>
				    	<input type="url" name="website" class="form-control" id="website">
				  	</div>
				  	<div class="form-group">
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