<div class="container">
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<p>Coming Soon</p>

			<p>If you are logged in, your API Auth Token will appear below</p>
			<?php if ($user) { ?>
			<p>API Auth Token: <code><?php echo $user['auth_token']; ?></code></p>
			<?php } ?>

			<br>
			<br>
			<a href="<?=base_url()?>">Back to the game</a>
		</div>
	</div>
</div>

