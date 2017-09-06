<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
    </head>
    
    <body>
    	<!-- Den här filen ökar ett namnförslags röst antal om användaren trycker på "vote" knappen på index sidan. Den gör detta genom att ta emot namnet som blivit röstat på och ökar dens "vote" värde i databasen. -->
        
    	<?php
			$votename = $_POST['votename'];
			
			$host = "localhost"; // Den server som kör MySQL
            $user = "root"; // Användarnamn till MySQL
            $pass = ""; // Lösenord till MySQL
            $databas = "berra"; // Databasens namn
            
            $conn = mysqli_connect($host, $user, $pass, $databas);
            if(! $conn)
            {
                echo "Anslutningen misslyckades.";
                exit; 
            }
            
            $sql = "SELECT * FROM projectnames3 WHERE name = '$votename';";
            $resultat = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($resultat) > 0)
            {
                while($rad = mysqli_fetch_assoc($resultat))
                {
					$vote = utf8_encode($rad["vote"]);
                }
            }
            
            else
            {
                echo "No name found";
            }
            $votechange = $vote + 1;
			$sql = "UPDATE projectnames3 SET vote = '$votechange' WHERE name = '$votename';";
			mysqli_query($conn, $sql);
			mysqli_close($conn);
			header('Location: index.php');
		?>
        
    </body>
</html>