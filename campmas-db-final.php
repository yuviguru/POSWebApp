<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>
  <body>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">

    <?php include 'navigation.php'; 
    if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes'){?> 

    <?php 

    $OLD_ID=$_GET['OLD_ID'];

    $ID=$_GET['ID'];

    $CAMP_BRCode=$_GET['CAMP_BRCode'];
    $CB_Name=$_GET['CB_Name'];
    $CAMP_E_ID=$_GET['CAMP_E_ID'];
    $CAMP_CL_Code=$_GET['CAMP_CL_Code'];
    $CAMP_BR_ID=$_GET['CAMP_BR_ID'];
    $CAMP_Activity=substr($_GET['CAMP_Activity'],0,4);

    $CAMP_CDate=date("Y-m-d");
    $CAMP_CCDate_view=date("d-m-Y");

    if(isset($_GET["Store_Ids"])) {
      $StoreIDs = implode(",",$_GET["Store_Ids"]);
    } else {
      $StoreIDs='';
    }

    $CAMP_ACT_SSDate=strtotime($_GET['CAMP_ACT_SDate']);
    $CAMP_ACT_SDate=date('Y-m-d',$CAMP_ACT_SSDate);
    $CAMP_ACT_SDate_view=date('d-m-Y',$CAMP_ACT_SSDate);


    if($_GET['CAMP_ACT_EDate']!='') {
      $CAMP_ACT_EEDate=strtotime($_GET['CAMP_ACT_EDate']);
      $CAMP_ACT_EDate_test=date('Y-m-d',$CAMP_ACT_EEDate);
      $CAMP_ACT_EDate='"'.$CAMP_ACT_EDate_test.'"';
      $CAMP_ACT_EDate_view=date('d-m-Y',$CAMP_ACT_EEDate);
    } else {
      $CAMP_ACT_EDate="NULL";
      $CAMP_ACT_EDate_view="--------";
    }

    $CAMP_PO_Num=$_GET['CAMP_PO_Num'];

    $CAMP_PO_Date_before=strtotime($_GET['CAMP_PO_Date']);
    $CAMP_PO_Date=date('Y-m-d',$CAMP_PO_Date_before);
    $CAMP_PO_Date_view=date('d-m-Y',$CAMP_PO_Date_before);

    $CAMP_Remarks=$_GET['CAMP_Remarks'];

    $Today=date("Y-m-d H:i:s");

    $Today_view=date("d-m-Y");

    ?>

    <?php
    include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
      echo "<br><br><br><br><br>";
    include 'check_page_access.php';
	
      $sql = "INSERT INTO campaign_master_final(CAMP_PKID,CAMP_EMP_BR_CODE,CAMP_EMP_ID,CAMP_CL_CODE,CAMP_BRD_ID,CAMP_ACTIVITY,CAMP_CC_DATE,CAMP_STORE_ID,CAMP_ACT_SDATE,CAMP_ACT_EDATE,CAMP_PO_NO,CAMP_PO_DATE,CAMP_REMARKS,CREATED_DATE) VALUES ('$ID','$CAMP_BRCode','$CAMP_E_ID','$CAMP_CL_Code','$CAMP_BR_ID','$CAMP_Activity','$CAMP_CDate','$StoreIDs','$CAMP_ACT_SDate',$CAMP_ACT_EDate,'$CAMP_PO_Num','$CAMP_PO_Date','$CAMP_Remarks','$Today')";

      $sql1 = "UPDATE settings set Campaign_Master='$ID' where Campaign_Master='$OLD_ID'";

      if (mysqli_query($conn, $sql)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Campaign" ?> <font color="green"><?php echo $ID ?></font> <?php echo "Created successfully"; ?>
        </div><br><br><br>
      <?php } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

      if (mysqli_query($conn, $sql1)) { ?>
      <?php } else {
          echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
      }

    }
    ?>

    <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x:auto;">
      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
        <thead>
          <tr>
            <th class="mdl-data-table__cell--numeric">Campaign ID</th>
            <th class="mdl-data-table__cell--numeric">Emp.Branch Code</th>
            <th class="mdl-data-table__cell--numeric">Emp.ID</th>
            <th class="mdl-data-table__cell--numeric">Client Code</th>
            <th class="mdl-data-table__cell--numeric">Brand ID</th>
            <th class="mdl-data-table__cell--numeric">Activity</th>
            <th class="mdl-data-table__cell--numeric">Campaign Creation Date</th>
            <th class="mdl-data-table__cell--numeric">Stores ID(S)</th>
            <th class="mdl-data-table__cell--numeric">Activity Start Date</th>
            <th class="mdl-data-table__cell--numeric">Activity End Date</th>
            <th class="mdl-data-table__cell--numeric">PO No.</th>
            <th class="mdl-data-table__cell--numeric">PO Date</th>
            <th class="mdl-data-table__cell--numeric">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $ID; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CB_Name; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_E_ID; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_CL_Code; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_BR_ID; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Activity; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_CCDate_view; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $StoreIDs; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_ACT_SDate_view; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_ACT_EDate_view; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_PO_Num; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_PO_Date_view; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php if($CAMP_Remarks!='') { echo $CAMP_Remarks; } else { echo "-------------"; } ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <br><br><br>
    <div align="center">
      <a href="viewCampaignDetails-Final.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
    <?php
   } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>
</div>
</body>
</html>