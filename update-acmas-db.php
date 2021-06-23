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

    ?>

    <?php
    include 'db-conn.php';
    include 'salvos_globals.php';
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
		
      $sql = "UPDATE activity_master set ACT_PKID='$ID',ACT_NAME='$ACT_NAME',ACT_CATEGORY=$ACT_CAT_ATTACH,ACT_DEPEND=$ACT_DEP_ATTACH,UPDATED_DATE='$Today',ACT_UPDATED_BY='$Logged_User' where ACT_PKID='$ID'";

      $sql1 = "UPDATE activity_master set ACT_APPROVAL='PENDING' where ACT_PKID='$ID'";

      if (mysqli_query($conn, $sql)) { 
         $sql_category_reset = $conn->query("UPDATE activity_category_elements set DELETE_FLAG='YES' WHERE ACT_PKID='$ID'");
        foreach ($ACT_CAT as $CAT) {
          $sql_category_select = $conn->query("SELECT * FROM activity_category_elements WHERE ACT_PKID='$ID' && CAT_ID='$CAT'");
          if($sql_category_select->num_rows > 0) {
            $sql_category_update = $conn->query("UPDATE activity_category_elements set DELETE_FLAG='NO',UPDATED_DATE='$Today',UPDATED_BY='$Logged_User' WHERE ACT_PKID='$ID' && CAT_ID='$CAT'");
          }
          else
          {
            $sql_category_insert = $conn->query("INSERT INTO activity_category_elements(ACT_PKID, CAT_ID, CREATED_DATE, CREATED_BY) VALUES ('$ID','$CAT','$Today','$Logged_User')");
          }
        }

        ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Activity" ?> <font color="green"><?php echo $ID ?></font> <?php echo "Details Updated successfully"; ?>
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

    <br><br><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
      <a href="viewActivityDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
    <?php } } else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
    ?>
  </div>
  </body>
  </html>