<head><link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap"
      rel="stylesheet"
    />
    <script src="https://kit.fontawesome.com/36bed4b74a.js" crossorigin="anonymous"></script></head>
<header>
      <div class="inner flex">
        <div class="logo">
          <h1><span>A-Z</span>company</h1>
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