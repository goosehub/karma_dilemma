<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            
            <?php if ($user) { ?>
            <form class="sell_karma_parent" action="<?=base_url()?>karma/sell/" method="post">
                <button class="sell_good_karma btn btn-success" value="0" type="button">Sell Good Karma</button>
                <button class="sell_bad_karma btn btn-danger" value="1" type="button">Sell Bad Karma</button>
            </form>
            <?php } ?>

            <hr>

            <?php foreach ($karma_on_auction as $karma) { ?>
            
            <?php if ($user) { ?>
            <form class="karma_bid_parent" action="<?=base_url()?>karma/bid/" method="post">
                <strong>Karma Type: <?php echo $karma['type'] ? 'Positive' : 'Negative'; ?></strong>
                <input class="karma_bid_karma_id" name="karma_id" type="hidden" value="<?php echo $karma['id']; ?>">
                <input class="karma_bid_input form-control" type="range" name="bid" min="1" max="100" value="<?php echo $karma['highest_bid'] + 1; ?>">
                <span class="karma_bid_value_label"><?php echo $karma['highest_bid'] + 1; ?></span>
                <button class="karma_bid_submit" type="button">Make this bid</button>
            </form>
            <hr>
            <?php } ?>

            <?php } ?>
        </div>
    </div>
</div>