<?php session_start();

/* Adapted from Heather Ebey's wonderful 240 form handler script

THIS SCRIPT MAY NOT BE USED OUTSIDE OF LIBR 240

DO NOT USE FOR A REAL WEBSITE

*/

/*================================================================================================*/
/*================================================================================================*/
/*================================================================================================*/
/*================================================================================================*/
/*================================= SETTINGS BELOW ===============================================*/

$yourName = "Zhane Alvites";

$yourEmail = "zhanealvites@gmail.com";

$requiredFields = "name,email";

$successText = "Submission Successful!";

$errorText = "You didn't enter the required fields";

$replyURL = "confirm.php";

// OPTIONAL: in order to require radios, select options, and checkboxes, you can add those names here. Must also appear above for $requiredFields
$multiFields = "";

// OPTIONAL: if you want to test your form without it sending the email to you, you can change this to 'false'
$sendEmail = true;




/*================================= SETTINGS ABOVE ===============================================*/
/*================================================================================================*/
/*================================================================================================*/
/*================================================================================================*/
/*================================================================================================*/

/* View Source after submitting form and arriving at your confirm.php page. You can style the output in your CSS stylesheet.

Classes you can use in your CSS to style confirmation output:

- Success text outputs in an h2 element with the class 'confirm-success'
- Error text outputs in an h2 element with the class 'confirm-error'
- The table with submitted names/values is output inside a div with the class 'confirm-output' (The 'Return to Form' button is also within this div)
- View Source to see additional classes in the table output
*/

/*================================= DO NOT CHANGE ANYTHING BELOW =================================*/
/*================================================================================================*/
/*================================== THE MONKEY IS WATCHING YOU ==================================*/
/*================================================================================================*/
/*================================= DO NOT CHANGE ANYTHING BELOW =================================*/
/*
                      __,__
             .--.  .-"     "-.  .--.
            / .. \/  .-. .-.  \/ .. \
           | |  '|  /   Y   \  |'  | |
           | \   \  \ 0 | 0 /  /   / |
            \ '- ,\.-"`` ``"-./, -' /
             `'-' /_   ^ ^   _\ '-'`
             .--'|  \._ _ _./  |'--.
           /`    \   \.-.  /   /    `\
          /       '._/  |-' _.'       \
         /          ;  /--~'   |       \
        /        .'\|.-\--.     \       \
       /   .'-. /.-.;\  |\|'~'-.|\       \
       \       `-./`|_\_/ `     `\'.      \
        '.      ;     ___)        '.`;    /
          '-.,_ ;     ___)          \/   /
           \   ``'------'\       \   `  /
            '.    \       '.      |   ;/_
     jgs  ___>     '.       \_ _ _/   ,  '--.
        .'   '.   .-~~~~~-. /     |--'`~~-.  \
       // / .---'/  .-~~-._/ / / /---..__.'  /
      ((_(_/    /  /      (_(_(_(---.__    .'
                | |     _              `~~`
                | |     \'.
                 \ '....' |
                  '.,___.'

*/
/*================================= DO NOT CHANGE ANYTHING BELOW =================================*/
/*================================================================================================*/
/*================================== THE MONKEY IS WATCHING YOU ==================================*/
/*================================================================================================*/
/*================================= DO NOT CHANGE ANYTHING BELOW =================================*/


// Set variables
$cleanArray = array();
$keys = array();
$values = array();
$missingDataKeys = array();
$missingNum = -1;
$outputData = "";
$stripHTML = 1;
$tagsAllowed = "";
$successMessage = "<p class=\"confirm-success\">" . $successText . "</p>\n";
$errorMessage = "<p class=\"confirm-error\">" . $errorText . "</p>\n";
$emailSubject = "Here is the data recently submitted";
$emailFrom = "LIBR 240 Form <no-reply@senna.sjsu.edu>";
$emailDataTo = $yourName . " <" . $yourEmail . ">";
$emailBody = "";


/* cleanData()
 * trim space at beginning and end of data and stripslashes if required
 * $form is array of all form values from $_POST
 */
function cleanData($form)
{
  foreach ($form as $key => $value ) {
    // Check only scalar values for magic quotes and do data cleaning
    if ( is_scalar( $value )) {
      if ( ini_get( 'magic_quotes_gpc' )) {
        $form[$key] = trim( stripslashes( $value ));
      } else {
        $form[$key] = trim( $value );
      }
    }
  }
  return ($form);
}

/* clean up data passed in for security reasons and to remove
   spaces at beginning and end of data
*/
$cleanArray = cleanData($_POST);

/*if $multiFields is set above, submits blank value if nothing entered*/

  if($multiFields !== '') {

    $multiFieldsArray = explode(',',$multiFields);
 
    foreach ($multiFieldsArray as $fieldName) {
    
      if (!isset($cleanArray[$fieldName])) {

        $cleanArray[$fieldName] = '';
      
      }

    }
  }

/* isRequired()
 * Checks that all required fields - those listed in $requiredFields
 * This does NOT confirm that the data is the correct type for the field.
 */
function isRequired ( $valueName, $requiredList )
{
   if ( eregi($valueName, $requiredList) ) {
      return true;
   }
      return false;
}

/* requiredMissing()
 * $key, $value are single values passed 
 * $requiredFields is a string of values set above.
 * loops through $postData and makes sure that all fields with
 * the prefix has been submitted.
 * Return: true if date is missing, else return false
 */
function requiredMissing ( $key, $value )
{
  global $requiredFields;
  $missingData = false;
  
  // isRequired is function above
  if ( isRequired( $key, $requiredFields ) ) {
    if ( empty($value) ) {
      $missingData = true;
    }
  }
  return $missingData;
}

foreach ($cleanArray as $thisKey => $thisValue ) {

   // requiredMissing returns true if data is missing, else returns false
   if ( requiredMissing( $thisKey, $thisValue) === true ) {
      $missingNum++;
      $missingDataKeys[$missingNum] = $thisKey;
   }

   // radio, select options, and checkboxes are arrays

      if (is_array($thisValue)) {
    $thisValue = implode(', ',$thisValue);
     }
   
   
     array_push ($keys, $thisKey);
     array_push ($values, $thisValue);
  
} // end foreach processing $_POST

/* createHtmlOutput()
 * Creates HTML table showing all table keys (name= in form) and values submitted. 
 * $keys are the form field names
 * $values are the content
 * $required is the array of required keys that were missed
 * Returns table to calling program
 */
function createHtmlOutput ($keys, $values, $required="")
{
  
  global $stripHTML;
  global $tagsAllowed;
  global $missingDataKeys;
  $outputData = "";
  
  $outputData .= "<table class=\"confirm-output\">\n<colgroup>\n<col class=\"confirm-names\">\n<col class=\"confirm-values\">\n</colgroup>\n<thead>\n<tr>\n<th colspan=\"2\">Form Data Submitted</th>\n</tr>\n</thead>\n<tbody>\n";
  
  for ( $i = 0; $i < count ($keys); $i++ ) {

    if ( $stripHTML ) {
      $values[$i] = strip_tags ($values[$i], $tagsAllowed);
    }

    if ( in_array($keys[$i], $required) ) {
      $outputData .= "<tr>\n<td class=\"confirm-required\"><span class=\"confirm-asterisk\">*</span>".$keys[$i].": </td>\n<td>&nbsp;</td>\n</tr>\n";
    } else {
        $outputData .= "<tr>\n<td>".$keys[$i].": </td>\n<td>".$values[$i]."</td>\n</tr>\n";
    }
  }

  $outputData .= "</tbody>\n</table><br><br>";
  
   if ( count( $missingDataKeys ) > 0 ) {
  $outputData .= "<button onclick=\"history.back();\">Return to Form</button>\n";
  }

  return $outputData;
}


// Were any required values missing?
// If so, print page showing data entered with required data marked.
if ( count( $missingDataKeys ) > 0 ) {
      $html_output = createHtmlOutput($keys, $values, $missingDataKeys);
        $_SESSION['htmlOutput'] = $html_output;
        $_SESSION['statusMessage'] = isset($errorMessage) && $errorMessage != ""  ? $errorMessage: "Data not submitted!";
        header("location:". $replyURL.'?'.session_name().'='.session_id());
        exit;
}


// If required fields are filled in, process form
if ( count( $missingDataKeys ) <=  0 ) {

  if ($sendEmail) {
  
    // Make sure email is set up correctly. 

    $headerExtras = ( $emailFrom ) ? 'From: '.$emailFrom : '';
       
    for ($i = 0; $i < count($keys); $i++ ) {
      $emailBody .= $keys[$i].": ".$values[$i]."\n";
    }
    $emailBody .= "\n";
 
    // Send mail to person collecting this data
    mail($emailDataTo, $emailSubject, $emailBody, $headerExtras);

  }
}

if ( count($missingDataKeys) <=  0 ) {
        $html_output = createHtmlOutput( $keys, $values, $missingDataKeys );
        $_SESSION['htmlOutput'] = $html_output;
        $_SESSION['statusMessage'] = isset($successMessage) && $successMessage != ""  ? $successMessage: "<h2 class=\"confirm-success\">Data submitted successfully!</h2>";
        header("location:". $replyURL.'?'.session_name().'='.session_id());
        exit;
} 

?>