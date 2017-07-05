<!-- A little space -->
<br>

<!-- jQuery -->
<script src="<?=base_url()?>resources/jquery/jquery-3.1.1.min.js"></script>
<!-- Bootstrap -->
<script src="<?=base_url()?>resources/bootstrap/js/bootstrap.min.js"></script>
<!-- Pass Variables to Local Script -->
<script>
	var base_url = '<?php echo base_url(); ?>';
	var user = false;
	<?php if ($user) { ?>
	var user = '<?php echo json_encode($user); ?>';
	var my_user_polling = <?php echo MY_USER_POLLING; ?>;
	var karma_on_auction_polling = <?php echo KARMA_ON_AUCTION_POLLING; ?>;
	var games_on_auction_polling = <?php echo GAMES_ON_AUCTION_POLLING; ?>;
	var started_games_polling = <?php echo STARTED_GAMES_POLLING; ?>;
	<?php } ?>
</script>
<!-- Local Script -->
<script src="<?=base_url()?>resources/script.js?<?php echo time(); ?>"></script>

<!-- End of Document -->
  </body>
</html>