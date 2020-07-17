<?php

require_once 'protect.php';
Protect\with('form.php', 'apt3ac');

$url = 'http://phrogers.com/ac/api/data/state.php';
$ch = curl_init();
//Set the URL that you want to GET by using the CURLOPT_URL option.
curl_setopt($ch, CURLOPT_URL, $url);

//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$data = json_decode(curl_exec($ch));
curl_close($ch);

?>

<head>
    <link rel="stylesheet" href="style.css">
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div>Hello Mike!</div>
<br>
<h2>Current State</h2>
<div>
    <h3>Current swamp cooler state is: <em><?php echo $data->state; ?></em> </h3>

</div>
<h2>Select New State</h2>
<form action="../api/data/web.php" method="post">
    <div>
        <input type="radio" name="command" id="low_vent" value="1" required />
        <label for="low_vent">Low Vent</label>
    </div>
    <div>
        <input type="radio" name="command" id="high_vent" value="2" required />
        <label for="high_vent">High Vent</label>
    </div>
    <div>
        <input type="radio" name="command" id="low_cool" value="3" required />
        <label for="low_cool">Low Cool</label>
    </div>
    <div>
        <input type="radio" name="command" id="high_cool" value="4" required />
        <label for="high_cool">High Cool</label>
    </div>
    <div>
        <input type="radio" name="command" id="pump" value="5" required />
        <label for="pump">Pump</label>
    </div>
    <div>
        <input type="radio" name="command" id="off" value="6" required />
        <label for="off">Off</label>
    </div>
    <div>
        <label for="new_state"></label>
        <input type="submit" name="new_state" value="Submit"/>
    </div>
</form>








