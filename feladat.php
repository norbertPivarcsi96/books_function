<?php
$host="127.0.0.1";
$dbName="books";
$username="root";
$password='';

$conn = new mysqli($host, $username, $password, $dbName);

if ($conn -> connect_errno) {
  echo "Failed to connect to MySql: ".$connection -> connect_error;
  exit();
}


if (isset($_POST['iro']) && isset($_POST['cim']) && isset($_POST['leiras'])) {
  echo "ide belépek baszki";
  $iro = $_POST['iro'];
  $cim = $_POST['cim'];
  $leiras = $_POST['leiras'];

  $new_book_query = $conn->query("INSERT INTO books (író, cím, leírás) VALUES ('$iro', '$cim', '$leiras')");

  if ($new_book_query) {
    echo "Sikeres felvétel";
  }else {
    echo "Pucu pucu pucu";
  }
}

if (isset($_GET['modify_leiras']) && isset($_GET['modify_id'])) {
  $edit = $_GET['modify_leiras'];
  $id = $_GET['modify_id'];
  $edit_book_query = $conn->query("UPDATE books SET leírás = '$edit' WHERE id = $id");

  if ($edit_book_query) {
    echo "Sikeres módosítás";
  }else {
    echo "Tedd anyádba te buzi";
  }
}

if (isset($_GET['delete'])) {
    $unsetData = $_GET['delete'];
    $delete_book_query = $conn->query("DELETE FROM books WHERE id = $unsetData");
    if ($delete_book_query) {
      echo "Sikeres törlés";
    }else {
      echo "Valami hiba történ, kérjük keresse fel vevőszolgálatukat";
    }
}

$book_query = $conn->query("SELECT * FROM books");


while ($book_row = mysqli_fetch_assoc($book_query)) {
  echo "<h3>".$book_row['cím']."<br>"."</h3>";
  echo "Író: ".$book_row['író']."<br><br>";
  echo "Leírás: ".$book_row['leírás']."<br>";
  echo "<a href=feladat.php?modify=".$book_row['id'].">Szerkesztés</a><br>";
  echo "<a href=feladat.php?delete=".$book_row['id'].">Törlés</a><br>";


  if (isset($_GET['modify'])) {
    if ($_GET['modify'] == $book_row['id']) {
      ?>
      <form class="" method="get">
        <input type="hidden" name="modify_id" value="<?php echo $book_row['id']?>">
        <input type="text" name="modify_leiras" value="<?php echo $book_row['leírás']?>"><br>
        <input type="submit" name="submit" value="Módosítás">
      </form>
      <?php
    }

  }
  echo "----------------------------------";
}
?>
<form class="" method="post">
  <input type="text" name="iro" value="" placeholder="Író  neve"><br>
  <input type="text" name="cim" value="" placeholder="Könyv címe"><br>
  <input type="text" name="leiras" value="" placeholder="Leírás"><br>
  <input type="submit" name="submit" value="Küldés">
</form>
