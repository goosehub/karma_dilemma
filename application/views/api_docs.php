<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
            <a href="<?=base_url()?>"><p class="lead text-center"><?php echo site_name(); ?></p></a>

<h1 class="text-center">API Documentation</h1>

<h2>Basics</h2>

<?php if ($user) { ?>
<p>This is your User ID and API Key. All examples on this page are populated with information.</p>
<p><strong>user_id:</strong> <code><?php echo $user['id']; ?></code></p>
<p><strong>api_key:</strong> <code><?php echo $user['api_key']; ?></code></p>
<?php } else { ?>
<!-- Set these for documentation population -->
<?php $user['id'] = 1; ?>
<?php $user['api_key'] = '3c2b3fec3de9939d6c111b5782a67992'; ?>
<p>Login or Register to see your User ID and API Key.</p>
<p>
	<a class="btn btn-primary" href="<?=base_url()?>?logged_out=true">Login</a>
	<a class="btn btn-action" href="<?=base_url()?>">Register</a>
</p>
<?php } ?>

<p>Send your User ID, API Key, and any other paramters in a JSON POST request to the desired API path. API returns JSON. Check success or error bool in response to see if call succeeded. On error true, error_code and error_message will also be provided.</p>

<h2>Example</h2>

<h3>Bidding 50 on game with id of 3</h3>

<h4>Path</h4>
<pre><code><?=base_url()?>game/bid/?api=true</code></pre>

<h4>JSON POST Request</h4>
<pre><code>{
  "user_id": <?php echo $user['id']; ?>,
  "api_key": "<?php echo $user['api_key']; ?>",
  "game_id": 3,
  "amount": 50
} </code></pre>

<h4>Terminal</h4>
<pre><code>curl -H "Content-Type: application/json" -X POST -d '{"user_id":"<?php echo $user['id']; ?>","api_key":"<?php echo $user['api_key']; ?>","game_id":3,"amount":50}' <?=base_url()?>game/bid/?api=true </code></pre>

<h4>Javascript</h4>
<pre><code>// Create URL
$path = 'game/bid';
var url = '<?=base_url()?>' + $path + '/?api=true';

// Create JSON POST
var data = {};
data.user_id = <?php echo $user['id']; ?>;
data.api_key = '<?php echo $user['api_key']; ?>';
data.game_id = 3;
data.amount = 50;

// Perform API Call
var xhr = new XMLHttpRequest();
xhr.open('POST', url, false);
xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
xhr.send(JSON.stringify(data));

// Get Response
var response = JSON.parse(xhr.responseText);
if (response.error) {
	console.log(response.error_code + ' - ' + response.error_message);
}
console.log(response); </code></pre>

<h4>PHP</h4>
<pre><code>// Create URL
$path = 'game/bid';
$url = '<?=base_url()?>' . $path . '/?api=true';

// Create JSON POST
$data = array();
$data['user_id'] = <?php echo $user['id']; ?>;
$data['api_key'] = '<?php echo $user['api_key']; ?>';
$data['game_id'] = 3;
$data['amount'] = 50;
$post = json_encode($data);

// Perform API Call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$raw_response = curl_exec($ch);

// Get Response
$response = json_decode($raw_response);
if ($response->error) {
    echo $response->error_code . ' - ' . $response->error_message;
}
var_dump($response); </code></pre>

<h2>Paths</h2>

<h3>Get your user information</h3>
<pre><code>/?api=true</code></pre>
<ul>
</ul>

<h3>Get all games currently on auction</h3>
<pre><code>/games_on_auction/?api=true</code></pre>
<ul>
</ul>

<h3>Get your started games</h3>
<pre><code>/started_games/?api=true</code></pre>
<ul>
</ul>

<h3>Get your finished games</h3>
<pre><code>/finished_games/?api=true</code></pre>
<ul>
</ul>

<h3>Get karma currently on auction</h3>
<pre><code>/games_on_auction/?api=true</code></pre>
<ul>
</ul>

<h3>Create a bid for a game on auction</h3>
<pre><code>/game/bid/?api=true</code></pre>
<ul>
	<li>Requires POST parameter <code>game_id</code>. Must be a positive integer.</li>
	<li>Requires POST parameter <code>amount</code>. Must be between an integer -100 and 100.</li>
</ul>

<h3>Play a game by sending your choice</h3>
<pre><code>/game/play/?api=true</code></pre>
<ul>
	<li>Requires POST parameter <code>game_id</code>. Must be a positive integer.</li>
	<li>Requires POST parameter <code>choice</code>. Must be either 0 or 1.</li>
</ul>

<h3>Create a bid for a karma on auction</h3>
<pre><code>/karma/bid/?api=true</code></pre>
<ul>
	<li>Requires POST parameter <code>karma_id</code>. Must be a positive integer.</li>
	<li>Requires POST parameter <code>amount</code>. Must be between an integer 0 and 100.</li>
</ul>

<h3>Give another user karma</h3>
<pre><code>/karma/give/?api=true</code></pre>
<ul>
	<li>Requires POST parameter <code>type</code>. Must be either 0 or 1.</li>
	<li>Requires POST parameter <code>other_player_user_id</code>. Must be a positive integer.</li>
</ul>

<h3>Sell karma by putting it up on auction</h3>
<pre><code>/karma/sell/?api=true</code></pre>
<ul>
	<li>Requires POST parameter <code>type</code>. Must be either 0 or 1.</li>
</ul>

<h3>Get the leaderboard</h3>
<pre><code>leaderboard/$1/$2/$3/$4/?api=true</code></pre>
<ul>
	<li><code>$1</code> is the column you want to sort by.</li>
	<li><code>$2</code> is the direct you want to sort. You can pass ASC or DESC.</li>
	<li><code>$3</code> is the limit. The maximum value is <?php echo MAX_LEADERBOARD_LIMIT; ?>.</li>
	<li><code>$4</code> is the offset.</li>
	<li>All these parameters are optional. By default it returns top 100 score leaders.</li>
</ul>

<h2>Existing bots</h2>

<p>If you have a bot for this game, send the GitHub link to goosepostbox@gmail.com and I'll feature it here.</p>

		</div>
	</div>
</div>

<script src="<?=base_url()?>resources/highlightjs/highlightjs-9.4.0.min.js"></script>
<script>
// Include highlightjs main css
var head  = document.getElementsByTagName('head')[0];
var link  = document.createElement('link');
link.id   = 'highlight_css';
link.rel  = 'stylesheet';
link.type = 'text/css';
link.href = '<?=base_url()?>resources/highlightjs/highlightjs-9.4.0.min.css';
link.media = 'all';
head.appendChild(link);

// Include highlightjs theme css
var head  = document.getElementsByTagName('head')[0];
var link  = document.createElement('link');
link.id   = 'highlight_css';
link.rel  = 'stylesheet';
link.type = 'text/css';
// link.href = '<?=base_url()?>resources/highlightjs/styles/tomorrow-night-eighties.css';
// link.href = '<?=base_url()?>resources/highlightjs/styles/tomorrow-night.css';
link.href = '<?=base_url()?>resources/highlightjs/styles/paraiso-dark.css';
link.media = 'all';
head.appendChild(link);

// Activate highlightjs
hljs.initHighlightingOnLoad();
</script>