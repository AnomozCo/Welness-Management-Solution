<?include_once("global.php");?>
<!DOCTYPE html>
<html lang="en">

<?include("./phpParts/head.php")?>
<body class="">

<?
date_default_timezone_set("Asia/Karachi");
function logout() {
    session_destroy();
  }
  if (isset($_GET['logout'])) {
    logout();
    $logged=0;
  }
  
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

if($logged==1){
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
    
}





//expired rooms list
$query_expiredRoomsList = "select*from wel_students s inner join wel_bookings b on s.cardnumber = b.studentId where b.endTime='' and b.category='pool' order by b.id desc"; 
// and ((n.notfType is null)or(n.notfType='-1min')) 
$result_expiredRoomList = $con->query($query_expiredRoomsList); 

//expired rooms list
$query_expiredRoomsList = "select*from wel_students s inner join wel_bookings b on s.cardnumber = b.studentId where b.endTime!='' and b.category='pool' order by b.id desc"; 
// and ((n.notfType is null)or(n.notfType='-1min')) 
$result_bookedRoomList = $con->query($query_expiredRoomsList); 

//expired rooms list
$query_gymin = "select*from wel_students s inner join wel_bookings b on s.cardnumber = b.studentId where b.endTime='' and b.category='gym' order by b.id desc"; 
// and ((n.notfType is null)or(n.notfType='-1min')) 
$result_gymin= $con->query($query_gymin); 

//expired rooms list
$query_gymin = "select*from wel_students s inner join wel_bookings b on s.cardnumber = b.studentId where b.endTime!='' and b.category='gym' order by b.id desc"; 
// and ((n.notfType is null)or(n.notfType='-1min')) 
$result_gymout= $con->query($query_gymin); 

//pool up


//number of rooms booked uptil now
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where category='pool'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nRoomsBookedTillNow= $row['amount'];
    }
}


//free rooms
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where endTime='' and category='pool'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $inPool= $row['amount'];
    }
}

//booked rooms
$da =date("d-m")."-20".date("y");
$da = strtotime($da);
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where startTime>'$da' and category='pool'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nBookedRooms= $row['amount'];
    }
}

//months signin
$da = "1-".date("m")."-20".date("y");
$da = strtotime($da);
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where startTime>'$da' and category='pool'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $monthsSignin= $row['amount'];
    }
}


//gym down



//number of rooms booked uptil now
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where category='gym'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nRoomsBookedTillNow_gym= $row['amount'];
    }
}


//free rooms
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where endTime='' and category='gym'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $inPool_gym= $row['amount'];
    }
}

//booked rooms
$da =date("d-m")."-20".date("y");
$da = strtotime($da);
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where startTime>'$da' and category='gym'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nBookedRooms_gym= $row['amount'];
    }
}

//months signin
$da = "1-".date("m")."-20".date("y");
$da = strtotime($da);
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where startTime>'$da' and category='gym'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $monthsSignin_gym= $row['amount'];
    }
}

//pool signin

?>
<script>
/**
    
    var pool_x = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];
    var pool_y =[112, 17, 7, 17, 23, 18, 38];
    **/
    var pool_x = [];
    var pool_y =[];
</script>
<?

//sent notf status
$query = "select COUNT(startTime) as 'nSignins', DATE_FORMAT(FROM_UNIXTIME(`startTime`), '%e %b %Y') AS 'date_formatted'
 from wel_bookings where category='pool' GROUP by DATE_FORMAT(FROM_UNIXTIME(`startTime`), '%e %b %Y')  order by id asc
"; 
$result = $con->query($query); 
$i = 0;
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        ?>
        <script>
            pool_y[<?echo $i?>] = "<?echo $row['nSignins']?>"
            pool_x[<?echo $i?>] = "<?echo ''?>"
        </script>
        <?
        $i +=1;
    }
}

//gym signin

?>
<script>
/**
    
    var pool_x = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];
    var pool_y =[112, 17, 7, 17, 23, 18, 38];
    **/
    var gym_x = [];
    var gym_y =[];
</script>
<?

//sent notf status
$query = "select COUNT(startTime) as 'nSignins', DATE_FORMAT(FROM_UNIXTIME(`startTime`), '%e %b %Y') AS 'date_formatted'
 from wel_bookings where category='gym' GROUP by DATE_FORMAT(FROM_UNIXTIME(`startTime`), '%e %b %Y')  order by id asc
"; 
$result = $con->query($query); 
$i = 0;
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        ?>
        <script>
            gym_y[<?echo $i?>] = "<?echo $row['nSignins']?>"
            gym_x[<?echo $i?>] = "<?echo ''?>"
        </script>
        <?
        $i +=1;
    }
}




?>
  <div class="wrapper">
      <?include("./phpParts/leftBar.php")?>
    <div class="main-panel">
      <!-- Navbar -->
      <?include("./phpParts/navBar.php")?>
        
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
            <div class="alert alert-primary" role="alert" style="display:none;" id="pageReloadPop">
            Update detected. Page reloading...
        </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">pool</i>
                  </div>
                  <p class="card-category">People in Pool</p>
                  <h3 class="card-title"><?echo $inPool?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of people currently in pool
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">calendar_today</i>
                  </div>
                  <p class="card-category">Today's Pool signins</p>
                  <h3 class="card-title" id="nBookedRooms"><?echo $nBookedRooms?>                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who signed in pool today
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Month's Pool signins</p>
                  <h3 class="card-title" id="nExpiredRooms"><?echo $monthsSignin?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who signed in pool this month
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">library_books</i>
                  </div>
                  <p class="card-category">Total Pool Signins</p>
                  <h3 class="card-title"><?echo $nRoomsBookedTillNow?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who have signed in pool till now
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">fitness_center</i>
                  </div>
                  <p class="card-category">People in Gym</p>
                  <h3 class="card-title"><?echo $inPool_gym?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of people currently in Gym
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">calendar_today</i>
                  </div>
                  <p class="card-category">Today's Gym signins</p>
                  <h3 class="card-title" id="nBookedRooms"><?echo $nBookedRooms_gym?>                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who signed in Gym today
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Month's Gym signins</p>
                  <h3 class="card-title" id="nExpiredRooms"><?echo $monthsSignin_gym?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who signed gym in this month
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">library_books</i>
                  </div>
                  <p class="card-category">Total Gym Signins</p>
                  <h3 class="card-title"><?echo $nRoomsBookedTillNow_gym?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who have signed in gym till now
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
              
              <div class="col-md-12 col-lg-6">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <div class="ct-chart" id="dailySalesChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Overall Pool Signins</h4>
                  <p class="card-category">
                    Shows the overall trend of the Pool Signins</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Reload page to Refresh
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-12 col-lg-6">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <div class="ct-chart" id="dailySalesChart_gym"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Overall Gym Signins</h4>
                  <p class="card-category">
                    Shows the overall trend of the Gym Signins</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Reload page to Refresh
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title" data-toggle="tooltip" data-placement="right" title="Current status of all rooms">Today's Pool's Signins</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            Signed in
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            Signed Out
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                      <table class="table">
                          <thead class="text-success">
                      <th>Name</th>
                      <th>UserId</th>
                      <th>Time</th>
                    </thead>
                        <tbody>
                          <?php
                          $i=0;
                            if ($result_expiredRoomList->num_rows > 0)
                            { 
                                while($row = $result_expiredRoomList->fetch_assoc()) 
                                { 

                                    echo "<tr>";
                                    echo "<td>".$row['firstname']." ".$row['surname']."</td>";
                                    echo "<td>".$row['studentId']."</td>";
                                    echo "<td>".date('H:i',$row['startTime'])."</td>";
                                    echo "</tr>";
                                     
                                }
                            }
                          ?>
                         
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  
                                </label>
                              </div>
                            </td>
                            
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="messages">
                      <table class="table">
                          <thead class="text-success">
                      <th>Name</th>
                      <th>UserId</th>
                      <th>Time In</th>
                      <th>Time Out</th>
                    </thead>
                        <tbody>
                          <?php
                            if ($result_bookedRoomList->num_rows > 0)
                            { 
                                while($row = $result_bookedRoomList->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['firstname']." ".$row['surname']."</td>";
                                    echo "<td>".$row['studentId']."</td>";
                                    echo "<td>".date('H:i',$row['startTime'])."</td>";
                                     echo "<td>".date('H:i',$row['endTime'])."</td>";
                                    echo "</tr>";
                                }
                            }
                          ?>

                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  
                                </label>
                              </div>
                            </td>

                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            
            <div class="col-lg-6 col-md-12">
                            <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">Today's Gym's Signins</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="add students to the queue when all rooms are busy">
                          <a class="nav-link active" href="#bookingQueue" data-toggle="tab">
                            Signed in
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#book" data-toggle="tab">
                            Signed out
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="bookingQueue">
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-success">
                      <th>Name</th>
                      <th>UserId</th>
                      <th>Time In</th>
                    </thead>
                    <tbody>
                      <?
                      if ($result_gymin->num_rows > 0)
                            { 
                                while($row = $result_gymin->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['firstname']." ".$row['surname']."</td>";
                                    echo "<td>".$row['studentId']."</td>";
                                    echo "<td>".date('H:i',$row['startTime'])."</td>";
                                    echo "</tr>";
                                }
                            }
                      ?>
                        
                    </tbody>
                    
                  </table>
                  
                </div>

                    </div>
                    <div class="tab-pane" id="book">
                      <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-success">
                      <th>Name</th>
                      <th>UserId</th>
                      <th>Time In</th>
                      <th>Time Out</th>
                    </thead>
                        <tbody>
                      <?
                      if ($result_gymout->num_rows > 0)
                            { 
                                while($row = $result_gymout->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['firstname']." ".$row['surname']."</td>";
                                    echo "<td>".$row['studentId']."</td>";
                                    echo "<td>".date('H:i',$row['startTime'])."</td>";
                                     echo "<td>".date('H:i',$row['endTime'])."</td>";
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
          
          
        </div>
      </div>
    </div>
            <?//include("./phpParts/footer.php")?>
            
            <script src="https://hu.anomoz.com/wellness/assets/js/core/jquery.min.js"></script>
  <script src="https://hu.anomoz.com/wellness/assets/js/core/popper.min.js"></script>
  <script src="https://hu.anomoz.com/wellness/assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="https://hu.anomoz.com/wellness/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="https://hu.anomoz.com/wellness/assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="https://hu.anomoz.com/wellness/assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="https://hu.anomoz.com/wellness/assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="https://hu.anomoz.com/wellness/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->

  <!-- Chartist JS -->
  <script src="https://hu.anomoz.com/wellness/assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script>
  
  
  /*!

 =========================================================
 * Material Dashboard - v2.1.1
 =========================================================

 * Product Page: https://www.creative-tim.com/product/material-dashboard
 * Copyright 2018 Creative Tim (http://www.creative-tim.com)

 * Designed by www.invisionapp.com Coded by www.creative-tim.com

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 */


   function initDashboardPageCharts() {

    //pool graph
    if ($('#dailySalesChart').length != 0 || $('#completedTasksChart').length != 0 || $('#websiteViewsChart').length != 0) {
      /* ----------==========     Daily Sales Chart initialization    ==========---------- */
        
      dataDailySalesChart = {
        labels: pool_x,
        series: [
          pool_y
        ]
      };

      optionsDailySalesChart = {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0
        }),
        low: 0,
        high: Math.max(...pool_y)+1, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
      }

      var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);
      
      //gym graph
      
       dataDailySalesChart = {
        labels: gym_x,
        series: [
          gym_y
        ]
      };

      optionsDailySalesChart = {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0
        }),
        low: 0,
        high: Math.max(...gym_y)+1, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
      }

      var dailySalesChart_gym = new Chartist.Line('#dailySalesChart_gym', dataDailySalesChart, optionsDailySalesChart);
      
      

    }
    
    
  
       
       
   }





    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      initDashboardPageCharts();

    });
  </script>

</body>

</html>
