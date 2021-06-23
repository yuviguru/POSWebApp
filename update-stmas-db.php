<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <style type="text/css">
    #nameErr,#add1Err,#cityErr,#cityErr,#pinErr,#stateErr,#mobErr{
      color: #d50000;
      position: absolute;
      font-size: 12px;
      margin-top: 3px;
      visibility: visible;
      display: block;}
  </style>
  <body>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php';
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?> 

    <?php

    $ID=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['ID'])));

    $STR_StoreType=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_StoreType'])));

    
    $STR_Name_view=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_Name'])));
    $STR_Name=addslashes($STR_Name_view);

    $STR_Address1_view=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_Address1'])));
    $STR_Address1=addslashes($STR_Address1_view);

    $STR_Address2_view=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_Address2'])));
    $STR_Address2=addslashes($STR_Address2_view);

    $STR_State=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_State'])));
    $STR_City=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['City'])));
    $STR_Pincode=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_Pincode'])));
    $STR_Phone=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_Phone'])));
    $STR_EmailStore=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_EmailStore'])));
    $STR_Person=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_Person'])));
    $STR_Mobile=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_Mobile'])));
    $STR_EmailCP=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_EmailCP'])));
    $STR_VAT=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_VAT'])));
    $STR_Remarks=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STR_Remarks'])));

    $Today=date("Y-m-d H:i:s");


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

      $sql = "UPDATE store_master set STR_PKID='$ID',STR_TYPE='$STR_StoreType',STR_NAME='$STR_Name',STR_ADDRESS1='$STR_Address1',STR_ADDRESS2='$STR_Address2',STR_STATE='$STR_State',STR_CITY='$STR_City',STR_PIN='$STR_Pincode',STR_PHONE='$STR_Phone',STR_EMAIL='$STR_EmailStore',STR_CT_PERSON='$STR_Person',STR_PERS_MOBILE='$STR_Mobile',STR_PERS_EMAIL='$STR_EmailCP',STR_VAT_REG='$STR_VAT',STR_REMARKS='$STR_Remarks',UPDATED_DATE='$Today' where STR_PKID='$ID'";

      $sql1 = "UPDATE store_master set STR_APPROVAL='PENDING' where STR_PKID='$ID'";

      if (mysqli_query($conn, $sql)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Store" ?> <font color="green"><?php echo $ID ?></font> <?php echo "Details Updated successfully"; ?>
        </div><br><br><br>
      <?php } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      
      if (mysqli_query($conn, $sql1)) {} else {
          echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
      }
    }
    ?>
    <div style="overflow-x: scroll;margin-left:40px;margin-right:40px;">
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Store ID</th>
          <th class="mdl-data-table__cell--numeric">StoreType</th>
          <th class="mdl-data-table__cell--numeric">Name</th>
          <th class="mdl-data-table__cell--numeric">Address1</th>
          <th class="mdl-data-table__cell--numeric">Address2</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
          <th class="mdl-data-table__cell--numeric">Phone</th>
          <th class="mdl-data-table__cell--numeric">EmailStore</th>
          <th class="mdl-data-table__cell--numeric">ContactPerson</th>
          <th class="mdl-data-table__cell--numeric">Mobile</th>
          <th class="mdl-data-table__cell--numeric">EmailPerson</th>
          <th class="mdl-data-table__cell--numeric">VATReg</th>
          <th class="mdl-data-table__cell--numeric">Remarks</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $ID; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_StoreType; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_Name_view; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_Address1_view; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_Address2_view; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_State; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_City; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_Pincode; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_Phone; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_EmailStore; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_Person; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_Mobile; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_EmailCP; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_VAT; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $STR_Remarks; ?></td>
        </tr>
      </tbody>
    </table>
    </div>
    <br><br><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
      <a href="viewStoreDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
   <?php } } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } ?>
  </div>
  </body>
  </html>