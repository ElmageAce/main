<article>
    <div class="container">
        <h3>Rate Post</h3>
        <div class="row">
        	<div class="col-lg-12">
        		<form role="form" method="get" action="" id="review-post">
                    <div class="form-group">
                        <label class="radio-inline"><input type="radio" name="rate" value="0"><small>Very Poor </small></label>
                        <label class="radio-inline"><input type="radio" name="rate" value="1"><small> Poor </small></label>
                        <label class="radio-inline"><input type="radio" name="rate" value="2"><small> Satisfactory </small></label>
                        <label class="radio-inline"><input type="radio" name="rate" value="3"><small> Good </small></label>
                        <label class="radio-inline"><input type="radio" name="rate" value="4"> <small>Very Good </small></label>
                        <label class="radio-inline"><input type="radio" name="rate" value="5"><small> Excellent </small></label>
                        <button type="submit" class="btn btn-info pull-right" name="id" value="<?php echo $pageId; ?>"><small>Review </small></button>
                    </div>
        		</form>
        	</div>
        </div>
        
    </div>
</article>