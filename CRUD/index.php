<?php
$insert = false;
$update = false;
$delete = false;
//connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("The connection is not successfull because: " . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `notes`.`S.No` = $sno ";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['snoEdit'])) {
    $sno =  $_POST['snoEdit'];
    $title = $_POST['TitleEdit'];
    $description = $_POST['DescriptionEdit'];

    $sql = "UPDATE `notes` SET `Title` = '$title' , `Description` = '$description' WHERE `notes`.`S.No` = $sno";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $update = true;
    }
  } else {
    $title = $_POST['Title'];
    $description = $_POST['Description'];

    //Query to be executed
    $sql = "INSERT INTO `notes` (`Title`, `Description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $insert = true;
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>PHP CRUD</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Data Table CSS -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>

<body>
  <?php
  if ($insert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been inserted successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>
  <?php
  if ($update) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been updated successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>
  <?php
  if ($delete) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been deleted successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/CRUD/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="Title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="TitleEdit" name="TitleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="Description" class="form-label">Note Description</label>
              <textarea class="form-control" id="DescriptionEdit" name="DescriptionEdit" aria-label="With textarea"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div class="container my-4">
    <h1>Add a Note</h1>
    <form action="/CRUD/index.php" method="POST">
      <div class="mb-3">
        <label for="Title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="Title" name="Title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="Description" class="form-label">Note Description</label>
        <textarea class="form-control" id="Description" name="Description" aria-label="With textarea"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>

    <div class="container my-4">

      <table class="table" id="myTable">

        <thead>
          <tr>
            <th scope="col">S.No</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>

        <tbody>
        <?php 
          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['Title'] . "</td>
            <td>". $row['Description'] . "</td>
            <td> <button class='edit btn btn-sm btn-primary' id=".$row['S.No'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['S.No'].">Delete</button>  </td>
          </tr>";
        } 
          ?>
        </tbody>
      </table>

    </div>
  </div>


  <!-- Optional JavaScript -->

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <!-- Data Table JavaScript -->
  <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit,");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        TitleEdit.value = title;
        DescriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        var myModal = new bootstrap.Modal(document.getElementById('editModal'), {
          keyboard: false
        })
        myModal.toggle();
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit,");
        sno = e.target.id.substr(1, );
        if (confirm("Are you sure you want to delete this note?")) {
          console.log("yes");
          window.location = `/CRUD/index.php?delete=${sno}`;
        } else {
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>