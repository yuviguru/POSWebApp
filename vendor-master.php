<?php session_start();
  $vendor_master='';

include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
	
		include 'check_page_access.php';
      $sql_branch_stat = "SELECT BRN_PKID,BRN_CITY FROM branch_master where BRN_APPROVAL='YES'";
      $sql_branch_list = $conn->query($sql_branch_stat);


    $sql_settings="SELECT Vendor_Master FROM settings";
    $sql_branch = $conn->query($sql_settings);


     $sql_state_details = "SELECT DISTINCT State_ID,State_Name FROM state_city order by State_Name";
    $sql_state = $conn->query($sql_state_details);

    $sql_city_details = "SELECT DISTINCT City_Name FROM state_city";
    $sql_city = $conn->query($sql_city_details);

  if($sql_branch->num_rows > 0){
    while ($sql_bra = $sql_branch->fetch_assoc()) {   
      $vendor_master=$sql_bra["Vendor_Master"];
    }
  } 
  
                         
?>

<!doctype html>
<html lang="en">
<?php 
  include 'header.php'; 

  ?>
   <style type="text/css">
    #vennameErr,#contbrancherr,#cityErr,#C_formErr,#stateErr,#pinErr,#mobErr,
    #quotetypeErr,#paymentErr,#cmpStatusErr,#add1err{
      color: #d50000;
      position: absolute;
      font-size: 12px;
      margin-top: 3px;
      visibility: visible;
      display: block;}
      .mandatory{color: red;font-size: 17px;}
  </style> 
  
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
 
  <?php include 'navigation.php';
  if(isset($_SESSION['USERID'])) { ?> 
  <br><br><br><br> 
  <main>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        Vendor Master
      </div>
      <?php if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes'){?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewVendorDetails.php">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">View All</button>
        </a>
      </div>
      <?php } ?>
    </div>
  </main> 

  
  <main class="mdl-layout__content" style="margin-top: -15px;">
    <div class="mdl-grid">
        <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center" style="">
        <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
          <div class="mdl-cell mdl-cell--12-col" align="right">
            <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
          </div>
        </div>

          <form action="vendor_db.php" style="padding: 2px;" autocomplete="off" class="margin">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--3-col" align="center">
           
                  <input class="mdl-textfield__input" type="hidden" id="VEN_ID" name="VEN_ID" maxlength="50" value="<?php echo $vendor_master?>">
                  <input id="OLD_VEN_ID" type="hidden" name="OLD_VEN_ID" value="<?php echo $vendor_master?>">
                   <div id="cntrl_branch" style="display: none;"></div>
                <!-- </div> -->
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="vendorName" name="vendorName" maxlength="50" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="vendorName">Vendor Name<span class="mandatory">*</span></label>
                  <span id="vennameErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="sample3" name="conpers" maxlength="30" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="sample3">Contact Person</label>
                </div>
                
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" id="sample3" name="telephone" pattern="^\(?([0-9]{3,5})\)?([-][0-9]{6,8})$" onkeypress="validateNumber_and_Hyphen();" maxlength="15">
                  <label class="mdl-textfield__label" for="sample3">Telephone</label>
                  <span class="mdl-textfield__error">Enter Valid Telephone Number (Ex : 044-12345678)</span>
                </div>
                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-top: -13px;">
                  <input class="mdl-textfield__input" type="text" id="Mobile" name="Mobile" pattern="^([0-9]{10})+$" maxlength="10" onkeypress="validateNumber();">
                  <label class="mdl-textfield__label" for="Mobile">Mobile <span class="mandatory">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Mobile Number</span>
                  <span id="mobErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input"  id="sample3" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" name="email" maxlength="50">
                  <label class="mdl-textfield__label" for="sample3">E-Mail</label>
                  <span class="mdl-textfield__error">Please Enter valid Email Id!(ex:name@domin.com)</span>
                </div>
              </div>

              <div class="mdl-cell mdl-cell--3-col" align="center">
               
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="contbranch">Controlling Branch<span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" name="contbranch" id="contbranch">
                    <option value="" disabled selected></option>
                   <?php if($sql_branch_list->num_rows > 0){
                    while ($sql_branchDetails = $sql_branch_list->fetch_assoc()) {
                      echo '<option value="'.$sql_branchDetails["BRN_PKID"].'">'.$sql_branchDetails["BRN_CITY"].'('.$sql_branchDetails["BRN_PKID"].')'.'</option><br>';
                    
                    }
                    } 
                    $conn->close();
                    ?>
                  </select>
                  <span id="contbrancherr"></span>
                </div>
                

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: -18px;">
                  <textarea class="mdl-textfield__input" type="text" rows= "2" id="add1" maxlength="100" name="add1"></textarea>
                  <label class="mdl-textfield__label" for="add1">Address 1<span class="mandatory">*</span></label>
                  <span id="add1err"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: -5px;">
                  <textarea class="mdl-textfield__input" type="text" rows="2" id="add2" name="add2" maxlength="50"></textarea>
                  <label class="mdl-textfield__label" for="add2">Address 2</label>
                </div> 
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: -20px;">
                  <input class="mdl-textfield__input" type="text" id="Pincode" name="Pincode" pattern="^([0-9]{6})+$" maxlength="6" onkeypress="validateNumber();">
                  <label class="mdl-textfield__label" for="Pincode">Pin Code <span class="mandatory">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Pincode</span>
                  <span id="pinErr"></span>
                </div>               
              </div>

              <div class="mdl-cell mdl-cell--3-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="State">State <span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" name="State" id="State">
                    <option value="" disabled selected></option>
                    <?php if($sql_state->num_rows > 0){
                      while ($sql_st_name = $sql_state->fetch_assoc()) {
                        echo '<option value='.$sql_st_name["State_Name"].'>'.$sql_st_name["State_Name"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                   <span id="stateErr"></span>
                </div>
                <div id="city_names" style="margin-top: 0px;"></div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="sample3" name="PAN" maxlength="10" onkeypress="Alphanumeric();">
                  <label class="mdl-textfield__label" for="sample3">PAN</label>
                </div>


                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="sample3" name="VAT" maxlength="15" onkeypress="Alphanumeric();">
                  <label class="mdl-textfield__label" for="sample3">VAT Regn </label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-top: 19px;">
                  <input class="mdl-textfield__input" type="text" id="sample3" name="STX" maxlength="15" onkeypress="Alphanumeric();">
                  <label class="mdl-textfield__label" for="sample3">STX</label>
                </div>
              </div>

              <div class="mdl-cell mdl-cell--3-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">                  
                  <label class="mdl-textfield__label" for="quotetype">Quote Type<span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" name="quotetype" id="quotetype">
                    <option value="" disabled selected></option>
                    <option value="Mail">Mail</option>
                    <option value="Quote">Quote</option>
                    <option value="our confirm">Our Confirm</option>                   
                  </select>
                  
                  <span id="quotetypeErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="paymentterm" name="paymentterm" maxlength="100" onkeypress="validateAlphanumeric();">
                  <label class="mdl-textfield__label" for="paymentterm">Payment Term<span class="mandatory">*</span></label>
                  <span id="paymentErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-top: 19px;">
                  <label class="mdl-textfield__label" for="companyStatus">Company Status<span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" name="companyStatus" id="companyStatus">
                    <option value="" disabled selected></option>
                    <option value="Asscociation of Persons">Asscociation of Persons</option>
                    <option value="Body of Individuals-Proprietorship">Body of Individuals-Proprietorship</option>
                    <option value="Company Resident-Limited">Company Resident-Limited</option>
                    <option value="Company Resident-PVT Ltd">Company Resident-PVT Ltd</option>
                    <option value="Co-operative Society/Trust">Co-operative Society/Trust</option>
                    <option value="Individual HUF Resident">Individual HUF Resident</option>
                    <option value="Limited Liablity Partnership(LLP)">Limited Liablity Partnership(LLP)</option>
                    <option value="Partnership Firm">Partnership Firm</option>
                  </select>
                  <span id="cmpStatusErr"></span>
                </div>
              </div>

              <div class="mdl-grid" align="center" style="width:100%">
              <div class="mdl-cell mdl-cell--3-col" align="center"></div>
               <div class="mdl-cell mdl-cell--3-col" align="center">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="submit" type="submit" name="submit" style="width:100%" onclick="return(checkvenName() && checkMobile() && conbranch() && checkAddress_vendor() && checkState() && checkCity() && checkPincode() &&  checkquotetype() && checkpayment() && checkcmpStatus() && ven());">Submit</button>
                </div>
                 <div class="mdl-cell mdl-cell--3-col" align="center">
                <button type="reset" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%" >Clear</button>
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
<script src="js/validation.js" type="text/javascript"></script>
<script type="text/javascript">

      $("#State").on("change", function() {
          $.ajax({url: "getCity.php?State="+document.getElementById("State").value, success: function(result){
              $("#city_names").show();
              $("#city_names").html(result);
          }});
      });


         $("#contbranch").on("change", function() {
          $.ajax({url: "getCB.php?CB="+document.getElementById("contbranch").value, success: function(result){
              $("#cntrl_branch").show();
              $("#cntrl_branch").html(result);
          }});
      });

</script>

<script type="text/javascript">

 function ven()
    {
      var full_serial='';
      var ID=($('#VEN_ID').val().trim());

    var bran_code=($('#contbranch').val().trim());
    // alert("Branch Name : "+bran_code);

      var brnch_code_two=bran_code.substr(0,2);
      // alert("Branch code  First 2 Characters: "+brnch_code_two);

    var name=($('#City').val().trim());
    // alert("City Name : "+name);

      var city_code=name.substr(0,3).toUpperCase();
      // alert("city code(3 Alphabets) : "+city_code);

    var ven_name=($('#vendorName').val().trim());
    //alert("vendor Name  : "+ven_name);

      var ven_name_code=ven_name.charAt(0).toUpperCase();
     // alert("Name(1 Alphabets) : "+ven_name_code);

   var serial=ID.substr(ID.length - 3);
   // alert("serial ID : "+serial);

      var serial_plus=++serial;
      // alert("serial_plus ID : "+serial_plus);

        if(serial_plus.toString().length <= 1){
            full_serial="00"+serial_plus;
        }
        else if (serial_plus.toString().length>1 && serial_plus.toString().length<= 2){
            full_serial="0"+serial_plus;
        }
        else if (serial_plus.toString().length>2 && serial_plus.toString().length<= 3){
            full_serial=serial_plus;
        }
      var final_ID=brnch_code_two+city_code+ven_name_code+full_serial;
      $('#VEN_ID').val(final_ID).change();
      // alert("Your Vendor ID is : " +final_ID);
    }
</script>

</body>
</html>
