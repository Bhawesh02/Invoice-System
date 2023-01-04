
<?php
include 'connect_db.php';
include 'Sesson_end.php';
        $currentuser=$_SESSION['id'];
        $query = "SELECT * FROM customer where users_id =" . $currentuser;
        $result = mysqli_query($conn, $query);
        
        $customers = array();

if (mysqli_num_rows($result) >0) { // The query returned some results 
  while ($row = mysqli_fetch_assoc($result)) { // Add the data for each row to the array
$customers[] = $row; } } 



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pno = mysqli_real_escape_string($conn, $_POST['phone_number']);

  if(isset($_POST["add_customer"]))
  {
    
    $query = "INSERT INTO customer (name,email, phone_number,users_id) VALUES ('$name','$email', '$pno','$currentuser')";
    if (mysqli_query($conn, $query)) {
      header('Location: customer.php');
      exit;
  } else {
      // Signup failed
      echo 'Error: ' . mysqli_error($conn);
  }
    
  }
  elseif (isset($_POST["edit_customer"])) {
   
    
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $query = "Update customer set name = '$name',phone_number = '$pno',email = '$email' where customer_id = '$id'";
  if (mysqli_query($conn, $query)) {
    header('Location: customer.php');
    exit;
} else {
    // Signup failed
    echo 'Error: ' . mysqli_error($conn);
}
}
}








?>











<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>customers</title>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css"
    />
    <link rel="stylesheet" type="text/css" href="./css/customer.css" />
    
     
    <script>
      var customers = <?php echo json_encode($customers); ?>;
    </script>
  </head>
  <body>
    
  <?php
    include 'header.php';
    ?>
    <h2>CUSTOMERS</h2>
    <table
      id="customers"
      class="table table-striped table-bordered"
      cellspacing="0"
      width="100%"
    >
      <thead>
        <tr>
          <th>No.</th>
          <th>Name</th>
          <th>email</th>
          <th>Phone Number</th>

          <th style="text-align: center; width: 100px">
            Add Customer
            <button
              type="button"
              data-func="dt-add"
              class="btn btn-success btn-xs dt-add"
              id="add_row_btn"
            >
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
          </th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <div id="popup" class="modal">
      <span class="close" id="popup_close">&times;</span>
      <div id="add_row_popup">
      <div class="form-container modal-content">
          <form  method="POST" class="form">
              <div class="form-group">
                  <label for="name" class="form-label">customer Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Name *" tabindex="1" required>
              </div>
              <div class="form-group">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control " id="email" name="email" placeholder="Email *"  tabindex="2" required
                        >
                </div>
              <div class="form-group">
                    <label for="Phone_number" class="form-label">Phone Number</label>
                    <input type="tel" onKeyDown="if(this.value.length==10 && event.keyCode!=8) return false;" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number *"
                    tabindex="3" required>
                </div>
              
              <div>
                  <button type="submit" name="add_customer" class="submit_btn">Add Customer!</button>
              </div>
          </form>
          
      </div>
</div>
      <div id="edit_row_popup">
      <div class="form-container modal-content">
          <form  method="POST" class="form">
          <div class="form-group">
                  <label for="id" class="form-label">customer No</label>
                  <input type="text" class="form-control" id="edit_id"  placeholder="" disabled>
                  <input name="id" id="edit_id_h" hidden>
              </div>
              <div class="form-group">
                  <label for="name" class="form-label">customer Name</label>
                  <input type="text" class="form-control" id="edit_name" name="name" placeholder="Name *" tabindex="1" required>
              </div>
              <div class="form-group">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control " id="edit_email" name="email" placeholder="Email *"  tabindex="2" required
                        >
                </div>
              <div class="form-group">
                    <label for="Phone_number" class="form-label">Phone Number</label>
                    <input type="tel" onKeyDown="if(this.value.length==10 && event.keyCode!=8) return false;" class="form-control" id="edit_phone_number" name="phone_number" placeholder="Phone Number *"
                    tabindex="3" required>
                </div>
              
              <div>
                  <button type="submit" name="edit_customer" class="submit_btn">Edit Customer!</button>
              </div>
          </form>
          
      </div>
      </div>
  </div>
    <!-- partial -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./js/customer.js"></script>
  </body>
</html>
