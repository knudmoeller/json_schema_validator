<?php

include "jsv4-php/jsv4.php";

define("SCHEMA", "od-schema/schema/od_berlin_schema.json");


function screen_log($message, $type) {
	$out = "";
	if ($type == "error") {
		$out .= "<b class='error'>ERROR</b> ... ";
	} else if ($type == "success") {
		$out .= "<b class='ok'>OK</b> ... ";
	}
	$out .= $message ."<br/>";
	
	echo $out;
}

$header = <<<HTML
<?xml version="1.0" encoding="UTF-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>validator | Datenregister Berlin</title>
  <link rel="stylesheet" type="text/css" href="http://datenregister.berlin.de/css/style.css" />
  <link rel="stylesheet" type="text/css" href="http://datenregister.berlin.de/css/bootstrap.min.css" />
  <link href="http://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet" type="text/css" />	
  <link href="style/validator_style.css" rel="stylesheet" type="text/css" />	
</head>

<body class="index home no-sidebar">

  <div id="wrap">
    <div class="header outer">
      <header class="container">
        <a href="/">
          <img src="http://datenregister.berlin.de/CKAN-logo.png" alt="Datenregister Berlin Logo" title="Datenregister Berlin Logo" id="logo" />
        </a>
        <div id="site-name">
          <a href="/">Datenregister Berlin </a>
        </div>

      </header>
    </div>
    <div id="main" class="container">
      <div class="row">
        <div class="span9 content-outer">

HTML;

echo $header;

$upload_file_path = $_FILES['uploadedfile']['tmp_name'];
$basename = basename($_FILES['uploadedfile']['name']);

$data_string = file_get_contents($upload_file_path);
$schema_location = "http://" . $_SERVER['SERVER_NAME'] . "/" . SCHEMA;

$data = json_decode($data_string);
$schema = json_decode(file_get_contents($schema_location));

if ($data) {
  $result = Jsv4::validate($data, $schema);
  if ($result->valid) {
    screen_log("validation passed", "success");
  } else {
    screen_log("'$basename' not valid", "error");
    $errors = $result->errors;
    foreach($errors as $error) {
      screen_log("Code [$error->code]", "error");
      $message = "<div class='error_desc'>";
      if ($error->message) {}
        $message .= "<span class='error_msg'>$error->message</span><br/>";
      if ($error->dataPath) {
        $message .= "data path: <span class='error_path'>$error->dataPath</span><br/>";
      }
      if ($error->schemaKey) {
        $message .= "schema key: <span class='error_path'>$error->schemaKey</span><br/>";
      }
      $message .= "</div>";
      echo($message);
    }
  }
} else {
	screen_log("could not load '$basename' (no file sent?)", "error");
}

$footer = <<<HTML
        </div>
      </div>
    </div>
  </div>

  <div class="clearfix"></div>
  <div class="footer outer">
     <footer class="container">
       <div class="row">
         <div class="span4">
           <h3 class="widget-title">Über Datenregister Berlin</h3>
           <div class="textwidget">
             <ul>
               <li>
                   <a href="/de/about">Was ist das?</a>
               </li>
               <li>
                   Portal-Hauptseite: <a href="http://daten.berlin.de/">daten.berlin.de</a>
               </li>
               <li>API:
                 <a href="/api/1">Einstieg</a> |
                 <a href="http://docs.ckan.org/en/latest/api.html">Dokumentation</a>
               </li>
             </ul>
           </div>
         </div>
         <div class="span4">
           <h3 class="widget-title">Sektionen</h3>
           <div class="textwidget">
             <ul>
               <li>
                 <a href="/user">
                   Benutzer
                 </a>
               </li>
               <li>
                 <a href="/tag">
                   Tags
                 </a>
               </li>
               <li>
                 <a href="/stats">
                   Statistiken
                 </a>
               </li>
               <li>
                 <a href="/revision">
                   Revisionen
                 </a>
               </li>
               <li>
                 <a href="/ckan-admin">
                   Seiten-Admin
                 </a>
               </li>
             </ul>
           </div>
         </div>
         <div class="span4">
           <h3 class="widget-title">Sprachen</h3>
           <div class="textwidget">
             <ul>
               <li>
               <a href="/de/">
                   Deutsch
                 </a>
               </li><li>
               <a href="/en/">
                   English
                 </a>
               </li>
             </ul>
           </div>
         </div>
       </div>
     </footer>
   </div> <!-- eo #container -->
	</div>
</body>
</html>
HTML;

echo $footer;

?>