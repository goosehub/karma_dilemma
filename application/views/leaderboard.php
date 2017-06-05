<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <h2 class="text-center">Leaderboards</h2>

            <?php // var_dump($leaders); die(); ?>

            <table class="leaderboard_table table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr class="success">
                        <th>Rank</th>
                        <th>User</th>
                        <th>Score</th>
                        <th>Games Played</th>
                        <th>Avail. Positive Karma</th>
                        <th>Avail. Negative Karma</th>
                        <th>Avail. Karma Ratio</th>
                        <th>Sum Avail. Karma</th>
                        <th>Positive Karma</th>
                        <th>Negative Karma</th>
                        <th>Karma Ratio</th>
                        <th>Sum Karma</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leaders as $leader) { ?>
                    <tr>
                        <td>
	                        <?php echo $leader['rank']; ?>
                        </td>
                        <td>
	                        <a href="<?=base_url()?>user/<?php echo $leader['id']; ?>">
		                        <p class="text-center"><?php echo $leader['username']; ?></p>
	                        </a>
	                        <a href="<?=base_url()?>uploads/<?php echo $leader['avatar']; ?>" target="_blank">
		                        <img class="leaderboard_avatar" src="<?=base_url()?>uploads/<?php echo $leader['avatar']; ?>" alt="Avatar"/>
	                        </a>
                        </td>
                        <td>
	                        <?php echo number_format($leader['score']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['games_played']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['available_positive_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['available_negative_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['available_karma_ratio']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['total_available_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['positive_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['negative_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['karma_ratio']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['total_karma']); ?>
                        </td>
                        <td>
	                        <small><?php echo date('Y m d', strtotime($leader['created'])); ?></small>
                        </td>
                    </tr>
                	<?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>