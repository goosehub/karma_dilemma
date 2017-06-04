<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <a href="<?=base_url()?>"><p class="lead text-center"><?php echo site_name(); ?></p></a>
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($karma_on_auction as $karma) { ?>

            <?php var_dump($karma); ?>
            
            <?php if ($user) { ?>
            <form class="karma_bid_parent" action="<?=base_url()?>karma/bid/<?php echo $karma['id']; ?>" method="post">
                <input class="karma_bid_karma_id" name="karma_id" type="hidden" value="<?php echo $karma['id']; ?>">
                <input class="karma_bid_input form-control" type="range" name="bid" min="1" max="100" value="1">
                <span class="karma_bid_value_label">1</span>
                <button class="karma_bid_submit" type="button">Make this bid</button>
            </form>
            <hr>
            <?php } ?>

            <?php } ?>
        </div>
    </div>
</div>