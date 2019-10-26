<?include_once("../global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}
if ($session_role!="pool"){
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}
if(isset($_POST["oldPassword"])){
    $newPassword = md5($_POST["newPassword"]);
    $oldPassword = md5($_POST["oldPassword"]);

if((!$newPassword)||(!$oldPassword)){
    $message = "Please insert both fields.";
    } 
else{ 

        //update room status
        $sql="update wel_users  set password='$newPassword' where password='$oldPassword' and email='$session_email '";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
       
        ?>
    <script type="text/javascript">
            window.location = "./dashboard.php";
        </script>
    <?
        
}}


?>
<!DOCTYPE html>
<html lang="en">
<?include_once("../phpParts/head.php");?>


<body class="">
  <div class="wrapper ">
      <?include("./phpParts/leftBar.php")?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Settings</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12 col-md-12">
              
              <div class="card" style="margin-top: 40px;">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Change Password</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="post" action="" autocomplete="off" >
                     <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Old Password</label>
                          <input id="studentIdBox"  name="oldPassword" type="password" class="form-control" placeholder="" required>
                        </div>
                       <div class="form-group col-md-6">
                          <label for="inputEmail4">New Password</label>
                          <input id="studentIdBox"  name="newPassword" type="password" class="form-control" placeholder="" required>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

        </div>
        
        
   
      </div>
     <?include_once("../phpParts/footer.php");?>

</body>

</html>
