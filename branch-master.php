<?php session_start();
    include 'db-conn.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    include 'check_page_access.php';
      $sql_branch_id = $conn->query("SELECT Branch_Master FROM settings");
      $branch_id = $sql_branch_id->fetch_assoc()["Branch_Master"];
      $sql_state_details = "SELECT DISTINCT State_ID,State_Name FROM state_city order by State_Name";
      $sql_state = $conn->query($sql_state_details);
    ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  
  <body>
  <div class="mdl-layout mdl-js-layout">
 
  <?php include 'navigation.php';
  if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes') {  ?> 
  <br><br><br><br> 
  <main class="mdl-layout__content">
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        Branch Master
      </div>
      <?php if( $_SESSION['VIEW']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewBranchDetails.php">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">View All</button>
        </a>
      </div>
      <?php } ?>
    </div>
      <div class="mdl-grid">
        <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center" style="">
        <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
            <div class="mdl-cell mdl-cell--12-col" align="right">
              <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
            </div>
        </div>
          <form class="margin" id="branch-form" action="branchmas-db.php" style="padding: 15px;padding-top:0px;" autocomplete="off">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--4-col" align="center">
                  <?php if ($branch_id !== false) { ?>
                  <input class="mdl-textfield__input req" type="hidden" id="branch-id" name="branch-id" value="">
                  <input class="mdl-textfield__input req" type="hidden" id="old-branch-id" name="old-branch-id" value="<?php echo $branch_id; ?>">
                  <?php } ?>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input" type="text" rows= "2" maxlength="100" id="branch-add1" name="branch-add1" onkeypress="SpecialCharacters();"></textarea>
                  <label class="mdl-textfield__label" for="branch-add1">Branch Address 1<span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input req" type="text" rows= "2" maxlength="50" id="branch-add2" name="branch-add2" onkeypress="SpecialCharacters();"></textarea>
                  <label class="mdl-textfield__label" for="branch-add2">Branch Address 2</label>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="branch-state">State <span class="mandatory-field">*</span></label>
                  <select class="browser-default mdl-textfield__input" name="branch-state" id="branch-state">
                  <option value="" disabled selected></option>
                    <?php if($sql_state->num_rows > 0){
                      while ($sql_st_name = $sql_state->fetch_assoc()) {
                        echo '<option value="'.$sql_st_name["State_Name"].'">'.$sql_st_name["State_Name"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                  <span class="mdl-textfield__error"></span>
                  <span class="emptyfield-error"></span>
                </div>
                <div id="city_names2"></div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" pattern="^([0-9]{6})+$" maxlength="6" id="branch-pincode" name="branch-pincode">
                  <label class="mdl-textfield__label" for="branch-pincode">Pin Code<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Pincode</span>
                  <span class="emptyfield-error"></span>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" maxlength="45" id="branch-mail" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" name="branch-mail" maxlength="100">
                  <label class="mdl-textfield__label" for="branch-mail">Email(Official)<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Email(eg. Myname@domain.com)</span>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input req" type="text" id="branch-phn-num" pattern="^\(?([0-9]{3,5})\)?([-][0-9]{6,8})$" name="branch-phn-num" maxlength="12">
                  <label class="mdl-textfield__label" for="sample3">Telephone Number</label>
                  <span class="mdl-textfield__error">Enter Valid Telephone Number(eg:081-12345678)</span>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="branch-CP" name="branch-CP" maxlength="50" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="branch-CP">Contact Person<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error"></span>
                  <span class="emptyfield-error"></span>
                </div>
              </div>  
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
  <?php include 'footer.php'; ?>

  <?php 
   } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>
</div>
     <script type="text/javascript">
       $("#branch-form").on("submit", function() {
  var check = true;
    var anyFieldIsEmpty5 = $("#branch-form input").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
           
         }
        });

    var anyFieldIsEmpty6 = $("#branch-form select").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
           
         }
        });

    var anyFieldIsEmpty7 = $("#branch-form textarea").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
           
         }
        });

    if(check == false){
      return false;
    }
    var old_branch_id = $('#old-branch-id').val();
    var nxt_branch_id = ++old_branch_id;
    var new_branch_id= (nxt_branch_id < 10 ? '0' : '')+nxt_branch_id;
    $('#branch-id').val(new_branch_id);
});  
 $("#branch-form .mdl-textfield__input").on("change paste keyup", function() {
  if($(this).val().trim() != '') 
    $(this).siblings('.emptyfield-error').hide();
   else
    $(this).siblings('.emptyfield-error').show();
  });
     </script>
     <script type="text/javascript">
      $("#branch-state").on("change", function() {
          $.ajax({url: "getCity2.php?State="+document.getElementById("branch-state").value, success: function(result){
              $("#city_names2").show();
              $("#city_names2").html(result);
          }});
      });

</script>
 <script type="text/javascript" src="js/validation.js"></script>
  </body>
</html>
