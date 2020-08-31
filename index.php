<!DOCTYPE html>
<html>
<head>
<title>Guild Wars 2 Chat Buffer Buddy</title>
<link rel='stylesheet' id='reset-css'  href='theme/reset.css' type='text/css' media='all' />
<link rel='stylesheet' id='gw2-css'  href='theme/gw2theme.css' type='text/css' media='all' />
</head>
<body>
<script>
// Copy text with id=textID to clipboard
function copyToClipboard(textID) {
	var copyText = document.getElementById(textID);
	copyText.select();
	document.execCommand("copy");
	//alert("Text Copied!");
}
</script>
<div id="body">
<center>
<br>
<h1 style='color:#ffffff;'>
<table><tr>
<td align='center'><img src="theme/media/gw2.png" alt="Guild Wars 2 " width="80%" height="80%"></td>
<td> Chat Buffer Buddy</td>
</tr></table>
</h1>
</center>
<?php
mb_internal_encoding("UTF-8");

# Prints the main form for entering inputs and configuring output
function printForm($chatBuffer, $continueChar, $startFlag, $format) {
	$continueOpt = array('>', '+', '-', '♪');
	echo "<center><form action='index.php' method='post'>";
	echo "<textarea name='chat' rows='10' cols='100'>" . $chatBuffer . "</textarea><br>";
	echo "<table><tr><td style='padding: 20px;'><label for='continue'>Continue Marker: </label><select name='continue' id='continue'>";
	foreach ($continueOpt as $opt) {
		echo "<option value='" . $opt . "'";
		if ($opt == $continueChar) echo " selected='selected'";
		echo ">" . $opt . "</option>";
	}
	echo "</select><br><br>";
	echo "Continue Marker at Start of New Line: <input type='radio' name='start' value='yes' id='starty'";
	if ($startFlag == 'yes') {
		echo " checked";
	}
	echo "><label for='starty'> Yes </label><input type='radio' name='start' value='no' id='startn'";
	if ($startFlag == 'no') {
		echo " checked";
	}
	echo "><label for='startn'> No</label><br><br>";
	echo "Post Format: <input type='radio' name='format' value='Emote' id='formate'";
	if ($format == 'Emote') {
		echo " checked";
	}
	echo "><label for='formate'> Emote </label><input type='radio' name='format' value='Say' id='formats'";
	if ($format == 'Say') {
		echo " checked";
	}
	echo "><label for='formats'> Say/Party</label></td>";
	echo "<td align='center' style='padding: 20px;'><input type='submit' name='submit' value='Submit'></td></tr></table></form><br></center>";
}

# Prints an output block, including the associated 'Copy to Clipboard' button
function printOutputBlock( $text, $num ) {
	echo "<tr><td align='center' style='padding: 10px;'><h4>" . $num . "</h4></td>";
	echo "<td><textarea id='post$num' rows='2' cols='100' readonly>" . $text . "</textarea></td>";
	echo "<td align='center' style='padding: 10px;'><input type='button' name='copy$num' value='Copy to Clipboard' onclick='copyToClipboard(\"post$num\")'></td></tr>";
}

function console_log( $data ){
  echo '<script>console.log('. json_encode( $data ) . ')</script>';
}

# Constants
$bufferSize = 199;
$chatRegEx = '/^\/[deglmprstwy] /';

# Get the form action
$action = $_POST['submit'] ?? 'None';

# Maintain any values prior to the submit function
# otherwise set defaults for first run
$chatBuffer = $_POST['chat'] ?? '';
$continueChar = $_POST['continue'] ?? '>';
$format = $_POST['format'] ?? 'Emote';
$startFlag = $_POST['start'] ?? 'yes';

if ($action == 'Submit') {
	# Do some data cleansing on the chat buffer
	$chatBuffer = mb_ereg_replace('\s+', ' ', trim($chatBuffer));
	
	# Convert double hyphens to em dashes
	$chatBuffer = mb_ereg_replace('--', '—', $chatBuffer);
	
	printForm($chatBuffer, $continueChar, $startFlag, $format);
	
	# Setup post prefix and prime the output loop with initial values
	if ($format == 'Emote') {
		$postPrefix = '/e ';
	} else {
		$postPrefix = '';
	}
	$postNum = 1;
	$length = mb_strlen($chatBuffer);
	$workingBuffer = $chatBuffer;
	if( !preg_match($chatRegEx, $workingBuffer) ) {
		$workingBuffer = $postPrefix . $chatBuffer;
	}
	$workingString = mb_substr($workingBuffer,0,$bufferSize);
	if ($startFlag == 'yes') {
		$postPrefix = $postPrefix . $continueChar . ' ';
	}
	
	if ($length > 0) {
		echo "<center><hr><h3>Perfectly Parsed Posts</h3>";
		
		$continue = mb_strpos($workingString, $continueChar, min(25,mb_strlen($workingString)-1));
	
		echo "<table>";
		while ($length > $bufferSize or $continue != false) {
			# Allow a manual continue.
			# Otherwise put continue marker after the last space in workingString.
			if ($continue != false) {
				$workingString = mb_substr($workingString,0,$continue+1);
			} else {
				$continue = mb_strrpos(trim($workingString), ' ');
				# Protect against bizarre inputs with no (or not enough) spaces
				if ($continue === false or $continue <= 100) {
					$continue = $bufferSize - 2;
				}
				$workingString = mb_substr($workingString,0,$continue+1) . $continueChar;
			}
			
			printOutputBlock($workingString, $postNum);
			$postNum = $postNum + 1;
			$workingBuffer = ltrim(mb_substr($workingBuffer,$continue+1));
			if( !preg_match($chatRegEx, $workingBuffer) ) {
				$workingBuffer = $postPrefix . $workingBuffer;
			}
			$length = mb_strlen($workingBuffer);
			$workingString = mb_substr($workingBuffer,0,$bufferSize);
			if (mb_strlen($workingString) > 25) {
				$continue = mb_strpos($workingString, $continueChar, 25);
			} else {
				$continue = false;
			}
		}
		if ($workingBuffer != $postPrefix) {
			printOutputBlock($workingBuffer, $postNum);
		}
		echo "</table></center>";
	}
} else {
	printForm($chatBuffer, $continueChar, $startFlag, $format);
}
?>
</div>
<div id="footer">
<br><br>
Author: Lius Graysmoke / Nihlus Duskstalker of Tarnished Coast (US)<br>
(Version 1.4) Source code available on <a href="https://github.com/NihlusDuskstalker/gw2chatbufferbuddy">GitHub</a><br><br>
<center>Guild Wars, Guild Wars 2, Heart of Thorns, Guild Wars 2: Path of Fire, ArenaNet, NCSOFT, the Interlocking NC Logo, and all associated logos and designs are trademarks or registered trademarks of NCSOFT Corporation.<br>
Images owned by NCSOFT used in accordance with the <a href="https://www.guildwars2.com/en/legal/guild-wars-2-content-terms-of-use/">Guild Wars 2 Content Terms of Use</a>.</center>
</div>
</body>
</html>
