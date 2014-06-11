<?
define('CRYPT', '/^[a-z-_/#=&:\pN\?\.\";\'\`\*\s]*\z/i');
define('HTTP_ACCEPT_LANGUAGE', '/^[a-z0-9-,;=\.]{2,}\z/i');
define('HTTP_COOKIE', '/^[a-z0-9-_=\.]{1,}\z/i');
define('LNG', '/^[a-z]{2}(-[a-z]{2})?\z/i');
define('PARMS', '/^[a-z-_\pN/]+\z/i');
define('QUERY_STRING', '/^[a-z\pN-_=&\?\.\/]{1,}\z/i');
define('SESSION_ID', '/^[a-z\pN]{1,}\z/i');
define('TPL', '/^[a-z-\pN\.\/]*\z/i');

define('UTF8_STRING_WHITE', '/^[\pL\pM\s]*\z/u');
// ^ Start of line
// [ Starts the character class.
// \pL Any kind of letter from any language.
// \pM Mark.  (*** A character intended to be combined with another character (e.g. accents, umlauts, enclosing boxes, etc.). ***)
// \s Whitespaces.
// ] Ends the character class.
// * zero or more
// \z End of subject or newline at end. (Better then $ because $ does not include /n characters at the end of a line.)
// /u Pattern strings are treated as UTF-8

define('UTF8_STRING_DIGIT_WHITE', '/^[\pL\pM\pN\s]*\z/u');
// ^ Start of line
// [ Starts the character class.
// \pL Any kind of letter from any language.
// \pM Mark.  (*** A character intended to be combined with another character (e.g. accents, umlauts, enclosing boxes, etc.). ***)
// \pN Any number.
// \s Whitespaces.
// ] Ends the character class.
// * zero or more
// \z End of subject or newline at end. (Better then $ because $ does not include /n characters at the end of a line.)
// /u Pattern strings are treated as UTF-8

define('UTF8_STRING_DIGIT_PUNC_WHITE', '/^[\pL\pM\pN\pP\s]*\z/u');
// ^ Start of line
// [ Starts the character class.
// \pL Any kind of letter from any language.
// \pM Mark.  (*** A character intended to be combined with another character (e.g. accents, umlauts, enclosing boxes, etc.). ***)
// \pN Any number.
// \pP Punctuation. (*** Does not include ~$^+=|<> symbols. ***)
// \s Whitespaces.
// ] Ends the character class.
// * zero or more
// \z End of subject or newline at end. (Better then $ because $ does not include /n characters at the end of a line.)
// /u Pattern strings are treated as UTF-8

$ccms_whitelist = array(
	"ccms_lngSelect"		=> array("type" => "LNG",					"maxlength"	=> 5),
	"ccms_parms"			=> array("type" => "PARMS",					"maxlength"	=> 128),
	"ccms_tpl"				=> array("type" => "TPL",					"maxlength"	=> 256),
	"ccms_vid"				=> array("type" => "SESSION_ID",			"maxlength"	=> 64),
	"ccms_cid"				=> array("type" => "SESSION_ID",			"maxlength"	=> 64),
	"ccms_lng"				=> array("type" => "LNG",					"maxlength"	=> 5),
	"HTTP_ACCEPT_LANGUAGE"	=> array("type" => "HTTP_ACCEPT_LANGUAGE",	"maxlength"	=> 256),
	"HTTP_COOKIE"			=> array("type" => "HTTP_COOKIE",			"maxlength"	=> 256),
	"QUERY_STRING"			=> array("type" => "QUERY_STRING",			"maxlength"	=> 1024),
);


function CCMS_setLng() {
	global $CFG, $CLEAN;
	if(isset($CLEAN["HTTP_COOKIE"]) && $CLEAN["HTTP_COOKIE"] != "" && $CLEAN["HTTP_COOKIE"] != "MAXLEN" && $CLEAN["HTTP_COOKIE"] != "INVAL") {
		// There is a valid HTTP_COOKIE variable.
		$cookieLng = explode("=", $CLEAN["HTTP_COOKIE"]);
		foreach($cookieLng as $cookieLng2) {
			$cookieLng3 = explode("=", $cookieLng2);
			if($cookieLng3[0] == "ccms_lng") {
				if(preg_match('/^[a-z]{2}(-[a-z]{2})?\z/i', $cookieLng3[1], $matches)) {
					$CLEAN["ccms_lng"] = $matches[0];
				}
				break;
			}
		}
	}
	if(isset($CLEAN["QUERY_STRING"]) && $CLEAN["QUERY_STRING"] != "" && $CLEAN["QUERY_STRING"] != "MAXLEN" && $CLEAN["QUERY_STRING"] != "INVAL") {
		// There is a valid QUERY_STRING variable.
		$queryArray = explode("&", $CLEAN["QUERY_STRING"]);
		foreach($queryArray as $queryArray2) {
			$queryArray3 = explode("=", $queryArray2);
			if($queryArray3[0] == "ccms_lng") {
				if(preg_match('/^[a-z]{2}(-[a-z]{2})?\z/i', $queryArray3[1], $matches)) {
					$CLEAN["ccms_lng"] = $matches[0];
				}
				break;
			}
		}
	}
	if($CLEAN["ccms_lng"] == "" && isset($CLEAN["HTTP_ACCEPT_LANGUAGE"]) && $CLEAN["HTTP_ACCEPT_LANGUAGE"] != "" && $CLEAN["HTTP_ACCEPT_LANGUAGE"] != "MAXLEN" && $CLEAN["HTTP_ACCEPT_LANGUAGE"] != "INVAL") {
		// There is a valid HTTP_ACCEPT_LANGUAGE variable.
		preg_match_all('/([a-z]{2}((-[a-z]{2,4})*)?)(;q=[0-9]\.[0-9])?/i', $CLEAN["HTTP_ACCEPT_LANGUAGE"],  $matches);
		foreach($matches[1] as $lngString2) {
			$qry = $CFG["DBH"]->prepare("SELECT lng FROM `ccms_lng_charset` WHERE `status` = '1' AND `lng` = :lngString2 LIMIT 1;");
			$qry->execute(array(':lngString2' => $lngString2));
			$row = $qry->fetch(PDO::FETCH_ASSOC);
			if($row == true) {
				$CLEAN["ccms_lng"] = $row["lng"];
				break;
			}
		}
	}
	if($CLEAN["ccms_lng"] == "") {
		// There is still no value assigned to the $CLEAN["ccms_lng"] variable so we will first attempt to retrieve one set
		// in the database.  If not found in the database we will pull a default language setting from the config file.
		$qry = $CFG["DBH"]->prepare("SELECT lng FROM `ccms_lng_charset` WHERE `status` = '1' AND `default` = '1' LIMIT 1;");
		$qry->execute();
		$row = $qry->fetch(PDO::FETCH_ASSOC);
		if($row == true) {
			$CLEAN["ccms_lng"] = $row["lng"];
		} else {
			$CLEAN["ccms_lng"] = $CFG["DEFAULT_SITE_CHAR_SET"];
		}
	} else {
		// There is still a value assigned to the $CLEAN["ccms_lng"] variable, all we want to do now it double check that we
		// actually do support it.  So we will first confirm that it's found in the ccms_lng_charset and marked live, if not then
		// we will have to correct the value by stepping through our language options and setting it by hand to something else.
		$qry = $CFG["DBH"]->prepare("SELECT id FROM `ccms_lng_charset` WHERE `status` = '1' AND `lng` = :ccms_lng LIMIT 1;");
		$qry->execute(array(':ccms_lng' => $CLEAN["ccms_lng"]));
		$row = $qry->fetch(PDO::FETCH_ASSOC);
		if($row != true) {
			$qry = $CFG["DBH"]->prepare("SELECT lng FROM `ccms_lng_charset` WHERE `status` = '1' AND `default` = '1' LIMIT 1;");
			$qry->execute();
			$row = $qry->fetch(PDO::FETCH_ASSOC);
			if($row == true) {
				$CLEAN["ccms_lng"] = $row["lng"];
			} else {
				$CLEAN["ccms_lng"] = $CFG["DEFAULT_SITE_CHAR_SET"];
			}
		}
	}
	setcookie("ccms_lng", $CLEAN["ccms_lng"], time() + ($CFG["COOKIE_VISITOR_EXPIRE"] * 86400), "/");
}


function CCMS_cookieVID() {
	global $CFG, $CLEAN;
	if(isset($CLEAN["ccms_cid"]) && $CLEAN["ccms_cid"] != "" && $CLEAN["ccms_cid"] != "INVAL" && $CLEAN["ccms_cid"] != "MAXLEN") {
		// This option helps when jumping from one website to another and retaining a users id value for a shoping cart.
		// Like when moving between www.abc.com and secure.abc.com.
		$CLEAN["ccms_vid"] = $CLEAN["ccms_cid"];
	}
	if(!isset($CLEAN["ccms_vid"])) {
		if($CFG["DEBUG"] == 1) echo "<br />No 'ccms_vid' variable found, creating one now.\n";
		$a = md5(time());
		$b = time() + ($CFG["COOKIE_VISITOR_EXPIRE"] * 86400);
		setcookie("ccms_vid", $a, $b, "/");
		if($CFG["DEBUG"] == 1) echo "<br />a = " . $a . " expire = " . $b . "\n";
		$CLEAN["ccms_vid"] = $a;
	} else {
		// Else update the id value found in the 'ccms_vid' variable every time it is seen.
		$a = time();
		$b = $a + ($CFG["COOKIE_VISITOR_EXPIRE"] * 86400);
		// Check the 'ccms_visitor_id' table for matches.
		$qry = $CFG["DBH"]->prepare("SELECT expire, id FROM `ccms_visitor_id` WHERE `sid` = :ccms_vid LIMIT 1;");
		$qry->execute(array(':ccms_vid' => $CLEAN["ccms_vid"]));
		$row = $qry->fetch(PDO::FETCH_ASSOC);
		if($row == true) {  // If $row contains a valid object.
			if($a > $row["expire"]) {
				// If the current time is greater than the time stored in 'expire' then delete the old record and create a new one.
				$qry = $CFG["DBH"]->prepare("DELETE FROM `ccms_visitor_id` WHERE `id` = :id LIMIT 1;");
				$qry->execute(array(':id' => $row["id"]));
			} else {
				// Else update the 'sid' and 'expire' field with their new values.
				$qry = $CFG["DBH"]->prepare("UPDATE `ccms_visitor_id` SET `sid` = :sid, `expire` = :expire WHERE `id` = :id LIMIT 1;");
				$qry->execute(array(':sid' => $CLEAN["ccms_vid"], ':expire' => $b, ':id' => $row["id"]));
			}
		}
		if($CFG["DEBUG"] == 1) echo "<br />Updating cookie and \$CLEAN[\"ccms_vid\"] arg to " . md5($a) . "\n";
		setcookie("ccms_vid", md5($a), $b, "/");
		$CLEAN["ccms_vid"] = md5($a);
	}
}


function CCMS_dbFirstConnect() {
	global $CFG;
	if($CFG["DEBUG"] == 1) echo "CCMS_dbFirstConnect() call<br />\n";
	$host		= $CFG["DB_HOST"];
	$dbname		= $CFG["DB_NAME"];
	$user		= $CFG["DB_USERNAME"];
	$pass		= $CFG["DB_PASSWORD"];
	try {
		// MSSQL
		// $CFG["DBH"] = new PDO("mssql:host=$host;dbname=$dbname, $user, $pass");
		// MySQL
		$CFG["DBH"] = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, array(PDO::ATTR_PERSISTENT => true));
		// SQLite
		// $CFG["DBH"] = new PDO("sqlite:my/database/path/database.db");
		// Sybase
		// $CFG["DBH"] = new PDO("sybase:host=$host;dbname=$dbname, $user, $pass");
		// Sets encoding UTF-8
		$CFG["DBH"]->exec("SET CHARACTER SET utf8");
		$CFG["DBH"]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		if($CFG["DEBUG"] == 1) echo "Error!: " . $e->getCode() . '<br />\n'. $e->getMessage();
		$CFG["DBH"] = NULL;
		die();
	}
}


function CCMS_filter($input, $whitelist) {
	global $CLEAN;
	foreach($input as $key => $value) {
		if(array_key_exists($key, $whitelist)) {
			$buf = NULL;
			$value = trim($value);
			if(isset($whitelist[$key]['maxlength']) && (strlen($value) > $whitelist[$key]['maxlength'])) {
				$buf = "MAXLEN";
			}
			if($buf != "MAXLEN") {
				switch($whitelist[$key]['type']) {
					case "CRYPT":
						$value = stripslashes(rawurldecode($value));
						$buf = (preg_match(CRYPT, $value)) ? $value : "INVAL";
						break;
					case "HTTP_ACCEPT_LANGUAGE":
						$buf = (preg_match(HTTP_ACCEPT_LANGUAGE, $value)) ? $value : "INVAL";
						break;
					case "HTTP_COOKIE":
						$buf = (preg_match(HTTP_COOKIE, $value)) ? $value : "INVAL";
						break;
					case "LNG":
						$buf = (preg_match(LNG, $value)) ? $value : "INVAL";
						break;
					case 'OPTION':
						if(is_array($value)) {
							if($whitelist[$key]['multiselect']) {
								$buf = array();
								foreach($value as $option) {
									if(in_array($option, $whitelist[$key]['options'])) {
										$buf[] = $option;
									}
								}
							}
						} else {
							$buf = in_array($value, $whitelist[$key]['options']) ? $value : "INVAL";
						}
						break;
					case "QUERY_STRING":
						$buf = (preg_match(QUERY_STRING, $value)) ? $value : "INVAL";
						break;
					case "SESSION_ID":
						$buf = (preg_match(SESSION_ID, $value)) ? $value : "INVAL";
						break;
					case "TPL":
						$buf = (preg_match(TPL, $value)) ? $value : "INVAL";
						break;
					case "UTF8_STRING_WHITE":
						$buf = (preg_match(UTF8_STRING_WHITE, $value)) ? $value : "INVAL";
						break;
					case "UTF8_STRING_DIGIT_WHITE":
						$buf = (preg_match(UTF8_STRING_DIGIT_WHITE, $value)) ? $value : "INVAL";
						break;
					case "UTF8_STRING_DIGIT_PUNC_WHITE":
						$buf = (preg_match(UTF8_STRING_DIGIT_PUNC_WHITE, $value)) ? $value : "INVAL";
						break;
				}
			}
			$CLEAN[$key] = $buf;
		}
	}
}


function CCMS_insDB($a) {
	global $CFG, $CLEAN;
	if(isset($CLEAN["CCMS_insDBPreloadContent"])) {
		if($CLEAN["CCMS_insDBPreloadContent"][$a[2]][$a[3]][$CLEAN["ccms_lng"]] != "") {
			echo $CLEAN["CCMS_insDBPreloadContent"][$a[2]][$a[3]][$CLEAN["ccms_lng"]];
		} else {
			echo $CLEAN["CCMS_insDBPreloadContent"][$a[2]][$a[3]][$CFG["DEFAULT_SITE_CHAR_SET"]];
		}
	} else {
		echo $a[0] . " ERROR: Either CCMS_insDBPreloadContent function or CCMS_DB_PRELOAD tag not run on your template prior to calling this CCMS_DB tag. ";
	}
}


function CCMS_insDBPreload($a = NULL) {
	global $CFG, $CLEAN;
	$CLEAN["CCMS_insDBPreloadContent"] = array();
	// This function can be called in two different ways:
	// $content = CCMS_insDBPreload("about_us_filter,footer_filter,header_filter,twiter_feed_filter");
	// or
	// {CCMS_DB_PRELOAD:about_us_filter,footer_filter,header_filter,twiter_feed_filter}
	//
	// `access` = '0'; www side
	// `access` = '1'; admin side
	if($a[2]) {
		$scopeArray = explode(",", $a[2]);
		foreach($scopeArray as $key) {
			if($scope != "") {
				$scope .= " OR ";
			}
			$scope .= "`scope` = '" . $key . "'";
		}
		$query = "SELECT * FROM `ccms_ins_db` WHERE `status` = '1' AND `access` = '0' AND (" . $scope . ");";
	} else {
		$query = "SELECT * FROM `ccms_ins_db` WHERE `status` = '1' AND `access` = '0';";
	}
	$qry = $CFG["DBH"]->prepare($query);
	$qry->execute();
	$qry->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $qry->fetch()) {
		$CLEAN["CCMS_insDBPreloadContent"][$row["scope"]][$row["word"]][$CFG["DEFAULT_SITE_CHAR_SET"]] = $row[$CFG["DEFAULT_SITE_CHAR_SET"]];
		$CLEAN["CCMS_insDBPreloadContent"][$row["scope"]][$row["word"]][$CLEAN["ccms_lng"]] = $row[$CLEAN["ccms_lng"]];
	}
}


function CCMS_insTPL($a) {
	global $CFG;
	// Test to see if CLEAN["ccms_tpl"] file being requested is stored on the server with a .htm, .html, .php,
	// .tpl, .txt, .xml or .xsl extension.  .php is tested for first, if found it is pre-parsed by php, stored in a buffer
	// and then submitted to the CMS system for further parsing.  If any other extension found it is sent
	// immediately for parsing.
	//
	// NOTE: The filenames are returned in the order in which they are stored by the file system.
	//
	// NOTE ABOUT file_get_contents(): On Windows servers the case of a filename is not important, however on
	// UNIX/LINUX systems case is very important.  If you have a file on your system you are looking for is not
	// typed if with the proper case it will reselt in an error.  Just make sure you always lowercase all your
	// URL's and template names for safety.
	//
	// WARNING: It is recommended that you do NOT store two files of the same name with different extensions
	// in the same directory at the same time.  You'll save yourself from pulling out all your hair trying
	// to figure out why the newer file simply isn't being called.  In these cases it's best to remove the
	// original and replace with the new file extension all together.
	if(preg_match('/\.php\z/i', $a[2])) {
		ob_start();
		include $_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $a[2];
		$html = ob_get_contents();
		ob_end_clean();
		echo CCMS_tplParser($html);
	} elseif(preg_match('/\.htm\z/i', $a[2]) || preg_match('/\.html\z/i', $a[2]) || preg_match('/\.tpl\z/i', $a[2]) || preg_match('/\.txt\z/i', $a[2]) || preg_match('/\.xml\z/i', $a[2]) || preg_match('/\.xsl\z/i', $a[2])) {
		if(($html = @file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $a[2])) !== FALSE) {
			echo CCMS_tplParser($html);
		} else {
			echo $a[0] . " ERROR: CCMS_TPL '" . $a[2] . "' not performed.  Be sure the file exists and has either a .htm, .html, .php, .tpl, .txt, .xml or .xsl extention. ";
		}
	} else {
		echo $a[0] . " ERROR: CCMS_TPL '" . $a[2] . "' not performed.  Be sure the file exists and has either a .htm, .html, .php, .tpl, .txt, .xml or .xsl extention. ";
	}
}


function CCMS_setContentTypeHeader() {
	global $CFG;
	/*
	//header("Expires:" . gmdate("D, d M Y H:i:s", time() + ($CFG["COOKIE_VISITOR_EXPIRE"] * 86400)) . " GMT");
	// To allow your visitors to use the back button after they sent a form with the post method.
	header("Pragma:public");
	header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:text/html; charset=utf-8");
	*/

	header("Content-Type: text/html; charset=UTF-8");
	header("Cache-Control: public, must-revalidate, proxy-revalidate");
	// "public" Indicates that the response may be cached by any cache, even if it would normally be non-cacheable or cacheable only within a
	// non-shared cache.
	// "must-revalidate" tells the visitors' 'browser' that if the visitor use thier 'reload' button the content must come from the server and
	// not their cache.
	// "proxy-revalidate" is similar to must-revalidate, except that it only applies to proxy caches.

	// Other example headers that may need to be used depending on the purpose of your site.

	// Use the following to force a no caching situation and make sure the visitors browser always pulls fresh from the server.
	//header('Cache-Control: no-store, no-cache, must-revalidate');
	//header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	// Use the Etag header via md5 of your content to help set a method for browsers to notice a page has changed and fresh version
	// should be pulled regardless of the expiry date of cached content.
	//$HashID = md5(a_copy_of_your_object_buffer_for_the_template);
	//header('ETag: ' . $HashID);
}


function CCMS_tplParser($a = NULL) {
	global $CFG;
	if($a) {
		$from = 0;
		while(($to = strpos($a, "{CCMS_", $from)) !== false) {
			echo substr($a, $from, $to - $from);
			$from = $to;
			$to = strpos($a, "}", $from);
			$to++;
			$b = substr($a, $from, $to-$from);
			if($CFG["DEBUG"] == 1) echo "b=[" . $b . "]<br />\n";
			$from = $to;
			if(preg_match('/^\{(CCMS_LIB):(_?[a-z]+[a-z-_\pN\/]+[a-z-_\pN]+\.php);(FUNC):([a-z_\pN]+)\(?(.*?)\)?}\z/i', $b, $c)) {
				// {CCMS_LIB:_default.php;FUNC:ccms_cfgDomain}
				// {CCMS_LIB:cms/_123.php;FUNC:XyZZy123_}
				// {CCMS_LIB:test/dir/indeX_Asdf-123.php;FUNC:cfgindeX_Asdf123("arg1", "arg2")}
				if($c["5"] != "") {
					$tmp = explode('",', $c["5"]);
					foreach($tmp as $key => $val) {
						$val = ltrim($val, ' ');
						$val = ltrim($val, '"');
						$tmp[$key] = rtrim($val, '"');
					}
				}
				// Note: There is a potential bug/problem with the use of the function_exists() function below.
				// If someone places two CCMS_LIB tags in their code like this:
				// {CCMS_LIB:_default.php;FUNC:test1}
				// {CCMS_LIB:user_lib.php;FUNC:test1}
				// The function test1 inside the _default.php template gets loaded first by PHP with the require_once().
				// When PHP attempts to load the the user_lib.php template it will produce an error complaining that the
				// test1 function is already in use because it was previously loaded on the _default.php template.
				// Rule of thumb, make sure all your functions have different names.
				if(function_exists($c[4])) {
					if($c["5"] == "") {
						call_user_func($c[4]);
					} else {
						call_user_func_array($c[4], $tmp);
					}
				} else {
					require_once $_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["LIBDIR"] . "/" . $c[2];
					if(function_exists($c[4])) {
						if($c["5"] == "") {
							call_user_func($c[4]);
						} else {
							call_user_func_array($c[4], $tmp);
						}
					} else {
						echo $c[0] . " ERROR: FUNC '" . $c[4] . "' not found. ";
					}
				}
			} elseif(
				preg_match('/^\{(CCMS_DB):([a-z]+[a-z-_\pN]+),([a-z]+[a-z-_\pN]+)}\z/i', $b, $c)) {
				// {CCMS_DB:about_us_filter,meta_description}
				// {CCMS_DB:about_us_filter,meta_keywords}
				// {CCMS_DB:about_us_filter,title}
				// {CCMS_DB:about_us_filter,first_paragraph}
				// {CCMS_DB:about_us_filter,second_paragraph}
				// {CCMS_DB:footer_filter,copywrite}
				// {CCMS_DB:header_filter,title}
				// {CCMS_DB:twiter_feed_filter,title}
				// {CCMS_DB:twiter_feed_filter,tag_top}
				// {CCMS_DB:twiter_feed_filter,tag_bottm}
				CCMS_insDB($c);
			} elseif(preg_match('/^\{(CCMS_DB_PRELOAD):([a-z]+[a-z-_,\pN]*)}\z/i', $b, $c)) {
				// {CCMS_DB_PRELOAD:about_us_filter,footer_filter,header_filter,twiter_feed_filter}
				CCMS_insDBPreload($c);
			} elseif(preg_match('/^\{(CCMS_TPL):([a-z-\pN_\/]+(\.php|\.htm|\.html|\.tpl|\.txt|\.xml|\.xsl)?)}\z/i', $b, $c)) {
				// This preg_match helps prevent CCMS_TPL calls like this; {CCMS_TPL:css/../../../../../../../etc/passwd}
				// {CCMS_TPL:test_01}
				// {CCMS_TPL:test_02.txt}
				// {CCMS_TPL:test_03.php}
				// {CCMS_TPL:temp/test_04.tpl}
				// {CCMS_TPL:temp/test_05.html}
				// {CCMS_TPL:temp/test_06}
				// {CCMS_TPL:temp/test_07.php}
				if($CFG["DEBUG"] == 1) echo "c=[" . $c . "]<br />\n";
				CCMS_insTPL($c);
			} else {
				echo $b;
			}
		}
		echo substr($a, $from, strlen($a)-$from);
	}
}


function CCMS_sqlQueryFailure($query, $error) {
	global $CFG;
	if($CFG["DEBUG_SQL"] == 1) {
		$MSG = htmlspecialchars("Query Failed: " . $query . "\nMySQL Error: " . $error);
		return "<pre style=\"font-weight:bold; margin:0px; padding:0px;\">" . $MSG . "</pre>";
	}
	return "There was either a problem with your request or the requested page is temporarily unavailable, please try again later.";
}


function CCMS_go() {
	global $CFG, $CLEAN;
	CCMS_setLng();
	CCMS_cookieVID();
	CCMS_setContentTypeHeader();
	// If there is no template requested, show $CFG["INDEX"].
	// This code helps when dealing with URL's that resemble:
	// $CFG["INDEX"] = BLANK
	// /
	// make into:
	// index
	// /index
	if(!isset($CLEAN["ccms_tpl"]) || $CLEAN["ccms_tpl"] == "" || $CLEAN["ccms_tpl"] == "/") {
		$CLEAN["ccms_tpl"] = $CFG["INDEX"];
	}
	// If the template being requested is inside a dir and no specific template name is
	// part of that request, add index to the end.
	// /fruit/
	// /fruit/orange/
	// /fruit/orange/vitamin/
	// make into:
	// /fruit/index
	// /fruit/orange/index
	// /fruit/orange/vitamin/index
	if(preg_match('/[\/]\z/', $CLEAN["ccms_tpl"])) {
		$CLEAN["ccms_tpl"] .= "index";
	}
	// Trims the 'forward slash' from both ends and .html from the end of a string saved inside CLEAN["ccms_tpl"]:
	//$CLEAN["ccms_tpl"] = preg_replace('/^(\/)?(\/?.*?)(\/|\.html)?\z/i', '$2', $CLEAN["ccms_tpl"]);
	// Trim the 'forward slash', .htm and .html from $CLEAN["ccms_tpl"].
	// /index
	// /fruit/orange.htm
	// /fruit/orange/vitamin
	// /fruit/orange/vitamin/c.html
	// make into:
	// index
	// fruit/orange
	// fruit/orange/vitamin
	// fruit/orange/vitamin/c
	$CLEAN["ccms_tpl"] = preg_replace('/^(\/)(.*?)(\.html?)?\z/i', '$2', $CLEAN["ccms_tpl"]);
	// Copys the end of the string found inside $CLEAN["ccms_tpl"] after the last /.
	preg_match('/([^\/]*)\z/', $CLEAN["ccms_tpl"], $ccms_file);
	// Copys the first part of the string inside $CLEAN["ccms_tpl"] before the last /.
	$ccms_dir = strstr($CLEAN["ccms_tpl"], $ccms_file[0], true);
	// Test to see if CLEAN["ccms_tpl"] file being requested is stored on server with a .htm, .html, .php,
	// .tpl or .txt extension.  .php is tested for first, if found it is pre-parsed by php, stored in
	// a buffer and then submitted to the CMS system for further parsing.  If any other extension
	// found it is sent immediately to the CML system for parsing.
	//
	// NOTE: The filenames are returned in the order in which they are stored by the file system.
	//
	// WARNING: Because of the note above its recommended you do not try to store two files of the
	// same name with different extensions in the same directory at the same time.  You'll save
	// yourself from pulling out all your hair trying to figure out why the newer file simply
	// isn't being called.  In these cases it's best to remove the original and replace with
	// the new file extension all together.
	if($CFG["DEBUG"] == 1) echo "Looking in ccmstpl dir for .php, .htm, .html, .tpl, .txt, .xml or .xsl template, '" . $CLEAN["ccms_tpl"] . "'.<br />\n";
	$found = "0";

//echo "<br />1=[" . $_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $ccms_dir . "]\n";

	if(is_dir($_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $ccms_dir)) {
		$odhandle = @opendir($_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $ccms_dir);
		while(($file = @readdir($odhandle)) !== false) {

//echo "<br />2=[" . $_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $ccms_dir . $file . "]\n";

			if($file != "." && $file != ".." && is_file($_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $ccms_dir . $file)) {
				if($file == $ccms_file[0] . ".php") {
					if($CFG["DEBUG"] == 1) echo $file . " found.<br />\n";
					ob_start();
					include $_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $ccms_dir . $file;
					$html = ob_get_contents();
					ob_end_clean();
					$found = "1";
					break;
				} elseif($file == $ccms_file[0] . ".htm" || $file == $ccms_file[0] . ".html" || $file == $ccms_file[0] . ".tpl" || $file == $ccms_file[0] . ".txt" || $file == $ccms_file[0] . ".xml" || $file == $ccms_file[0] . ".xsl") {
					if($CFG["DEBUG"] == 1) echo $file . " found.<br />\n";
					$html = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $ccms_dir . $file);
					$found = "1";
					break;
				}
			}
		}
		@closedir($odhandle);
	}
	if($found == "1") {
		if(isset($html) && strlen($html) > 0) CCMS_tplParser($html);
	} else {
		//echo "ERROR: \$CLEAN[\"ccms_tpl\"] '" . $CLEAN["ccms_tpl"] . "' not found.";
		$CLEAN["ccms_tpl_org"] = $CLEAN["ccms_tpl"];  // Store a copy of the original tpl requested for use later on in the error page.
		$CLEAN["ccms_tpl"] = "error";  // Rest the tpl variable to the error page.
		ob_start();
		include $_SERVER["DOCUMENT_ROOT"] . "/" . $CFG["TPLDIR"] . "/" . $CLEAN["ccms_tpl"] . ".php";
		$html = ob_get_contents();
		ob_end_clean();
		CCMS_tplParser($html);
	}
}
?>