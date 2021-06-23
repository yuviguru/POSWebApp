<?php session_start(); ?>
<!doctype html>
<html lang="en">
<?php include 'header.php'; ?>  

  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
  <?php include 'navigation.php'; 
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?> 

<?php
   include 'db-conn.php';
   include 'salvos_globals.php';
$elements      = (isset($_POST['elements']) ? $_POST['elements'] : null);
$elements=rtrim(ltrim(preg_replace('/\s+/',' ',$elements)));
$element_cat = $_POST['ElE_ACT'];
$Today=date("Y-m-d H:i:s");


$ID=(isset($_POST['ID']) ? $_POST['ID'] : null);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
} 

    include 'check_page_access.php';
$sql="UPDATE element_master set ELEMENTS='$elements',UPDATED_DATE='$Today',ELE_UPDATED_BY='$Logged_User' where ELE_PKID='$ID'";

$sql1 = "UPDATE element_master set ELE_APPROVAL='PENDING' where ELE_PKID='$ID'";
  $prev_cat="";
  $Act_view =""; 

 if (mysqli_query($conn, $sql)) { 
    $sql_category_reset = $conn->query("UPDATE element_classfication set DELETE_FLAG='YES',UPDATED_DATE='$Today',UPDATED_BY='$Logged_User' WHERE ELE_PKID='$ID'");
        foreach ($element_cat as $CAT) {
          $sql_category_select = $conn->query("SELECT * FROM element_classfication WHERE ELE_PKID='$ID' && ACT_CAT_ID='$CAT'");

          
          if($sql_category_select->num_rows > 0) {
            $sql_category_update = $conn->query("UPDATE element_classfication set DELETE_FLAG='NO',UPDATED_DATE='$Today',UPDATED_BY='$Logged_User' WHERE ELE_PKID='$ID' && ACT_CAT_ID='$CAT'");

          }
          else
          {
            $sql_category_insert = $conn->query("INSERT INTO element_classfication(ACT_CAT_ID, ELE_PKID, CREATED_DATE, CREATED_BY) VALUES ('$CAT','$ID','$Today','$Logged_User')");
          }
          $sql_activity = $conn->query("SELECT ACT_PKID,CAT_ID FROM activity_category_elements where ACT_CAT_ID='$CAT'");
          $sql_act_fetch = $sql_activity->fetch_assoc();
          $sql_cat= $sql_act_fetch['CAT_ID'];
          $sql_act= $sql_act_fetch['ACT_PKID'];
          $curr_cat = $sql_act;
          $sql_activity = $conn->query("SELECT a.ACT_NAME,b.CAT_NAME FROM activity_master a,categories b where a.ACT_PKID='$sql_act' AND b.CAT_ID='$sql_cat'");
          $sql_act_fetch = $sql_activity->fetch_assoc();
          $sql_act_name= $sql_act_fetch['ACT_NAME'];
          $sql_cat_name= $sql_act_fetch['CAT_NAME'];
          if($curr_cat != $prev_cat){
            if($prev_cat != ""){
              $Act_view .='</li>';
            }
            $Act_view .='<li>'.$sql_act_name.' - '.$sql_cat_name;
          }
          else{
            $Act_view .=' , '.$sql_act_name;
          }
          $prev_cat = $curr_cat;
        }
  ?>
  
<br><br><br><br><br><br>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Element" ?> <font color="green"><?php echo $elements ?></font> <?php echo "Details Updated successfully"; ?>
        </div><br>
        <br><br>
  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Element Name</th>
          <th class="mdl-data-table__cell--numeric">Activities</th>         
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $elements; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php if($Act_view != "") echo $Act_view.'</li>'; else echo '--------'; ?></td>         
        </tr>
      </tbody>
    </table>
    <br><br><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
     <a href="viewElementsDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
      <?php } } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
       if (mysqli_query($conn, $sql1)) {
     } else {
          echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
      }

?>
<?php } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } ?> 
</div>
  </body>
  </html>

