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
                <?php if ($user) { ?>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'games_on_auction') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>games_on_auction" class="nav_link">Games</a>
                </li>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'started_games') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>started_games" class="nav_link">
                        Your Turn
                        <span id="started_games_count">
                            <?php if ($user['started_games_count']) { ?>
                            (<?php echo $user['started_games_count']; ?>)
                            <?php } ?>
                        </span>
                    </a>
                </li>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'finished_games') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>finished_games" class="nav_link">
                        Past Games
                        <span id="finished_unviewed_games_count">
                            <?php if ($user['finished_unviewed_games_count']) { ?>
                            (<?php echo $user['finished_unviewed_games_count']; ?>)
                            <?php } ?>
                        </span>
                    </a>
                </li>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'karma_on_auction') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>karma_on_auction" class="nav_link">Karma</a>
                </li>
                <?php } ?>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'leaderboard') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>leaderboard" class="nav_link">Leaderboard</a>
                </li>
                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], 'api_docs') !== false ? 'active' : ''; ?>">
                    <a href="<?=base_url()?>api_docs" class="nav_link">API / Make Bots</a>
                </li>
            </ul>
            <ul class="main_nav nav navbar-nav navbar-right">
                <?php if ($user) { ?>
                <li>
                    <p class="navbar-text">
                        <a class="nav_username" href="<?=base_url()?>single_user/<?php echo $user['id']; ?>"><?php echo $user['username'] ?></a>
                    </p>
                </li>
                <li>
                    <p class="nav_score navbar-text">Score: <?php echo $user['score'] ?></p>
                </li>
                <?php } else { ?>
                <a class="btn btn-primary navbar-btn" href="<?=base_url()?>?logged_out=true">Login</a>
                <a class="btn btn-action navbar-btn" href="<?=base_url()?>">Register</a>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>