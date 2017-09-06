<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Project names</title>
        <link href="style.css" rel="stylesheet">
    </head>
    
    <body>
    	<!-- Här på startsidan visas ett formulär med ett textfält där användaren kan skriva in namnförslag. Under denna visas en lista över de namn som finns i databasen och knappar för att rösta på de olika namnen. Längst ner på sidan visas de tre namn som har fläst röster. -->
        
        <h1 class="Spacer">Project names</h1>
        <div class="Spacer">
        <form id="AddNameForm" action="send.php" method="POST">  
            <input type="text" id="name" name="name" placeholder="Name.. (max 32 characters)">
            <input type="submit" name="submit" value="Submit">
            <br>
            <label id="error" style="">
            	<!-- Här tas errormedelandet från send emot -->
            	<?php
					if(isset($_GET["error"])){
						$error = $_GET["error"];
						echo $error;
					}
				?>
            </label>
        </form>
        </div>
        
        <div class="Spacer">
            <h2>Previously added names</h2>
            <?php
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
                
                $sql = "SELECT * FROM projectnames3 ORDER BY id DESC";
                $resultat = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($resultat) > 0)
                {
                    echo "<ul class='NameList'>";
                    
                    echo "
						<ul id='NameListExplainer'>
                    		<li>Votes</li>
                    		<li>Names</li>
                    		<li>Vote button</li>
                    	</ul>";
						
                    while($rad = mysqli_fetch_assoc($resultat)) 
					//Raderna nedan visar alla namn och deras röster från databasen i en lista och lägger till en röstnings knapp. 
                    {
                        echo "
							<p id='VoteFormSpacer'></p> 
							<li id='NameListNum'>" . utf8_encode($rad["vote"]) . "</li> 
							<li id='NameListContent'>" . mysqli_real_escape_string($conn, utf8_encode($rad["name"])) . "</li>
							
							<form id='VoteForm' action='send2.php' method='POST'> 
								<input type='hidden' id='votename' name='votename' value='". mysqli_real_escape_string($conn, utf8_encode($rad["name"])) ."'>
								<input type='submit' name='submit' value='Vote' id='Vote' name='Vote'>
							</form>
                        ";
                        
                    }
                    echo "</ul>";
                }
                else
                {
                    echo "No names added";
                }
            ?>
            
        </div>
        
        <div class="Spacer">
            <h2>Top three names</h2>
            
            <?php
                $sql = "SELECT * FROM projectnames3 ORDER BY vote DESC LIMIT 3";
                $resultat = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($resultat) > 0)
                {
                    echo "<ul class='NameList'>";
                    
                    echo "
						<ul id='NameListExplainer'>
                    		<li>Votes</li>
                    		<li>Names</li>
                    	</ul>";
                    
                    
                    while($rad = mysqli_fetch_assoc($resultat))
                    //Raderna nedan visar de tre namn som har mest röster och hur många röster de har.  
					{
                        echo "
							<p id='VoteFormSpacer'></p> 
							<li id='NameListNum'>" . utf8_encode($rad["vote"]) . "</li> 
							<li id='NameListContent'>" . utf8_encode($rad["name"]) . "</li>
                        ";
                    }
                    echo "</ul>";
                }
                
                else
                {
                    echo "No names added";
                }
                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
