<?php session_start();

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_rate_master="SELECT * FROM rate_master;";
    $sql_rate = $conn->query($sql_rate_master);

  
                         
?>

<!doctype html>
<html lang="en">
  <?php include 'header.php'; ?>  
 
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">

  <?php include 'navigation.php';
  if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?>    
    <br><br><br><br>
    <main>
      <div class="mdl-grid" style="margin-right: 60px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 350px;" align="center">
          Salvos Rate Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top: 0px;">
          <a href="salvos-rate-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>

  <div style="margin-left:60px;margin-right:60px;">
      <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
      <thead>  
        <tr style="background: #ccc;">

          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <th class="mdl-data-table__cell--non-numeric">Approve/Reject</th>
          <?php } if($_SESSION['EDIT']=='Yes') { ?>  
            <th class="mdl-data-table__cell--non-numeric">Edit</th>
          <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
                <th class="mdl-data-table__cell--non-numeric">Delete</th>
          <?php } ?>
          <th class="mdl-data-table__cell--numeric">Element Name</th>
          <th class="mdl-data-table__cell--numeric">Activity Name</th>
          <th class="mdl-data-table__cell--numeric">Material Specs</th>
    
         
        </tr>
      </thead>
      <tbody>
      <?php if($sql_rate->num_rows > 0) {
        $count=1;
          while ($sql_rate_details = $sql_rate->fetch_assoc()) {
            $Rate_Id=$sql_rate_details["RAT_ID"]; 
            $delete_flag=$sql_rate_details["DELETE_FLAG"]; 

            if($delete_flag=='NO') {   

               $value = '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                            <tr>
                                <th>Rate Per Unit</th>
                                <th>Rate in Units</th>
                                <th>Rate Tax(%)</th>
                            </tr>
                             <tr>
                              <td>'.$sql_rate_details["RATE_PER_UNIT"].'</td>
                              <td>'.$sql_rate_details["RAT_UNITS"].'</td>
                              <td>'.$sql_rate_details["RAT_TAX"].'</td>
  
                            </tr>
                            </table>';
                 
        ?>
        <tr data-child-value="<?php echo $value;?>" >
        
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
           <td class="mdl-data-table__cell--non-numeric">
            <?php if($sql_rate_details["APPROVAL"]=='PENDING') { ?>
                <a href="approvalSalvosRate.php?RAT_ID=<?php echo $sql_rate_details["RAT_ID"] ?>&APPROVAL=<?php echo $sql_rate_details["APPROVAL"] ?>&APPROVAL=<?php echo "APPROVE" ?>">
                  <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                </a>
                <a href="approvalSalvosRate.php?RAT_ID=<?php echo $sql_rate_details["RAT_ID"] ?>&APPROVAL=<?php echo $sql_rate_details["APPROVAL"] ?>&APPROVAL=<?php echo "REJECT" ?>">
                  <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                </a>
            <?php } else if($sql_rate_details["APPROVAL"]=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($sql_rate_details["APPROVAL"]=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
            ?>
          </td>

          <?php } if($_SESSION['EDIT']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if($sql_rate_details["APPROVAL"]!='EDITING') { ?>
                <a href="editSalvosRateDetails.php?RAT_ID=<?php echo $sql_rate_details["RAT_ID"] ?>&Approval_Status=<?php echo $sql_rate_details["APPROVAL"] ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></a>
              <?php } else { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
            </td>
          <?php } ?>

          <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if(($delete_flag=='NO') && (($sql_rate_details["APPROVAL"]=='PENDING') || ($sql_rate_details["APPROVAL"]=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed();" href="deleteSalvosRate.php?RAT_ID=<?php echo $Rate_Id ?>&RAT_DELETE_FLAG=<?php echo $delete_flag ?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
              <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
            </td>
          <?php } ?>
          
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_rate_details["ELE_PKID"])!=null) {
                $elements = $sql_rate_details["ELE_PKID"];
                $get_elem_name = $conn->query("SELECT ELEMENTS FROM element_master WHERE ELE_PKID='$elements'"); 
                echo $get_elem_name->fetch_assoc()['ELEMENTS'];
              }
              else
                echo "--";
            ?>
          </td>
           <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_rate_details["ACT_PKID"])!=null) {
                $Activity = $sql_rate_details["ACT_PKID"];
                $get_act_name = $conn->query("SELECT a.ACT_NAME FROM salvos.activity_master a,activity_category_elements b where b.ACT_CAT_ID='$Activity' and a.ACT_PKID=b.ACT_PKID ;"); 
                echo $get_act_name->fetch_assoc()['ACT_NAME'];
              }
              else
                echo "--";
            ?>
          </td>
           <td class="mdl-data-table__cell--non-numeric">
            <?php 
              $split_ID= explode('/', $Rate_Id);
              $MAT_IDS = $split_ID[2];
              $MAT_CAT_ID_DB=explode('-', $MAT_IDS); 
              if($MAT_CAT_ID_DB!="") {
                foreach ($MAT_CAT_ID_DB as $MAT_CAT) {
                  $MAT_CLASS_ID = explode('^', $MAT_CAT);
                  $get_mat_details = $conn->query("SELECT b.MAT_COD_SPECS,b.MAT_COD_NAME,c.CAT_NAME FROM salvos.material_classfication a join categories c on a.CAT_ID=c.CAT_ID,material_code_master b WHERE a.MAT_CLASS_ID='$MAT_CLASS_ID[0]' AND a.MAT_COD_ID=b.MAT_COD_ID;");
                  $fetch=$get_mat_details->fetch_assoc();
                  $get_mat_cat_name=$fetch['CAT_NAME'];
                  $get_mat_name=$fetch['MAT_COD_NAME'];
                  $get_mat_spec=$fetch['MAT_COD_SPECS'];
                  $split_mat_spec=explode(',', $get_mat_spec);
                  $mat_index=$MAT_CLASS_ID[1]-1;
                  $final_mat_spec= $split_mat_spec[$mat_index];
                  echo'<li align="left"><b>'.$get_mat_cat_name.' : </b>'.$get_mat_name.'<b> - '.$final_mat_spec.'</b></li>';
                   }
              }
              else
                echo "--";
            ?>
          </td>

           
        </tr>
      

        <?php
            }            
          }

        }
        $conn->close(); ?>
      </tbody>
    </table>
  </div>
  <?php include "footer.php"; } else {
   echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } 
  ?>
</div>
<script type="text/javascript">
  $('.click-off').click(function (e) {
    e.preventDefault();
    var linkURL = $(this).attr("href");
    // escape here if the confirm is false;
    swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!',
              closeOnConfirm: false,
              closeOnCancel: true
          }, function clickOffConfirmed(isConfirm) {
              if (isConfirm) {
                  swal("Deleted!", "Your file has been deleted.", "success");
                  window.location.href = linkURL;
                  // table.row($(btn).parents('tr')).remove().draw(false);
              } else {
                  swal('Cancelled','Your imaginary file is safe.','error');
              }
          });
  });
</script>
<script type="text/javascript">
    $( document ).ready(function() {
    var url = document.location.toString();
      var url_id= url.substr(-1);
    if (url_id=='#'){
      window.location.href='viewSalvosRate.php';
      }
    });
</script>
<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>
</body>
</html>