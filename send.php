<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
    </head>
    
    <body>
    	<!-- I den här filen tas namnförslaget emot, körs igenom säkerhets filtret och läggs till i databasen. Den dubbelkollar även om namnet redan finns i databasen och skickar tillbaks ett error medelande till användaren. -->
        
    	<?php
			if(isset($_POST["submit"])){
				$filtered = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
				$filtered = trim($filtered);
	
				// databas
				$mysqli = new mysqli("localhost", "root", "", "berra");
				/* check connection */
				if ($mysqli->connect_error) {
					die('Connect Error (' . $mysqli->connect_errno . ') '
							. $mysqli->connect_error);
				}
				
				
				/* change character set to utf8 */
				if (!$mysqli->set_charset("utf8")) {
					echo "Error loading character set utf8: " . $mysqli->error;
					exit();
				}
			
				// spara i databas med prep statements
				if (!($stmt = $mysqli->prepare("INSERT into projectnames3(name) values (?)"))) {
					echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				
				if (!$stmt->bind_param("s",$filtered)) {
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
			
				if (!$stmt->execute()) {
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				}
			
				$filtered = $mysqli->real_escape_string($filtered);
				
				if($stmt->errno == 1062){ // Här skickas error medelandet om användaren skrev in ett namn som redan finns i databasen. 
					echo "Duplicate entery not allowed";
					header('Location: index.php?error=* Duplicate entery not allowed');
				}
				else{
					header('Location: index.php');
				}
			}
			else{
				header('Location: index.php');
			}
		?>
        
    </body>
</html>