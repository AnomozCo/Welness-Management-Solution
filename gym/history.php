<?include_once("../global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}
if ($session_role!="gym"){
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

//number of rooms booked uptil now
$query = "select*from wel_students s inner join wel_bookings b on s.cardnumber = b.studentId where b.category='gym' order by b.id desc"; 
$result = $con->query($query); 

?>
<!DOCTYPE html>
<html lang="en">
<?include("../phpParts/head.php")?>

<body class="">
  <div class="wrapper ">
    <?include("./phpParts/leftBar.php")?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Past Signins</a>
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
            <div class="col-md-12">
              <!--
              <div class="form-check form-check-radio">
                  <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
                      Room 201
                      <span class="circle">
                          <span class="check"></span>
                      </span>
                  </label>
                  <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
                      Room 202
                      <span class="circle">
                          <span class="check"></span>
                      </span>
                  </label>
              </div>
            -->
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Past Signins</h4>
                  <p class="card-category">Find all the past signins here</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          No.
                        </th>
                        <th class="text-primary">
                          StudentId
                        </th>
                        <th class="text-primary">
                          Name
                        </th>
                        <th>
                          Time In
                        </th>
                        <th>
                          Date
                        </th>
                      </thead>
                      <tbody>

                        <?php
                        if ($result->num_rows > 0)
                        { 
                            
                            while($row = $result->fetch_assoc()) 
                            { 
                                date_default_timezone_set("Asia/Karachi");
                                    $currentDateTime = date('Y/m/d H:i:s',$row['expiry']);
                                    $newDateTime = date('h:i:s A', strtotime($currentDateTime));
                                echo "<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['studentId']."</td>";
                                    echo "<td>".$row['firstname']." ".$row['surname']."</td>";
                                    echo "<td>".date('H:i',$row['startTime'])."</td>";
                                    echo "<td>".date('d-M-Y',$row['startTime'])."</td>";
                                    
                                    echo "</tr>";

                            }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?include("../phpParts/footer.php")?>

</body>

</html>
