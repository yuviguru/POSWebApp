<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php';
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?>   

    <?php 


    $ID=$_GET['ID'];

    $CAMP_BRCode=$_GET['CAMP_BRCode'];
    $CAMP_E_ID=$_GET['CAMP_E_ID'];
    $CAMP_CL_Code=$_GET['CAMP_CL_Code'];
    $CAMP_BR_ID=$_GET['CAMP_BR_ID'];
    $CAMP_Activity=$_GET['CAMP_Activity'];
    $CAMP_CDate=$_GET['CAMP_CDate'];
    $CAMP_Email=$_GET['CAMP_Email'];
    $CAMP_CP=$_GET['CAMP_CP'];
    $CAMP_Mobile=$_GET['CAMP_Mobile'];
    $CAMP_Email_CP=$_GET['CAMP_Email_CP'];
    $CAMP_VAT=$_GET['CAMP_VAT'];
    $CAMP_Budget=$_GET['CAMP_Budget'];

    $StoreIDs = implode(",",$_GET["Store_Ids"]);

    $CAMP_CL_Name=$_GET['CAMP_CL_Name'];
    $CAMP_BR_Name=$_GET['CAMP_BR_Name'];
    $CAMP_Approval=$_GET['CAMP_Approval'];
    $CAMP_ACT_SDate=$_GET['CAMP_ACT_SDate'];
    $CAMP_ACT_EDate=$_GET['CAMP_ACT_EDate'];
    $CAMP_PO_Num=$_GET['CAMP_PO_Num'];
    $CAMP_PO_Date=$_GET['CAMP_PO_Date'];
    $CAMP_PO_App_By=$_GET['CAMP_PO_App_By'];
    $CAMP_INV_Num=$_GET['CAMP_INV_Num'];
    $CAMP_INV_Date=$_GET['CAMP_INV_Date'];
    $CAMP_Remarks=$_GET['CAMP_Remarks'];

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

      $sql = "UPDATE campaign_master set Campaign_ID='$ID',EmpBrCode='$CAMP_BRCode',EMPID='$CAMP_E_ID',ClientCode='$CAMP_CL_Code',BrandID='$CAMP_BR_ID',Activity='$CAMP_Activity',Campaign_Created_Date='$CAMP_CDate',Email='$CAMP_Email',ContactPerson='$CAMP_CP',Mobile='$CAMP_Mobile',EmailCP='$CAMP_Email_CP',VAT_Reg='$CAMP_VAT',Budget='$CAMP_Budget',StoreID='$StoreIDs',ClientName='$CAMP_CL_Name',BrandName='$CAMP_BR_Name',QuoteApproved='$CAMP_Approval',Activity_StartDate='$CAMP_ACT_SDate',Activity_EndDate='$CAMP_ACT_EDate',PO_Number='$CAMP_PO_Num',PO_Date='$CAMP_PO_Date',PO_ApprovedBy='$CAMP_PO_App_By',INV_Number='$CAMP_INV_Num',INV_Date='$CAMP_INV_Date',Remarks='$CAMP_Remarks' where Campaign_ID='$ID'";

      if (mysqli_query($conn, $sql)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Campaign" ?> <font color="green"><?php echo $ID ?></font> <?php echo "Details Updated successfully"; ?>
        </div><br><br><br>
      <?php } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

    }
    ?>

    <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x:auto;">
      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
        <thead>
          <tr>
            <th class="mdl-data-table__cell--non-numeric">Campaign ID</th>
            <th class="mdl-data-table__cell--non-numeric">Emp.Branch Code</th>
            <th class="mdl-data-table__cell--non-numeric">Emp.ID</th>
            <th class="mdl-data-table__cell--non-numeric">Client Code</th>
            <th class="mdl-data-table__cell--non-numeric">Brand ID</th>
            <th class="mdl-data-table__cell--non-numeric">Activity</th>
            <th class="mdl-data-table__cell--non-numeric">Campaign Creation Date</th>
            <th class="mdl-data-table__cell--non-numeric">E-Mail ID</th>
            <th class="mdl-data-table__cell--non-numeric">Contact Person(CP)</th>
            <th class="mdl-data-table__cell--non-numeric">Mobile</th>
            <th class="mdl-data-table__cell--non-numeric">E-Mail(CP)</th>
            <th class="mdl-data-table__cell--non-numeric">VAT-Regn</th>
            <th class="mdl-data-table__cell--non-numeric">Budget</th>
            <th class="mdl-data-table__cell--non-numeric">Client Name</th>
            <th class="mdl-data-table__cell--non-numeric">Brand Name</th>
            <th class="mdl-data-table__cell--non-numeric">Quote Approved</th>
            <th class="mdl-data-table__cell--non-numeric">Activity Start Date</th>
            <th class="mdl-data-table__cell--non-numeric">Activity End Date</th>
            <th class="mdl-data-table__cell--non-numeric">PO No.</th>
            <th class="mdl-data-table__cell--non-numeric">PO Date</th>
            <th class="mdl-data-table__cell--non-numeric">PO Aprroved By</th>
            <th class="mdl-data-table__cell--non-numeric">Inv No</th>
            <th class="mdl-data-table__cell--non-numeric">Inv Date</th>
            <th class="mdl-data-table__cell--non-numeric">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $ID; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_BRCode; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_E_ID; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_CL_Code; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_BR_ID; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Activity; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_CDate; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Email; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_CP; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Mobile; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Email_CP; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_VAT; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Budget; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_CL_Name; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_BR_Name; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Approval; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_ACT_SDate; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_ACT_EDate; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_PO_Num; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_PO_Date; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_PO_App_By; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_INV_Num; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_INV_Date; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Remarks; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <br><br><br>
    <div align="center">
      <a href="viewCampaignDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
    <?php } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } ?>
</div>
</body>
</html>