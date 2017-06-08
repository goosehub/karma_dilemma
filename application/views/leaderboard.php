<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Leaderboards</h1>

            <?php // var_dump($leaders); die(); ?>

            <table class="leaderboard_table table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr class="success">
                        <th>
                            Rank
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'username' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/username/<?php echo $column === 'username' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                User
                                <?php if ($column === 'username') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-alphabet-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'score' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/score/<?php echo $column === 'score' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Score
                                <?php if ($column === 'score') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'games_played' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/games_played/<?php echo $column === 'games_played' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Games Played
                                <?php if ($column === 'games_played') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'available_good_karma' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/available_good_karma/<?php echo $column === 'available_good_karma' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Avail. Good Karma
                                <?php if ($column === 'available_good_karma') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'available_bad_karma' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/available_bad_karma/<?php echo $column === 'available_bad_karma' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Avail. Bad Karma
                                <?php if ($column === 'available_bad_karma') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'total_available_karma' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/total_available_karma/<?php echo $column === 'total_available_karma' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Sum Avail. Karma
                                <?php if ($column === 'total_available_karma') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'good_karma' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/good_karma/<?php echo $column === 'good_karma' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Good Karma
                                <?php if ($column === 'good_karma') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'bad_karma' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/bad_karma/<?php echo $column === 'bad_karma' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Bad Karma
                                <?php if ($column === 'bad_karma') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'total_karma' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/total_karma/<?php echo $column === 'total_karma' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Sum Karma
                                <?php if ($column === 'total_karma') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                        <th>
                            <a class="btn btn-sm form-control <?php echo $column === 'created' ? 'btn-info' : 'btn-default'; ?>"
                            href="<?=base_url()?>leaderboard/created/<?php echo $column === 'created' && $sort === 'desc' ? 'asc' : 'desc'; ?>">
                                Joined
                                <?php if ($column === 'created') { ?>
                                <?php if ($sort === 'desc') { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                                <?php } else { ?>
                                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                                <?php } ?>
                                <?php } ?>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leaders as $leader) { ?>
                    <tr>
                        <td>
	                        <h2><?php echo $leader['rank']; ?></h2>
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
	                        <?php echo number_format($leader['available_good_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['available_bad_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['total_available_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['good_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['bad_karma']); ?>
                        </td>
                        <td>
	                        <?php echo number_format($leader['total_karma']); ?>
                        </td>
                        <td>
	                        <small><?php echo date('Y-m-d', strtotime($leader['created'])); ?></small>
                        </td>
                    </tr>
                	<?php } ?>
                </tbody>
            </table>

            <!-- Previous Page -->
            <?php if ($offset - $limit >= 0) { ?>
            <a href="<?=base_url()?>leaderboard/<?php echo $column; ?>/<?php echo $sort; ?>/<?php echo $limit; ?>/<?php echo $offset - $limit; ?>">
                Previous
            </a>
            <!-- Previous Page but offset is less than limit -->
            <?php } else if ($offset > 0) { ?>
            <a href="<?=base_url()?>leaderboard/<?php echo $column; ?>/<?php echo $sort; ?>/<?php echo $limit; ?>">
                Previous
            </a>
            <?php } ?>

            <!-- Next Page -->
            <a href="<?=base_url()?>leaderboard/<?php echo $column; ?>/<?php echo $sort; ?>/<?php echo $limit; ?>/<?php echo $offset + $limit; ?>">
                Next
            </a>

        </div>
    </div>

</div>