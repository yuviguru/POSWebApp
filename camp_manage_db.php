<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>

  <body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php'; 
     if((isset($_SESSION['USERID'])) && ($_SESSION['APPROVE']=='Yes')) {  

  // if(isset($_POST['submit'])){

    $camp_pkid=$_GET['campid'];
    $str_pkid=$_GET['strpkid'];
    $Emp_id=$_GET['emp_id'];
    $Today=date("Y-m-d H:i:s");
   include 'db-conn.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql_camp_check="SELECT * FROM campaign_management where CAMP_PKID='$camp_pkid'";
    $sql_check = $conn->query($sql_camp_check);

    include 'check_page_access.php';
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  
    else
    {
        if ($sql_check->num_rows > 0) {
        echo "<br><br><br><br><br>";
      $Count= count($_GET['emp_id']);
      echo '<div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">Employee <font color="green"></font> Updated successfully
        </div><br><br><br><table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center"> <thead><tr><th class="mdl-data-table__cell--non-numeric">S.No</th><th class="mdl-data-table__cell--numeric">Campaign ID</th><th class="mdl-data-table__cell--numeric">Store Id</th><th class="mdl-data-table__cell--numeric">Employee ID</th></tr></thead><tbody>';
      for($i=0; $i<$Count; $i++){
        $sql_emp="SELECT EMP_NAME FROM employee_master WHERE EMP_ID ='$Emp_id[$i]'";
        $emp_name=$conn->query($sql_emp);
        $name=$emp_name->fetch_assoc()['EMP_NAME'];
      $sql = "UPDATE campaign_management SET CAMP_PKID='$camp_pkid',STR_PKID='$str_pkid[$i]' ,EMP_ID='$Emp_id[$i]',UPDATED_DATE='$Today' WHERE CAMP_PKID='$camp_pkid' && STR_PKID='$str_pkid[$i]'";
     $conn->query($sql);
      // echo $sql;
?>
      <tr>
           <td class="mdl-data-table__cell--non-numeric"><?php echo $i+1;?></td>
           <td class="mdl-data-table__cell--non-numeric""><?php echo $camp_pkid ?></td>
           <td class="mdl-data-table__cell--non-numeric"><?php echo $str_pkid[$i]; ?></td>
           <td class="mdl-data-table__cell--numeric"><?php echo $Emp_id[$i].'-'.$name; ?></td>
        </tr>
   <?php } ?>
      </tbody>
    </table>
    <br>  
    <br>
    <br>
    <div align="center">
        <a href="CampaignManagement.php">
          <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">Create New</button>
        </a> 
      </div>
   <?php }
   else{
      echo "<br><br><br><br><br>";
      $Count= count($_GET['emp_id']);
      echo '<div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">Employee <font color="green"></font>Assigned successfully
        </div><br><br><br><table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center"> <thead><tr><th class="mdl-data-table__cell--non-numeric">S.No</th><th class="mdl-data-table__cell--numeric">Campaign ID</th><th class="mdl-data-table__cell--numeric">Store Id</th><th class="mdl-data-table__cell--numeric">Employee ID</th></tr></thead><tbody>';
      for($i=0; $i<$Count; $i++){
      $sql = "INSERT INTO campaign_management(CAMP_PKID,STR_PKID,EMP_ID,CREATED_DATE) VALUES ('$camp_pkid','$str_pkid[$i]','$Emp_id[$i]','$Today')";
     $conn->query($sql);
      // echo $sql;
?>
      <tr>
           <td class="mdl-data-table__cell--non-numeric"><?php echo $i+1;?></td>
           <td class="mdl-data-table__cell--non-numeric""><?php echo $camp_pkid ?></td>
           <td class="mdl-data-table__cell--non-numeric"><?php echo $str_pkid[$i]; ?></td>
           <td class="mdl-data-table__cell--numeric"><?php echo $Emp_id[$i]; ?></td>
        </tr>
   <?php } ?>
      </tbody>
    </table>
    <br>  
    <br>
    <br>
    <div align="center">
        <a href="CampaignManagement.php">
          <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">Create New</button>
        </a> 
      </div>
  <?php  } }
    ?>
    
</div>
<?php  } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } 
  ?>
  </body>
  </html>