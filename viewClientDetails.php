<?php session_start();
  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
	
    include 'check_page_access.php';
    $sql_client_master="SELECT * FROM client_master ";
    $sql_client = $conn->query($sql_client_master);

  $conn->close();
                         
?>

<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <style type="text/css">
.resize th{
  font-size: 14px;
}
  </style>
  <body>

  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
  <?php include 'navigation.php';
  if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?>  
    <br><br><br><br>
    <main>
      <div class="mdl-grid" style="margin-right:20px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px;" align="center">
          Client Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
          <a href="client-master.php">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Create New</button>
        </a>
        </div>
        <?php } ?>
      </div>
    </main>

 <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
      <thead>
      <div align="left">
      </div>  
        <tr style="background: #ccc;"> 
          <?php if($_SESSION['APPROVE']=='Yes') { ?>  
            <th class="mdl-data-table__cell--numeric">Approve/Reject</th>
          <?php } ?>
          <?php if($_SESSION['EDIT']=='Yes') { ?>  
            <th class="mdl-data-table__cell--numeric">Edit</th>
          <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <th class="mdl-data-table__cell--non-numeric">Delete</th>
          <?php } ?>
          <th class="mdl-data-table__cell--numeric">Client ID</th>
          <th class="mdl-data-table__cell--numeric">Name</th>
          <th class="mdl-data-table__cell--numeric">Address 1</th>
          <th class="mdl-data-table__cell--numeric">Address 2</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">Phone1</th>
          <th class="mdl-data-table__cell--numeric">Contact Person</th>

       
        </tr>
      </thead>
      <tbody>
      <?php if($sql_client->num_rows > 0) {
          while ($sql_client_details = $sql_client->fetch_assoc()) {
            $CLT_CLIENT_ID=$sql_client_details["CLT_CLIENT_ID"];
            $CLT_APPROVAL=$sql_client_details["CLT_APPROVAL"];
            $delete_flag=$sql_client_details["CLT_DELETE_FLAG"];

            if($delete_flag=='NO') {

               $value = '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                            <tr>
                                <th>Phone2</th>
                                <th>Mobile(Contact Person)</th>
                                <th>E-Mail(Contact Person)</th>
                                <th>Company Status</th>
                                <th>PAN</th>
                                <th>GST Regn. Number</th>
                                <th>VAT Regn. Number</th>
                                <th>STX Regn. Number</th>
                            </tr>
                             <tr>
                              <td>'.$sql_client_details["CLT_PHONE2"].'</td>
                              <td>'.$sql_client_details["CLT_CP_MOB_NUM"].'</td>
                              <td>'.$sql_client_details["CLT_CP_MAIL"].'</td>
                              <td>'.$sql_client_details["CLT_COMPANY_STATUS"].'</td>
                              <td>'.$sql_client_details["CLT_PAN"].'</td>
                              <td>'.$sql_client_details["CLT_GST_REG"].'</td>
                              <td>'.$sql_client_details["CLT_VAT_REG"].'</td>
                              <td>'.$sql_client_details["CLT_STX_REG"].'</td>
                            </tr>
                            </table>';

        ?>
        <tr data-child-value="<?php echo $value;?>">
          <?php if($_SESSION['APPROVE']=='Yes') { ?> 
          <td>
            <?php if($CLT_APPROVAL=='PENDING') { ?>
                <a href="approvalClient.php?CLT_CLIENT_ID=<?php echo $CLT_CLIENT_ID ?>&CLT_APPROVAL=<?php echo $CLT_APPROVAL ?>&APPROVAL=<?php echo "APPROVE" ?>">
                  <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                </a>
                <a href="approvalClient.php?CLT_CLIENT_ID=<?php echo $CLT_CLIENT_ID ?>&CLT_APPROVAL=<?php echo $CLT_APPROVAL ?>&APPROVAL=<?php echo "REJECT" ?>">
                 <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                </a>
            <?php } else if($CLT_APPROVAL=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($CLT_APPROVAL=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
            ?>
          </td>
          <?php } ?>
          
          <?php if($_SESSION['EDIT']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
            <?php if(($CLT_APPROVAL != 'EDITING')) { ?>
              <a href="editClientDetails.php?Client_ID=<?php echo $CLT_CLIENT_ID; ?>&Approval_Status=<?php echo $CLT_APPROVAL; ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>
            <?php } else if ($CLT_APPROVAL=='EDITING') { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } ?>
               
            </td>
          <?php } ?>

          <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <td class="mdl-data-table__cell--non-numeric" id="delete_client">
              <?php if(($delete_flag=='NO') && (($CLT_APPROVAL=='PENDING') || ($CLT_APPROVAL=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed();" href="deleteClient.php?Client_ID=<?php echo $CLT_CLIENT_ID ?>&Delete_Flag=<?php echo $delete_flag ?>"> <span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
              <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
            </td>
          <?php } ?>
          
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_CLIENT_ID"])!=null) 
                  echo $sql_client_details["CLT_CLIENT_ID"]; 
                else
                  echo "---------";
              ?>
          </td>

          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_NAME"])!=null) 
                  echo $sql_client_details["CLT_NAME"]; 
                else
                  echo "---------";
              ?>
          </td>

          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_ADDRESS1"])!=null) 
                  echo $sql_client_details["CLT_ADDRESS1"]; 
                else
                  echo "---------";
              ?>
          </td>

          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_ADDRESS2"])!=null) 
                  echo $sql_client_details["CLT_ADDRESS2"]; 
                else
                  echo "---------";
              ?>
          </td>

          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_PIN"])!=null) 
                  echo $sql_client_details["CLT_PIN"]; 
                else
                  echo "---------";
              ?>
          </td>

          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_CITY"])!=null) 
                  echo $sql_client_details["CLT_CITY"]; 
                else
                  echo "---------";
              ?>
          </td>

          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_STATE"])!=null) 
                  echo $sql_client_details["CLT_STATE"]; 
                else
                  echo "---------";
              ?>
          </td>

          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_PHONE1"])!=null) 
                  echo $sql_client_details["CLT_PHONE1"]; 
                else
                  echo "---------";
              ?>
          </td>


          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_client_details["CLT_CONTACT_PERSON"])!=null) 
                  echo $sql_client_details["CLT_CONTACT_PERSON"]; 
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
      window.location.href='viewClientDetails.php';
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