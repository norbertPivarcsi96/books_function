<?php
function getAllBook($conn) {
  $getAllBook = $conn->query("SELECT * FROM books");

  return $getAllBook;
}

function insertDatabase($newBook, $conn) {
  $title = $newBook['title'];
  $author = $newBook['author'];
  $description = $newBook['description'];
  $addNewBook = $conn->query("INSERT INTO books (iro, cim, leiras) VALUES ('$author', '$title', '$description')");

  return $addNewBook;
}

function connectionToDatabase() {
  $host = "127.0.0.1";
  $database = "books";
  $username = "root";
  $password = "";

  $conn = new mysqli($host, $username, $password, $database);

  if ($conn -> connect_errno) {
    echo "Failed to connect to MySql: ".$connection -> connect_error;
    exit();
  }

  return $conn;
}
///////////////////////////////////////////////////////////////////////////////
$connection = connectionToDatabase();
$booksListing = getAllBook($connection);

if (isset($_POST['iro']) && isset($_POST['cim']) && isset($_POST['leiras'])) {

  $newBook = array('author' => $connection->real_escape_string($_POST['iro']),
                    'title' => $connection->real_escape_string($_POST['cim']),
                    'description' => $connection->real_escape_string($_POST['leiras'])
                  );

  if (insertDatabase($newBook, $connection)) {
    echo "A felvétel sikeres";
  }else {
    echo "NEm sikerült a felvétel";
  }
}

while ($row = $booksListing->fetch_assoc()) {
  echo "Iro: ".$row['iro']."<br>";
  echo "Cím: ".$row['cim']."<br>";
  echo "Leírás: ".$row['leiras']."<br><br>";
  echo "<a href=?edit_book_leiras=".$row['id'].">Leírás szerkesztése</a>";
}

?>
<form class="" method="post">
  <input type="text" name="iro" value="" placeholder="Író neve"><br>
  <input type="text" name="cim" value="" placeholder="Könyv címe"><br>
  <input type="text" name="leiras" value="" placeholder="Leírás"><br>
  <input type="submit" name="submit" value="Küldés">
</form>
