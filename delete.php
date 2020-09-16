<?php
  // GOAL: Elimina tutti i pagamenti con status rejected

  /* IMPORTANTE: PER ELIMINARE SI UTILIZZA DELETE. SINTASSI GENERICA:
        DELETE FROM table_name
        WHERE some_column = some_value

        - IN GENERE PER ELIMINARE UN TUPLE (UNA RIGA) SI UTILIZZA L'ID.
        - NON è POSSIBILE ELIMINARE DATI CHE SONO REFERENZIATI IN ALTRE TABELLE. (ESEMPIO NON POSSO ELIMINARE UN OSPITE DELL'HOTEL ESEMPIO OSPITE ID = 1 SE IN UN ALTRA TABELLA C'è AD ESEMPIO PAGAMENTI DA UTENTE_ID = 1 (COLLEGATO ALLA TABELLA UTENTI DA CUI VORREI CANCELLARE)) PERCHè SE NO IL DATABASE PERDEREBBE DI COERENZA. IN QUESTI CASI BISOGNEREBBE ELIMINARE L'UTENTE E TUTTI I COLLEGAMENTI ASSOCIATI IN MANIERA RICORSIVA
  */
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

  // in questo caso senza le virgolette a definire tabelle e stringhe non mi accettava la query (errata corrige senza le virgolette `` sulle tabelle lo accettava comunque, fondamentale le virgolette '' sulla stringa rejected)
  $qry = "
      DELETE FROM `pagamenti`
      WHERE `status` LIKE 'rejected'
   ";

  // salvo nella variabile result la risposta alla query. Sarà un oggetto complesso che non contiene i dati
  $result = $conn->query($qry);


  var_dump($result); // in result troverò true se l'operazione è andata a buon fine. in questo caso "scolastico" va bene così. In un progetto vero comunque se l'operazione va a buon fine bisogna scrivere un codice php che organizzi una risposta che faccia sapere al frontend che l'operazione è andata a buon fine.


  if ($result && $result->num_rows > 0) { //se results esite e num_row (attributo dell'oggetto results che ci dice di quante righe è composta la tabella di risultati) è maggiore di 0 eseguo il codice per estrarre i dati

    // nel caso di delete quasta parte non serve. $result->num_rows > 0 sarà uguale a zero perchè il risultato non avrà nessuna riga in quanto non sto leggendo dal database ma scrivendo sul database

  } elseif ($result ){ // se result esiste ma ($result->num_rows > 0) non è maggiore di 0 vuol dire che ci sono 0 righe. 0 risultati

    // si entrerà qua dentro in quanto $result->num_rows > 0 non è vera ma result esiste.
    echo "0 results";
  } else { // se $result non esiste qualcosa è andato storto nella formulazione della query (infatti la connessione l'abbiamo già controllata prima). "query error"
    echo "query error";
  }

  // chiudi la connessione
  $conn->close();
 ?>
