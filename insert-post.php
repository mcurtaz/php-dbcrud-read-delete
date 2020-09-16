<?php
  // GOAL: inserisci nuovo ospite prendendo i dati dal POST. Ovviamente per mandare i dati con POST non si può usare un url su chrome. Si può utilizzare Postman. Selezionando il metodo POST e poi mandando nel body (non in params!!) e selezionando x-www-form-urlencoded. Mandi i data. Tra l'altro è molto utile perchè ti fa vedere l'oggetto di ritorno. che dovrebbe essere l'oggetto $stmt del codice. infatti contiene affacted_rows che è 1 se abbiamo modificato una riga. Se c'è stato errore affected_rows ha valore -1 e nell'oggetto $stmt c'è anche un log degli errori (esempio formato del dato non valido) ["error"]=>string(37) "Column 'document_type' cannot be null".  ATTENZIONE!! QUESTO DISCORSO DEL POSTMAN FUNZIONA PERCHÈ C'È VAR_DUMP($stmt) IN FONDO. QUINDI LUI TI MANDA QUELLO CHE DA QUA DECIDIAMO DI MANDARE. Senza nulla in fondo per debug arriva solo un "1" in caso di successo

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
       INSERT INTO ospiti (name, lastname, date_of_birth, document_type, document_number)
       VALUES (?, ?, ?, ?, ?)
   ";

   $stmt = $conn->prepare($qry); // prepare() metodo della variabile in cui abbiamo creato l'oggetto connessione (a riga 9). come argomento prende la stringa della query con i punti di domanda che poi verranno sostituiti dai valori delle variabili

   $stmt->bind_param('sssss', $name, $lastname, $date, $document, $document_num); // bind params prende come argomenti: 
                                               // -il primo argomento definisce di che tipo saranno le variabili in questo caso is cioè i = intero e s = stringa. Gli passerò due variabili la prima sarà un intero la seconda una stringa.
                                               // -gli altri argomenti sono le variabili che dovrà associare ai punti di domanda. Attenzione per ora associa solo nome variabile. I valori verranno assegnati con execute() quindi le variabili e i relativi valori delle variabili li posso definire anche dopo

   
   // Prendo le variabili dal GET
   $name = $_POST["name"];
   $lastname = $_POST["lastname"];	
   $date = $_POST["date"];	
   $document = $_POST["document"];	
   $document_num = $_POST["num"];	
   
   //var_dump($name, $lastname, $date,  $document, $document_num  ); die();

   // lancio la funzione execute che sostituisce i valori delle variabili nella stringa che ho preparato prima con bind params. (bind params serve sopratutto per evitare iniezioni di codice cioè uno mi scrive una query che cancella tutto il database e la passa come stringa nella query che ho scritto io. bind params previeni problemi simili)
   
                                           
   $stmt->execute(); // eseguo lo stmt che farà la query

   VAR_DUMP($stmt); // questo verrà mandato come risposta e visualizzata in postman
  
  $conn->close();
 ?>
