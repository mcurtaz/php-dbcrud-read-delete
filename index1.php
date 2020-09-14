<?php
  // GOAL: seleziona tutto dalla tabella pagamenti e stampa il risultato in una lista ordinata (fatto in classe)

  
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
          SELECT *
            FROM pagamenti
   ";

  $result = $conn->query($qry);


  // var_dump($result); die();


  if ($result && $result->num_rows > 0) { //se results esite e num_row (attributo dell'oggetto results che ci dice di quante righe è composta la tabella di risultati) è maggiore di 0 eseguo il codice per estrarre i dati

    // per stampare una lista apro e chiudo il tag ul. dentro faccio il ciclo while e stampo i risultati dentro a un tag li (ovviamente in un caso reale il php manda solo i dati al frontend e poi il frontend si occupa di stamparli in pagina)
    echo "<ul>";

    //ciclo sui risultati prendendo una riga alla volta con fetch_assoc()
    while($row = $result->fetch_assoc()){ 

      echo "<li>";
      echo "Status: " . $row["status"] . " ID-Pagante: " . $row["pagante_id"] . " Prezzo: " . $row["price"];
      echo "</li>";

    }

    echo "</ul>";

  } elseif ($result ){ 
    echo "0 results";
  } else { 
    echo "query error";
  }

  // chiudi la connessione
  $conn->close();
 ?>
