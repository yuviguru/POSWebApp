<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?> 
  <body>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php';

    include 'salvos_globals.php';
    include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    include 'check_page_access.php';
    
    if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes') { 

      $ACT_NAME=$_GET['ACT_NAME'];

      $sql_activity_dup_check = $conn->query("SELECT * FROM activity_master WHERE ACT_NAME='$ACT_NAME'");
      if(($sql_activity_dup_check->num_rows > 0) && (!isset($_GET['Confirmation']))) { ?><br><br><br> 

      <div class="moz-margin" align="center">
        <h3 style="color:red;font-size:20px;">The Activity You have entered is already exist in the Database.<br>Do You want to continue?</h3>
        <a href="<?php echo basename($_SERVER['REQUEST_URI']).'&Confirmation=Yes'?>"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">Yes</button></a>
        <a href="activity-master.php"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">No</button></a>
      </div><br> 
      <div class="mdl-cell mdl-cell--12-col scroll-table" align="center">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
          <thead>
            <tr>
              <th class="mdl-data-table__cell--numeric">Activity Code</th>
              <th class="mdl-data-table__cell--numeric">Name</th>
              <th class="mdl-data-table__cell--numeric">Category</th>
              <th class="mdl-data-table__cell--numeric">Dependencies</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($sql_activity_dup = $sql_activity_dup_check->fetch_assoc()) { ?>
          <tr>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_activity_dup['ACT_PKID'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_activity_dup['ACT_NAME'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php $CAT_DUP = explode(',', $sql_activity_dup['ACT_CATEGORY']);
                                                             $prefix = $catnames ='';
                                                            foreach($CAT_DUP as $CAT){
                                                              $sql_cat = $conn->query("SELECT * FROM categories WHERE CAT_ID='$CAT'");
                                                              $cat_det = $sql_cat->fetch_assoc();
                                                              $catnames .= $prefix.$cat_det['CAT_NAME'];
                                                              $prefix = ', ';
                                                            }
                                                            echo $catnames; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_activity_dup['ACT_DEPEND'];?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div> 
    <?php } else {

    $OLD_ID=$_GET['OLD_ID'];
    $ID=$_GET['ID'];
    $ACT_NAME=$_GET['ACT_NAME'];
    $ACT_CAT=$_GET['ACT_CAT'];
    $ACT_CAT_ATTACH =  "'".implode(",",$ACT_CAT)."'";
    

    if(isset($_GET['ACT_DEP'])){
    $ACT_DEP=$_GET['ACT_DEP'];
    $ACT_DEP_ATTACH =  "'".implode(",",$ACT_DEP)."'";
    $ACT_DEP_VIEW =  implode(",",$ACT_DEP);
    }else{
      $ACT_DEP_ATTACH = "NULL";
      $ACT_DEP_VIEW =  "-------";
    }
    
    $Today=date("Y-m-d H:i:s");
    
    

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
      echo "<br><br><br><br><br>";

      $sql = "INSERT INTO activity_master(ACT_PKID, ACT_NAME, ACT_CATEGORY, ACT_DEPEND, ACT_CREATED_BY, CREATED_DATE) VALUES ('$ID','$ACT_NAME',$ACT_CAT_ATTACH,$ACT_DEP_ATTACH,'$Logged_User','$Today')";
      $sql1 = "UPDATE settings set Activity_Master='$ID' where Activity_Master='$OLD_ID'";

      if ((mysqli_query($conn, $sql)) && (mysqli_query($conn, $sql1))) { 
        foreach ($ACT_CAT as $CAT) {
          $sql_act="INSERT INTO activity_category_elements(ACT_PKID, CAT_ID, CREATED_DATE, CREATED_BY) VALUES ('$ID','$CAT','$Today','$Logged_User')";
          if (mysqli_query($conn, $sql_act)){

          }
          else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
        }
        ?>

        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Activity" ?> <font color="green"><?php echo $ID ?></font> <?php echo "Created successfully"; ?>
        </div><br><br><br>

        <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x:auto;">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
          <thead>
            <tr>
              <th class="mdl-data-table__cell--numeric">Activity Code</th>
              <th class="mdl-data-table__cell--numeric">Name</th>
              <th class="mdl-data-table__cell--numeric">Category</th>
              <th class="mdl-data-table__cell--numeric">Dependencies</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="mdl-data-table__cell--non-numeric"><?php echo $ID;?></td>
              <td class="mdl-data-table__cell--non-numeric"><?php echo $ACT_NAME;?></td>
              <td class="mdl-data-table__cell--non-numeric"><?php if(isset($_GET['ACT_CAT'])){ 
                                                             $prefix = $catnames ='';
                                                            foreach($ACT_CAT as $CAT){
                                                              $sql_cat = $conn->query("SELECT * FROM categories WHERE CAT_ID='$CAT'");
                                                              $cat_det = $sql_cat->fetch_assoc();
                                                              $catnames .= $prefix.$cat_det['CAT_NAME'];
                                                              $prefix = ', ';
                                                            }
                                                            echo $catnames; 
                                                            } else {
                                                              echo "-------"; 
                                                            } ?>
              </td>
              <td class="mdl-data-table__cell--non-numeric"><?php echo $ACT_DEP_VIEW;?></td>
            </tr>
          </tbody>
        </table>
      </div>  
      <br>
      <br>  
      <br>
      <div align="center">
      <a href="viewActivityDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
      <?php } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);     
        }     
      }
      }
    } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
    ?>
  </div>
  </body>
  </html>