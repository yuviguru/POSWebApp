<?php session_start();
$ACT_PKID=$_GET['ACT_PKID'];
$Approval_Status=$_GET['Approval_Status'];
$ACT_APPROVALL='';

include 'db-conn.php';

// Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

  $sql_appr="SELECT ACT_APPROVAL FROM activity_master where ACT_PKID='$ACT_PKID'";
  $sql_app = $conn->query($sql_appr);
  $sql_category = $conn->query("SELECT * FROM categories");

  if($sql_app->num_rows > 0) 
  {
    while ($sql_act_details = $sql_app->fetch_assoc()) {
      $ACT_APPROVALL=$sql_act_details["ACT_APPROVAL"];
    }
  }
  if($ACT_APPROVALL!='EDITING') { 

  $ACT_PKID=$_GET['ACT_PKID'];
  $ACT_NAME='';
  $ACT_CATEGORY='';
  $ACT_DEPEND='';

  include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

    $sql1 = "UPDATE activity_master set ACT_APPROVAL='EDITING' where ACT_PKID='$ACT_PKID'";

    if (mysqli_query($conn, $sql1)) 
    { 

      $sql_act_master="SELECT * FROM activity_master where ACT_PKID='$ACT_PKID'";
      $sql_act = $conn->query($sql_act_master);

      if($sql_act->num_rows > 0) 
      {
        while ($sql_act_details = $sql_act->fetch_assoc()) {
          $ACT_NAME=$sql_act_details["ACT_NAME"];
          $ACT_CATEGORY=explode(',', $sql_act_details["ACT_CATEGORY"]);
          $ACT_DEPEND=explode(',', $sql_act_details["ACT_DEPEND"]);
        }
      }

    } else {
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }

  
  $conn->close();
                         
?>

<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
  <?php include 'navigation.php'; 
  if(isset($_SESSION['USERID']) && $_SESSION['EDIT']=='Yes') { ?> 
  <br><br><br><br> 
  <main>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        Activity Details
      </div>
      <?php if( $_SESSION['VIEW']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewActivityDetails.php#">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">View All</button>
        </a>
      </div>
      <?php } ?>
    </div>
  </main>
  <main class="mdl-layout__content">
    <div class="mdl-grid">
        <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center">
          <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
            <div class="mdl-cell mdl-cell--12-col" align="right">
              <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
            </div>
          </div>
          <form id="act-form" action="update-acmas-db.php" style="padding: 15px;" autocomplete="off">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--4-col" align="center">

                <input type="hidden" id="ID" name="ID" maxlength="50" value="<?php echo $ACT_PKID?>">
                <input type="hidden" id="Approval_Status" name="Approval_Status" maxlength="50" value="<?php echo $Approval_Status?>">

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="ACT_NAME" name="ACT_NAME" value="<?php echo $ACT_NAME ?>" maxlength="50" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="ACT_NAME">Activity Name<span class="mandatory">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
               
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <div id="cat_select">
                <select id='ACT_CAT' multiple='multiple' name="ACT_CAT[]">
                  <?php if($sql_category->num_rows > 0) {
                      while ($sql_cat = $sql_category->fetch_assoc()) {
                        echo '<option '.(in_array($sql_cat["CAT_ID"], $ACT_CATEGORY) ? "selected" : "").' value="'.$sql_cat["CAT_ID"].'">'.$sql_cat["CAT_NAME"].'</option>';
                      }
                    } ?>
                </select>
                <label class="mdl-textfield__label" for="ACT_NAME" style="display:none">Categories<span class="mandatory">*</span></label>
                <span class="emptyfield-error relative"></span>
              </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="new">
                  <input class="mdl-textfield__input req" type="text" id="ACT_CAT_NEW" name="ACT_CAT_NEW" maxlength="50" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="ACT_CAT_NEW">New Category</label>
                  <span  class="emptyfield-error"></span>
                </div>
                <button type="button" id="add_cat" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--blue mdl-color-text--white" style="width:10%">Add</button>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
              <label style="font-size:16px;">Rate Dependencies</label><br><br>
               <table align="center">
                  <tr><td> 
                     <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="ACT_DEP0">
                        <input type="checkbox" name="ACT_DEP[0]" id="ACT_DEP0" class="mdl-checkbox__input req" <?php echo (in_array("ELEMENT MASTER", $ACT_DEPEND) ? "checked" : "") ?> value="ELEMENT MASTER">
                        <span class="mdl-checkbox__label">ELEMENT MASTER</span>
                     </label>
                </td></tr><tr><td>
                     <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="ACT_DEP1">
                        <input type="checkbox" name="ACT_DEP[1]" id="ACT_DEP1" class="mdl-checkbox__input req" <?php echo (in_array("MATERIAL MASTER", $ACT_DEPEND) ? "checked" : "") ?> value="MATERIAL MASTER">
                        <span class="mdl-checkbox__label">MATERIAL MASTER</span>
                     </label>   
                </td></tr><tr><td>
                     <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="ACT_DEP2">
                        <input type="checkbox" name="ACT_DEP[2]" id="ACT_DEP2" class="mdl-checkbox__input req" <?php echo (in_array("WORK PLACE", $ACT_DEPEND) ? "checked" : "") ?> value="WORK PLACE">
                        <span class="mdl-checkbox__label">WORK PLACE</span>
                     </label>    
                 </td><tr>
               </table>  
              </div>
              <div class="mdl-grid" align="center" style="width:100%">
              <div class="mdl-cell mdl-cell--3-col" align="center"></div>
               <div class="mdl-cell mdl-cell--3-col" align="center">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-cell--6-offset " style="width:100%">Update</button>
               </div>
              </div>
            </div>
          </form>
        </div>
      </div>
  </main>
<?php } else {
  echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
} ?>
</div>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">

    $( window ).on('unload',function() {
    var ACT_PKID=$("#ID").val();
    var Approval_Status=$("#Approval_Status").val();
    var Table_Name="activity_master";
    var Col_Name="ACT_PKID";
    var Col_Name2="ACT_APPROVAL";

      $.ajax({
      type: 'GET',
      async: false,
      url: 'Approval_Status.php',
      data: 'PKID=' + ACT_PKID + '&Table_Name=' + Table_Name + '&Col_Name=' + Col_Name + '&Col_Name2=' + Col_Name2 + '&Approval_Status=' + Approval_Status,
      });
   });
</script>
<script type="text/javascript">
  $("#act-form").on("submit", function() {
  var check = true;
    var anyFieldIsEmpty = $("#act-form input").not('.req').each(function() {
           fieldname1 = $(this).siblings('.mdl-textfield__label').text();
           fieldname = fieldname1.substr(0, fieldname1.length - 1);
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;  
         }
        });

    var anyFieldIsEmpty1 = $("#act-form select").not('.req').each(function() {
           fieldname1 = $(this).siblings('.mdl-textfield__label').text();
           fieldname = fieldname1.substr(0, fieldname1.length - 1);
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
         }
        });
    if(check == false){
      return false;
    }
});


 $("#act-form .mdl-textfield__input").on("change paste keyup", function() {
  if($(this).val().trim() != '') 
    $(this).siblings('.emptyfield-error'). hide();
   else
    $(this).siblings('.emptyfield-error').show();
  });
</script>

<script type="text/javascript">
  $('#ACT_CAT').multiSelect({
    selectableHeader: "<div class='custom-header'>Selectable Categories</div>",
    selectionHeader: "<div class='custom-header'>Selected Categories</div>"
    });
    $('#refresh').on('click', function(){
      $('#ACT_CAT').multiSelect('refresh');
      return false;
    });

    $('#add_cat').on('click', function(){
        var new_cat = $("#ACT_CAT_NEW").val();
        if(new_cat != ""){
        var master = "activity_master";
        swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Add it!',
              closeOnConfirm: false,
              closeOnCancel: true
          }, function clickOffConfirmed(isConfirm) {
              if (isConfirm) {
                $.ajax({
                    url : 'addCategories.php',
                    type : 'POST',
                    data : {CAT_NAME : new_cat,CAT_MASTER : master},
                    success : function (result) {
                      if(result['error']=="false"){
                        $('#ACT_CAT').multiSelect('addOption', { value: result['id'], text: result['name'], index: 0 });
                        swal("Added!", "Your Category has been deleted.", "success");
                      }
                      else{
                        alert(result['error']);
                        swal("Error!", "Try Again", "error");
                      }
                    },
                })
              } else {
                  swal('Cancelled','error');
              }
          });
     
      }else{
        $("#ACT_CAT_NEW").siblings('.emptyfield-error').text('Enter Name to Add');
      }
  });
 </script> 
  </body>
</html>
<?php } else {
  echo"<script>alert('Another Admin Editing this Activity');
  window.top.location.href='viewActivityDetails.php'</script>";
} 

?>


