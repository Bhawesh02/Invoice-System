<?php
include 'Sesson_end.php';
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap"
      rel="stylesheet"
    />
    <script src="https://kit.fontawesome.com/36bed4b74a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/home.css" />
    <script src="./js/destroySesson.js" defer></script>
    <title>Homme page</title>
  </head>
  <body>
    <header>
      <div class="inner flex">
        <div class="logo">
          <h1><span>Company</span> name</h1>
        </div>
        <button
          class="mobile-nav-toggle"
          aria-controls="primary-navigation"
          aria-expanded="false"
        >
          <span class="sr-only">Menu</span>
        </button>

        <nav>
          <ul
            id="primary-navigation"
            data-visible="false"
            class="primary-navigation flex"
          >
            <li><span class="user_info"> <i class="fa-solid fa-user"></i> <?php echo $_SESSION['name']?></span></li>
            <li><a href="?call_function=1">Sign Out</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <section>
      <div class="container">
        <div class="card">
          <div class="content">
            <div class="contentBx">
              <h3>Products<br /><span>nice</span></h3>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="content">
            <div class="contentBx">
              <h3>Customers<br /><span>nice</span></h3>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="content">
            <div class="contentBx">
              <h3>Invoice<br /><span>nice</span></h3>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
