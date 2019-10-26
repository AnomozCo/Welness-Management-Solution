<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

?>
<!DOCTYPE html>
<html lang="en">
<?include("./phpParts/head.php")?>

<body class="">
  <div class="wrapper ">
      <?include("./phpParts/leftBar.php")?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Import/Export Data</a>
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
            <?if ($session_role=="admin"){?>
         <a href="./importStudentsData.php" target="_blank"> <button type="submit" class="btn btn-primary">Import Students Data</button></a>
         <?}?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Download Data</h4>
                  <p class="card-category">All your data now under one shelf.</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          ID
                        </th>
                        <th class="text-primary">
                          Type of Data
                        </th>
                        <th>
                          Description
                        </th>
                        <th>
                          View/Download
                        </th>
                      </thead>
                      <tbody>

                        <tr>
                        <td>1</td>
                        <td>Gym Signins</td>
                        <td>Contains details of all Gym Signins done uptil now.</td>
                        <td><a href="./profiles/data/exportData_gymSignins.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>
                        
                        <tr>
                        <td>2</td>
                        <td>Pool Signins</td>
                        <td>Contains details of all Pool Signins done uptil now.</td>
                        <td><a href="./profiles/data/exportData_poolSignins.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>
                        
                        <tr>
                        <td>2</td>
                        <td>Softwares Users</td>
                        <td>Contains details of all software users</td>
                        <td><a href="./profiles/data/exportData_softwaresusers.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>
                      
                        
                        
                        
                      </tbody>
                    </table>
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
