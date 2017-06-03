<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
            <a href="<?=base_url()?>"><p class="lead text-center"><?php echo site_name(); ?></p></a>

<h1 class="text-center">API Documentation</h1>

<h2>Basics</h2>

<p>Always include in your requests a GET parameter with key of api and value of true.</p>

<pre><code>?api=true</code></pre>

<?php if ($user) { ?>
<p>This is your User ID and API Key.</p>
<p><strong>user_id:</strong> <code><?php echo $user['id']; ?></code></p>
<p><strong>api_key:</strong> <code><?php echo $user['api_key']; ?></code></p>
<?php } else { ?>
<p>Login or Register to see your User ID and API Key.</p>
<p>
	<a class="btn btn-primary" href="http://localhost/theory/?logged_out=true">Login</a>
	<a class="btn btn-action" href="http://localhost/theory/">Register</a>
</p>
<?php } ?>

<p>Send your User ID and API Key in your JSON POST request along with any parameters to the path as shown in the examples below.</p>

<h2>Examples</h2>

<h3>Getting list of games on auction</h3>

<strong>JSON to POST</strong>
<pre><code>{
  "user_key": 1,
  "3c2b3fec3de9939d6c111b5782a67992": "Hello World"
} </code></pre>

<strong>Terminal</strong>
<pre><code>curl -H "Content-Type: application/json" -X GET http://localhost/theory/games_on_auction?api=true </code></pre>

<strong>Javascript</strong>
<pre><code>var url = 'http://localhost/theory/games_on_auction?api=true';
var xhr = new XMLHttpRequest();
xhr.open('GET', url, false);
xhr.send(null);
var response = JSON.parse(xhr.responseText);
if (response.error) {
	console.log(response.error_code + ' - ' + response.error_message);
}
console.log(response); </code></pre>

<strong>PHP with CURL</strong>
<pre><code>// Create URL
$base_url = 'http://localhost/theory/';
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
}
var_dump($response); </code></pre>

<h3>Bidding 50 on game with id of 3</h3>

<strong>JSON to POST</strong>
<pre><code>{
  "user_key": 1,
  "3c2b3fec3de9939d6c111b5782a67992": "Hello World",
  "game_id": 3,
  "amount": 50
} </code></pre>

<strong>Terminal</strong>
<pre><code>curl -H "Content-Type: application/json" -X POST -d '{"user_id":"1","api_key":"3c2b3fec3de9939d6c111b5782a67992","game_id":3,"amount":50}' http://localhost/theory/game/bid/?api=true </code></pre>

<strong>Javascript</strong>
<pre><code>var url = 'http://localhost/theory/game/bid/?api=true';
var data = {};
data.user_id = 1;
data.api_key = '3c2b3fec3de9939d6c111b5782a67992';
data.game_id = 3;
data.amount = 50;
var xhr = new XMLHttpRequest();
xhr.open('POST', url, false);
xhr.setRequestHeader('Content-Type', 'application/javascript; charset=UTF-8');
xhr.send(JSON.stringify(data));
var response = JSON.parse(xhr.responseText);
if (response.error) {
	console.log(response.error_code + ' - ' + response.error_message);
}
console.log(response); </code></pre>

<strong>PHP with CURL</strong>
<pre><code>// Create URL
$base_url = 'http://localhost/theory/';
$action = 'game/bid/';
$url = $base_url . $action . '?api=true';

// Create JSON POST
$data = array();
$data['user_id'] = 1;
$data['api_key'] = '3c2b3fec3de9939d6c111b5782a67992';
$data['game_id'] = 3;
$data['amount'] = 50;
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
}
var_dump($response); </code></pre>

<h2>Paths</h2>

<h3>Get your own user information</h3>
<pre><code>/?api=true</code></pre>
<ul>
	<li>Requires authentication.</li>
	<li>Does not require post parameters.</li>
</ul>

<h3>Get games on auction</h3>
<pre><code>/games_on_auction?api=true</code></pre>
<ul>
	<li>Does not require authentication.</li>
	<li>Does not require post parameters.</li>
</ul>

<h3>Make bid on game</h3>
<pre><code>/game/bid/?api=true</code></pre>
<ul>
	<li>Requires authentication.</li>
	<li>Requires post parameter <code>game_id</code>. Must be a positive integer. Must be the id of the game you're bidding on.</li>
	<li>Requires post parameter <code>amount</code>. Must be between an integer -100 and 100.</li>
</ul>

<h2>Existing bots</h2>

<p>If you make a bot for this game, send me a GitHub link at goosepostbox@gmail.com and I'll feature it here.</p>

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
link.href = '<?=base_url()?>resources/highlightjs/styles/tomorrow-night-eighties.css';
link.media = 'all';
head.appendChild(link);

// Activate highlightjs
hljs.initHighlightingOnLoad();
</script>
