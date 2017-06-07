<nav class="main_nav navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=base_url()?>">Karma Dilemma</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'leaderboard') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>leaderboard" class="nav_link">Leaderboard</a> <br>
                </li>
                <?php if ($user) { ?>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'games_on_auction') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>games_on_auction" class="nav_link">Game Auctions</a> <br>
                </li>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'karma_on_auction') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>karma_on_auction" class="nav_link">Karma Auctions</a> <br>
                </li>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'started_games') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>started_games" class="nav_link">Your Turn</a> <br>
                </li>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'finished_games') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>finished_games" class="nav_link">Past Games</a> <br>
                </li>
                <?php } ?>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'api_docs') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>api_docs" class="nav_link">API / Make Bots</a> <br>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
            </ul>
        </div>
    </div>
</nav>