<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-us">

<?php require_once("require.php"); ?>

<a href="../projects">Go Back</a>
<br>

<?php

  // Declare empty variables
  $codeText = "";
  $password = "";

  // Test the code when the user submits the page
  if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Update the variables
    $codeText = test_input($_POST["codeText"]);
    $password = test_input($_POST["password"]);

    // Check to make sure the user submitted the correct password
    if($password == "********") {

      // Put the code contents into a file named test.R
      $file = "/var/www/html/rtest/test.R";
      file_put_contents($file, $codeText);

      // Run a bash script to replace the $lt; tags with '<' characters
      shell_exec('./replace.sh');

      // Print the output to the webpage
      $output = shell_exec('Rscript test.R');
      echo "Output: <br>" . $output;
    }
  }

  // Test the input data
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>">

<!-- Text area to hold the code contents -->
<br>
<textarea name="codeText" rows="89" cols="233"><?php echo $codeText; ?>
</textarea>
<br>
Password: &nbsp;<textarea name="password" rows="1" cols="30">
</textarea>
<br>

<!-- Submit button -->
<br>
<label>
<input id="button" type="submit" value="Test Code" />
</label>
<br><br><br>
</form>

  </body>
</html>
