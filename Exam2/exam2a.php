<?php
require __DIR__ . '/../vendor/autoload.php'; 
use GuzzleHttp\Client;

$wikipediaUri = "https://en.wikipedia.org/api/rest_v1/";
$client = new Client(['base_uri' => $wikipediaUri,'timeout'  => 2.0]);
function req($v){
try {
	global $client;
        $response = $client->request('get',"page/references/".$v);
    } catch (Exception $e) {
        print "There was an error.";
        exit;
    }

        $body = (string) $response->getBody();
        $jbody = json_decode($body);
        if (!$jbody) {
                error_log("no json");
                exit;
        }
        return $jbody;
}
?>


<h1>DNS</h1>
<?php
$h = "DNS";
$a = req($h);
?>
<p><?php print "Revision " . $a->revision; ?></p>
<p><?php print "Tid " . $a->tid; ?></p>
<h1>Miami</h1>
<?php
$q = "Miami";
$b = req($q);
?>
<p><?php print "Revision " . $b->revision; ?></p>
<p><?php print "Tid " . $b->tid; ?></p>
<h1>Ohio</h1>
<?php
$i = "Ohio";
$c = req($i);
?>

<p><?php print "Revision " . $c->revision; ?></p>
<p><?php print "Tid " . $c->tid; ?></p>

