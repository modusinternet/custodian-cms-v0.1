<?php
header("Content-Type: text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(!($_SERVER["SCRIPT_NAME"] == "/index.php")) {
	echo "This script can not be called directly.";
	die();
}

@include "ccmspre/config.php";
?><!DOCTYPE html>
<html id="no-fouc" lang="en" style="opacity: 0;">
	<head>
		<meta charset="utf-8">
		<title>Custodian CMS v<?php echo $CFG["VERSION"];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- Favicons -->
		<link rel="shortcut icon" href="/ccmstpl/examples/img/icons/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/ccmstpl/examples/img/icons/favicon.ico" type="image/x-icon">

		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries.
		WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<style type="text/css">
			.oj { color: rgb(236, 127, 39); }
			.td-ul { text-decoration: underline; }
			.td-dul {
				text-decoration: underline;
				border-bottom: 1px solid rgb(236, 127, 39);
			}
			.pass { font-size: 150%; color: rgb(134, 177, 53); }
		</style>
	</head>
	<body>
		<a href="/" style="text-decoration: none; border: 0 none;">
			<img alt="Custodian CMS Banner.  Easy gears no spilled beers." class="img-responsive" title="Custodian CMS Banner.  Easy gears no spilled beers." src="/ccmsusr/_img/ccms-logo-banner-large-en.png" />
		</a><br />
		<div class="panel-body">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" style="margin-bottom: 20px; ">
				<li class="active"><a href="#welcome" data-toggle="tab" aria-expanded="true">Welcome</a>
				</li>
				<li><a href="#setup_instructions" data-toggle="tab" aria-expanded="false">Setup Instructions</a>
				</li>
				<li><a href="#step_results" data-toggle="tab" aria-expanded="false">Setup Results</a>
				</li>
				<li><a href="#copyright" data-toggle="tab" aria-expanded="false">Copyright</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane fade active in" id="welcome">
					<p style="text-indent: 1.5em;">
						Welcome to Custodian CMS, <span class="oj">@Version <?php echo $CFG["VERSION"];?> (Release Date: <?php echo $CFG["RELEASE_DATE"];?>)</span>.  This page is designed to help test your server environment, check your configuration template, import example database content and help establish your first administrator.  Once everything is properly configured and the setup process is complete, you will need to either <span class="oj">rename or remove the /setup.php template from your server to continue</span>.
					</p>
					<p style="text-indent: 1.5em;">
						For more information visit <a class="td-ul" style="word-wrap: break-word;" href="//modusinternet.com/en/products/custodian-cms.html" target="_blank">http://modusinternet.com/en/products/custodian-cms.html</a>.
					</p>
				</div>
				<div class="tab-pane fade" id="setup_instructions">
					<p style="margin-top: 20px;">
						To fully activate your new templates you need to manually complete some of the following steps.  We do not automate most of this process in order to make sure it never becomes a target for hackers.  The following shows the test order and a brief description of what is needed to pass each test.  If you are familiar with the steps listed below click the <a class="oj td-ul href-to-step-results" href="#step_results">Setup Results</a> tab to see your results now.
					</p>
					<ol>
						<li>Custodian CMS requires PHP v5.3.7+ and MySQL v4.1+ to run properly.</li>
						<li>Make a copy of <span class="oj">/ccmspre/config_original.php</span> and name it <span class="oj">/ccmspre/config.php</span>.  Then update it with all your domain name and database settings.</li>
						<li>Make a copy of <span class="oj">/ccmspre/whitelist_public_original.php</span> and name it <span class="oj">/ccmspre/whitelist_public.php</span>.</li>
						<li>Make a copy of <span class="oj">/ccmspre/whitelist_user_original.php</span> and name it <span class="oj">/ccmspre/whitelist_user.php</span>.</li>
						<li>Import the contents of the <span class="oj">/ccms-db-setup.sql</span> file into your database manually (ie: using PHPMyAdmin) or go to <a class="oj td-ul href-to-step-results" href="#step_results">Setup Results</a> <i class="fa fa-angle-double-right"></i> <span class="oj">Test for database content</span> and use the "<span class="oj">Click here</span>" link to automatically do it for you.</li>
						<li>Add an administrator using the <a class="oj td-ul href-to-step-results" href="#step_results">Setup Results</a> <i class="fa fa-angle-double-right"></i> <span class="oj">Test for Administrator</span> form if you need one.</li>
						<li>Delete or rename the <span class="oj">/setup.php</span> file and reload this page.</li>
					</ol>
					<p>
						For more information or documentation about Custodian CMS <a class="ul" href="http://modusinternet.com/en/products/custodian-cms.html" target="_blank">click here</a>.
					</p>
				</div>
				<div class="tab-pane fade" id="step_results">
					<p style="text-indent: 1.5em;">
						Click any of the colored bars below to learn more about each test.
					</p>
					<div class="panel-body">
						<div class="panel-group" id="accordion" role="tablist">

<?php if(version_compare(phpversion(), '5.3.7', '>=')) { $CFG["pass"]=1; } else { $CFG["pass"]=0; } ?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#1" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for minimum <span class="oj">PHP v5.3.7+</span>
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="1" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass (v<?php echo phpversion(); ?>)
<?php else: ?>
										The version of PHP on your server does not appear to be high enough. (<?php echo phpversion(); ?>)
<?php endif ?>
									</div>
								</div>
							</div>

<?php if(file_exists("ccmspre/config.php")) { $CFG["pass"] = 1; } else { $CFG["pass"] = 0; } ?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#2" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for <span class="oj">/ccmspre/config.php</span> template
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="2" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass
<?php else: ?>
										Make a copy of /ccmspre/config_original.php, name it /ccmspre/config.php, update the domain name, database settings and reload this page.
<?php endif ?>
									</div>
								</div>
							</div>

<?php if(file_exists("ccmspre/whitelist_public.php")) { $CFG["pass"] = 1; } else { $CFG["pass"] = 0; } ?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#3" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for <span class="oj">/ccmspre/whitelist_public.php</span> template
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="3" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass
<?php else: ?>
										Make a copy of /ccmspre/whitelist_public_original.php, name it /ccmspre/whitelist_public.php and reload this page.
<?php endif ?>
									</div>
								</div>
							</div>

<?php if(file_exists("ccmspre/whitelist_user.php")) { $CFG["pass"] = 1; } else { $CFG["pass"] = 0; } ?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#4" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for <span class="oj">/ccmspre/whitelist_user.php</span> template
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="4" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass
<?php else: ?>
										Make a copy of /ccmspre/whitelist_user_original.php, name it /ccmspre/whitelist_user.php and reload this page.
<?php endif ?>
									</div>
								</div>
							</div>

<?php if($CFG["DOMAIN"]) { $CFG["pass"] = 1; } else { $CFG["pass"] = 0; } ?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#5" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for <span class="oj">domain name</span> inside <span class="oj">/ccmspre/config.php</span>
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="5" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass
<?php else: ?>
										Open the /ccmspre/config.php template, update the $CFG["DOMAIN"] field with your websites domain name, ie: $CFG["DOMAIN"] = "YOURDOMAIN.COM"; and reload this page.
<?php endif ?>
									</div>
								</div>
							</div>

<?php if($CFG["DB_HOST"] && $CFG["DB_USERNAME"] && $CFG["DB_PASSWORD"] && $CFG["DB_NAME"]) { $CFG["pass"] = 1; } else { $CFG["pass"] = 0; } ?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#6" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for <span class="oj">database settings</span> inside <span class="oj">/ccmspre/config.php</span>
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="6" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass
<?php else: ?>
										Open the /ccmspre/config.php template, update the $CFG["DB_HOST"], $CFG["DB_USERNAME"], $CFG["DB_PASSWORD"], $CFG["DB_NAME"] fields with your database settings and reload this page to test again.
<?php endif ?>
									</div>
								</div>
							</div>

<?php
$host	= $CFG["DB_HOST"];
$dbname	= $CFG["DB_NAME"];
$user	= $CFG["DB_USERNAME"];
$pass	= $CFG["DB_PASSWORD"];
try {
	$CFG["DBH"] = @new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, array(PDO::ATTR_PERSISTENT => true));
	$CFG["DBH"]->exec("SET CHARACTER SET utf8");
	$CFG["DBH"]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$CFG["pass"] = 1;
} catch(PDOException $e) {
	$CFG["pass"] = 0;
	$msg = $e->getCode() . ' ' . $e->getMessage();
}
?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#7" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test <span class="oj">connect</span> to <span class="oj">database</span>
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="7" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass
<?php else: ?>
										<?php echo $msg; ?>
<?php endif ?>
									</div>
								</div>
							</div>

<?php
if($CFG["DBH"]) {
	$val = @$CFG["DBH"]->getAttribute(constant("PDO::ATTR_SERVER_VERSION"));
	$valArray = explode("-", $val);
	if($valArray[0] >= 4.1) {
		$CFG["pass"] = 1;
	} else {
		$CFG["pass"] = 0;
		$msg = "The version of MySQL on your server does not appear to be high enough.  (v" . $valArray[0] . ")  If you attempt to run Custodian CMS in this environment you may experience problems.  Continue at your own risk.";
	}
} else {
	$CFG["pass"] = 0;
	$msg = "Not tested because no database connection established.";
}
?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#8" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for minimum <span class="oj">MySQL v4.1+</span>
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="8" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass (v<?php echo $valArray[0]; ?>)
<?php else: ?>
										<?php echo $msg; ?>
<?php endif ?>
									</div>
								</div>
							</div>

<?php
if($CFG["DBH"]) {
	$CFG["pass"] = 1;
	if($_SERVER["REQUEST_URI"] == "/?import=1") {
		if(strstr($_SERVER["HTTP_REFERER"], $CFG["DOMAIN"])) {
			try {
				// This try call helps handle situations where /?import=1 is called more then once, most likely accidentally by hitting the reload button.
				$CFG["DBH"]->query("DESCRIBE `ccms_blacklist`");
				$CFG["DBH"]->query("DESCRIBE `ccms_ins_db`");
				$CFG["DBH"]->query("DESCRIBE `ccms_lng_charset`");
				$CFG["DBH"]->query("DESCRIBE `ccms_session`");
				$CFG["DBH"]->query("DESCRIBE `ccms_user`");
			} catch(PDOException $e) {
				$CFG["DBH"]->query("DROP TABLE IF EXISTS `ccms_blacklist`, `ccms_ins_db`, `ccms_lng_charset`, `ccms_session`, `ccms_user`");
				$CFG["DBH"]->exec(file_get_contents('ccms-db-setup.sql'));
			}
		} else {
			exit('<script>alert("No direct script access allowed");</script>');
			die();
		}
	}
	try {
		$CFG["DBH"]->query("DESCRIBE `ccms_blacklist`");
		$msg = "ccms_blacklist: FOUND<br />";
	} catch(PDOException $e) {
		$CFG["pass"] = 0;
		$msg = "ccms_blacklist: <span class='oj'>NOT FOUND</span><br />";
	}
	try {
		$CFG["DBH"]->query("DESCRIBE `ccms_ins_db`");
		$msg .= "ccms_ins_db: FOUND<br />";
	} catch(PDOException $e) {
		$CFG["pass"] = 0;
		$msg .= 'ccms_ins_db: <span class="oj">NOT FOUND</span><br />';
	}
	try {
		$CFG["DBH"]->query("DESCRIBE `ccms_lng_charset`");
		$msg .= "ccms_lng_charset: FOUND<br />";
	} catch(PDOException $e) {
		$CFG["pass"] = 0;
		$msg .= 'ccms_lng_charset: <span class="oj">NOT FOUND</span><br />';
	}
	try {
		$CFG["DBH"]->query("DESCRIBE `ccms_session`");
		$msg .= "ccms_session: FOUND<br />";
	} catch(PDOException $e) {
		$CFG["pass"] = 0;
		$msg .= 'ccms_session: <span class="oj">NOT FOUND</span><br />';
	}
	try {
		$CFG["DBH"]->query("DESCRIBE `ccms_user`");
		$msg .= "ccms_user: FOUND<br />";
	} catch(PDOException $e) {
		$CFG["pass"] = 0;
		$msg .= 'ccms_user: <span class="oj">NOT FOUND</span><br />';
	}
} else {
	$CFG["pass"] = 0;
	$msg = "Not tested because no database connection established.";
}
?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#9" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for <span class="oj">database content</span>
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="9" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass
<?php else: ?>
										<?php echo $msg; ?>
										<a class="oj td-ul" href="/?import=1" onclick="return confirm('Are you sure?')">Click here</a> to import the <a class="oj td-ul" data-toggle="popover" data-container="body" type="button" data-content='There should be a file named <span class="oj">ccms-db-setup.sql</span> in the document root of this website.  It contains a copy of all the starter tables and the content required to setup a Custodian CMS project from scratch.  If you are missing this file you can get a copy of it from <a class="oj  td-ul" href="//github.com/modusinternet/Custodian-CMS/blob/master/ccms-db-setup.sql" target="_blank">GitHub</a>.  Just save the file to the document root folder of your website and reload this page to continue.<br /><br />We recommend you either delete or rename this file, along with the setup.php template, when you are done.' data-trigger="click" id="ccms-db-setup" style="cursor: pointer;">required database tables <i class="fa fa-hand-o-up"></i></a> now.  <span class='oj'>WARNING</span>: This process will remove and fully replace <span class="oj td-dul">ALL</span> database tables that may already exist under the same name.  So be sure to back up and rename any tables you do not want to loose before preforming this action.
<?php endif ?>
									</div>
								</div>
							</div>

<?php
if($CFG["DBH"]) {
	$CFG["pass"] = 1;
	if($_REQUEST["addSuper"] == 1) {
		if(strstr($_SERVER["HTTP_REFERER"], $CFG["DOMAIN"])) {
			// This call helps handle situations where it is called more then once, most likely accidentally by hitting the reload button.
			$count = $CFG["DBH"]->query("SELECT count(*) FROM `ccms_user` WHERE `super` = 1 LIMIT 1")->fetchColumn();
			if($count == 0) {
				// Hash the password and add the new super user.
				// See https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/ for more details.
				$cost = 10;
				$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
				$salt = sprintf("$2a$%02d$", $cost) . $salt;
				$hash = crypt($_REQUEST["password"], $salt);
				$qry = $CFG["DBH"]->prepare("INSERT INTO `ccms_user` (`email`, `hash`, `status`, `alias`, `super`) VALUES (:email, :hash, '1', :alias, '1');");
				$qry->execute(array(':email' => $_REQUEST["email"], ':hash' => $hash, ':alias' => $_REQUEST["alias"]));
			}
		} else {
			exit('<script>alert("No direct script access allowed");</script>');
			die();
		}
	}
	try {
		$CFG["DBH"]->query("DESCRIBE `ccms_user`");
	} catch(PDOException $e) {
		$CFG["pass"] = 0;
		$msg = 'Not tested because ccms_user: <span class="oj">NOT FOUND</span>';
	}
	if($CFG["pass"] == 1) {
		$count = $CFG["DBH"]->query("SELECT count(*) FROM `ccms_user` WHERE `super` = 1 LIMIT 1")->fetchColumn();
		if($count == 0) {
			$CFG["pass"] = 0;
			$CFG["pass2"] = 1;
		}
	}
} else {
	$CFG["pass"] = 0;
	$msg = "Not tested because no database connection established.";
}
?>
							<div class="panel panel-<?php echo ($CFG["pass"]==1) ? "success" : "danger"; ?>">
								<div aria-expanded="false" class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#10" role="tab" style="cursor: pointer;">
									<h4 class="panel-title">
										Test for <span class="oj">Administrator</span>
										<i class="fa fa-angle-double-down" style="float: right;"></i>
									</h4>
								</div>
								<div id="10" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" style="height: 0px;">
									<div class="panel-body">
<?php if($CFG["pass"]==1): ?>
										Pass
<?php else: ?>
<?php if($CFG["pass2"]==1): ?>
										No Administrator found in the ccms_user table.  Add one now.<br />
										<form action="/" id="addSuperUserForm" method="post" novalidate="novalidate">
											<input type="hidden" name="addSuper" value="1">
											<div id="login-status" style="color:#ec7f27; font-weight:bold;"></div>
											<div class="form-group">
												<label for="alias">Alias *</label>
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
													<input class="form-control placeholder" id="alias" name="alias" placeholder="Account Alias" type="text">
												</div>
											</div>
											<div class="form-group">
												<label for="email">Email *</label>
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
													<input class="form-control placeholder" id="email" name="email" placeholder="Email" type="email">
												</div>
											</div>
											<div class="form-group">
												<label for="password">Password *</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-key"></i></div>
													<input class="form-control placeholder" id="password" name="password" placeholder="Password" type="password">
												</div>
											</div>
											<button type="submit" class="btn btn-lg btn-success btn-block">Submit</button>
										</form>
<?php else: ?>
										<?php echo $msg; ?>
<?php endif ?>
<?php endif ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<p style="text-indent: 1.5em;">
						If all the tests above are successful, <span class="alert alert-success" style="font-weight: 600;">GREEN</span>, all you need to do next is delete or rename the <span class="oj">/setup.php</span> file and reload this page.
					</p>
				</div>
				<div class="tab-pane fade" id="copyright">
					<h1>The MIT License (MIT)</h1>
					Copyright &copy; <?php echo date("Y");?> <a href="http://modusinternet.com" target="_blank">Modus Internet</a>
					<p>
						Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
						<br />
						The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
						<br />
						THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
					</p>
				</div>
			</div>
		</div>

		<p style="margin:10px 10px;">
			Copyright &copy; <?php echo date("Y");?> <a href="http://modusinternet.com" target="_blank">Modus Internet</a>, all rights reserved.
		</p>

		<script>
			function loadFirst(e,t){var a=document.createElement("script");a.async = true;a.readyState?a.onreadystatechange=function(){("loaded"==a.readyState||"complete"==a.readyState)&&(a.onreadystatechange=null,t())}:a.onload=function(){t()},a.src=e,document.body.appendChild(a)}

			var cb = function() {
				var l = document.createElement('link'); l.rel = 'stylesheet';
				l.href = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css';
				var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);

				var l = document.createElement('link'); l.rel = 'stylesheet';
				//l.href = '/ccmsusr/_css/custodiancms.css';
				l.href = '/ccmsusr/_css/custodiancms.min.css';
				var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);

				var l = document.createElement('link'); l.rel = 'stylesheet';
				l.href = '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css';
				var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);

				var l = document.createElement('link'); l.rel = 'stylesheet';
				l.href = '//fonts.googleapis.com/css?family=Open+Sans:300';
				var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);
			};
			var raf = <?php include "ccmsusr/browser.php"; ?>
			if (raf) raf(cb);
			else window.addEventListener('load', cb);

			function loadJSResources() {
				loadFirst("//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js", function(){ // JQuery is loaded
					loadFirst("//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js", function(){ // Bootstrap is loaded
						//loadFirst("/ccmsusrv/_js/custodiancms.js", function(){ // CustodianCMS JavaScript
						loadFirst("/ccmsusr/_js/custodiancms.min.js", function(){ // CustodianCMS JavaScript

							// Fade in web page.
							$("#no-fouc").delay(250).animate({"opacity": "1"}, 250);

							$('#ccms-db-setup').popover({
								html:true,
								placement:'top'
							});

							$('.href-to-step-results').click(function (e) {
								e.preventDefault();
								var a = $('a[href="' + $(this).attr('href') + '"]');
								a.tab('show');
								a.scrollView();
							})

							loadFirst("//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js", function(){ // jquery.validate.js is loaded
								loadFirst("//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js", function(){ // additional-methods.js is loaded

									$.validator.addMethod(
										"badCharRegex",
										function(value, element, regexp) {
											var re = new RegExp(regexp);
											return this.optional(element) || re.test(value);
										},
										"Please check your input."
									);

									$('#addSuperUserForm').validate({
										rules: {
											alias: {
												required: true,
												minlength: 4,
												maxlength: 32,
												badCharRegex: /^[^\<\>&#]+$/i
											},
											email: {
												required: true,
												email: true,
												maxlength: 255
											},
											password: {
												required: true,
												minlength: 8,
												//badCharRegex: "^[^\<\>\&\#]+$"
											}
										},
										messages: {
											alias: {
												required: "This field is required.",
												minlength: "This field has a minimum length of 4 characters or more.",
												maxlength: "This field has a maximum length of 32 characters or less.",
												badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
											},
											email: {
												required: "Please enter a valid email address.",
												maxlength: "Please try to keep your email address to 255 characters or less."
											},
											password: {
												required: "Please enter your password.",
												minlength: "Passwords must be at least 8 characters in length.",
												badCharRegex: "The following characters are not permited in this field. &gt; &lt; &amp; &#35; Please remove before submitting."
											}
										}
									});
								});
							});
						});
					});
				});
			}

			if (window.addEventListener)
				window.addEventListener("load", loadJSResources, false);
			else if (window.attachEvent)
				window.attachEvent("onload", loadJSResources);
			else window.onload = loadJSResources;
		</script>
	</body>
</html>