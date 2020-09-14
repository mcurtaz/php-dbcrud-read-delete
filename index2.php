<?php
  // GOAL: elimina dalla tabella pagamenti la riga con id 8 (fatto in classe)

  
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "dbhotel";

  $conn = new mysqli($servername, $username, $password, $dbname);

  // questo if controlla se la connessione al db è andata a buon fine. in caso contrario stampa l'errore (di solito con dettagli abbastanza chiari da capire cosa è andato storto) e fa un return in modo da interrompere l'esecuzione del codice
  if ($conn && $conn->connect_error) { 
      echo "Connection failed: " . $conn->connect_error;
      return;
  }

  // creazione query
  $qry = "
          DELETE FROM pagamenti
            WHERE id = 8
   ";

  $result = $conn->query($qry);


  // var_dump($result); die();


  if ($result) { 

    var_dump($result); // bool(true) //Se eseguo il codice una seconda volta tentando di eliminare nuovamente lo stesso elemento (che però non esiste in quanto ho già visto in phpMyAdmin che è stato eliminato) comunque mi restituisce true.
    echo "Element deleted";

  } else {

    var_dump($result);
    echo "An error has occurred";
  }

  // chiudi la connessione
  $conn->close();
 ?>
