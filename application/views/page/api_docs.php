<div class="container">
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
            <a href="<?=base_url()?>"><p class="lead text-center"><?php echo site_name(); ?></p></a>

<h1>API Documentation</h1>

<h2>Authenticating</h2>

<p>If you are logged in, your User ID and API Key will appear below.</p>

<?php if ($user) { ?>
<p><strong>user_id:</strong> <code><?php echo $user['id']; ?></code></p>
<p><strong>api_key:</strong> <code><?php echo $user['api_key']; ?></code></p>
<?php } ?>

<p>Include these in your POST JSON. It is optional on public pages (/games_on_auction) and required on private pages and game actions (/game/bid).</p>

<h2>Examples</h2>
<h3>Example of getting list of games on auction</h3>

<strong>Terminal</strong>
<pre><code> curl -H "Content-Type: application/json" -X GET http://dev.foobar.com/personal/theory/games_on_auction?api=true </code></pre>

<strong>PHP with CURL</strong>
<pre><code> // Create URL
$base_url = 'http://dev.foobar.com/personal/theory/';
$action = 'games_on_auction';
$url = $base_url . $action . '?api=true';

// Make API Call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$raw_response = curl_exec($ch);

// Get response
$response = json_decode($raw_response);
if ($response->error) {
    echo $response->error_code . ' - ' . $response->error_message;
} </code></pre>

<h3>Example of making a bid of 50 on game with id of 3</h3>

<strong>Terminal</strong>
<pre><code> curl -H "Content-Type: application/json" -X POST -d '{"user_id":"1","api_key":"e78987628aee0bcbd522f5db42bd7d10","amount":"50"}' http://dev.foobar.com/personal/theory/game/bid/3?api=true </code></pre>

<strong>PHP with CURL</strong>
<pre><code> // Create URL
$base_url = 'http://dev.foobar.com/personal/theory/';
$game_id = 3;
$action = 'game/bid/' . $game_id;
$url = $base_url . $action . '?api=true';

// Create JSON POST
$data = array();
$data['user_id'] = '1';
$data['api_key'] = 'e78987628aee0bcbd522f5db42bd7d10';
$data['amount'] = '50';
$post = json_encode($data);

// Make API Call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$raw_response = curl_exec($ch);

// Get response
$response = json_decode($raw_response);
if ($response->error) {
    echo $response->error_code . ' - ' . $response->error_message;
} </code></pre>

		</div>
	</div>
</div>

