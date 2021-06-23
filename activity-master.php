<?php session_start();
  $Activity_Master='';

 include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_settings="SELECT Activity_Master as Activity_Master FROM settings";
    $sql_category = $conn->query("SELECT * FROM categories WHERE CAT_MASTER='activity_master'");
    $sql_branch = $conn->query($sql_settings);

  if($sql_branch->num_rows > 0){
    while ($sql_bra = $sql_branch->fetch_assoc()) {
      $Activity_Master=$sql_bra["Activity_Master"];
    }
  } 
                         
?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <style type="text/css">
    #ACTdescErrEmpty,#ACTVATErrEmpty,#ACTCSTwCErrEmpty,#ACTCSTwoCErrEmpty,#ACTSRVErrEmpty,#ACTGSTErrEmpty {
      color: #d50000;
      position: absolute;
      font-size: 12px;
      margin-top: 3px;
      visibility: visible;
      display: block;}
    .mandatory{color: red;font-size: 17px;}
    .relative{position: relative;}
  </style>
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
 
  <?php include 'navigation.php'; 
  if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes') { ?> 
  <br><br><br><br> 
  <main>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        Activity Details
      </div>
      <?php if( $_SESSION['VIEW']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewActivityDetails.php">
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
          <form id="act-form" type="POST" action="acmas-db.php" autocomplete="off">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <input type="hidden" id="ID" name="ID" maxlength="50" value="<?php echo $Activity_Master?>">
                <input type="hidden" id="OLD_ID" name="OLD_ID" maxlength="50" value="<?php echo $Activity_Master?>">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="ACT_NAME" name="ACT_NAME" maxlength="50" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="ACT_NAME">Activity Name<span class="mandatory">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <div id="cat_select">
                <select id='ACT_CAT' multiple='multiple' name="ACT_CAT[]">
                  <?php if($sql_category->num_rows > 0) {
                      while ($sql_cat = $sql_category->fetch_assoc()) {
                        echo '<option value="'.$sql_cat["CAT_ID"].'">'.$sql_cat["CAT_NAME"].'</option>';
                      }
                    } ?>
                </select>
                <label class="mdl-textfield__label" for="ACT_CAT" style="display:none">Categories<span class="mandatory">*</span></label>
                <span class="emptyfield-error relative"></span>
              </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="new">
                  <input class="mdl-textfield__input req" type="text" id="ACT_CAT_NEW" name="ACT_CAT_NEW" maxlength="50">
                  <label class="mdl-textfield__label" for="ACT_CAT_NEW">New Category</label>
                  <span  class="emptyfield-error"></span>
                </div>
                <button type="button" id="add_cat" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--blue mdl-color-text--white" style="width:10%">Add</button>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
              <label style="font-size:16px;">Rate Dependencies</label><br><br>
               <table align="center">
                  <tr><td> 
                     <label class="mdl-checkbox mdl-js-checkbox" for="ACT_DEP0">
                        <input type="checkbox" name="ACT_DEP[0]" id="ACT_DEP0" class="mdl-checkbox__input req" value="ELEMENT MASTER">
                        <span class="mdl-checkbox__label">ELEMENT MASTER</span>
                     </label>
                </td></tr><tr><td>
                     <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="ACT_DEP1">
                        <input type="checkbox" name="ACT_DEP[1]" id="ACT_DEP1" class="mdl-checkbox__input req" value="MATERIAL MASTER">
                        <span class="mdl-checkbox__label">MATERIAL MASTER</span>
                     </label>   
                </td></tr><tr><td>
                     <label class="mdl-checkbox mdl-js-checkbox" for="ACT_DEP2">
                        <input type="checkbox" name="ACT_DEP[2]" id="ACT_DEP2" class="mdl-checkbox__input req" value="WORK PLACE">
                        <span class="mdl-checkbox__label">WORK PLACE</span>
                     </label>    
                 </td><tr>
               </table>  
              </div>
              <br><br><br><br><br><br><br><br><br><br><br><br>
              <div class="mdl-grid" align="center" style="width:100%">
              <div class="mdl-cell mdl-cell--3-col" align="center"></div>
               <div class="mdl-cell mdl-cell--3-col" align="center">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Submit</button>
               </div>
                 <div class="mdl-cell mdl-cell--3-col" align="center">
                  <button type="reset" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">Clear</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      
  </main>
  <?php include "footer.php";
   } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>
</div>

   
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
   check = function (e,value){
      if (!e.target.validity.valid) {
        e.target.value = value.substring(0,value.length - 1);
        return false;
      }
      var idx = value.indexOf('.');
      if (idx >= 0) {
        if (value.length - idx > 3 ) {
          e.target.value = value.substring(0,value.length - 1);
          return false;
        }
      }
      return true;
    }
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
      var full_serial='';
      var ID=($('#ID').val());

      var desc=($('#ACT_NAME').val());

      var desc_first=desc.charAt(0);

      var serial=ID.substr(ID.length - 2);

      var serial_plus=++serial;

        if(serial_plus.toString().length <= 1){
            full_serial="0"+serial_plus;
        }
        else if (serial_plus.toString().length>1 && serial_plus.toString().length<= 2){
            full_serial=serial_plus;
        }

      var final_ID="A"+desc_first.toUpperCase()+full_serial;
      $('#ID').val(final_ID).change();
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
                        $("#ACT_CAT_NEW").val("");
                        $("#ACT_CAT_NEW").focus();
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
