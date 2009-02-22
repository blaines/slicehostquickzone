<?
################################################################################################
#	Slicehost Quick Zone Creator - Copyright 2009 TechnologyAZ, LLC and Blaine Schanfeldt
#	Version 1.00 - 2/22/09
#	Code License:  	 MIT License - http://www.opensource.org/licenses/mit-license.php
#
#	REQUIRES pyactiveresource by Jared Kuolt - http://code.google.com/p/pyactiveresource/
################################################################################################
$apiaccess = "../../shqz100.py";	# This points to the api script - store the api script in a safe directory (non-public)

#					Name of template file = MUST BE IN SAME LOCATION AS $apiaccess
#					\/\/\/\/	Template Name
$templates = array('template'=>'Demo Template',
				   'template'=>'Demo Template',
				   'template'=>'Demo Template',);

if(!isset($_POST['apikey']) || !isset($_POST['domain'])) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Slicehost Quick Zone Creator</title>
<style type="text/css">
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	background-color:#fcfcfb;
	margin: 0;
	padding: 0;
}
.head {
	margin: 0 auto;
	width: 40em;
}
.head h1 {
	margin: 0;
}
.head h1 sub {
	font-weight: normal;
	font-size: .5em;
}
.head h2 {
	margin: 0;
	font-size: 1em;
}
.head h2 sub {
	font-weight: normal;
	font-size: .5em;
}
.head p {
	font-size: .75em;
}
.formdiv {
	margin: 0 auto;
	width: 38em;
}
.formwrapper {
	margin: 1em;
	border: #E2E2E2 1em solid;
	padding: 1em;
}
form {
	color:#333333;
	font-size:70%;
	font-weight:normal;
}
label {
	display: block;
	width: 100%;
	text-align: left;
	float: left;
	clear:left;
	border-bottom: #CCC 1px solid;
}
input, select {
	display:block;
	float:right;
	width: 30em;
	font-size: 1.5em;
}
input[type="radio"] {
	width: 1em;
	float: left;
}
</style>
</head>
<body>
<div class="head">
  <h1>slicehost quick zone creator <sub><a href="http://github.com/technologyaz/slicehostquickzone/">@ GitHub!</a></sub></h1>
  <p> This is a working version, but if you want to modify this for your own use check out <a href="http://github.com/technologyaz/slicehostquickzone/">github</a> for both commandline and GUI versions. ( <a href="http://github.com/technologyaz/slicehostquickzone/zipball/master">ZIP</a> - <a href="http://github.com/technologyaz/slicehostquickzone/tarball/master">TAR</a> )</p>
  <h2>NEW 2/22/09 - Templates!</h2>
  <p>Templates are a robust and simple way to standardize your zone configurations. Submit your zone template by posting it in the forums and I'll add it to the demo.</p>
</div>
<div class="formdiv">
  <div class="formwrapper">
    <p><strong>Warning</strong>: It is recommended that you either disable api access or create a new api key after the process is complete.</p>
    <form method="post" action="">
      <label>API Key:
        <input type="text" name="apikey" />
      </label>
      <label>Domain Name:
        <input type="text" name="domain" />
      </label>
      <label>Server/Slice IP:
        <input type="text" name="ip" />
      </label>
      <label for="else">Zone Template</label>
   	  <label>
      	  <select name="template" id="template">
<?
foreach($templates as $k => $v) {
?>
      	    <option value="<?=$k?>"><?=$v?></option>
<?
}
?>
        </select>
   	  </label>
   	  <label for="else"> </label>
      <label for="else">Confirm
        <input type="submit" value="Confirm" />
      </label>
    </form>
    <div style="clear:both"></div>
  </div>
</div>
<div style="position: absolute; bottom:0; width: 100%; font-size: 9px; color: #CCC;">
  <p align="center">Version 1.00</p>
  <p align="center">&copy; Copyright 2009 TechnologyAZ, LLC and Blaine Schanfeldt</p>
</div>
<script type="text/javascript" src="http://include.reinvigorate.net/re_.js"></script><script type="text/javascript">re_("565f0-p68368mz2b");</script>
</body>
</html>
<?
} else {
foreach($_POST as $var => $val) {
	$CLEAN[$var] = addslashes(trim(trim($val,"~!@#$%^&*()_+=-`[]\;',<>?\\:\"{}|/")));
}
foreach($CLEAN as $key => $val) {
	if(empty($val) && $key != 'mxtype') die("<pre>$key seems to be invalid</pre>");
}

$exec = "/usr/bin/python $apiaccess {$CLEAN['apikey']} {$CLEAN['domain']} {$CLEAN['ip']} {$CLEAN['template']}";

if(exec($exec,$reply)) {
	$log = "";
	foreach($reply as $val) {
		$log .= $val."\n";
	}
	$html = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Slicehost Quick Zone Creator - Success!</title>
</head>
<body>
<pre>
<h1>Success!</h1>
$log
</pre>
<a href="./">Add Another</a>
<script type='text/javascript' src='http://include.reinvigorate.net/re_.js'></script><script type='text/javascript'>var re_purchase_tag = true;var re_name_tag = '{$CLEAN['domain']}';var re_context_tag = 'http://{$CLEAN['domain']} - Success';re_('565f0-p68368mz2b');</script>
</body>
</html>
HTML;
echo $html;
} else {
	$html = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Slicehost Quick Zone Creator - Failure!</title>
</head>
<body>
<pre>
<h1>Failure!</h1>
-Make sure the zone does not already exist.
-Make sure the API key is valid.
-Make sure the template file is valid.
</pre>
<a href="./">Go Back</a>
<script type='text/javascript' src='http://include.reinvigorate.net/re_.js'></script><script type='text/javascript'>var re_purchase_tag = true;var re_name_tag = '{$CLEAN['domain']}';var re_context_tag = 'http://{$CLEAN['domain']} - Failure';re_('565f0-p68368mz2b');</script>
</body>
</html>
HTML;
echo $html;
}
}
?>
