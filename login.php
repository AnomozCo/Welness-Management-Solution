<?include_once("global.php");?>
<?if ($logged==1){ 
    if($session_role=="pool"){
       ?>
    <script type="text/javascript">
            window.location = "./pool/dashboard.php";
        </script>
    <? 
    }
    if($session_role=="gym"){
       ?>
    <script type="text/javascript">
            window.location = "./gym/dashboard.php";
        </script>
    <? 
    }
    if($session_role=="admin"){
       ?>
    <script type="text/javascript">
            window.location = "./dashboard.php";
        </script>
    <? 
    }
    
}
if(isset($_POST["email"])){
    $email = $_POST["email"]; 
    $password = md5($_POST["password"]);
if((!$email)||(!$password)){
    $message = "Please insert both fields.";
    } 
else{ 

        //$_SESSION['email'] = $email;
    $query = "SELECT *  FROM wel_users WHERE email='$email' AND password='$password'";
    $result = $con->query($query);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) 
    { 
        $logged=1;
        $_SESSION['password'] = $password;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $row['role'];
        $_SESSION['name'] = $row['name'];
        $session_role = $_SESSION['role'];
        
        if($session_role=="pool"){
       ?>
    <script type="text/javascript">
            window.location = "./pool/dashboard.php";
        </script>
    <? 
    }
    if($session_role=="gym"){
       ?>
    <script type="text/javascript">
            window.location = "./gym/dashboard.php";
        </script>
    <? 
    }
    if($session_role=="admin"){
       ?>
    <script type="text/javascript">
            window.location = "./dashboard.php";
        </script>
    <? 
    }
    
    }
}
    } 
    }?>
<!DOCTYPE html>
<html lang="en">
<?include("./phpParts/head.php")?>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
     
      
    </div>
    <div class="main-panel">
      <!-- Navbar -->
 
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">User Login - Wellness Center</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="POST" action="">
                     <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Email</label>
                          <input name="email" type="email" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Password</label>
                          <input name="password" type="password" class="form-control" placeholder="">
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Sign in</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?include("./phpParts/footer.php")?>

</body>

</html>
