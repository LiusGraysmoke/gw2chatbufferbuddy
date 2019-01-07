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
# Prints the main form for entering inputs and configuring output
function printForm($chatBuffer, $continueChar, $startFlag, $format) {
	$continueOpt = array('>', '+', '-');
	echo "<center>";
	echo "<form action='index.php' method='post'>";
	echo "<textarea name='chat' rows='10' cols='100'>";
	echo $chatBuffer;
	echo "</textarea>";
	echo "<br>";
	echo "<table><tr>";
	echo "<td style='padding: 20px;'><label>Continue Marker: <select name='continue'>";
	foreach ($continueOpt as $opt) {
		echo "<option value='" . $opt . "'";
		if ($opt == $continueChar) echo " selected='selected'";
		echo ">" . $opt . "</option>";
	}
	echo "</select></label><br><br>";
	echo "Continue Marker at Start of New Line: ";
	echo "<input type='radio' name='start' value='yes'";
	if ($startFlag == 'yes') {
		echo " checked";
	}
	echo "> Yes ";
	echo "<input type='radio' name='start' value='no'";
	if ($startFlag == 'no') {
		echo " checked";
	}
	echo "> No <br><br>";
	echo "Post Format: ";
	echo "<input type='radio' name='format' value='Emote'";
	if ($format == 'Emote') {
		echo " checked";
	}
	echo "> Emote ";
	echo "<input type='radio' name='format' value='Say'";
	if ($format == 'Say') {
		echo " checked";
	}
	echo "> Say/Party</td>";
	echo "<td align='center' style='padding: 20px;'><input type='submit' name='submit' value='Submit'></td>";
	echo "</tr></table>";
	echo "</form><br>";
	echo "</center>";
}

# Prints an output block, including the associated 'Copy to Clipboard' button
function printOutputBlock( $text, $num ) {
	echo "<tr><td>";
	echo "<textarea id='post$num' rows='2' cols='100' readonly>";
	echo $text;
	echo "</textarea></td>";
	echo "<td align='center' style='padding: 10px;'><input type='button' name='copy$num' value='Copy to Clipboard' onclick='copyToClipboard(\"post$num\")'>";
	echo "</td></tr>";
}

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

# Constants
$bufferSize = 199;

# Get the form action
$action = $_POST['submit'] ?? 'None';

# Maintain any values prior to the submit function
# otherwise set defaults for first run
$chatBuffer = $_POST['chat'] ?? '/e ';
$continueChar = $_POST['continue'] ?? '>';
$format = $_POST['format'] ?? 'Emote';
$startFlag = $_POST['start'] ?? 'yes';

# Setup post prefix
if ($format == 'Emote') {
	$postPrefix = '/e ';
} else {
	$postPrefix = '';
}
if ($startFlag == 'yes') {
	$postPrefix = $postPrefix . $continueChar . ' ';
}

if ($action == 'Submit') {
	# Do some data cleansing on the chat buffer
	$chatBuffer = preg_replace('/\s+/', ' ', trim($chatBuffer));
	
	printForm($chatBuffer, $continueChar, $startFlag, $format);

	echo "<center><hr><h3>Perfectly Parsed Posts</h3>";
	
	# Prime the output loop with initial values
	$postNum = 1;
	$workingBuffer = $chatBuffer;
	$length = strlen($workingBuffer);
	$workingString = substr($workingBuffer,0,$bufferSize);
	$continue = strpos($workingString, $continueChar, min(25,strlen($workingString)-1));
	
	echo "<table>";
	while ($length > $bufferSize or $continue != false) {
		# Allow a manual continue.
		# Otherwise put continue marker after the last space in workingString.
		if ($continue != false) {
			$workingString = substr($workingString,0,$continue+1);
		} else {
			$continue = strrpos(trim($workingString), ' ');
			# Protect against bizarre inputs with no (or not enough) spaces
			if ($continue === false or $continue <= 100) {
				$continue = $bufferSize - 2;
			}
			$workingString = substr($workingString,0,$continue+1) . $continueChar;
		}
		
		printOutputBlock($workingString, $postNum);
		$postNum = $postNum + 1;
		$workingBuffer = $postPrefix . ltrim(substr($workingBuffer,$continue+1));
		$length = strlen($workingBuffer);
		$workingString = substr($workingBuffer,0,$bufferSize);
		$continue = strpos($workingString, $continueChar, min(25,strlen($workingString)-1));
	}
	printOutputBlock($workingBuffer, $postNum);
	echo "</table></center>";
} else {
	printForm($chatBuffer, $continueChar, $startFlag, $format);
}
?>
</div>
<div id="footer">
<br><br>
Author: Nihlus Duskstalker of  <a href="https://www.gw2tale.com/">The Tyrian Adventure League</a><br>
(Version 1.2) Source code available on <a href="https://github.com/NihlusDuskstalker/gw2chatbufferbuddy">GitHub</a><br><br>
<center>Guild Wars, Guild Wars 2, Heart of Thorns, Guild Wars 2: Path of Fire, ArenaNet, NCSOFT, the Interlocking NC Logo, and all associated logos and designs are trademarks or registered trademarks of NCSOFT Corporation.<br>
Images owned by NCSOFT used in accordance with the <a href="https://www.guildwars2.com/en/legal/guild-wars-2-content-terms-of-use/">Guild Wars 2 Content Terms of Use</a>.</center>
</div>
</body>
</html>
