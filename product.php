
<?php
include 'connect_db.php';
include 'Sesson_end.php';
        $currentuser=$_SESSION['id'];
        $query = "SELECT * FROM product where users_id =" . $currentuser;
        $result = mysqli_query($conn, $query);
        
        $products = array();

if (mysqli_num_rows($result) >0) { // The query returned some results 
  while ($row = mysqli_fetch_assoc($result)) { // Add the data for each row to the array
$products[] = $row; } } 



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $name = mysqli_real_escape_string($conn, $_POST['name']);

  $price = mysqli_real_escape_string($conn, $_POST['price']);
  if(isset($_POST["add_product"]))
  {
    
    $query = "INSERT INTO product (name,price, users_id) VALUES ('$name','$price', '$currentuser')";
    if (mysqli_query($conn, $query)) {
      header('Location: product.php');
      exit;
  } else {
      // Signup failed
      echo 'Error: ' . mysqli_error($conn);
  }
    
  }
  elseif (isset($_POST["edit_product"])) {
   
    
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $query = "Update product set name = '$name',price = '$price' where product_id = '$id'";
  if (mysqli_query($conn, $query)) {
    header('Location: product.php');
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
    <title>Products</title>
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
    <link rel="stylesheet" type="text/css" href="./css/product.css" />
    
     
    <script>
      var products = <?php echo json_encode($products); ?>;
    </script>
  </head>
  <body>
    
  <?php
    include 'header.php';
    ?>
    <h2>PRODUCTS</h2>
    <table
      id="Products"
      class="table table-striped table-bordered"
      cellspacing="0"
      width="100%"
    >
      <thead>
        <tr>
          <th>No.</th>
          <th>Name</th>
          <th>MRP</th>

          <th style="text-align: center; width: 100px">
            Add row
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
                  <label for="name" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Name *" tabindex="1" required>
              </div>
              <div class="form-group">
                  <label for="price" class="form-label">MRP</label>
                  <input type="number"  class="form-control" id="price" name="price" placeholder="MRP *"
                  tabindex="2" required>
              </div>
              
              <div>
                  <button type="submit" name="add_product" class="submit_btn">Add Product!</button>
              </div>
          </form>
          
      </div>
</div>
      <div id="edit_row_popup">
      <div class="form-container modal-content">
          <form  method="POST" class="form">
          <div class="form-group">
                  <label for="id" class="form-label">Product No</label>
                  <input type="text" class="form-control" id="edit_id"  placeholder="" tabindex="1" disabled>
                  <input name="id" id="edit_id_h" hidden>
              </div>
              <div class="form-group">
                  <label for="name" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="edit_name" name="name" placeholder="Name *" tabindex="2" required>
              </div>
              <div class="form-group">
                  <label for="price" class="form-label">MRP</label>
                  <input type="number"  class="form-control" id="edit_price" name="price" placeholder="MRP *"
                  tabindex="3" required>
              </div>
              
              <div>
                  <button type="submit" name="edit_product" class="submit_btn">Edit Product!</button>
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
    <script src="./js/product.js"></script>
  </body>
</html>
