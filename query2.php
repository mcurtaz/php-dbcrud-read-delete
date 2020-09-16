<?php
  // GOAL: Stampare in PHP i risultati della seguente query: Conta quante volte è stata prenotata ogni stanza

  // PER INFO: spesso a compilare questo codice mi ha dato errore. L'errore 500 è qualcosa che non va nel codice php. 9 su 10 manca una virgola, un punto e virgola o una graffa. In questi casi può aiutare il log (in windows C:/MAMP/logs/php_error.log)

  // Dati di accesso al database. username e password in MAMP li trovi nella pagina iniziale di MAMP di default sono root root (questo in windows e mac. su linux tutti i software aggregati da mamp si installano singolarmente quindi ognuno andrà configurato da se)
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
          SELECT stanza_id, COUNT(*) AS num
            FROM prenotazioni
              GROUP BY stanza_id
                ORDER BY COUNT(*) DESC
   ";

  // salvo nella variabile result la risposta alla query. Sarà un oggetto complesso che non contiene i dati
  $result = $conn->query($qry);


  // var_dump($result); die();


  if ($result && $result->num_rows > 0) { //se results esite e num_row (attributo dell'oggetto results che ci dice di quante righe è composta la tabella di risultati) è maggiore di 0 eseguo il codice per estrarre i dati

    while($row = $result->fetch_assoc()){ // fetch_assoc() è una funzione che estrae di volta in volta la riga successiva. quindi parte da riga 1 poi 2 3 4 ecc. la riga viene salvata di volta in volta nella variabile $row. sarà un array con key nome della colonna e value il valore corrispondente in quella riga (conviene fare un var_dump per farsi un idea. e comunque è più comodo visualizzare i risultati delle query in phpMyAdmin). se result ha n righe a un certo punto fetch_assoc cercherà la riga n + 1 che non esiste, assocerà a $row un valore tipo undefined o null e quindi si uscirà dal while.

      //var_dump($row);

      echo "stanza: " . $row['stanza_id'] . " prenotazioni: " . $row['num'] . '<br>';

    }

  } elseif ($result ){ // se result esiste ma ($result->num_rows > 0) non è maggiore di 0 vuol dire che ci sono 0 righe. 0 risultati
    echo "0 results";
  } else { // se $result non esiste qualcosa è andato storto nella formulazione della query (infatti la connessione l'abbiamo già controllata prima). "query error"
    echo "query error";
  }

  // chiudi la connessione
  $conn->close();
 ?>
