<?php session_start();

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_vendor_master="SELECT a.*,b.BRN_CITY FROM vendor_master a,branch_master b where a.VEN_CON_BRN=b.BRN_PKID";
    $sql_vendor = $conn->query($sql_vendor_master);

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
      <div class="mdl-grid" style="margin-right:40px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;" align="center">
          Vendor Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top: 0px;">
          <a href="vendor-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>

  
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
           <th class="mdl-data-table__cell--numeric">Vendor Id</th> 
          <th class="mdl-data-table__cell--numeric">Vendor Name</th>
          <th class="mdl-data-table__cell--numeric">Contact Person</th>
          <th class="mdl-data-table__cell--numeric">Controlling Branch</th>
          <th class="mdl-data-table__cell--numeric">Mobile Number</th>      
          <th class="mdl-data-table__cell--numeric">Company Status</th>
        </tr>
      </thead>
      <tbody>
      <?php if($sql_vendor->num_rows > 0) {
          while ($sql_vendor_details = $sql_vendor->fetch_assoc()) {
             $VEN_PKID=$sql_vendor_details["VEN_PKID"];
             $delete_flag=$sql_vendor_details["DELETE_FLAG"]; 

            if($delete_flag=='NO') {

               $value = '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                            <tr>     
                            <th>Address 1</th>                          
                                <th>Address 2</th>
                                <th>City</th>
                                <th>State </th>
                                <th>Pincode</th>
                                
                                <th>Telephone</th> 
                                <th>Email</th>
                                <th>PAN</th>
                                <th>VAT Regn</th>
                                <th>STX</th>
                                <th>Quote Type</th>
                                <th>Payment Term</th>
                            </tr>
                             <tr>
                             <td>'.$sql_vendor_details["VEN_ADD1"].'</td>
                             <td>'.$sql_vendor_details["VEN_ADD2"].'</td>
                              <td>'.$sql_vendor_details["VEN_CITY"].'</td>
                              <td>'.$sql_vendor_details["VEN_STATE"].'</td>
                              <td>'.$sql_vendor_details["VEN_PINCD"].'</td>
                              
                              <td>'.$sql_vendor_details["VEN_TELE_PH"].'</td>
                              <td>'.$sql_vendor_details["VEN_EMAIL_ID"].'</td>
                              <td>'.$sql_vendor_details["VEN_PAN"].'</td>
                              <td>'.$sql_vendor_details["VEN_VAT"].'</td>
                              <td>'.$sql_vendor_details["VEN_STX"].'</td>
                              <td>'.$sql_vendor_details["VEN_QUOTE_TYPE"].'</td>
                              <td>'.$sql_vendor_details["VEN_PAYMENT_TERM"].'</td>
                            </tr>
                            </table>';
        ?>
        <tr data-child-value="<?php echo $value;?>">
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
            <?php if($sql_vendor_details["VEN_APPROVAL"]=='PENDING') { ?>
                <a href="approvalVendor.php?VEN_PKID=<?php echo $sql_vendor_details["VEN_PKID"] ?>&VEN_APPROVAL=<?php echo $sql_vendor_details["VEN_APPROVAL"] ?>&APPROVAL=<?php echo "APPROVE" ?>">
                  <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                </a>
                <a href="approvalVendor.php?VEN_PKID=<?php echo $sql_vendor_details["VEN_PKID"] ?>&VEN_APPROVAL=<?php echo $sql_vendor_details["VEN_APPROVAL"] ?>&APPROVAL=<?php echo "REJECT" ?>">
                  <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                </a>
              <?php } else if($sql_vendor_details["VEN_APPROVAL"]=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($sql_vendor_details["VEN_APPROVAL"]=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
            ?>
            </td>

          <?php } if($_SESSION['EDIT']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if($sql_vendor_details["VEN_APPROVAL"]!='EDITING') { ?>
                <a href="editVendorDetails.php?VEN_PKID=<?php echo $VEN_PKID ?>&Approval_Status=<?php echo $sql_vendor_details["VEN_APPROVAL"]; ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>              
              <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
            </td>
          <?php } ?>
          
          <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if(($delete_flag=='NO') && (($sql_vendor_details["VEN_APPROVAL"]=='PENDING') || ($sql_vendor_details["VEN_APPROVAL"]=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed = confirm('Are you sure?');" href="deleteVendor.php?VEN_PKID=<?php echo $VEN_PKID ?>&DELETE_FLAG=<?php echo $delete_flag ?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a> 
              <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
            </td>
          <?php } ?>

          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_vendor_details["VEN_PKID"])!=null) 
                echo $sql_vendor_details["VEN_PKID"]; 
              else
                echo "--";
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_vendor_details["VEN_NAME"])!=null) 
                echo $sql_vendor_details["VEN_NAME"]; 
              else
                echo "--";
            ?>
          </td>
           <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_vendor_details["VEN_CP"])!=null) 
                echo $sql_vendor_details["VEN_CP"]; 
              else
                echo "--";
            ?>
          </td>
           <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_vendor_details["BRN_CITY"])!=null) 
                echo $sql_vendor_details["BRN_CITY"]; 
              else
                echo "--";
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_vendor_details["VEN_MOB_NO"])!=null) 
                echo $sql_vendor_details["VEN_MOB_NO"]; 
              else
                echo "--";
            ?>
          </td>          
        
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_vendor_details["VEN_COMPANY_STATUS"])!=null) 
                echo $sql_vendor_details["VEN_COMPANY_STATUS"]; 
              else
                echo "--";
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
  } ?></div>
<script type="text/javascript">
  $('.click-off').click(function () {
    // escape here if the confirm is false;
    if (!clickOffConfirmed) return false;
    var btn = this;
    return true;
  });
</script>
<script type="text/javascript">
    $( document ).ready(function() {
    var url = document.location.toString();
      var url_id= url.substr(-1);
    if (url_id=='#'){
      window.location.href='viewVendorDetails.php';
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