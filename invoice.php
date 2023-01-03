<?php
include 'connect_db.php';
include 'Sesson_end.php';
$currentuser=$_SESSION['id'];
$query = "SELECT invoice_cust_user.invoice_id, customer.name,invoice_total.total_pro ,invoice_total.total_amt FROM invoice_cust_user left join invoice_total on invoice_total.invoice_id = invoice_cust_user.invoice_id left join customer on customer.customer_id = invoice_cust_user.customer_id WHERE invoice_cust_user.users_id =  " . $currentuser ;
$result = mysqli_query($conn, $query);


$invoices = array();

if (mysqli_num_rows($result) >0) { // The query returned some results 
    while ($row = mysqli_fetch_assoc($result)) { // Add the data for each row to the array
  $invoices[] = $row; } } 
  
  $customerquery = "SELECT * From customer where users_id = " .$currentuser;
  $customersdb = mysqli_query($conn, $customerquery);
  $customers = array();

if (mysqli_num_rows($result) >0) { // The query returned some results 
    while ($row = mysqli_fetch_assoc($customersdb)) { // Add the data for each row to the array
  $customers[] = $row; } } 
  $productquery = "SELECT * From product where users_id = " .$currentuser;
  $productsdb = mysqli_query($conn, $productquery);
  $products = array();

if (mysqli_num_rows($result) >0) { // The query returned some results 
    while ($row = mysqli_fetch_assoc($productsdb)) { // Add the data for each row to the array
  $products[] = $row; } } 


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_POST["add_invoice"]))
    {
        $cust_id=mysqli_real_escape_string($conn, $_POST['customer_id']);
        $pro_id=mysqli_real_escape_string($conn, $_POST['product_id']);
        $pro_qty=mysqli_real_escape_string($conn, $_POST['pro_qty']);

        $query1 = "INSERT INTO invoice_cust_user(users_id,customer_id) values ('$currentuser','$cust_id')";
        if (mysqli_query($conn, $query1))
        {
            $query2 = "Set @max_id = 0;SELECT max(invoice_id) into @max_id from invoice_cust_user;INSERT INTO invoice_product(invoice_id,product_id,Num) VALUES (@max_id,'$pro_id','$pro_qty')";
            if (mysqli_multi_query($conn, $query2))
            {
                header('Location: invoice.php');
                exit;
            }
        }
      
     
    }
    
  }
  
  
  
  

?>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>invoices</title>
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
  <link rel="stylesheet" type="text/css" href="./css/invoice.css" />
  
   
  <script>
    var invoices = <?php echo json_encode($invoices); ?>;
    var customers = <?php echo json_encode($customers); ?>;
    var products = <?php echo json_encode($products); ?>;
  </script>
</head>
<body>
  
<?php
  include 'header.php';
  ?>
  <table
    id="invoices"
    class="table table-striped table-bordered"
    cellspacing="0"
    width="100%"
  >
    <thead>
      <tr>
        <th>No.</th>
        <th>Customer Name</th>
        <th>Total No. of Products</th>
        <th>Total Amount</th>

        <th style="text-align: center; width: 100px">
          Add Invoice
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
                <label for="Customer_name" class="form-label">Customer Name</label>
                <select name="Customer_name" class="form-control" onchange="cust_change(event)" id="add_customer_name" required>
                    <option disabled value="" selected hidden>Customer Name</option>
                </select>
                <input class="form-control " type = "number" name ="customer_id" id="cu_id" >
            </div>
            <div class="form-group">
                <label for="Customer_email" class="form-label">Customer Email</label>
                <input class="form-control " id="cu_email" placeholder="Customer Email" disabled>
            </div>
            <div id="products_to_add">
            <div class="form-group">
                <label for="Product_name" class="form-label">Product Name</label>
                <select name="Product_name" class="form-control" onchange="pro_change(event)" id="add_Product_name" required>
                    <option disabled value="" selected hidden>Product Name</option>
                </select>
                <input type = "number" name ="product_id" id="pro_id" hidden>
            </div>
            <div class="form-group">
                <label for="Product_price" class="form-label">Product Price</label>
                <input class="form-control " id="pro_price" placeholder="Product Price" disabled>
            </div>
            <div class="form-group">
                <label for="Quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="pro_qty" placeholder="Enter Quantity *" required>
            </div>
            </div>
            <div>
                <button type="submit" name="add_invoice" class="submit_btn">Add Procduct!</button>
            </div>
        </form>
        
    </div>
</div>
    <div id="edit_row_popup">
    <div class="form-container modal-content">
        <form  method="POST" class="form">
        <div class="form-group">
                <label for="id" class="form-label">invoice No</label>
                <input type="text" class="form-control" id="edit_id"  placeholder="" disabled>
                <input name="id" id="edit_id_h" hidden>
            </div>
            <div class="form-group">
                <label for="name" class="form-label">invoice Name</label>
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
                <button type="submit" name="edit_invoice" class="submit_btn">Edit Procduct!</button>
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
  <script src="./js/invoice.js"></script>
</body>
</html>
