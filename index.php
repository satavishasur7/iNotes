<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Project";
$insert = false;
$update = false;
$delete= false;
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
  die("Sorry we failed to connect : " . mysqli_connect_error());
}
if (isset($_GET['delete']))
{
  $Sno=$_GET['delete'];
  $delete= true;
  $sql= "DELETE FROM `notes` WHERE `Sno`='$Sno'";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['SnoEdit'])) {
    // Update the record
    $Sno = $_POST["SnoEdit"];
    $Title = $_POST["TitleEdit"];
    $Description = $_POST["DescriptionEdit"];

    // Sql query to be executed
    $sql = "UPDATE `notes` SET `Title` = '$Title' , `Description` = '$Description' WHERE `notes`.`Sno` = '$Sno'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $update = true;
    } else {
      echo "We could not update the record successfully";
    }
  } else {
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $sql2 = "INSERT INTO `Notes`(`Title`,`Description`) VALUES('$Title','$Description')";
    $result = mysqli_query($conn, $sql2);


    if ($result) {
      $insert = true;
    }
  }
}

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" class="css">

  <title>iNotes</title>
</head>

<body>


  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this note:</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="/form/index.php" method="POST" class="mb-5">
          <div class="modal-body">

            <input type="hidden" name="SnoEdit" id="SnoEdit">

            <div class="mb-3 fs-5">
              <label for="Title" class="form-label">Notes Title</label>
              <input type="text" class="form-control" id="TitleEdit" name="TitleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 fs-5">
              <label for="Description" class="form-label">Note Description</label>
              <textarea class="form-control" id="DescriptionEdit" name="DescriptionEdit" rows="3"></textarea>
            </div>
            <div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>


  <?php
  if ($insert == true) {
    echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Your notes has been inserted successfully.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
  }

  ?>
  <?php
    if($update){
        echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    ?>

  <?php
    if($delete){
        echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    ?>


  <div class="container my-5 fs-6">
    <div class="mb-3">
      <h2>Add a note.<h2>
          <form action="/form/index.php" method="POST" class="mb-5">
            <div class="mb-3 fs-5">
              <label for="Title" class="form-label">Notes Title</label>
              <input type="text" class="form-control" id="Title" name="Title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 fs-5">
              <label for="Description" class="form-label">Note Description</label>
              <textarea class="form-control" id="Description" name="Description" rows="3"></textarea>
            </div>
            <div>
              <button type="submit" class="btn btn-primary">Add Note</button>
            </div>
          </form>
          <table class="table fs-6" id="myTable">
            <thead>
              <tr>
                <th scope="col">Sl No.</th>
                <th scope="col">Notes Title</th>
                <th scope="col">Notes Desc</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $sql = "SELECT * FROM `notes`";
              $result2 = mysqli_query($conn, $sql);
              $sno = 0;
              while ($row = mysqli_fetch_assoc($result2)) {
                $sno = $sno + 1;
                echo " <tr>
       <th scope='row'> " . $sno . "</th>
       <td>" . $row['Title'] . "</td>
       <td>" . $row['Description'] . "</td>
       <td><button type='button' class='edit btn btn-sm btn-primary' id=". $row['Sno']." data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['Sno'].">Delete</button> </td></tr>";
              
      }
              ?>

            </tbody>
          </table>
    </div>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#myTable').DataTable();
      });
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
          console.log("edit ", );
          tr = e.target.parentNode.parentNode;
          Title = tr.getElementsByTagName("td")[0].innerText;
          Description = tr.getElementsByTagName("td")[1].innerText;
          console.log(Title, Description);
          TitleEdit.value = Title;
          DescriptionEdit.value = Description;
          SnoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })
      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
          console.log("delete ", );
          Sno=e.target.id.substr(1);
          if(confirm("Press a button"))
          {
            console.log("yes");
            window.location=`/form/index.php?delete=${Sno}`;
          }
          else{
            console.log("no");
          }
        })
      })
    </script>
   
</body>

</html>