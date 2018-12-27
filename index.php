<!DOCTYPE html>
<html>
<head>
<title>Guild Wars 2 Chat Buffer Buddy</title>
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
<h1 style='color:#ffffff;'>
<table><tr>
<td><img src="theme/media/gw2.png" alt="Guild Wars 2 "></td>
<td style='vertical-align:top;'>Chat Buffer Buddy</td>
<tr></table>
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
	echo "<br><br>";
	echo "<label>Continue Marker: <select name='continue'>";
	foreach ($continueOpt as $opt) {
		echo "<option value='" . $opt . "'";
		if ($opt == $continueChar) echo " selected='selected'";
		echo ">" . $opt . "</option>";
	}
	echo "</select></label><br><br>";
	echo "Include Continue Marker at Start of New Line: ";
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
	echo "> Say/Party <br><br>";
	echo "<input type='submit' name='submit' value='Submit'>";
	echo "</form><br>";
	echo "</center>";
}

# Prints an output block, including the associated 'Copy to Clipboard' button
function printOutputBlock( $text, $num ) {
	echo "<tr><td>";
	echo "<textarea id='post$num' rows='2' cols='100' readonly>";
	echo $text;
	echo "</textarea></td>";
	echo "<td><input type='button' style='vertical-align:middle;' name='copy$num' value='Copy to Clipboard' onclick='copyToClipboard(\"post$num\")'>";
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
	
	$postNum = 1;
	$workingBuffer = $chatBuffer;
	$length = strlen($workingBuffer);
	
	echo "<table>";
	while ($length > $bufferSize) {
		$workingString = substr($workingBuffer,0,$bufferSize-1);
		$lastSpace = strrpos($workingString, ' ');
		
		# If you're going to try and break my code with ridiculous inputs,
		# I'm going to give you a ridiculous output.
		if ($lastSpace === false or $lastSpace <= 100) {
			$lastSpace = $bufferSize - 2;
		}
		
		$workingString = substr($workingString,0,$lastSpace+1) . $continueChar;
		printOutputBlock($workingString, $postNum);
		$postNum = $postNum + 1;
		$workingBuffer = $postPrefix . substr($workingBuffer,$lastSpace+1);
		$length = strlen($workingBuffer);
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
Author: Nihlus Duskstalker of  <a href="https://www.gw2tac.com/">Tyrian Adventures Coalition</a><br><br>
Guild Wars, Guild Wars 2, Heart of Thorns, Guild Wars 2: Path of Fire, ArenaNet, NCSOFT, the Interlocking NC Logo,<br>
and all associated logos and designs are trademarks or registered trademarks of NCSOFT Corporation.<br>
Images owned by NCSOFT used in accordance with the <a href="https://www.guildwars2.com/en/legal/guild-wars-2-content-terms-of-use/">Guild Wars 2 Content Terms of Use</a>.
</div>
</body>
</html>