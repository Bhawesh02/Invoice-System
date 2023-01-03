<?php
include 'Sesson_end.php';
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" type="text/css" href="./css/home.css" />
    <link rel="stylesheet" type="text/css" href="./css/header.css" />
    <title>Home page</title>
  </head>
  <body>
    <?php
    include 'header.php';
    ?>
    <section>
      <div class="container">
        <div class="card" onclick="redirect('product')">
          <div class="content">
            <div class="contentBx">
              <h3>Products</h3>
            </div>
          </div>
        </div>

        <div class="card" onclick="redirect('customer')">
          <div class="content">
            <div class="contentBx">
              <h3>Customers</h3>
            </div>
          </div>
        </div>

        <div class="card" onclick="redirect('invoice')">
          <div class="content">
            <div class="contentBx">
              <h3>Invoice</h3>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
  <script>
    function redirect(page) {
      window.location = page + '.php';
    }
  </script>
</html>
