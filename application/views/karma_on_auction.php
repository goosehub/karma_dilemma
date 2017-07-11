<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            
            <?php if ($user) { ?>
            <form class="sell_karma_parent" action="<?=base_url()?>karma/sell/" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <button class="sell_good_karma btn btn-success form-control" value="0" type="button">
                            Sell Good Karma (<span class="good_karma"><?php echo $user['good_karma']; ?></span> Left To Sell)
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="sell_bad_karma btn btn-danger form-control" value="1" type="button">
                            Sell Bad Karma (<span class="bad_karma"><?php echo $user['bad_karma']; ?></span> Left To Sell)
                        </button>
                    </div>
                </div>
            </form>
            <?php } ?>

            <hr>

            <?php foreach ($karma_on_auction as $karma) { ?>
            <div class="karma_auction_parent" karma_id="<?php echo $karma['id'] ?>">
                <form class="karma_bid_parent well" action="<?=base_url()?>karma/bid/" method="post">
                    <input class="karma_bid_karma_id" name="karma_id" type="hidden" value="<?php echo $karma['id']; ?>">
                    <input class="karma_bid_input_range form-control" type="range" name="bid" min="1" max="100" value="<?php echo $karma['highest_bid'] + 1; ?>">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="karma_type_label alert <?php echo $karma['type'] ? 'alert-success' : 'alert-danger'; ?> text-center" role="alert">
                                <strong class="<?php echo $karma['type'] ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $karma['type'] ? 'Good' : 'Bad'; ?> Karma
                                </strong>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <input class="karma_bid_input_number text-center form-control" type="number" min="1" max="100" value="<?php echo $karma['highest_bid'] + 1; ?>"/>
                        </div>
                        <div class="col-sm-4 text-center">
                            <button class="karma_bid_submit btn btn-primary form-control" type="button">Make this bid</button>
                            <div class="you_are_karma_bid_leader" style="<?php echo !$karma['you_are_highest_bid'] ? 'display: none;' : ''; ?>">
                                <small class="text-success">You have the highest bid</small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>