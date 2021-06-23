<?php session_start(); 
    include 'db-conn.php';
    

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
      include 'check_page_access.php';
      $sql_emp_ids = $conn->query("SELECT * FROM employee_master where EMP_USER_STATUS='NO' AND EMP_APPROVAL='YES'");
    ?>
  <!doctype html>
  <html lang="en">
  <?php include 'header.php'; ?>  
  
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
 
  <?php include 'navigation.php';
  if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes'){?>
  <br><br><br><br> 
  <main>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        User Master
      </div>
      <?php if( $_SESSION['CREATE']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewUserDetails.php">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">View All</button>
        </a>
      </div>
      <?php } ?>
    </div>
  </main>

    <main class="mdl-layout__content" style="top:-30px;">
    <div class="mdl-grid">
        <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center" style="">
        <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
          <div class="mdl-cell mdl-cell--12-col" align="right">
            <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
          </div>
        </div>
          <form id="user-form" action="usrmas-db.php" autocomplete="off">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <div id="hi"></div>
                <label style="font-size:16px;">User Type<span class="mandatory-field">*</span></label><br>
                <table>
                  <tr><td> 
                     <label class="mdl-radio mdl-js-radio" for="Employee">
                        <input type="radio" id="Employee" name="usertype" value="Employee" class="mdl-radio__button" onchange="getuserdetails()" checked>
                        <span class="mdl-radio__label">Employee</span>
                     </label>
                </td>
                  <td>
                     <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="Client">
                        <input type="radio" id="Client" name="usertype" value="Client" class="mdl-radio__button" onchange="getuserdetails()">
                        <span class="mdl-radio__label">Client</span>
                     </label>
                </td>
                  </tr>
               </table><br>
               <div id="newusertype">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  
                    <?php if($sql_emp_ids->num_rows > 0){
                      echo '<label class="mdl-textfield__label" for="client-id">User<span class="mandatory-field">*</span></label><select class="browser-default mdl-textfield__input" id="user-id" name="user-id"><option value="" disabled selected></option>';
                    while ($sql_emp_id = $sql_emp_ids->fetch_assoc()) {
                      echo '<option value="'.$sql_emp_id["EMP_ID"].'">'.$sql_emp_id["EMP_ID"].' - '.$sql_emp_id["EMP_NAME"].'</option><br>';
                    }
                      echo'</select>';
                    } else { ?>
                      
                      <h6>No Employee Available.<a href="employee-master.php" style="color:green">Create One!</a></h6><br>
                      
                   <?php } ?>
                  <span class="emptyfield-error"></span>
                  </div>
                </div>
                <br><br>
              <label style="font-size:16px;">User Rights<span class="mandatory-field">*</span></label><br>
                <table align="center">
                  
                  <tr><td> 
                     <label class="mdl-checkbox mdl-js-checkbox" for="user_rights0">
                        <input type="hidden" name="user_rights[0]" id="user_rights0hidden" value="No">
                        <input type="checkbox" name="user_rights[0]" id="user_rights0" class="mdl-checkbox__input req" value="Yes">
                        <span class="mdl-checkbox__label">APPROVE</span>
                     </label>
                </td><td>
                     <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="user_rights1">
                        <input type="hidden" name="user_rights[1]" id="user_rights1hidden" value="No">
                        <input type="checkbox" name="user_rights[1]" id="user_rights1" class="mdl-checkbox__input req" value="Yes">
                        <span class="mdl-checkbox__label">EDIT</span>
                     </label>   
                </td><td>
                     <label class="mdl-checkbox mdl-js-checkbox" for="user_rights2">
                        <input type="hidden" name="user_rights[2]" id="user_rights2hidden" value="No">
                        <input type="checkbox" name="user_rights[2]" id="user_rights2" class="mdl-checkbox__input req" value="Yes">
                        <span class="mdl-checkbox__label">CREATE</span>
                     </label>    
                 </td><td>
                     <label class="mdl-checkbox mdl-js-checkbox" for="user_rights3">
                        <input type="hidden" name="user_rights[3]" id="user_rights2hidden" value="No">
                        <input type="checkbox" name="user_rights[3]" id="user_rights3" class="mdl-checkbox__input req" value="Yes" checked onclick="return false">
                        <span class="mdl-checkbox__label">VIEW</span>
                     </label>    
                 </td></tr>
               </table>  
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$" id="user-pass" name="user-pass" maxlength="20" onkeypress="Space();" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
                  <label class="mdl-textfield__label" for="user-pass">Password<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Password Should have 1 uppercase & a number</span>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="password" id="user-cpass" name="user-cpass" maxlength="20" onkeypress="Space();" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
                  <label class="mdl-textfield__label" for="user-cpass">Confirm Password<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Password Should have 1 uppercase & a number</span>
                  <span class="emptyfield-error"></span>
                  <span class="otherfield-error"></span>
                </div>  
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <label style="font-size:16px;">Menu Access<span class="mandatory-field">*</span></label><br><br>
                <table align="center">
                <?php 
                $sql_menu = $conn->query("SELECT * FROM menu_master order by MENU_ORDER,MENU_ID;");
                  $menu_count = 0;
                  $menu_rows  = round(($sql_menu->num_rows)/2); 
                  if($sql_menu->num_rows > 0){
                    while ($sql_menu_det = $sql_menu->fetch_assoc()) {?>
                    <?php if($menu_count%2==0) {?>
                      <tr>
                    <?php }
                       echo '<td><label class="mdl-checkbox mdl-js-checkbox" for="menu'.$menu_count.'"><input value='.$sql_menu_det['MENU_ID'].' name="menu['.$menu_count.']" type="checkbox" id="menu'.$menu_count.'" class="mdl-checkbox__input req"><span class="mdl-checkbox__label">'.$sql_menu_det['MENU_NAME'].'</span></label></td>';
                     if($menu_count%2!=0) { ?>
                      </tr>
                    <?php } $menu_count++; } } 
                    $conn->close();?>
                </table>   
              </div>
              <div class="mdl-grid" align="center" style="width:100%">
              <div class="mdl-cell mdl-cell--3-col" align="center"></div>
               <div class="mdl-cell mdl-cell--3-col" align="center">
                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Submit</button>
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
  <?php include 'footer.php'; 
   } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>
</div>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
  $("#user-id").on("change", function() {
        var radioValue = $("input[name='usertype']:checked").val();
          $.ajax({url: "getUserName.php?user_id="+document.getElementById("user-id").value+"&usertype="+radioValue, success: function(result){
              $("#hi").html(result);
          }});
      });
  function getuserdetails() {
        var radioValue = $("input[name='usertype']:checked").val();
          $.ajax({url: "getuserdetails.php?usertype="+radioValue, success: function(result){
              
              $("#newusertype").html(result);
          }});
      }
</script>
</body>
</html>
