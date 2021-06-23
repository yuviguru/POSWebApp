<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>

  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php'; 
    include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes'){ 
        $Client_id_name       =$_GET['client_id'];
        $Client_id_name_split = explode('-',$Client_id_name);
        $Client_id            = $Client_id_name_split[0];
        $Client_name          = $Client_id_name_split[1];
        $Brand_name           =$_GET['brand-name'];
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
    include 'check_page_access.php';
        $sql_branch_dup_check = $conn->query("SELECT * FROM brand_master WHERE BRD_CLIENT_ID='$Client_id' AND BRD_NAME='$Brand_name'");
      if(($sql_branch_dup_check->num_rows > 0) && (!isset($_GET['rec-confirm']))) {
        ?><br><br><br> 
      <div class="moz-margin" align="center">
        <h5 style="color:red;">The Brand Name you entered already exist for the Client <?php echo $Client_id.'-'.$Client_name;?> in the Database.<br>Do You want to continue?</h5><br>
        <a href="<?php echo basename($_SERVER['REQUEST_URI']).'&rec-confirm=Yes'?>"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">Yes</button></a>
        <a href="brand-master.php"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">No</button></a>
      </div><br> 
  <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x: scroll;">
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Brand ID</th>
          <th class="mdl-data-table__cell--numeric">Brand Name</th>
          <th class="mdl-data-table__cell--numeric">Client</th>
          <th class="mdl-data-table__cell--numeric">Controlling Branch</th>
          <th class="mdl-data-table__cell--numeric">Contact Person</th>
          <th class="mdl-data-table__cell--numeric">Address 1</th>
          <th class="mdl-data-table__cell--numeric">Address 2</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
          <th class="mdl-data-table__cell--numeric">Mobile Number</th>
          <th class="mdl-data-table__cell--numeric">E-Mail</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($sql_branch_dup = $sql_branch_dup_check->fetch_assoc()) { ?>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_ID'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_NAME'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_CLIENT_ID']; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_CON_BRANCH'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_CT_PERSON'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_ADDRESS1'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_ADDRESS2'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_STATE']; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_CITY'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_PIN'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_MOBILE_NO'];?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_dup['BRD_EMAIL_ID'];?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    </div>
    <br><br><br>
    <?php
       }
      else {
    $Client_id_name       =$_GET['client_id'];
    $Client_id_name_split = explode('-',$Client_id_name);
    $Client_id            = $Client_id_name_split[0];
    $Client_name          = $Client_id_name_split[1];
    $Brand_ID             =$_GET['brand-id'];
    $Brand_name           =$_GET['brand-name'];
    $Brand_CB             =$_GET['brand-cb'];
    $Client_CP            =$_GET['client-CP'];
    
    $Address1_View=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Address1'])));
    $Address1=addslashes($Address1_View);

    $Address2_View=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Address2'])));
    $Address2=addslashes($Address2_View);

    $City=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['City2'])));
    $Pincode=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Pincode'])));
    $State=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['State'])));
    
    $Client_mob           =$_GET['client-mob'];
    $Client_mail          =$_GET['client-mail'];
    $CB_Name              =$_GET['CB_Name'];
    $Today                =date("Y-m-d H:i:s");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
      echo "<br><br><br><br><br>";
      $sql = "INSERT INTO brand_master(BRD_ID, BRD_NAME, BRD_CLIENT_ID, BRD_CON_BRANCH, BRD_CT_PERSON, BRD_ADDRESS1, BRD_ADDRESS2, BRD_STATE, BRD_CITY, BRD_PIN, BRD_MOBILE_NO, BRD_EMAIL_ID, CREATED_DATE) VALUES ('$Brand_ID','$Brand_name','$Client_id','$Brand_CB','$Client_CP','$Address1','$Address2','$State','$City','$Pincode','$Client_mob','$Client_mail','$Today')";

      if (mysqli_query($conn, $sql)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Brand" ?> <font color="green"><?php echo $Brand_ID ?></font> <?php echo "Created successfully"; ?>
        </div><br><br><br>
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Brand ID</th>
          <th class="mdl-data-table__cell--numeric">Brand Name</th>
          <th class="mdl-data-table__cell--numeric">Client ID</th>
          <th class="mdl-data-table__cell--numeric">Controlling Branch</th>
          <th class="mdl-data-table__cell--numeric">Contact Person</th>
          <th class="mdl-data-table__cell--numeric">Address 1</th>
          <th class="mdl-data-table__cell--numeric">Address 2</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
          <th class="mdl-data-table__cell--numeric">Mobile Number</th>
          <th class="mdl-data-table__cell--numeric">E-Mail</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Brand_ID;   ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Brand_name; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Client_name;  ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $CB_Name;  ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Client_CP;  ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Address1_View;?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Address2_View;?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $State; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $City;?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Pincode;?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Client_mob; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Client_mail;?></td>
        </tr>
      </tbody>
    </table> 
    <br>
    <br>  
    <br>
      <?php }
        else{

           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
       } } }   else {
        echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
      } 
  
    ?><br>
    <div align="center">
    <a href="viewBrandDetails.php">
      <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
    </a>
    </div>
  </div>
  </body>
  </html>

  