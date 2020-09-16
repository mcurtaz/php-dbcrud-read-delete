<?php
	//Prendo il valore dall'esterno con un GET. GLielo passo nell'url con qualcosa del tipo localhost?price=10
	$price = $_GET["price"];

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
	// sintassi base da w3 school per l'update  
	// UPDATE table_name
	// SET column1 = value1, column2 = value2, ...
	// WHERE condition;

	$qry = "
			UPDATE pagamenti
			SET price = " . $price . "
			WHERE status LIKE 'pending';
	 ";

	$result = $conn->query($qry);

	// print results
	
	//var_dump($result); In alternativa a var_dump a volte (a seconda di cosa si stampa) può essere più chiaro/semplice usare print_r()

	if($result){
		echo "ok";
	} else {
		echo "An error has occured";
	}
	// chiudi la connessione
	$conn->close();
 ?>
