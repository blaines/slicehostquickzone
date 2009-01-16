<?
################################################################################################
#	API ACCESS PHP/PY Copyright 2009 TechnologyAZ, LLC and Blaine Schanfeldt
#	Version 0 - 1/16/09
#	Code License:  	 MIT License - http://www.opensource.org/licenses/mit-license.php
#
#	REQUIRES pyactiveresource by Jared Kuolt - http://code.google.com/p/pyactiveresource/
################################################################################################
$apiaccess = "../apiaccess.py";	# This points to your apiaccess.py

if(!isset($_POST['apikey']) || !isset($_POST['domain'])) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Slicehost Quick Zone Maker</title>
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
input {
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
  <h1>slicehost quick zone creator</h1>
  <p>The quick zone creator will:<br />
    Create a new zone<br />
    <acronym title="ns1.slicehost.net
ns2.slicehost.net
ns3.slicehost.net">Create three NS records</acronym><br />
    Add an A record pointing to your slice<br />
    <acronym title="alt1.aspmx.l.google.com.
aspmx.l.google.com.
alt2.aspmx.l.google.com.
aspmx2.googlemail.com.
aspmx3.googlemail.com.
aspmx4.googlemail.com.
aspmx5.googlemail.com.">Creates Google Apps MX records (optional)</acronym><br />
    <acronym title="ghs.google.com.">Create 1 CNAME (webmail.yourdomain.tld &gt; ghs.google.com)</acronym><br />
    <acronym title="v=spf1 include:aspmx.googlemail.com ~all">Create 1 SPF TXT record</acronym> </p>
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
      <label for="else">Confirm</label>
      <p>MX Records for
        <label>
          <input type="radio" name="mxtype" value="2" id="mx0" checked="checked" />
          Google Apps</label>
        <label>
          <input type="radio" name="mxtype" value="1" id="mx1" />
          Internal (On this slice)</label>
        <label>
          <input type="radio" name="mxtype" value="0" id="mx0" />
          No email</label>
      </p>
      <label for="else"> </label>
      <label for="else">Confirm
        <input type="submit" value="Confirm" />
      </label>
    </form>
    <div style="clear:both"></div>
  </div>
</div>
<div style="position: absolute; bottom:0; width: 100%; font-size: 9px; color: #CCC;">
  <p align="center">&copy; Copyright 2009 TechnologyAZ, LLC and Blaine Schanfeldt</p>
</div>
</body>
</html>
<?
} else {
?>
<pre>
<?
foreach($_POST as $var => $val) {
	$CLEAN[$var] = addslashes(trim(trim($val,"~!@#$%^&*()_+=-`[]\;',<>?\\:\"{}|/")));
}
foreach($CLEAN as $key => $val) {
	if(empty($val) && $key != 'mxtype') die("<pre>$key seems to be invalid</pre>");
}

if(`/usr/bin/python $apiaccess {$CLEAN['apikey']} {$CLEAN['domain']} {$CLEAN['ip']} {$CLEAN['mxtype']}`==1) {
	echo "<pre>Success!</pre>";
} else {
	echo "<pre>Failure!</pre>";
}
?>
</pre>
<?
}
?>
</body>
</html>