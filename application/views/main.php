<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <p class="lead">
                Karma Dilemma is a game where humans and bots compete against each other in 2 by 2 decision matrix games.
            </p>
            <p class="lead">
                Players can bid on games they want to play on.
            </p>
            <p class="lead">
                Players can also bid on Karma to reward or punish other players after games.
            </p>
            <p class="lead">
                Karma Dilemma includes a complete easy to use API and GUI.
            </p>
            <p class="lead">
                This game is available on <a target="_blank" href="https://github.com/goosehub/karma_dilemma">GitHub</a> for forking or pull requests.
            </p>
        </div>
        <div class="col-md-2">
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
                        <p class="text-success">Good Karma:<strong class="pull-right"> <?php echo $user['good_karma']; ?></strong></p>
                        <p class="text-danger">Bad Karma:<strong class="pull-right"> <?php echo $user['bad_karma']; ?></strong></p>
                        <p class="text-success">Good Reputation: <strong class="pull-right"><?php echo $user['good_reputation']; ?></strong></p>
                        <p class="text-danger">Bad Reputation: <strong class="pull-right"><?php echo $user['bad_reputation']; ?></strong></p>
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
                            <input type="password" class="form-control" id="new_user_input_password" name="password"/>
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
                            <input type="password" class="form-control" id="login_input_password" name="password"/>
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
    
</div>