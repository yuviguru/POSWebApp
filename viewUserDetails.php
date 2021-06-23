<?php session_start();
    include 'db-conn.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
	
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
		
    include 'check_page_access.php';
      $sql_user_details = $conn->query("SELECT a.*,b.EMP_NAME FROM user_master a,employee_master b where a.EMP_ID=b.EMP_ID and b.EMP_ID!='00000'");
    ?>
<!doctype html>
<html lang="en">
  <?php include 'header.php'; ?>
  <body>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
  
  <?php include 'navigation.php';
  if(isset($_SESSION['USERID'])) { ?> 
    <br><br><br><br>
    <main>
      <div class="mdl-grid" style="margin-right:120px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 300px;" align="center">
          User Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
          <a href="user-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>
    <div style="margin-right: 200px;
    margin-left: 200px;">
      <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
        <thead>
          <tr>
            <?php if($_SESSION['EDIT']=='Yes') { ?>  
              <th class="mdl-data-table__cell--numeric">Edit</th>
            <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
                <th class="mdl-data-table__cell--numeric">Delete</th>
              <?php } ?>
            <th class="mdl-data-table__cell--numeric">Employee ID</th>
            <th class="mdl-data-table__cell--numeric">Employee Name</th>
            <th class="mdl-data-table__cell--numeric">Approve</th>
            <th class="mdl-data-table__cell--numeric">Edit</th>
            <th class="mdl-data-table__cell--numeric">Create</th>
            <th class="mdl-data-table__cell--numeric">View</th>
          </tr>
        </thead>
        <tbody>
          <?php if($sql_user_details->num_rows > 0) {
            while ($sql_user_detail = $sql_user_details->fetch_assoc()) {

            if($sql_user_detail["Delete_Flag"]=='NO') {
               $menu = explode(',',$sql_user_detail['USER_MENU_ACCESS']); 
                $prefix = $menunames ='';
                foreach($menu as $menuid){
                  $sql_menu = $conn->query("SELECT * FROM menu_master WHERE MENU_ID='$menuid'");
                  $menu_det = $sql_menu->fetch_assoc();
                  $menunames .= $prefix.$menu_det['MENU_NAME'];
                  $prefix = ', ';
                }
                


               $value = '<strong><span class=text_style>More Details</span></strong><br><strong>Menu Access :&nbsp;</strong>'
                        .$menunames.'<br>';
          ?>
          <tr data-child-value="<?php echo $value;?>">
          <?php if($_SESSION['EDIT']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <a href="editUserDetails.php?usrID=<?php echo $sql_user_detail["EMP_ID"]; ?>"><button class="mdl-button mdl-js-button mdl-button--accent"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></button></a>
            </td>
          <?php } ?>

          <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if($sql_user_detail["Delete_Flag"]=='NO') { ?>
                  <a class="click-off" onclick="clickOffConfirmed();" href="deleteUser.php?usrID=<?php echo $sql_user_detail["EMP_ID"] ?>&Delete_Flag=<?php echo $sql_user_detail["Delete_Flag"] ?>"><button class="mdl-button mdl-js-button mdl-button--accent"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></button></a>
              <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
            </td>
          <?php } ?>
          
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_user_detail["EMP_ID"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_user_detail["EMP_NAME"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_user_detail["USER_ACCESS_APPROVE"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_user_detail["USER_ACCESS_EDIT"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_user_detail["USER_ACCESS_CREATE"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_user_detail["USER_ACCESS_VIEW"]?>
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
   
  <?php include "footer.php";} else {
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
<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>
</body>
</html>