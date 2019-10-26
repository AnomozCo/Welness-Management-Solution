<?$filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);?>
<div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    
      <div class="logo">
        <a href="./" class="simple-text logo-normal">
          <?echo $session_name."'s Panel"?>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item <?if($filename=="dashboard.php"){echo "active";}?>">
            <a class="nav-link" href="./dashboard.php">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item <?if($filename=="history.php"){echo "active";}?>">
            <a class="nav-link" href="./history.php">
              <i class="material-icons">library_books</i>
              <p>Gym Signins</p>
            </a>
          </li>
          <li class="nav-item <?if($filename=="allDataDownload.php"){echo "active";}?>">
            <a class="nav-link" href="./allDataDownload.php">
              <i class="material-icons">import_export</i>
              <p>Export data</p>
            </a>
          </li>
          <li class="nav-item <?if($filename=="settings.php"){echo "active";}?>">
            <a class="nav-link" href="./settings.php">
              <i class="material-icons">settings</i>
              <p>Settings</p>
            </a>
          </li>
        </ul>
      </div>
      
    </div>



