<?php

include "jsv4-php/jsv4.php";

define("DATA_UPLOAD", "data_upload");
define("DATA_URL", "data_url");
define("DATA_TEXT", "data_text");


function screen_log($message, $type) {
	$out = "";
	switch ($type) {
	  case "text-error":
	    $label = "ERROR: ";
	    break;
	  case "text-success":
	    $label = "OK: ";
	    break;
	  default:
	    $label = "";
	}
	$out .= "<span class='$type'>$label$message</span><br/>";
	
	echo $out;
}

function get_data_from_url($url) {
  if (empty($url)) {
    screen_log("No URL specified", "text-error");
    return NULL;
  } else {
    $data_string = file_get_contents($url);
    if (empty($data_string)) {
      screen_log("Could not load data from <code>$url</code>", "text-error");
      return NULL;
    } else {
      return $data_string;
    }
  }
}

function parse_json($json)
{
    $result = json_decode($json);
    switch (json_last_error())
    {
        case JSON_ERROR_DEPTH:
            $error =  ' - Maximum stack depth exceeded';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = ' - Unexpected control character found';
            break;
        case JSON_ERROR_SYNTAX:
            $error = ' - Syntax error, malformed JSON';
            break;
        case JSON_ERROR_NONE:
        default:
            $error = '';                    
    }
    if (!empty($error))
        screen_log("could not parse as JSON: $error", "text-error");;        
    
    return $result;
}

function get_data_string() {
  $input_method = $_POST["input_radio"];
  $data_string = NULL;
  switch ($input_method) {
    case DATA_UPLOAD:
      screen_log("getting data to validate from file ...", "text-info");
      $upload_file_path = $_FILES['uploadedfile']['tmp_name'];
      if (!$upload_file_path) {
        screen_log("no file specified for upload", "text-error");
        break;
      }
      $basename = basename($_FILES['uploadedfile']['name']);
      screen_log("getting data from <code>$basename</code> ...", "text-info");
      $data_string = get_data_from_url($upload_file_path);
      break;
    case DATA_URL:
      $url = $_POST[DATA_URL];
      screen_log("getting data to validate from <code><a href='$url'>$url</a></code> ...", "text-info");
      $data_string = get_data_from_url($url);
      break;
    case DATA_TEXT:
      screen_log("getting data to validate from text area ...", "text-info");
      $data_string = $_POST[DATA_TEXT];
      break;
    default:
      screen_log("unknown input method '$input_method'", "text-error");
  }
  return $data_string;
}


include('header.php');

screen_log("starting validation ...", "text-info");
screen_log("trying to get schema ...", "text-info");
$schema_location = $_POST["schema_uri"];
$schema_string = get_data_from_url($schema_location);

$input_method = $_POST["input_radio"];

if ($schema_string) {
  screen_log("schema loaded successfully from <code><a href='$schema_location'>$schema_location</a></code>", "text-success");

  screen_log("parsing schema as JSON ...", "text-info");
  $schema = parse_json($schema_string);
  if ($schema) {
    screen_log("schema parsed successfully", "text-success");
    
    $data_string = get_data_string();
    
    if ($data_string) {
      screen_log("data loaded successfully", "text-success");

      screen_log("parsing data as JSON ...", "text-info");
      $data = parse_json($data_string);
      if ($data) {
        screen_log("JSON parsed successfully from data string", "text-success");

        screen_log("validating data against schema ...", "text-info");
        $result = Jsv4::validate($data, $schema);
        if ($result->valid) {
          screen_log("passed - your data conforms to the schema!", "text-success");
        } else {
          screen_log("data not valid", "text-error");
          $errors = $result->errors;
          foreach($errors as $error) {
            screen_log("Code [$error->code]", "text-error");
            $message = "<div class='error_desc'>";
            if ($error->message) {
              $message .= "<span class='error_msg'>$error->message</span><br/>";
            }
            if ($error->subResults) {
              $message .= "<span class='error_submsg'>$error->subResults</span><br/>";
            }
            if ($error->dataPath) {
              $message .= "data path: <span class='error_path'>$error->dataPath</span><br/>";
            }
            if ($error->schemaPath) {
              $message .= "schema path: <span class='error_path'>$error->schemaPath</span><br/>";
            }
            $message .= "</div>";
            echo($message);
          }
        }
      } 
    } else {
      screen_log("no data found (or empty)", "text-error");
    }
  }
}

$back = <<<HTML

          <hr/>
          <p>
            <a href=".">Back...</a>
          </p>
HTML;

echo $back;

include('footer.php');

?>