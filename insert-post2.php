<?php
  // GOAL: inserisci nuovo pagamento prendendo i dati dal POST. Ovviamente per mandare i dati con POST non si può usare un url su chrome. Si può utilizzare Postman. Selezionando il metodo POST e poi mandando nel body (non in params!!) e selezionando x-www-form-urlencoded. Mandi i data. Tra l'altro è molto utile perchè ti fa vedere l'oggetto di ritorno. che dovrebbe essere l'oggetto $stmt del codice. infatti contiene affacted_rows che è 1 se abbiamo modificato una riga. Se c'è stato errore affected_rows ha valore -1 e nell'oggetto $stmt c'è anche un log degli errori (esempio formato del dato non valido) ["error"]=>string(37) "Column 'document_type' cannot be null".  ATTENZIONE!! QUESTO DISCORSO DEL POSTMAN FUNZIONA PERCHÈ C'È VAR_DUMP($stmt) IN FONDO. QUINDI LUI TI MANDA QUELLO CHE DA QUA DECIDIAMO DI MANDARE. Senza nulla in fondo per debug arriva solo un "1" in caso di successo.


  // ATTENZIONE per fare debug si può a un certo punto fare de var_dump o degli echo e leggere i risultati direttamente da postman (tra l'altro in postman ci sono delle tab per scegliere come visualizzare la pagina html che restituisce il php. pretty / raw / preview)

  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "dbhotel";

  // Si salva la connessione al server nella variabile $conn
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn && $conn->connect_error) { // questo if controlla se la connessione al db è andata a buon fine. in caso contrario stampa l'errore (di solito con dettagli abbastanza chiari da capire cosa è andato storto) e fa un return in modo da interrompere l'esecuzione del codice
      echo "Connection failed: " . $conn->connect_error;
      return;
  }

  // salvo la query in sql. la SELECT invece di * è meglio definire quali dati scaricare. meno dati si scaricano meglio è (solo i dati necessari. questione di ottimizzazione)
  $qry = "
       INSERT INTO pagamenti (status, price, prenotazione_id, pagante_id)
       VALUES (?, ?, ?, ?)
   ";

   $stmt = $conn->prepare($qry); // prepare() metodo della variabile in cui abbiamo creato l'oggetto connessione (a riga 9). come argomento prende la stringa della query con i punti di domanda che poi verranno sostituiti dai valori delle variabili

   $stmt->bind_param('sdii', $status, $price, $prenotazione, $pagante); // In questo caso ci sono degli accorgimenti: 'sdii' perchè price è un numero con la virgola (d sta per double) documentazione php di bind_params https://www.php.net/manual/en/mysqli-stmt.bind-param.php.
   // Inoltre bisogna stare attenti perchè prenotazione_id e pagante_id sono foreign keys da altre tabelle e quindi non si potrà inserire un id che non ha corrispondenza nelle tabelle a cui si riferisce.

   
   // Prendo le variabili dal GET
   $status = $_POST["status"];
   $price = $_POST["price"];	
   $prenotazione = $_POST["prenotazione"];	
   $pagante = $_POST["pagante"];
   
                                           
   $stmt->execute(); // eseguo lo stmt che farà la query

   VAR_DUMP($stmt); // questo verrà mandato come risposta e visualizzata in postman
  
  $conn->close();
 ?>
