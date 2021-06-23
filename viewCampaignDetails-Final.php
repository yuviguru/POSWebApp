<?php session_start();
  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_campaign_master="SELECT a.*,b.BRN_NAME FROM campaign_master_final a,branch_master b where a.CAMP_EMP_BR_CODE=b.BRN_PKID;";
    $sql_campaign = $conn->query($sql_campaign_master);

  $conn->close();
                         
?>

<!doctype html>
<html lang="en">

<?php include 'header.php'; ?> 
<style type="text/css">
.display_none{
    color: transparent;
  }
</style>
<body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">

  <?php include 'navigation.php';
  if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?>   
    <br><br><br><br>
    <main>
      <div class="mdl-grid" style="margin-right:20px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;" align="center">
          Campaign Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col">
          <a href="campaign-master-final.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>

    <div style="margin-left:10px;margin-right:10px;">
         <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
        <thead>  
          <tr> 
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <th class="mdl-data-table__cell--numeric">Approve/Reject</th>
          <?php } ?>
            <?php if($_SESSION['EDIT']=='Yes') { ?>  
              <th class="mdl-data-table__cell--numeric">Edit</th>
            <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
              <th class="mdl-data-table__cell--numeric">Delete</th>
            <?php } ?>
            <th class="mdl-data-table__cell--numeric">Campaign ID</th>
            <th class="mdl-data-table__cell--numeric">Emp.Branch Code</th>
            <th class="mdl-data-table__cell--numeric">EMP ID</th>
            <th class="mdl-data-table__cell--numeric">Client Code</th>
            <th class="mdl-data-table__cell--numeric">Brand ID</th>
            <th class="mdl-data-table__cell--numeric">Activity</th>
            
          
          </tr>
        </thead>
        <tbody>
        <?php if($sql_campaign->num_rows > 0) {
            while ($sql_campaign_details = $sql_campaign->fetch_assoc()) {
              $camp_id=$sql_campaign_details["CAMP_PKID"];
              $CAMP_APPROVAL=$sql_campaign_details["CAMP_APPROVAL"];
              $delete_flag=$sql_campaign_details["CAMP_DELETE_FLAG"]; 

              if($delete_flag=='NO') {
                   $date = new DateTime($sql_campaign_details["CAMP_ACT_EDATE"]);
                  $camp_act_edate = $date->format('d-m-Y');

                  $sdate = new DateTime($sql_campaign_details["CAMP_ACT_SDATE"]);
                  $camp_act_sdate = $sdate->format('d-m-Y');

                   $podate = new DateTime($sql_campaign_details["CAMP_PO_DATE"]);
                  $camp_podate = $podate->format('d-m-Y');

                   $camp_cc_date = new DateTime($sql_campaign_details["CAMP_CC_DATE"]);
                  $camp_ccdate = $camp_cc_date->format('d-m-Y');
                  $value = '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                            <tr>
                                <th>Store ID(S)</th>
                                <th>Campaign Created Date</th>
                                <th>Activity Start Date</th>
                                <th>Activity End Date</th>
                                <th>PO Number</th>
                                <th>PO Date</th>
                                <th>Remarks</th>
                            </tr>
                             <tr>
                              <td>'.$sql_campaign_details["CAMP_STORE_ID"].'</td>
                              <td>'.$camp_ccdate.'</td>
                              <td>'.$camp_act_sdate.'</td>
                              <td>'.$camp_act_edate.'</td>
                              <td>'.$sql_campaign_details["CAMP_PO_NO"].'</td>
                              <td>'.$camp_podate.'</td>
                              <td>'.$sql_campaign_details["CAMP_REMARKS"].'</td>
                            </tr>
                            </table>';
          ?>
          <tr data-child-value="<?php echo $value;?>">
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if($CAMP_APPROVAL=='PENDING') { ?>
                  <a class="display_none" href="approvalCampaign.php?camp_id=<?php echo $camp_id ?>&CAMP_APPROVAL=<?php echo $CAMP_APPROVAL ?>&APPROVAL=<?php echo "APPROVE" ?>">
                    <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                  </a>
                  <a class="display_none" href="approvalCampaign.php?camp_id=<?php echo $camp_id ?>&CAMP_APPROVAL=<?php echo $CAMP_APPROVAL ?>&APPROVAL=<?php echo "REJECT" ?>">
                     <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span></a>
              <?php } else if($CAMP_APPROVAL=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($CAMP_APPROVAL=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
              ?>
            </td>
          <?php } ?>
            <?php if($_SESSION['EDIT']=='Yes') { ?>
              <td class="mdl-data-table__cell--non-numeric">
              <?php if($CAMP_APPROVAL!='EDITING') { ?>
                <a href="editCampaignDetails-Final.php?camp_id=<?php echo $camp_id ?>&Approval_Status=<?php echo $CAMP_APPROVAL; ?>">
                  <span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span>
                </a>
              <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
              </td>
            <?php } ?>

            <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
              <td class="mdl-data-table__cell--non-numeric">
                <?php if(($delete_flag=='NO') && (($CAMP_APPROVAL=='PENDING') || ($CAMP_APPROVAL=='NO'))) { ?>
                    <a class="click-off" onclick="clickOffConfirmed();" href="deleteCampaign.php?Campaign_ID=<?php echo $camp_id ?>&Delete_Flag=<?php echo $delete_flag ?>"> <span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
                <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
              </td>
            <?php } ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php 
                if(($sql_campaign_details["CAMP_PKID"])!=null) 
                  echo $sql_campaign_details["CAMP_PKID"]; 
                else
                  echo "---------";
              ?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php 
                if(($sql_campaign_details["CAMP_EMP_BR_CODE"])!=null) 
                  echo $sql_campaign_details["BRN_NAME"]."(".$sql_campaign_details["CAMP_EMP_BR_CODE"].")"; 
                else
                  echo "---------";
              ?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php 
                if(($sql_campaign_details["CAMP_EMP_ID"])!=null) 
                  echo $sql_campaign_details["CAMP_EMP_ID"]; 
                else
                  echo "---------";
              ?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php 
                if(($sql_campaign_details["CAMP_CL_CODE"])!=null) 
                  echo $sql_campaign_details["CAMP_CL_CODE"]; 
                else
                  echo "---------";
              ?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php 
                if(($sql_campaign_details["CAMP_BRD_ID"])!=null) 
                  echo $sql_campaign_details["CAMP_BRD_ID"]; 
                else
                  echo "---------";
              ?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php 
                if(($sql_campaign_details["CAMP_ACTIVITY"])!=null) 
                  echo $sql_campaign_details["CAMP_ACTIVITY"]; 
                else
                  echo "---------";
              ?>
            </td>
         
          
          </tr>
          <?php
              }
            }
          } 
          ?>

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
      window.location.href='viewCampaignDetails-Final.php';
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