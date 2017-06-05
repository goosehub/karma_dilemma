<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <h2>How it works</h2>
            <p>Coming Soon</p>
            <div class="row">
                <div class="col-md-6">
                    <a href="<?=base_url()?>leaderboard" class="btn btn-action form-control">Leaderboard</a> <br>
                    <a href="<?=base_url()?>games_on_auction" class="btn btn-action form-control">Games on Auction</a> <br>
                    <a href="<?=base_url()?>karma_on_auction" class="btn btn-action form-control">Karma on Auction</a> <br>
                    <?php if ($user) { ?>
                    <a href="<?=base_url()?>started_games" class="btn btn-action form-control">Started Games</a> <br>
                    <a href="<?=base_url()?>finished_games" class="btn btn-action form-control">Finished Games</a> <br>
                    <?php } ?>
                    <a href="<?=base_url()?>api_docs" class="btn btn-action form-control">API Documentation</a> <br>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="login_register_parent">
                <?php if ($user) { ?>
                <h2>Welcome back <?php echo $user['username']; ?></h2>
                <div class="row">
                    <div class="col-sm-4">
                        <img src="<?=base_url()?>uploads/<?php echo $user['avatar']; ?>" alt="avatar" class="img-responsive"/>
                        <div id="change_avatar" class="btn btn-default btn-sm form-control">Change</div>
                        <div id="avatar_form_parent" style="display: none;">
                            <form id="avatar_form" action="<?=base_url()?>user/avatar" method="post" enctype="multipart/form-data">
                                <input id="avatar_input" class="form-control" type="file" name="avatar"/>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <p class="text-primary">Score: <strong class="pull-right"><?php echo $user['score']; ?></strong></p>
                        <p class="text-success">Positive Karma Available:<strong class="pull-right"> <?php echo $user['available_positive_karma']; ?></strong></p>
                        <p class="text-danger">Negative Karma Available:<strong class="pull-right"> <?php echo $user['available_negative_karma']; ?></strong></p>
                        <p class="text-success">Positive Karma: <strong class="pull-right"><?php echo $user['positive_karma']; ?></strong></p>
                        <p class="text-danger">Negative Karma: <strong class="pull-right"><?php echo $user['negative_karma']; ?></strong></p>
                    </div>
                </div>
                <br>
                <a class="btn btn-danger btn-sm pull-right" href="<?=base_url()?>user/logout">Logout</a>
                <?php } else { ?>
                <h3>Start playing now</h3>
                <?php echo $validation_errors; ?>
                <div id="new_user_parent">
                    <form action="<?=base_url()?>user/register" method="post">
                        <input type="hidden" name="ab_test" value="<?php echo $ab_test; ?>"/>
                        <input type="hidden" name="bee_movie" value=""/>
                        <div class="form-group">
                            <input type="username" class="form-control" id="new_user_input_username" name="username" placeholder="Username"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="new_user_input_password" name="password" placeholder="Password"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="new_user_input_password_confirm" name="confirm" placeholder="Confirm"/>
                        </div>
                        <button type="submit" class="custom_btn btn btn-action form-control">Start Playing</button>
                    </form>
                    <br>
                    <div id="show_login" class="custom_btn btn btn-primary pull-right">Or Login</div>
                </div>

                <div id="login_parent" style="display: none;">
                    <form action="<?=base_url()?>user/login" method="post">
                        <div class="form-group">
                            <input type="username" class="form-control" id="login_input_username" name="username" placeholder="Username"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="login_input_password" name="password" placeholder="Password"/>
                        </div>
                        <button type="submit" class="custom_btn btn btn-action form-control">Login</button>
                    </form>
                    <br>
                    <div id="show_register" class="custom_btn btn btn-primary pull-right">Or Register</div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <h2 class="text-center">Leaderboards</h2>
            <p>Coming Soon</p>
        </div>
    </div>

</div>