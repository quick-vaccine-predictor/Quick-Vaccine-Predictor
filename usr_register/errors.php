
<?php 
// Inside the associative array of errors we print an error when ocurred:

if(count($errors) > 0) : ?>
	<div class="alert alert-danger" role="alert">
		<?php foreach ($errors as $error) : ?>
			<p><?php echo $error ?></p>
		<?php endforeach ?>
	</div>
<?php endif ?>
		


 
