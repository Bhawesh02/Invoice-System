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

if (mysqli_num_rows($customersdb) >0) { // The query returned some results 
while ($row = mysqli_fetch_assoc($customersdb)) { // Add the data for each row to the array
$customers[] = $row; } } 
  $productquery = "SELECT * From product where users_id = " .$currentuser;
  $productsdb = mysqli_query($conn, $productquery);
  $products = array();

if (mysqli_num_rows($productsdb) >0) { // The query returned some results 
    while ($row = mysqli_fetch_assoc($productsdb)) { // Add the data for each row to the array
  $products[] = $row; } } 


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_POST["add_invoice"]))
    {
        $cust_id=mysqli_real_escape_string($conn, $_POST['customer_id']);
        $query1 = "INSERT INTO invoice_cust_user(users_id,customer_id) values ('$currentuser','$cust_id')";
        mysqli_query($conn, $query1);
        $no_of_product=mysqli_real_escape_string($conn, $_POST['no_of_product']);
        for ($i=1; $i <= $no_of_product ; $i++) { 
            $pro_id=mysqli_real_escape_string($conn, $_POST['product_id_'.$i]);
            $pro_qty=mysqli_real_escape_string($conn, $_POST['pro_qty_'.$i]);
           
            $query2 = "Set @max_id = 0";
             mysqli_query($conn, $query2);
             $query2 = "SELECT max(invoice_id) into @max_id from invoice_cust_user";
             mysqli_query($conn, $query2);
             $query2 = "INSERT INTO invoice_product(invoice_id,product_id,Num) VALUES (@max_id,'$pro_id','$pro_qty')";
             mysqli_query($conn, $query2);
            
            
            
        
        
      
     
    }
    header('Location: invoice.php');
                exit;
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
  <h2>INVOICES</h2>
  <table
    id="invoices"
    class="table table-striped table-bordered"
    cellspacing="0"
    width="100%"
  >
    <thead>
      <tr>
        <th>Invoice Number</th>
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
            <input type="number" value = 0 name="no_of_product" id="num_of_pro" hidden>
            </div>
            <div>
                <button type="submit" name="add_invoice" class="submit_btn">Add Procduct!</button>
            </div>
        </form>
        
    </div>
</div>
<div id="confirm_view">
  <div class="form-container modal-content">
    <form  method="POST" class="form">
      <div class="form-group">
        <h4>Confirm View?</h4>
        <input name="invoice_id" id="invoice_id" hidden>
        <div>
                <button type="submit" name="view_invoice" class="submit_btn" id="view_invoice">View Invoice!</button>
            </div>
      </div>
    </form>
  </div>
</div>
    <div id="edit_row_popup">
    <div class="form-container modal-content">
      <?php
      if(isset($_POST["view_invoice"]))
      {
        echo "Hello";
      }
      ?>
        <form  method="POST" class="form">
        <div class="form-group">
                <label for="id" class="form-label">invoice No</label>
                <input type="text" class="form-control" id="edit_id"  placeholder="" disabled>
                <input name="id" id="edit_id_h" hidden>
            </div>
            <div class="form-group">
                <label for="name" class="form-label">Customer Name</label>
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
