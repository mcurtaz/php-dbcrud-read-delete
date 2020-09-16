<?php
  // GOAL: inserisci nuovo ospite prendendo i dati dal GET. localhost?name=Miguel&lastname=Ciurtaz&date=1987-10-12&document=CI&num=AX_4578920

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
   $name = $_GET["name"];
   $lastname = $_GET["lastname"];	
   $date = $_GET["date"];	
   $document = $_GET["document"];	
   $document_num = $_GET["num"];	
   
   //var_dump($name, $lastname, $date,  $document, $document_num  ); die();

   // lancio la funzione execute che sostituisce i valori delle variabili nella stringa che ho preparato prima con bind params. (bind params serve sopratutto per evitare iniezioni di codice cioè uno mi scrive una query che cancella tutto il database e la passa come stringa nella query che ho scritto io. bind params previeni problemi simili)
   
                                           
   $operation = $stmt->execute(); // eseguo lo stmt che farà la query

   $result = $stmt -> get_result();



   var_dump($result); // potrebbe darti falso anche se la riga è stata inserita correttamente. controlla con phpmyadmin o con una query di read (SELECT * .. . . .).
   var_dump($stmt); // facendo var dump di stmt ci restitutisce un oggetto. in questo oggetto c'è una variabile affected row che ci da un idea del buon fine dell'operazione
  // chiudi la connessione
  var_dump($operation); // questo sembra il metodo più efficace. Penso dia true (sarebbe da verificare meglio) se l'operazione execute() che poi è la query va a buon fine.
  $conn->close();
 ?>
