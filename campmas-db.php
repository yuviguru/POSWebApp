<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>
  <body>
    <?php include 'navigation.php'; 
    if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes'){?> 

    <?php 

    $OLD_ID=$_GET['OLD_ID'];

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

    $StoreIDs = implode(",",$_GET["Store_Ids"]);;

    $CAMP_CL_Name=$_GET['CAMP_CL_Name'];
    $CAMP_BR_Name=$_GET['CAMP_BR_Name'];
    $CAMP_Approval=$_GET['CAMP_Approval'];
    $CAMP_ACT_SDate=$_GET['CAMP_ACT_SDate'];
    $CAMP_ACT_EDate=$_GET['CAMP_ACT_EDate'];
    $CAMP_Email_Personal=$_GET['CAMP_Email_Personal'];
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
      $sql = "INSERT INTO campaign_master(Campaign_ID,EmpBrCode,EMPID,ClientCode,BrandID,Activity,Campaign_Created_Date,Email,ContactPerson,Mobile,EmailCP,VAT_Reg,Budget,StoreID,ClientName,BrandName,QuoteApproved,Activity_StartDate,Activity_EndDate,PO_Number,PO_Date,PO_ApprovedBy,INV_Number,INV_Date,Remarks) VALUES ('$ID','$CAMP_BRCode','$CAMP_E_ID','$CAMP_CL_Code','$CAMP_BR_ID','$CAMP_Activity','$CAMP_CDate','$CAMP_Email','$CAMP_CP','$CAMP_Mobile','$CAMP_Email_CP','$CAMP_VAT','$CAMP_Budget','$StoreIDs','$CAMP_CL_Name','$CAMP_BR_Name','$CAMP_Approval','$CAMP_ACT_SDate','$CAMP_ACT_EDate','$CAMP_PO_Num','$CAMP_PO_Date','$CAMP_PO_App_By','$CAMP_INV_Num','$CAMP_INV_Date','$CAMP_Remarks')";

      $sql1 = "UPDATE settings set Campaign_Master='$ID' where Campaign_Master='$OLD_ID'";

      if ((mysqli_query($conn, $sql) && (mysqli_query($conn, $sql1)))) { ?>
        <div class="moz-margin" align="center" style="color: red;font-size: 20px;">
          <?php echo "New Record Created successfully"; ?>
        </div><br><br><br>

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
                <th class="mdl-data-table__cell--numeric">E-Mail ID</th>
                <th class="mdl-data-table__cell--numeric">Contact Person(CP)</th>
                <th class="mdl-data-table__cell--numeric">Mobile</th>
                <th class="mdl-data-table__cell--numeric">E-Mail(CP)</th>
                <th class="mdl-data-table__cell--numeric">VAT-Regn</th>
                <th class="mdl-data-table__cell--numeric">Budget</th>
                <th class="mdl-data-table__cell--numeric">Client Name</th>
                <th class="mdl-data-table__cell--numeric">Brand Name</th>
                <th class="mdl-data-table__cell--numeric">Quote Approved</th>
                <th class="mdl-data-table__cell--numeric">Activity Start Date</th>
                <th class="mdl-data-table__cell--numeric">Activity End Date</th>
                <th class="mdl-data-table__cell--numeric">Email(P)</th>
                <th class="mdl-data-table__cell--numeric">PO No.</th>
                <th class="mdl-data-table__cell--numeric">PO Date</th>
                <th class="mdl-data-table__cell--numeric">PO Aprroved By</th>
                <th class="mdl-data-table__cell--numeric">Inv No</th>
                <th class="mdl-data-table__cell--numeric">Inv Date</th>
                <th class="mdl-data-table__cell--numeric">Remarks</th>
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
                <td class="mdl-data-table__cell--non-numeric"><?php echo $CAMP_Email_Personal; ?></td>
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
        <h4 align="center"> Campaign is : <font color="red"><?php echo $ID; ?></font></h4>
      <?php } else {
      echo"<script>alert('Unsuccessful,Please Try Again');window.top.location.href='campaign-master.php'</script>";     
      }     
    }
   } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>
  </body>
  </html>