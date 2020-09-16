<?php
	// GOAL: con GET creare una query che imposta tutti i price dei pagamenti pending a 500. localhost?price=500&status=pending

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

	// PER EVITARE SQL INJECTION (vedi slide) SI UTILIZZA BIND PARAMS
	// bind params sostituisce ai punti di domanda nella stringa della query le variabili. documentazione ufficiale php https://www.php.net/manual/en/mysqli-stmt.bind-param.php

	$qry = "
			UPDATE pagamenti
			SET price = ?
			WHERE status LIKE ?;
	 ";

	$stmt = $conn->prepare($qry); // prepare() metodo della variabile in cui abbiamo creato l'oggetto connessione (a riga 9). come argomento prende la stringa della query con i punti di domanda che poi verranno sostituiti dai valori delle variabili

	$stmt->bind_param('is', $price, $status); // bind params prende come argomenti: 
												// -il primo argomento definisce di che tipo saranno le variabili in questo caso is cioè i = intero e s = stringa. Gli passerò due variabili la prima sarà un intero la seconda una stringa.
												// -gli altri argomenti sono le variabili che dovrà associare ai punti di domanda. Attenzione per ora associa solo nome variabile. I valori verranno assegnati con execute() quindi le variabili e i relativi valori delle variabili li posso definire anche dopo

	
	// Prendo le variabili dal GET
	$price = $_GET["price"];
	$status = $_GET["status"];											

	// lancio la funzione execute che sostituisce i valori delle variabili nella stringa che ho preparato prima con bind params. (bind params serve sopratutto per evitare iniezioni di codice cioè uno mi scrive una query che cancella tutto il database e la passa come stringa nella query che ho scritto io. bind params previeni problemi simili)
	
											
	$stmt->execute(); // lancio execute() che sostituirà i valori delle variabili e farà la query che esegui

	// PER ESTRARRE I RISULTATI

	$result = $stmt -> get_result();

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
