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


function editBook($connection) {
  if (isset($_GET['edit_leiras']) && isset($_GET['edit_id'])) {
    $edit = $_GET['edit_leiras'];
    $id = $_GET['edit_id'];
    $edit_book_query = $conn->query("UPDATE books SET leírás = '$edit' WHERE id = $id");

      return $edit_book_query;
    if ($edit_book_query) {
      echo "Sikeres módosítás";
    }else {
      echo "Sikertelen módosítás";
    }
  }
}
function deleteBook($conn) {
  if (isset($_GET['delete_film'])) {
      $unsetData = $_GET['delete_film'];
      $delete_filmSQL = $conn->query("DELETE FROM filmek WHERE id = $unsetData");
      if ($delete_filmSQL) {
        echo "Sikeres törlés";
      }else {
        echo "Valami hiba történ, kérjük keresse fel vevőszolgálatukat";
      }
  }
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
  echo "Leírás: ".$row['leiras']."<br>";
  echo "<a href=?edit_book_leiras=".$row['id'].">Leírás szerkesztése</a>"."<br>";
  echo "<a href=?delete_book=".$row['id'].">Könyv törlése</a>"."<br><br>";

  if (isset($_GET['edit_book_leiras'])) {
    if ($_GET['edit_book_leiras'] == $row['id']) {
      ?>
      <form class="" method="get">
        <input type="hidden" name="edit_id" value="<?php echo $row['id']?>">
        <input type="text" name="edit_leiras" value="<?php echo $row['leiras']?>"><br>
        <input type="submit" name="submit" value="Módosítás">
      </form>
      <?php
    }

  }
}

?>
<form class="" method="post">
  <input type="text" name="iro" value="" placeholder="Író neve"><br>
  <input type="text" name="cim" value="" placeholder="Könyv címe"><br>
  <input type="text" name="leiras" value="" placeholder="Leírás"><br>
  <input type="submit" name="submit" value="Küldés">
</form>
