<?php session_start();
  $StoreID='';

 include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
	
    include 'check_page_access.php';
    $sql_client_master="SELECT * FROM store_master";
    $sql_client = $conn->query($sql_client_master);

    $sql_campaign_store="SELECT distinct CAMP_STORE_ID FROM campaign_master_final where CAMP_STORE_ID!=''";
    $sql_store = $conn->query($sql_campaign_store);

  $conn->close();
                         
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
      <div class="mdl-grid" style="margin-right:20px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;" align="center">
          Store Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col">
          <a href="store-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>

       <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
        <thead>  
          <tr>
            <?php if($_SESSION['APPROVE']=='Yes') { ?>
              <th class="mdl-data-table__cell--non-numeric">Approve/Reject</th>
            <?php } if($_SESSION['EDIT']=='Yes') { ?>  
              <th class="mdl-data-table__cell--numeric">Edit</th>
            <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
              <th class="mdl-data-table__cell--non-numeric">Delete</th>
            <?php } ?>
            <th class="mdl-data-table__cell--numeric">Store ID</th>
            <th class="mdl-data-table__cell--numeric">Store Type</th>
            <th class="mdl-data-table__cell--numeric">Name</th>
            <th class="mdl-data-table__cell--numeric">Address 1</th>
            <th class="mdl-data-table__cell--numeric">Phone</th>
            <th class="mdl-data-table__cell--numeric">Email (Store)</th>
            <th class="mdl-data-table__cell--numeric">Contact Person</th>
           
           
          </tr>
        </thead>
        <tbody>
        <?php if($sql_client->num_rows > 0) {
            while ($sql_client_details = $sql_client->fetch_assoc()) {
              $storeid=$sql_client_details["STR_PKID"];
              $STR_APPROVAL=$sql_client_details["STR_APPROVAL"];
              $delete_flag=$sql_client_details["STR_DELETE_FLAG"]; 

            if($delete_flag=='NO') {

              $value = '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                            <tr>
                            <th>Mobile</th>
                                <th>Email (CP)</th>
                                <th>Address 2</th>
                                <th>City</th>
                                <th>State </th>
                                <th>Pincode</th>
                                <th>VAT Reg.Number</th>  
                                <th>Remarks</th> 
                            </tr>
                             <tr>
                             <td>'.$sql_client_details["STR_PERS_MOBILE"].'</td>
                             <td>'.$sql_client_details["STR_PERS_EMAIL"].'</td>
                              <td>'.$sql_client_details["STR_ADDRESS2"].'</td>
                              <td>'.$sql_client_details["STR_CITY"].'</td>
                              <td>'.$sql_client_details["STR_STATE"].'</td>
                              <td>'.$sql_client_details["STR_PIN"].'</td>
                              <td>'.$sql_client_details["STR_VAT_REG"].'</td>
                              <td>'.$sql_client_details["STR_REMARKS"].'</td>
                            </tr>
                            </table>';
          ?>
          <tr data-child-value="<?php echo $value;?>">
            <?php if($_SESSION['APPROVE']=='Yes') { ?>
              <td>
                <?php if($STR_APPROVAL=='PENDING') { ?>
                    <a href="approvalStore.php?Store_ID=<?php echo $storeid ?>&STR_APPROVAL=<?php echo $STR_APPROVAL ?>&APPROVAL=<?php echo "APPROVE" ?>">
                      <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                    </a>
                    <a href="approvalStore.php?Store_ID=<?php echo $storeid ?>&STR_APPROVAL=<?php echo $STR_APPROVAL ?>&APPROVAL=<?php echo "REJECT" ?>">
                     <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                    </a>
                <?php } else if($STR_APPROVAL=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($STR_APPROVAL=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
            ?>
              </td>

            <?php } if($_SESSION['EDIT']=='Yes') { ?>
              <td class="mdl-data-table__cell--non-numeric">
                <?php if($STR_APPROVAL!='EDITING') { ?>
                  <a href="editStoreDetails.php?Store_ID=<?php echo $storeid ?>&Approval_Status=<?php echo $STR_APPROVAL ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>
               <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
              </td>
            <?php } ?>

            <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>

            <?php 
              if($sql_store->num_rows > 0) {
                while ($sql_store_details = $sql_store->fetch_assoc()) {
                  $StoreID=$sql_store_details['CAMP_STORE_ID'];
                  $ids_array = explode(",",$StoreID);
              }
            }
            if($sql_store->num_rows > 0) {
            ?>
            <td class="mdl-data-table__cell--non-numeric">
            <?php
              $Store_check='';
              foreach ($ids_array as $id_array) {
                if($id_array==$sql_client_details["STR_PKID"]) { 
                    $Store_check='Yes'; } } 
                  if(($Store_check!='Yes') && ($delete_flag=='NO') && (($STR_APPROVAL=='PENDING') || ($STR_APPROVAL=='NO'))) { ?>
                    <a class="click-off" onclick="clickOffConfirmed();" href="deleteStore.php?Store_ID=<?php echo $storeid ?>&Delete_Flag=<?php echo $delete_flag ?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
                  <?php } else { ?>
                    <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
                <?php } ?>
            </td>
            <?php } else { ?>
            <td class="mdl-data-table__cell--non-numeric">
            <?php if((($STR_APPROVAL=='PENDING') || ($STR_APPROVAL=='NO')) && ($delete_flag=='NO')) { ?>
              <a class="click-off" onclick="clickOffConfirmed();" href="deleteStore.php?Store_ID=<?php echo $storeid ?>&Delete_Flag=<?php echo $delete_flag ?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
            <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
            <?php } ?>
            </td>
            <?php } ?>

            <?php } ?>

            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_client_details["STR_PKID"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_client_details["STR_TYPE"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_client_details["STR_NAME"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_client_details["STR_ADDRESS1"]?>
            </td>
          
            <td class="mdl-data-table__cell--non-numeric">
              <?php 
                if(($sql_client_details["STR_PHONE"])!=null) 
                  echo $sql_client_details["STR_PHONE"]; 
                else
                  echo "---------";
              ?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_client_details["STR_EMAIL"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_client_details["STR_CT_PERSON"]?>
            </td>
          
                  
          </tr>
          <?php
              }
            }
          }
          ?>
        </tbody>
      </table>
    
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
    window.location.href='viewStoreDetails.php';
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