<?php session_start(); ?>
<!doctype html>
<html lang="en">
<?php include 'header.php'; ?>  
  <body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" style="height:auto">
  <?php include 'navigation.php';
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?>  

<?php
   include 'db-conn.php';
$OLD_ID      = $_GET['ID'];
$ACT_PKID      = (isset($_GET['ACT_PKID']) ? $_GET['ACT_PKID'] : null);
$ELE_PKID      = (isset($_GET['ELE_PKID']) ? $_GET['ELE_PKID'] : null);
$ELE_PKID      = rtrim(ltrim(preg_replace('/\s+/',' ',$ELE_PKID)));
$MAT_CAT_ID    = [];
$MAT_CAT_NAME  = [];
$MAT_COUNT     = (isset($_GET['MAT_COUNT']) ? $_GET['MAT_COUNT'] : null);
$MAT_CAT_ID_DB = "";
$MAT_CAT_ID_DB = $ACT_PKID.'/'.$ELE_PKID;
for($i=1;$i<=$MAT_COUNT;$i++){
  $MAT_CAT_SWITCH="";
  $MAT_CAT_SWITCH = (isset($_GET['MAT_CAT_SWITCH'.$i]) ? $_GET['MAT_CAT_SWITCH'.$i] : null);
  if($MAT_CAT_SWITCH=="YES"){
    
    $MAT_SPLIT = explode(',', $_GET['MAT_CAT'.$i]);
    $MAT_CAT_ID[$i]=$MAT_SPLIT[0];
    $MAT_CAT_NAME[$i]=$MAT_SPLIT[1];
  }
}

if(!empty($MAT_CAT_ID)){
$MAT_CAT_ID_DB .= '/'.implode('-', $MAT_CAT_ID);
$MAT_CAT_NAME_DB = implode('', $MAT_CAT_NAME);

}

$RAT_PER_UNIT  = (isset($_GET['RAT_PER_UNIT']) ? $_GET['RAT_PER_UNIT'] : null);
$RAT_PER_UNIT  =rtrim(ltrim(preg_replace('/\s+/',' ',$RAT_PER_UNIT)));

$RAT_UNIT      = (isset($_GET['RAT_UNIT']) ? $_GET['RAT_UNIT'] : null);
$RAT_UNIT      =rtrim(ltrim(preg_replace('/\s+/',' ',$RAT_UNIT)));

$RAT_TAX       = (isset($_GET['RAT_TAX']) ? $_GET['RAT_TAX'] : null);
$RAT_TAX       =rtrim(ltrim(preg_replace('/\s+/',' ',$RAT_TAX)));


$Today=date("Y-m-d H:i:s");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
} 
include 'check_page_access.php';
include 'salvos_globals.php';
$sql="UPDATE rate_master set RAT_ID='$MAT_CAT_ID_DB',ELE_PKID='$ELE_PKID',ACT_PKID='$ACT_PKID',MAT_COD_SPECS='$MAT_CAT_NAME_DB',RATE_PER_UNIT='$RAT_PER_UNIT',RAT_UNITS='$RAT_UNIT',RAT_TAX='$RAT_TAX',UPDATED_DATE='$Today',UPDATED_BY='$Logged_User' where RAT_ID='$OLD_ID'";

 $sql1 = "UPDATE rate_master set APPROVAL='PENDING' where RAT_ID='$MAT_CAT_ID_DB'";

 if (mysqli_query($conn, $sql)) { ?>
 		<br><br><br><br><br>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Rate" ?> <font color="green"><?php echo $OLD_ID ?></font><?php echo " Details Updated successfully"; ?><br>
        </div>
        <br><br><br><br>
  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Element Name</th>
          <th class="mdl-data-table__cell--numeric">Activity Name</th>
          <th class="mdl-data-table__cell--numeric">Material Specs</th>
          <th class="mdl-data-table__cell--numeric">Rate Per Unit</th>
          <th class="mdl-data-table__cell--numeric">Rate in Units</th>
          <th class="mdl-data-table__cell--numeric">Rate Tax(%)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--numeric"><?php 
              if($ELE_PKID!=null) {
                $get_elem_name = $conn->query("SELECT ELEMENTS FROM element_master WHERE ELE_PKID='$ELE_PKID'"); 
                echo $get_elem_name->fetch_assoc()['ELEMENTS'];
              }
              else
                echo "--";
            ?></td>
          >
          <td class="mdl-data-table__cell--numeric"><?php 
              if($ACT_PKID!=null) {
                $get_act_name = $conn->query("SELECT a.ACT_NAME FROM salvos.activity_master a,activity_category_elements b where b.ACT_CAT_ID='$ACT_PKID' and a.ACT_PKID=b.ACT_PKID ;"); 
                echo $get_act_name->fetch_assoc()['ACT_NAME'];
              }
              else
                echo "--";
            ?></td>
            <td class="mdl-data-table__cell--numeric">
            <ul><?php 
              if($MAT_CAT_ID_DB!="") {
                foreach ($MAT_CAT_ID as $MAT_CAT) {
                  $MAT_CLASS_ID = explode('^', $MAT_CAT);
                  $get_mat_details = $conn->query("SELECT b.MAT_COD_SPECS,b.MAT_COD_NAME,c.CAT_NAME FROM salvos.material_classfication a join categories c on a.CAT_ID=c.CAT_ID,material_code_master b WHERE a.MAT_CLASS_ID='$MAT_CLASS_ID[0]' AND a.MAT_COD_ID=b.MAT_COD_ID;");
                  $fetch=$get_mat_details->fetch_assoc();
                  $get_mat_cat_name=$fetch['CAT_NAME'];
                  $get_mat_name=$fetch['MAT_COD_NAME'];
                  $get_mat_spec=$fetch['MAT_COD_SPECS'];
                  $split_mat_spec=explode(',', $get_mat_spec);
                  $mat_index=$MAT_CLASS_ID[1]-1;
                  $final_mat_spec= $split_mat_spec[$mat_index];
                  echo'<li align="left"><b>'.$get_mat_cat_name.'</b> : '.$get_mat_name.' - <b>'.$final_mat_spec.'</b></li>';
                   }
              }
              else
                echo "--";
            ?></ul></td>
          <td class="mdl-data-table__cell--numeric"><?php echo $RAT_PER_UNIT ?></td>
          <td class="mdl-data-table__cell--numeric"><?php echo $RAT_UNIT ?></td>
          <td class="mdl-data-table__cell--numeric"><?php echo $RAT_TAX ?></td>
        </tr>
      </tbody>
    </table>
    <br><br><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
     <a href="viewSalvosRate.php">
        <input type="button" value="View All Details" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent ">
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

