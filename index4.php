<?php
	// GOAL:seleziona dalla tabella pagamenti le colonne id, status e price di tutti i pagamenti con price superiore a 600, stampa il risultato in una lista non ordinata

	
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "dbhotel";

	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection

	if ($conn && $conn->connect_error) { 
			echo "Connection failed: " . $conn->connect_error;
			return;
	}

	// query creation
	$qry = "
					SELECT id, status, price
						FROM pagamenti
							WHERE price > 600
	 ";

	$result = $conn->query($qry);

	// print results
	
	//var_dump($result); In alternativa a var_dump a volte (a seconda di cosa si stampa) può essere più chiaro/semplice usare print_r()

	if($result && $result->num_rows > 0){

		echo "<ul>";

		while($row = $result->fetch_assoc()){
			echo "<li>";
			echo "ID: " . $row["id"] . " Status: " . $row["status"] . " Price: " . $row["price"];
			echo "</li>";
		}

		echo "</ul>";

	}
	// chiudi la connessione
	$conn->close();
 ?>
