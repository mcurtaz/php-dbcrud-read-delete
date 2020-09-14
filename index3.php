<?php
  // GOAL: elimina dalla tabella pagamenti la riga con pagante_id = 6 e con status = rejected

  
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
          DELETE FROM pagamenti
            WHERE pagante_id = 6
              AND status LIKE 'rejected'
   ";

  $result = $conn->query($qry);

  // print results
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
