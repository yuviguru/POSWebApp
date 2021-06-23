//-------------Client - Master Form ---------------------------------------------------------------

//-------------Name ---------------------

/*---------------------------Allowed number and Charcters --------------------------------------*/

function Alphanumeric(){

  if(!(event.keyCode >= 65 && event.keyCode <= 90) && !(event.keyCode >= 97 && event.keyCode <= 122) && !(event.keyCode >= 48 && event.keyCode <= 57))
  { 
    event.returnValue=false; 
  } 

}
/*----------------------------Allowed character  and special character only-------------------------------------*/
function validateAlphabetSpecialchar() 
{ 
  if((event.keyCode >= 48 && event.keyCode <= 57)&& (event.keyCode!= 32))
  { 
    event.returnValue=false; 
  } 
} 
function validateAlphabetSpaceAmpersandquotes() 
{ 
  if(!(event.keyCode >= 65 && event.keyCode <= 90) && !(event.keyCode >= 97 && event.keyCode <= 122) 
    && (event.keyCode != 39) && (event.keyCode != 38) && (event.keyCode != 32))
  { 
    event.returnValue=false; 
  } 
}  

/*--------------------------Allowed numbers and DOT values---------------------------------------*/
function validateNumber_and_dot() 
{ 
  if(!((event.keyCode >= 48 && event.keyCode <= 57)) && (event.keyCode != 46))
  { 
    event.returnValue=false; 
  } 
} 
/*---------------------------Allowed number and Charcters and SPACE--------------------------------------*/

function validateAlphanumeric(){

  if(!(event.keyCode >= 65 && event.keyCode <= 90) && !(event.keyCode >= 97 && event.keyCode <= 122) && !(event.keyCode >= 48 && event.keyCode <= 57) && !(event.keyCode == 32) && !(event.keyCode == 37))
  { 
    event.returnValue=false; 
  } 

}
/*------------------------------Allowed Only Characters-----------------------------------*/

function validateAlphabet() 
{ 
	if(!(event.keyCode >= 65 && event.keyCode <= 90) && !(event.keyCode >= 97 && event.keyCode <= 122) && !(event.keyCode == 32))
	{ 
		event.returnValue=false; 
	} 
}
/*------------------------------Allowed only Numbers-----------------------------------*/

function validateNumber() 
{ 
	if(!(event.keyCode >= 48 && event.keyCode <= 57))
	{ 
		event.returnValue=false; 
	} 
} 
/*---------------------------Allowed Numbers and Hyphen(-)--------------------------------------*/

function validateNumber_and_Hyphen() 
{ 
  if((!(event.keyCode >= 48 && event.keyCode <= 57)) && (event.keyCode != 45))
  { 
    event.returnValue=false; 
  } 
} 
/*-------------------------------Allowed Character,Hyphen(-)----------------------------------*/

function validatecharacter_and_Hyphen() 
{ 
  if((!(event.keyCode >= 65 && event.keyCode <= 90) && !(event.keyCode >= 97 && event.keyCode <= 122)) && (event.keyCode != 45) && (event.keyCode!= 32))
  { 
    event.returnValue=false; 
  } 
} 
/*-------------------------------Allowed Character,number,Hyphen(-),space Field----------------------------------*/

function validatecharacterNumber_and_Hyphen() 
{ 
  if((!(event.keyCode >= 65 && event.keyCode <= 90) && !(event.keyCode >= 97 && event.keyCode <= 122) && !(event.keyCode >= 48 && event.keyCode <= 57)) && (event.keyCode != 45) && (event.keyCode!= 32))
  { 
    event.returnValue=false; 
  } 
} 
/*-------------------------------Allowed Character,Dot,space Field----------------------------------*/
function validatecharacter_and_dot() 
{ 
  if((!(event.keyCode >= 65 && event.keyCode <= 90) && !(event.keyCode >= 97 && event.keyCode <= 122)) && (event.keyCode != 46) && (event.keyCode!= 32))
  { 
    event.returnValue=false; 
  } 
}

function SpecialCharacters() {

  if((event.keyCode == 59) || (event.keyCode == 39) || (event.keyCode == 34) || (event.keyCode == 92))
  { 
    event.returnValue=false; 
  } 

}
function Space() {

  if(event.keyCode == 32)
  { 
    event.returnValue=false; 
  } 

}
/*-----------------------------------------------------------------*/
function checkName()
{
	if(document.getElementById("Name").value.trim() == "")
	{
		document.getElementById("nameErr").innerHTML ="You must enter a Client Name";
		Name.focus();
		return false;
	}
	return true;
}

function checkCP(){
  if(document.getElementById("CPname").value.trim() == "")
  {
    document.getElementById("CPnameerr").innerHTML ="You must enter a Client Name";
    CPname.focus();
    return false;
  }
  return true;
}

function checkCPmob(){
  if(document.getElementById("CPmob").value.trim() == "")
  {
    document.getElementById("CPmoberr").innerHTML ="You must enter a Client Name";
      CPmob.focus();
    return false;
  }
  return true;
}

$("#CPname").on("change paste keyup", function() {
  if($('#CPname').val().trim() != '') {
    $("#CPnameerr").hide();
  }
  else{
    $("#CPnameerr").show();
  }
});

$("#CPmob").on("change paste keyup", function() {
  if($('#CPmob').val().trim() != '') {
    $("#CPmoberr").hide();
  }
  else{
    $("#CPmoberr").show();
  }
});

$("#Name").on("change paste keyup", function() {
  if($('#Name').val().trim() != '') {
    $("#nameErr").hide();
  }
  else{
    $("#nameErr").show();
  }
});

//-------------Name ---------------------

//-------------Address1 ---------------------
function checkAddress1()
{
	if(document.getElementById("Address1").value.trim() == "")
	{
		document.getElementById("add1Err").innerHTML ="You must enter a Client Address 1";
		Address1.focus();
		return false;
	}
	return true;
}

$("#Address1").on("change paste keyup", function() {
  if($('#Address1').val().trim() != '') {
    $("#add1Err").hide();
  }
  else{
    $("#add1Err").show();
  }
});
//-------------Address1 ---------------------

//-------------City ---------------------
function checkCity()
{
	var city = document.getElementById("City");      
    var optionSelIndex = city.options[city.selectedIndex].value;

    if (optionSelIndex == '') 
	{
		document.getElementById("cityErr").innerHTML ="You must Select a City";
       	city.focus();
		return false;
	} 
		return true; 
}

$("#City").on("change paste keyup", function() {
  if($('#City').val().trim() != '') {
    $("#cityErr").hide();
  }
  else{
    $("#cityErr").show();
  }
});

//-------------City ---------------------

//-------------Pincode ---------------------
function checkPincode()
{
	if(document.getElementById("Pincode").value.trim() == "")
	{
		document.getElementById("pinErr").innerHTML ="You must enter a Pincode";
		Pincode.focus();
		return false;
	}
	return true;
}

$("#Pincode").on("change paste keyup", function() {
  if($('#Pincode').val().trim() != '') {
    $("#pinErr").hide();
  }
  else{
    $("#pinErr").show();
  }
});
//-------------Pincode ---------------------

//-------------State ---------------------
function checkState()
{
	var state = document.getElementById("State");      
    var optionSelIndex = state.options[state.selectedIndex].value;

    if (optionSelIndex == '') 
	{
		document.getElementById("stateErr").innerHTML ="You must Select a State";
       	state.focus();
		return false;
	} 
		return true; 
}

$("#State").on("change paste keyup", function() {
  if($('#State').val()!= '') {
    $("#stateErr").hide();
  }
  else{
    $("#stateErr").show();
  }
});

//-------------State ---------------------

//-------------Mobile ---------------------

function checkMobile()
{
	if(document.getElementById("Mobile").value.trim() == "")
	{
		document.getElementById("mobErr").innerHTML ="You must enter a Mobile Number";
		Mobile.focus();
		return false;
	}
	return true;
}

$("#Mobile").on("change paste keyup", function() {
  if($('#Mobile').val().trim() != '') {
    $("#mobErr").hide();
  }
  else{
    $("#mobErr").show();
  }
});

//-------------Mobile ---------------------

//-------------Branch ---------------------
function checkBranch()
{
  var branch = document.getElementById("Branch");      
    var optionSelIndex = branch.options[branch.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("branchErr").innerHTML ="You must Select a Branch";
        branch.focus();
    return false;
  } 
    return true; 
}

$("#Branch").on("change paste keyup", function() {
  if($('#Branch').val()!= '') {
    $("#branchErr").hide();
  }
  else{
    $("#branchErr").show();
  }
});

//-------------Branch ---------------------
//-------------GST ---------------------

function checkGST()
{
  if(document.getElementById("GST").value.trim() == "")
  {
    document.getElementById("gstErr").innerHTML ="You must enter a GST Reg.Number";
    GST.focus();
    return false;
  }
  return true;
}

$("#GST").on("change paste keyup", function() {
  if($('#GST').val().trim() != '') {
    $("#gstErr").hide();
  }
  else{
    $("#gstErr").show();
  }
});

//-------------GST ---------------------

//---------------------End of Client - Master Form-----------------------------------------------------

//---------------------VENDOR - Master Form-----------------------------------------------------


// Company status
function checkAddress_vendor()
{
  if(document.getElementById("add1").value.trim() == "")
  {
    document.getElementById("add1err").innerHTML ="You must enter Address1";
    add1.focus();
    return false;
  }
  return true;
}

$("#add1").on("change paste keyup", function() {
  if($('#add1').val().trim() != '') {
    $("#add1err").hide();
  }
  else{
    $("#add1err").show();
  }
});



  function checkvenName()
{
  if(document.getElementById("vendorName").value.trim() == "")
  {
    document.getElementById("vennameErr").innerHTML ="You must enter a vendor Name";
    vendorName.focus();
    return false;
  }
  return true;
}

$("#vendorName").on("change paste keyup", function() {
  if($('#vendorName').val().trim() != '') {
    $("#vennameErr").hide();
  }
  else{
    $("#vennameErr").show();
  }
});


  function conbranch()
{
  if(document.getElementById("contbranch").value.trim() == "")
  {
    document.getElementById("contbrancherr").innerHTML ="You must enter a Controlling branch";
    contbranch.focus();
    return false;
  }
  return true;
}
$("#contbranch").on("change paste keyup", function() {
  if($('#contbranch').val().trim() != '') {
    $("#contbrancherr").hide();
  }
  else{
    $("#contbrancherr").show();
  }
});
  function vencity()
{
  if(document.getElementById("ven_city").value.trim() == "")
  {
    document.getElementById("ven_cityerr").innerHTML ="You must enter a Controlling branch";
    ven_city.focus();
    return false;
  }
  return true;
}

$("#ven_city").on("change paste keyup", function() {
  if($('#ven_city').val().trim() != '') {
    $("#ven_cityerr").hide();
  }
  else{
    $("#ven_cityerr").show();
  }
});

function c_form(form)
{
    
  if ((form.cform[0].checked == false) && (form.cform[1].checked == false)) 
  {
    document.getElementById("C_formErr").innerHTML ="You must Select C-Form";
    form.focus();
    return false;
  }
  else {
    $("#C_formErr").hide();
    return true;
  }
}

$("#cform").on("change paste keyup", function() {
  if ((form.cform[0].checked == false) && (form.cform[1].checked == false))  {
    $("#C_formErr").show();
  }
  else {
    $("#C_formErr").hide();
  }
});

  //Quote Type
  function checkquotetype()
{
  var branch = document.getElementById("quotetype");      
    var optionSelIndex = branch.options[branch.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("quotetypeErr").innerHTML ="You must Select a Quote Type";
        quotetype.focus();
    return false;
  } 
    return true; 
}

$("#quotetype").on("change paste keyup", function() {
  if($('#quotetype').val()!= '') {
    $("#quotetypeErr").hide();
  }
  else{
    $("#quotetypeErr").show();
  }
});

// Payment
function checkpayment()
{
  if(document.getElementById("paymentterm").value.trim() == "")
  {
    document.getElementById("paymentErr").innerHTML ="You must enter a Payment Term";
    paymentterm.focus();
    return false;
  }
  return true;
}

$("#paymentterm").on("change paste keyup", function() {
  if($('#paymentterm').val().trim() != '') {
    $("#paymentErr").hide();
  }
  else{
    $("#paymentErr").show();
  }
});


// Company status
function checkcmpStatus()
{
  if(document.getElementById("companyStatus").value.trim() == "")
  {
    document.getElementById("cmpStatusErr").innerHTML ="You must Select Company Status";
    companyStatus.focus();
    return false;
  }
  return true;
}

$("#companyStatus").on("change paste keyup", function() {
  if($('#companyStatus').val().trim() != '') {
    $("#cmpStatusErr").hide();
  }
  else{
    $("#cmpStatusErr").show();
  }
});


function check()
{
  var state = document.getElementById("State");      
    var optionSelIndex = state.options[state.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("stateErr").innerHTML ="You must Select a State";
        state.focus();
    return false;
  } 
    return true; 
}

$("#State").on("change paste keyup", function() {
  if($('#State').val()!= '') {
    $("#stateErr").hide();
  }
  else{
    $("#stateErr").show();
  }
});

//---------------------Elements - Master Form-------------------------------------------------
//---------------------Rate - Master Form-----------------------------------------------------
 function checkelementName()
{
  if(document.getElementById("elements").value.trim() == "")
  {
    document.getElementById("elenameErr").innerHTML ="You must enter a Element Name";
    elements.focus();
    return false;
  }
  return true;
}

$("#elements").on("change paste keyup", function() {
  if($('#elements').val().trim() != '') {
    $("#elenameErr").hide();
  }
  else{
    $("#elenameErr").show();
  }
});

//-----------
function elecode()
{
  if(document.getElementById("code").value.trim() == "")
  {
    document.getElementById("codeerr").innerHTML ="Enter Element Code";
    code.focus();
    return false;
  }
  return true;
}

$("#code").on("change paste keyup", function() {
  if($('#code').val().trim() != '') {
    $("#codeerr").hide();
  }
  else{
    $("#codeerr").show();
  }
});

//--------
function elerateunits()
{
  if(document.getElementById("rate").value.trim() == "")
  {
    document.getElementById("rateuniterr").innerHTML ="Enter Rate/Units";
    rate.focus();
    return false;
  }
  return true;
}

$("#rate").on("change paste keyup", function() {
  if($('#rate').val().trim() != '') {
    $("#rateuniterr").hide();
  }
  else{
    $("#rateuniterr").show();
  }
});
//-----------
function elespec()
{
  if(document.getElementById("spec").value.trim() == "")
  {
    document.getElementById("specerr").innerHTML ="Enter Specification";
    spec.focus();
    return false;
  }
  return true;
}

$("#spec").on("change paste keyup", function() {
  if($('#spec').val().trim() != '') {
    $("#specerr").hide();
  }
  else{
    $("#specerr").show();
  }
});
//-----------
function eleunits()
{
  var units = document.getElementById("units");      
    var optionSelIndex = units.options[units.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("unitserr").innerHTML ="You must Select a units";
        units.focus();
    return false;
  } 
    return true; 
}

$("#units").on("change paste keyup", function() {
  if($('#units').val().trim() != '') {
    $("#unitserr").hide();
  }
  else {
    $("#unitserr").show();
  }
});
//--------
function elevat()
{
  if(document.getElementById("vat").value.trim() == "")
  {
    document.getElementById("vaterr").innerHTML ="Enter Units";
    vat.focus();
    return false;
  }
  return true;
}

$("#vat").on("change paste keyup", function() {
  if($('#vat').val().trim() != '') {
    $("#vaterr").hide();
  }
  else{
    $("#vaterr").show();
  }
});
//---------------------Material - Master Form-------------------------------------------------

//---------------------STORE - Master Form-----------------------------------------------------

//-------------Store Type ---------------------
function checkSTRStoreType()
{
  var sttype = document.getElementById("STR_StoreType");      
    var optionSelIndex = sttype.options[sttype.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("STRtypeErr").innerHTML ="You must Select a Store Type";
        sttype.focus();
    return false;
  } 
    return true; 
}

$("#STR_StoreType").on("change paste keyup", function() {
  if($('#STR_StoreType').val().trim() != '') {
    $("#STRtypeErr").hide();
  }
  else{
    $("#STRtypeErr").show();
  }
});

//-------------Store Type ---------------------


//-------------STR Name ---------------------

function checkSTRName()
{
  if(document.getElementById("STR_Name").value.trim() == "")
  {
    document.getElementById("STRNameErr").innerHTML ="You must enter a Name";
    STR_Name.focus();
    return false;
  }
  return true;
}

$("#STR_Name").on("change paste keyup", function() {
  if($('#STR_Name').val().trim() != '') {
    $("#STRNameErr").hide();
  }
  else{
    $("#STRNameErr").show();
  }
});

//-------------STR Name ---------------------

//-------------STR Address1 ---------------------

function checkSTR_Address1()
{
  if(document.getElementById("STR_Address1").value.trim() == "")
  {
    document.getElementById("STRAdd1Err").innerHTML ="You must enter a Address1";
    STR_Address1.focus();
    return false;
  }
  return true;
}

$("#STR_Address1").on("change paste keyup", function() {
  if($('#STR_Address1').val().trim() != '') {
    $("#STRAdd1Err").hide();
  }
  else{
    $("#STRAdd1Err").show();
  }
});

//-------------STR Address1 ---------------------

//-------------STR State ---------------------
function checkSTRState()
{
  var state = document.getElementById("STR_State");      
    var optionSelIndex = state.options[state.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("STRstateErr").innerHTML ="You must Select a State";
        state.focus();
    return false;
  } 
    return true; 
}

$("#STR_State").on("change paste keyup", function() {
  if($('#STR_State').val().trim() != '') {
    $("#STRstateErr").hide();
  }
  else{
    $("#STRstateErr").show();
  }
});

//-------------State ---------------------

//-------------STR City ---------------------
function checkSTRCity()
{
  var city = document.getElementById("STR_City");      
    var optionSelIndex = city.options[city.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("STRcityErr").innerHTML ="You must Select a City";
        city.focus();
    return false;
  } 
    return true; 
}

$("#STR_City").on("change paste keyup", function() {
  if($('#STR_City').val().trim() != '') {
    $("#STRcityErr").hide();
  }
  else{
    $("#STRcityErr").show();
  }
});

//-------------CIty ---------------------

//------------- STR Pincode ---------------------
function checkSTRPin()
{
  if(document.getElementById("STR_Pincode").value.trim() == "")
  {
    document.getElementById("STRpinErr").innerHTML ="You must enter Pincode";
    STR_Pincode.focus();
    return false;
  }
  return true;
}

$("#STR_Pincode").on("change paste keyup", function() {
  if($('#STR_Pincode').val().trim() != '') {
    $("#STRpinErr").hide();
  }
  else{
    $("#STRpinErr").show();
  }
});
//-------------Pincode ---------------------

//------------- STR Email ---------------------
function checkSTREmail()
{
  if(document.getElementById("STR_EmailStore").value.trim() == "")
  {
    document.getElementById("STRemailErr").innerHTML ="You must enter a Email of Store";
    STR_EmailStore.focus();
    return false;
  }
  return true;
}

$("#STR_EmailStore").on("change paste keyup", function() {
  if($('#STR_EmailStore').val().trim() != '') {
    $("#STRemailErr").hide();
  }
  else{
    $("#STRemailErr").show();
  }
});
//-------------Email ---------------------

//------------- STR Contact Person ---------------------
function checkSTRCP()
{
  if(document.getElementById("STR_Person").value.trim() == "")
  {
    document.getElementById("STRcpErr").innerHTML ="You must enter a Contact Person";
    STR_Person.focus();
    return false;
  }
  return true;
}

$("#STR_Person").on("change paste keyup", function() {
  if($('#STR_Person').val().trim() != '') {
    $("#STRcpErr").hide();
  }
  else{
    $("#STRcpErr").show();
  }
});
//-------------Contact Person ---------------------

//------------- STR Mobile ---------------------
function checkSTRMobile()
{
  if(document.getElementById("STR_Mobile").value.trim() == "")
  {
    document.getElementById("STRmobCPErr").innerHTML ="You must enter Mobile Number";
    STR_Mobile.focus();
    return false;
  }
  return true;
}

$("#STR_Mobile").on("change paste keyup", function() {
  if($('#STR_Mobile').val().trim() != '') {
    $("#STRmobCPErr").hide();
  }
  else{
    $("#STRmobCPErr").show();
  }
});
//-------------Mobile ---------------------

//------------- STR Contact Person Email ---------------------
function checkSTREmailCP()
{
  if(document.getElementById("STR_EmailCP").value.trim() == "")
  {
    document.getElementById("STRemailCPErr").innerHTML ="You must enter a Email CP";
    STR_EmailCP.focus();
    return false;
  }
  return true;
}

$("#STR_EmailCP").on("change paste keyup", function() {
  if($('#STR_EmailCP').val().trim() != '') {
    $("#STRemailCPErr").hide();
  }
  else{
    $("#STRemailCPErr").show();
  }
});
//-------------Contact Person Email ---------------------

//-------------STR VAT -----------------------------------
function checkSTRVAT()
{
  if(document.getElementById("STR_VAT").value.trim() == "")
  {
    document.getElementById("STRVATErr").innerHTML ="You must enter a VAT Reg Number";
    STR_VAT.focus();
    return false;
  }
  return true;
}

$("#STR_VAT").on("change paste keyup", function() {
  if($('#STR_VAT').val().trim() != '') {
    $("#STRVATErr").hide();
  }
  else{
    $("#STRVATErr").show();
  }
});

//-------------VAT -------------------------------------


//---------------------END of STORE - Master Form-----------------------------------------------------

//---------------------Activity  - Master Form-----------------------------------------------------

//------------- ACT ACT_VAT---------------------
function checkACTVAT()
{
  if(document.getElementById("ACT_VAT").value.trim() == "")
  {
    $("#ACT_VAT").show();
    ACT_VAT.focus();
    return false;
  }
  return true;
}

$("#ACT_VAT").on("change paste keyup", function() {
  if($('#ACT_VAT').val().trim() != '') {
    $("#ACTVATErrEmpty").hide();
  }
  else{
    $("#ACTVATErrEmpty").show();
  }
});
//------------ ACT_VAT-------------------------------

//------------- ACT ACT_SwC---------------------
function checkACTSwC()
{
  if(document.getElementById("ACT_SwC").value.trim() == "")
  {
    $("#ACT_SwC").show();
    ACT_SwC.focus();
    return false;
  }
  return true;
}

$("#ACT_SwC").on("change paste keyup", function() {
  if($('#ACT_SwC').val().trim() != '') {
    $("#ACTCSTwCErrEmpty").hide();
  }
  else {
    $("#ACTCSTwCErrEmpty").show();
  }
});
//------------ ACT_SwC-------------------------------

//------------- ACT ACT Description---------------------
function checkACTDesc()
{
  if(document.getElementById("ACT_DESC").value.trim() == "")
  {
    $("#ACTdescErrEmpty").show();
    ACT_DESC.focus();
    return false;
  }
  return true;
}

$("#ACT_DESC").on("change paste keyup", function() {
  if($('#ACT_DESC').val().trim() != '') {
    $("#ACTdescErrEmpty").hide();
  }
  else{
    $("#ACTdescErrEmpty").show();
  }
});
//------------ ACT Description-------------------------------

//------------- ACT ACT ACT_SwoC---------------------
function checkACTSwoC()
{
if(document.getElementById("ACT_SwoC").value.trim() == "")
  {
    $("#ACT_SwoC").show();
    ACT_SwoC.focus();
    return false;
  }
  return true;
}

$("#ACT_SwoC").on("change paste keyup", function() {
  if($('#ACT_SwoC').val().trim() != '') {
    $("#ACTCSTwoCErrEmpty").hide();
  }
  else {
    $("#ACTCSTwoCErrEmpty").show();
  }
});
//------------ ACT ACT_SwoC-------------------------------

//------------- ACT ACT SRV Tax---------------------
function checkACTSRV()
{
if(document.getElementById("ACT_SRV_TAX").value.trim() == "")
  {
    $("#ACT_SRV_TAX").show();
    ACT_SRV_TAX.focus();
    return false;
  }
  return true;
}

$("#ACT_SRV_TAX").on("change paste keyup", function() {
  if($('#ACT_SRV_TAX').val().trim() != '') {
    $("#ACTSRVErrEmpty").hide();
  }
  else {
    $("#ACTSRVErrEmpty").show();
  }
});
//------------ ACT SRV Tax-------------------------------
//------------- ACT GST Tax---------------------
function checkACTGST()
{
if(document.getElementById("ACT_GST_TAX").value.trim() == "")
  {
    $("#ACTGSTErrEmpty").show();
    ACT_GST_TAX.focus();
    return false;
  }
  return true;
}

$("#ACT_GST_TAX").on("change paste keyup", function() {
  if($('#ACT_GST_TAX').val().trim() != '') {
    $("#ACTGSTErrEmpty").hide();
  }
  else {
    $("#ACTGSTErrEmpty").show();
  }
});
//------------ ACT GST Tax-------------------------------

//-----------------------For Activity Percentage-----------------

// $("#ACT_VAT").on("paste keyup keypress", function() {
      
//       if(($("#ACT_VAT").val().length ==3)) {
//         var value=$("#ACT_VAT").val();
//         var cut=value.substr(0,3);
//         var final=cut.replace(/[^\d]/g,'');
//         if(final>100){
//           $("#ACTVATErr").hide();
//           $("#ACTVATErr1").show();
//           return false;
//         }
//       }
//       if(($("#ACT_VAT").val().length <=2)) {
//         var value=$("#ACT_VAT").val();
//         var cut=value.substr(0,2);
//         var final=cut.replace(/[^\d]/g,'');
//         if(final<=100){
//           $("#ACTVATErr").hide();
//           $("#ACTVATErr1").hide();
//         }
//       }
//     });

$("#ACT_SwC").on("paste keyup keypress", function() {
      
      if(($("#ACT_SwC").val().length ==3)) {
        var value=$("#ACT_SwC").val();
        var cut=value.substr(0,3);
        var final=cut.replace(/[^\d]/g,'');
        if(final>100){
          $("#ACTCSTwCErr").hide();
          $("#ACTCSTwCErr1").show();
          return false;
        }
      }
      if(($("#ACT_SwC").val().length <=2)) {
        var value=$("#ACT_SwC").val();
        var cut=value.substr(0,2);
        var final=cut.replace(/[^\d]/g,'');
        if(final<=100){
          $("#ACTCSTwCErr").hide();
          $("#ACTCSTwCErr1").hide();
        }
      }
    });

$("#ACT_SwoC").on("paste keyup keypress", function() {
      
      if(($("#ACT_SwoC").val().length ==3)) {
        var value=$("#ACT_SwoC").val();
        var cut=value.substr(0,3);
        var final=cut.replace(/[^\d]/g,'');
        if(final>100){
          $("#ACTCSTwoCErr").hide();
          $("#ACTCSTwoCErr1").show();
          return false;
        }
      }
      if(($("#ACT_SwoC").val().length <=2)) {
        var value=$("#ACT_SwoC").val();
        var cut=value.substr(0,2);
        var final=cut.replace(/[^\d]/g,'');
        if(final<=100){
          $("#ACTCSTwoCErr").hide();
          $("#ACTCSTwoCErr1").hide();
        }
      }
    });

$("#ACT_SRV_TAX").on("paste keyup keypress", function() {
      
      if(($("#ACT_SRV_TAX").val().length ==3)) {
        var value=$("#ACT_SRV_TAX").val();
        var cut=value.substr(0,3);
        var final=cut.replace(/[^\d]/g,'');
        if(final>100){
          $("#ACTSRVErr").hide();
          $("#ACTSRVErr1").show();
          return false;
        }
      }
      if(($("#ACT_SRV_TAX").val().length <=2)) {
        var value=$("#ACT_SRV_TAX").val();
        var cut=value.substr(0,2);
        var final=cut.replace(/[^\d]/g,'');
        if(final<=100){
          $("#ACTSRVErr").hide();
          $("#ACTSRVErr1").hide();
        }
      }
    });


//-----------------------For Activity Percentage----------------
//---------------------End of Activity  - Master Form-----------------------------------------------------









//---------------------Campaign - Master Form-----------------------------------------------------

//-------------CAMP BR COde -----------------------------------
function checkCAMP_BRCode()
{
  var city = document.getElementById("CAMP_BRCode");      
    var optionSelIndex = city.options[city.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("CAMPbrCodeErr").innerHTML ="You must Select Emp Branch Code";
    city.focus();
    return false;
  } 
    return true; 
}

$("#CAMP_BRCode").on("change paste keyup", function() {
  if($('#CAMP_BRCode').val().trim() != '') {
    $("#CAMPbrCodeErr").hide();
  }
  else{
    $("#CAMPbrCodeErr").show();
  }
});

//-------------CAMP BR COde-------------------------------------

//-------------CAMP EMP ID -----------------------------------
function checkCAMP_EMP_ID()
{
  var city = document.getElementById("CAMP_E_ID");      
    var optionSelIndex = city.options[city.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("CAMPeIDErr").innerHTML ="You must Select Emp ID";
    city.focus();
    return false;
  } 
    return true; 
}

$("#CAMP_E_ID").on("change paste keyup", function() {
  if($('#CAMP_E_ID').val().trim() != '') {
    $("#CAMPeIDErr").hide();
  }
  else {
    $("#CAMPeIDErr").show();
  }
});

//-------------CAMP EMP ID-------------------------------------

//-------------CAMP CL Code -----------------------------------
function checkCAMP_CLCode()
{
  var city = document.getElementById("CAMP_CL_Code");      
    var optionSelIndex = city.options[city.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("CAMPclCodeErr").innerHTML ="You must Select Client Code";
    city.focus();
    return false;
  } 
    return true; 
}

$("#CAMP_CL_Code").on("change paste keyup", function() {
  if($('#CAMP_CL_Code').val().trim() != '') {
    $("#CAMPclCodeErr").hide();
  }
  else {
    $("#CAMPclCodeErr").show();
  }
});

//-------------CAMP CL Code-------------------------------------

//-------------CAMP BR ID -----------------------------------
function checkCAMP_BRID()
{
  var city = document.getElementById("CAMP_BR_ID");      
    var optionSelIndex = city.options[city.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("CAMbrIDErr").innerHTML ="You must Select Brand ID";
    city.focus();
    return false;
  } 
    return true; 
}

$("#CAMP_BR_ID").on("change paste keyup", function() {
  if($('#CAMP_BR_ID').val().trim() != '') {
    $("#CAMbrIDErr").hide();
  }
  else {
    $("#CAMbrIDErr").show();
  }
});

//-------------CAMP BR ID-------------------------------------

//-------------CAMP ACTivity-----------------------------------
function checkCAMP_ACT()
{
  var camp_acti = document.getElementById("CAMP_Activity");      
  var optionSelIndex = camp_acti.options[camp_acti.selectedIndex].value;
  var count=document.getElementById("store_Count").value;

  if (optionSelIndex == '') 
  {
    document.getElementById("CAMPactErr").innerHTML ="You must Select Activity";
    camp_acti.focus();
    return false;
  }
  else if (optionSelIndex != '') 
  {
    var get = $('#CAMP_Activity').val().trim();
    var upper = get.toUpperCase();
    var res = upper.match(/BRANDING/);

    if((res=='BRANDING') && (count==0))
    {
      $("#CAMPactErrEmptyStore").show();
      camp_acti.focus();
      return false;
    }  
    return true; 
  }
}

  $( document ).ready(function() {

    var get = ($('#CAMP_Activity').val().trim());
    var upper = get.toUpperCase();
    var res = upper.match(/BRANDING/);
    var count=document.getElementById("store_Count").value;
    
    if((res=='BRANDING') && (count==0))
    {
      $("#CAMPactErrEmptyStore").show();
      return false;
    } 
    else if(count!=0) 
    {
      if(res=='BRANDING') { 
        $("#CAMPactErrEmptyStore").hide(); 
        $("#hide_store").show();
      }
      else {
        $("#hide_store").hide();
      }
    }

  });

$("#CAMP_Activity").on("change paste keyup", function() {
  var count=document.getElementById("store_Count").value;

  if($('#CAMP_Activity').val().trim() != '') 
  {
    var get = $('#CAMP_Activity').val().trim();
    var upper = get.toUpperCase();
    var res = upper.match(/BRANDING/);

    if((res=='BRANDING') && (count==0))
    {
      $("#CAMPactErrEmptyStore").show();
      return false;
    } 
    else if((res=='BRANDING') && (count>0))
    {  
      $("#CAMPactErr").hide();
      $("#hide_store").show();
    }
    else 
    {
      $("#CAMPactErr").hide();
      $("#hide_store").hide();
    }
  }
  else {
    $("#CAMPactErr").show();
    $("#hide_store").hide();
  } 
  return true; 
});

//-------------CAMP ACTivity-------------------------------------

//------------- CAMP CC Date--------------------------------------
function checkCAMP_CC_Date()
{
  var get=$("#CAMP_CDate").val();
  var today = new Date();
  var date  = new Date(get);
  if(document.getElementById("CAMP_CDate").value.trim() == "")
  {
    document.getElementById("CAMP_CC_DateErr").innerHTML ="You must enter a Campaign Creation Date";
    CAMP_CDate.focus();
    return false;
  }
  else if(date > today)
  {
    $("#CAMP_CC_DateErr1").show();
    document.getElementById("CAMP_CDate").focus();
    return false;
  }
  $("#CAMP_CC_DateErr1").hide();
  return true;
}

$("#CAMP_CDate").on("change paste keyup", function() {
  if($('#CAMP_CDate').val().trim() != '') {
    $("#CAMP_CC_DateErr").hide();
    var get=$("#CAMP_CDate").val();
    var today = new Date();
    var date  = new Date(get);

    if(date > today)
    {
      $("#CAMP_CC_DateErr1").show();
      document.getElementById("CAMP_CDate").focus();
      return false;
    }
    $("#CAMP_CC_DateErr1").hide();
    return true;
  }
});
//------------ CAMP CC Date-----------------------------------------------

//------------- CAMP Email--------------------------------------
function checkCAMP_Email()
{
  if(document.getElementById("CAMP_Email").value.trim() == "")
  {
    document.getElementById("CAMP_EmailErr").innerHTML ="You must enter a Email";
    CAMP_Email.focus();
    return false;
  }
  return true;
}

$("#CAMP_Email").on("change paste keyup", function() {
  if($('#CAMP_Email').val().trim() != '') {
    $("#CAMP_EmailErr").hide();
  }
  else{
    $("#CAMP_EmailErr").show();
  }
});
//------------ CAMP Email-----------------------------------------------

//------------- CAMP CP--------------------------------------
function checkCAMP_CP()
{
  if(document.getElementById("CAMP_CP").value.trim() == "")
  {
    document.getElementById("CAMP_CPErr").innerHTML ="You must enter a Campaign Contact Person";
    CAMP_CP.focus();
    return false;
  }
  return true;
}

$("#CAMP_CP").on("change paste keyup", function() {
  if($('#CAMP_CP').val().trim() != '') {
    $("#CAMP_CPErr").hide();
  }
  else{
    $("#CAMP_CPErr").show();
  }
});
//------------ CAMP CP-----------------------------------------------

//------------- CAMP Mobile--------------------------------------
function checkCAMP_Mobile()
{
  if(document.getElementById("CAMP_Mobile").value.trim() == "")
  {
    document.getElementById("CAMP_MobErr").innerHTML ="You must enter a Campaign Mobile Number";
    CAMP_Mobile.focus();
    return false;
  }
  return true;
}

$("#CAMP_Mobile").on("change paste keyup", function() {
  if($('#CAMP_Mobile').val().trim() != '') {
    $("#CAMP_MobErr").hide();
  }
  else{
    $("#CAMP_MobErr").show();
  }
});
//------------ CAMP Mobile-----------------------------------------------

//------------- CAMP CAMP_Email_CP--------------------------------------
function checkCAMP_EMailCP()
{
  if(document.getElementById("CAMP_Email_CP").value.trim() == "")
  {
    document.getElementById("CAMP_EmailCPErr").innerHTML ="You must enter a Email of CP";
    CAMP_Email_CP.focus();
    return false;
  }
  return true;
}

$("#CAMP_Email_CP").on("change paste keyup", function() {
  if($('#CAMP_Email_CP').val().trim() != '') {
    $("#CAMP_EmailCPErr").hide();
  }
  else{
    $("#CAMP_EmailCPErr").show();
  }
});
//------------ CAMP CAMP_Email_CP-----------------------------------------------

//------------- CAMP CAMP_VAT--------------------------------------
function checkCAMP_VAT()
{
  if(document.getElementById("CAMP_VAT").value.trim() == "")
  {
    document.getElementById("CAMP_VATErr").innerHTML ="You must enter a VAT Reg Number";
    CAMP_VAT.focus();
    return false;
  }
  return true;
}

$("#CAMP_VAT").on("change paste keyup", function() {
  if($('#CAMP_VAT').val().trim() != '') {
    $("#CAMP_VATErr").hide();
  }
  else{
    $("#CAMP_VATErr").show();
  }
});
//------------ CAMP CAMP_VAT-----------------------------------------------

//------------ CAMP StoreID Checkboxes-----------------------------------------------

function checkCAMP_StoreIDs() {
  var flag = 0;
  var count=document.getElementById("store_Count").value;
  var get = ($('#CAMP_Activity').val().trim());
  var upper = get.toUpperCase();
  var res = upper.match(/BRANDING/g);

    if((res=='BRANDING') && (count!=0)) { 
      if(count==1) {
        for (var i = 0; i< count; i++) {
          if(document.form["Store_Ids[]"].checked) {
            flag ++;
          }
        }
      }
      else if(count==0) {
        flag=1;
      }
      else {
        for (var i = 0; i< count; i++) {
          if(document.form["Store_Ids[]"][i].checked) {
            flag ++;
          }
        }
      }
      if (flag == 0) {
        alert ("Please Select Store ID (Atleast One)!");
        return false;
      }
    }
  return true;
}


//------------ CAMP StoreID Checkboxes-----------------------------------------------

//------------- CAMP CAMP_Budget--------------------------------------
function checkCAMP_Budget()
{
  if(document.getElementById("CAMP_Budget").value.trim() == "")
  {
    document.getElementById("CAMP_BudErr").innerHTML ="You must enter a Budget";
    CAMP_Budget.focus();
    return false;
  }
  return true;
}

$("#CAMP_Budget").on("change paste keyup", function() {
  if($('#CAMP_Budget').val().trim() != '') {
    $("#CAMP_BudErr").hide();
  }
  else{
    $("#CAMP_BudErr").show();
  }
});
//------------ CAMP CAMP_Budget-----------------------------------------------

//------------- CAMP CAMP_CL_Name--------------------------------------
function checkCAMP_CL_NAme()
{
  if(document.getElementById("CAMP_CL_Name").value.trim() == "")
  {
    document.getElementById("CAMP_CNameErr").innerHTML ="You must enter a Client Name";
    CAMP_CL_Name.focus();
    return false;
  }
  return true;
}

$("#CAMP_CL_Name").on("change paste keyup", function() {
  if($('#CAMP_CL_Name').val().trim() != '') {
    $("#CAMP_CNameErr").hide();
  }
  else{
    $("#CAMP_CNameErr").show();
  }
});
//------------ CAMP CAMP_CL_Name-----------------------------------------------

//------------- CAMP CAMP_BR_Name--------------------------------------
function checkCAMP_BR_Name()
{
  if(document.getElementById("CAMP_BR_Name").value.trim() == "")
  {
    document.getElementById("CAMP_BRNameErr").innerHTML ="You must enter a Budget";
    CAMP_BR_Name.focus();
    return false;
  }
  return true;
}

$("#CAMP_BR_Name").on("change paste keyup", function() {
  if($('#CAMP_BR_Name').val().trim() != '') {
    $("#CAMP_BRNameErr").hide();
  }
  else{
    $("#CAMP_BRNameErr").show();
  }
});
//------------ CAMP CAMP_BR_Name-----------------------------------------------

//------------- CAMP CAMP_Approval--------------------------------------
function checkCAMP_Approval(form)
{
    
  if ((form.CAMP_Approval[0].checked == false) && (form.CAMP_Approval[1].checked == false)) 
  {
    document.getElementById("CAMP_QAErr").innerHTML ="You must Select Quote Approval";
    form.focus();
    return false;
  }
    return true;
}

$("#CAMP_Approval").on("change paste keyup", function() {
  if($('#CAMP_Approval').val().trim() != '') {
    $("#CAMP_QAErr").hide();
  }
  else{
    $("#CAMP_QAErr").show();
  }
});
//------------ CAMP CAMP_Approval-----------------------------------------------

//------------- CAMP CAMP_ACT_SDate--------------------------------------
function checkCAMP_ACT_SDate()
{
  if(document.getElementById("CAMP_ACT_SDate").value.trim() == "")
  {
    document.getElementById("CAMP_AStartDate_Err").innerHTML ="You must enter a Activity Start Date";
    CAMP_ACT_SDate.focus();
    return false;
  }
  return true;
}
$( document ).ready(function() {
  $("#CAMP_ACT_SDate").on("select change paste keyup", function() {

    $("#SDate_label").css('color','rgb(33, 150, 243)');
    $("#SDate_label").css('font-size','18px');
    $("#SDate_label").css('margin-left','-150px');

    if($('#CAMP_ACT_SDate').val().trim() != '') {
      var sdate=document.getElementById("CAMP_ACT_SDate").value;
      $("#CAMP_AStartDate_Err").hide();
      $("#CAMP_ACT_EDate").prop('disabled', false);
      $("#CAMP_ACT_EDate").css('color','black');
      $('#CAMP_ACT_EDate').attr("min",sdate);
    }
    else{
      $("#CAMP_AStartDate_Err").show();
    }
  });
});
//------------ CAMP CAMP_ACT_SDate-----------------------------------------------
//------------- CAMP CAMP_ACT_EDate--------------------------------------

function checkCAMP_ACT_EDate()
{
  var sdate=document.getElementById("CAMP_ACT_SDate").value;
  var edate=document.getElementById("CAMP_ACT_EDate").value;
  if($('#CAMP_ACT_EDate').val().trim() != '') {
    if (edate <= sdate) {
      $("#CAMP_AEndDate_Err").show();
      $("#CAMP_ACT_EDate").focus();
      return false;
    }
    else{
      $("#CAMP_AEndDate_Err").hide();
      return true;
    }
    return true;
  }
  else{
    $("#CAMP_AEndDate_Err").hide();
    return true;
  }
}


// $("#CAMP_ACT_EDate").on("change paste keyup", function() {

//   $("#EDate_label").css('color','rgb(33, 150, 243)');
//   $("#EDate_label").css('font-size','18px');
//   $("#EDate_label").css('margin-left','-160px');


//   if($('#CAMP_ACT_EDate').val().trim() != '') {  
//   var sdate=document.getElementById("CAMP_ACT_SDate").value;
//   var edate=document.getElementById("CAMP_ACT_EDate").value;
//     if (edate <= sdate) {
//       $("#CAMP_AEndDate_Err").show();
//       $("#CAMP_ACT_EDate").focus();
//       return false;
//     }
//     else {
//       $("#CAMP_AEndDate_Err").hide();
//       return true;
//     }   
//   }
//   else {
//     $("#CAMP_AEndDate_Err").hide();
//     return true;
//   }
// });
//------------ CAMP CAMP_ACT_EDate-----------------------------------------------

//------------- CAMP CAMP_ACT_EDate--------------------------------------
// function checkCAMP_ACT_EDate()
// {
//   var sdate=document.getElementById("CAMP_ACT_SDate").value;
//   var edate=document.getElementById("CAMP_ACT_EDate").value;
//   var d1 = Date.parse(sdate);
//   var d2 = Date.parse(edate);
//   if (d1 <= d2) {
//     alert ("Error!");
//     return false;
//   }
//   if(document.getElementById("CAMP_ACT_EDate").value == "")
//   {
//     document.getElementById("CAMP_AEndDate_Err").innerHTML ="You must enter a Activity End Date";
//     CAMP_ACT_EDate.focus();
//     return false;
//   }
//   return true;
// }

// $("#CAMP_ACT_EDate").on("change paste keyup", function() {
//   if($('#CAMP_ACT_EDate').val().trim() != '') {
//     $("#CAMP_AEndDate_Err").hide();
//   }
//   else{
//     $("#CAMP_AEndDate_Err").show();
//   }
// });
//------------ CAMP CAMP_ACT_EDate-----------------------------------------------

//------------- CAMP CAMP_Email_Personal--------------------------------------
function checkCAMP_Email_Personal()
{
  if(document.getElementById("CAMP_Email_Personal").value.trim() == "")
  {
    document.getElementById("CAMP_EmailPersErr").innerHTML ="You must enter a Personal Email";
    CAMP_Email_Personal.focus();
    return false;
  }
  return true;
}

$("#CAMP_Email_Personal").on("change paste keyup", function() {
  if($('#CAMP_Email_Personal').val().trim() != '') {
    $("#CAMP_EmailPersErr").hide();
  }
  else{
    $("#CAMP_EmailPersErr").show();
  }
});
//------------ CAMP CAMP_Email_Personal-----------------------------------------------

//------------- CAMP CAMP_PO_Num--------------------------------------
function checkCAMP_PO_Num()
{
  if(document.getElementById("CAMP_PO_Num").value.trim() == "")
  {
    document.getElementById("CAMP_PO_NumErr").innerHTML ="You must enter a PO Number";
    CAMP_PO_Num.focus();
    return false;
  }
  return true;
}

$("#CAMP_PO_Num").on("change paste keyup", function() {
  if($('#CAMP_PO_Num').val().trim() != '') {
    $("#CAMP_PO_NumErr").hide();
  }
  else{
    $("#CAMP_PO_NumErr").show();
  }
});
//------------ CAMP CAMP_PO_Num-----------------------------------------------

//------------- CAMP CAMP_PO_Date--------------------------------------
function checkCAMP_PO_Date()
{
  if(document.getElementById("CAMP_PO_Date").value.trim() != "")
  {
    var get=$("#CAMP_PO_Date").val();
    var today = new Date();
    var date  = new Date(get);
    if(date>=today) {
      $("#CAMP_PO_DateErrGreater").show();
      $("#CAMP_PO_DateErr").hide();
      return false;
    }
    else {
      $("#CAMP_PO_DateErr").hide();
    $("#CAMP_PO_DateErrGreater").hide();
    return true;
    }
  }
  else {
    $("#CAMP_PO_DateErrGreater").hide();
    $("#CAMP_PO_DateErr").show();
    return false;
  }
}

$("#CAMP_PO_Date").on("change paste keyup", function() {
  if($('#CAMP_PO_Date').val().trim() != '') {
    var get=$("#CAMP_PO_Date").val();
    var today = new Date();
    var date  = new Date(get);
    if(date>=today) {
      $("#CAMP_PO_DateErrGreater").show();
      $("#CAMP_PO_DateErr").hide();
      return false;
    }
    else {
      $("#CAMP_PO_DateErr").hide();
      $("#CAMP_PO_DateErrGreater").hide();
      return true;
    }
  }
  else {
    $("#CAMP_PO_DateErrGreater").hide();
    $("#CAMP_PO_DateErr").show();
    return false;
  }
});
//------------ CAMP CAMP_PO_Date-----------------------------------------------

//-------------CAMP PO Approved By-----------------------------------
function checkCAMP_PO_App_By()
{
  var app_by = document.getElementById("CAMP_PO_App_By");      
    var optionSelIndex = app_by.options[app_by.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("CAMP_PO_App_ByErr").innerHTML ="You must Select Atleast One";
    app_by.focus();
    return false;
  } 
    return true; 
}

$("#CAMP_PO_App_By").on("change paste keyup", function() {
  if($('#CAMP_PO_App_By').val().trim() != '') {
    $("#CAMP_PO_App_ByErr").hide();
  }
  else {
    $("#CAMP_PO_App_ByErr").show();
  }
});

//-------------CAMP PO Approved By-------------------------------------

//---------------------End of Campaign - Master Form-----------------------------------------------------

//---------------------Material-code-master.................................
  
  function checkspec()
{
  var app_by = document.getElementById("spec_1");      
  var optionSelIndex = app_by.options[app_by.selectedIndex].value;

    if (optionSelIndex == '') 
  {
    document.getElementById("specErr").innerHTML ="You must Select Atleast One";
    app_by.focus();
    return false;
  } 
    return true; 
}

$("#spec_1").on("change paste keyup", function() {
  if($('#spec_1').val().trim() != '') {
    $("#specErr").hide();
  }
  else{
    $("#specErr").show();
  }
});

  function checkmatName()
{
  if(document.getElementById("mat_name").value.trim() == "")
  {
    document.getElementById("matnameErr").innerHTML ="You must enter Material Name";
    mat_name.focus();
    return false;
  }
  return true;
}

$("#mat_name").on("change paste keyup", function() {
  if($('#mat_name').val().trim() != '') {
    $("#matnameErr").hide();
  }
  else{
    $("#matnameErr").show();
  }
});

function checkWrkDone(form)
{
    
  if ((form.work_done[0].checked == false) && (form.work_done[1].checked == false)) 
  {
    document.getElementById("wrkErr").innerHTML ="You must Select C-Form";
    form.focus();
    return false;
  }
  else {
    $("#wrkErr").hide();
    return true;
  }
}

$("#work_done").on("change paste keyup", function() {
  if ((form.work_done[0].checked == false) && (form.work_done[1].checked == false))  {
    $("#wrkErr").show();
  }
  else {
    $("#wrkErr").hide();
  }
});

//----------------------------Material  Master--------------------------------------
function checkvendor()
{
  if(document.getElementById("vendorid").value.trim() == "")
  {
    document.getElementById("vendorErr").innerHTML ="You must select vendor Id";
    vendorid.focus();
    return false;
  }
  return true;
}

$("#vendorid").on("change paste keyup", function() {
  if($('#vendorid').val().trim() != '') {
    $("#vendorErr").hide();
  }
  else{
    $("#vendorErr").show();
  }
});

function checkmatCode()
{
  if(document.getElementById("matcode").value.trim() == "")
  {
    document.getElementById("matCdErr").innerHTML ="You must select Material Code";
    matcode.focus();
    return false;
  }
  return true;
}

$("#matcode").on("change paste keyup", function() {
  if($('#matcode').val().trim() != '') {
    $("#matCdErr").hide();
  }
  else{
    $("#matCdErr").show();
  }
});

function checkunits()
{
  if(document.getElementById("units").value.trim() == "")
  {
    document.getElementById("unitsErr").innerHTML ="You must a enter units";
    units.focus();
    return false;
  }
  return true;
}

$("#units").on("change paste keyup", function() {
  if($('#units').val().trim() != '') {
    $("#unitsErr").hide();
  }
  else{
    $("#unitsErr").show();
  }
});

function checkvatCst()
{
  if(document.getElementById("VatCst").value.trim() == "")
  {
    document.getElementById("catCstErr").innerHTML ="You must a enter VAT/CST";
    VatCst.focus();
    return false;
  }
  return true;
}

$("#VatCst").on("change paste keyup", function() {
  if($('#VatCst').val().trim() != '') {
    $("#catCstErr").hide();
  }
  else{
    $("#catCstErr").show();
  }
});


function checkrateunits()
{
  if(document.getElementById("rateUnit").value.trim() == "")
  {
    document.getElementById("rateunitsErr").innerHTML ="You must a enter Rate/Units";
    rateUnit.focus();
    return false;
  }
  return true;
}

$("#rateUnit").on("change paste keyup", function() {
  if($('#rateUnit').val().trim() != '') {
    $("#rateunitsErr").hide();
  }
  else{
    $("#rateunitsErr").show();
  }
});


//----------------Elements master-------------------------------
  function checkelements()
{
  if(document.getElementById("elements").value.trim() == "")
  {
    document.getElementById("elementsErr").innerHTML ="You must enter a Elements Name";
    elements.focus();
    return false;
  }
  return true;
}

$("#elements").on("change paste keyup", function() {
  if($('#elements').val().trim() != '') {
    $("#elementsErr").hide();
  }
  else{
    $("#elementsErr").show();
  }
});


$("#media").on("change paste keyup", function() {
  if($('#media').val().trim() != '') {
    $("#mediaErr").hide();
  }
  else{
    $("#mediaErr").show();
  }
});
  function checkmedia()
{
  if(document.getElementById("media").value.trim()== "")
  {
    document.getElementById("mediaErr").innerHTML ="You must enter a Media Name";
    media.focus();
    return false;
  }
  return true;
}

$("#media").on("change paste keyup", function() {
  if($('#media').val().trim() != '') {
    $("#mediaErr").hide();
  }
  else{
    $("#mediaErr").show();
  }
});

  function checkactvitycode()
{
  if(document.getElementById("activity").value.trim() == "")
  {
    document.getElementById("activityErr").innerHTML ="You must select activity code";
    activity.focus();
    return false;
  }
  return true;
}

$("#activity").on("change paste keyup", function() {
  if($('#activity').val().trim() != '') {
    $("#activityErr").hide();
  }
  else{
    $("#activityErr").show();
  }
});
//---------------------VENDOR - Master Form-----------------------------------------------------

//---------------------EMPLOYEE - Master Form---------------------------------------------------
 $('.datefield-color').on("change", function() {
      $(this).siblings('label').css('color','rgb(33, 150, 243)');
    });

 

//---------------------User - Master Form---------------------------------------------------

$("#user-form").on("submit", function() {
  var check = true;
    var anyFieldIsEmpty11 = $("input,select").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
          $(this).siblings('.otherfield-error').hide();
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
         }
         else{
          check=true;
         }
        });

    if($('#user-cpass').val() != $('#user-pass').val()){
        $('#user-cpass').siblings('.otherfield-error').text('Passwords does not match');
        $('#user-cpass').siblings('.otherfield-error').show();
            check = false;
    }
    if(check == false){
      return false;
    }
    
});


   

 $("#user-form .mdl-textfield__input").on("change paste keyup", function() {
  if($(this).val().trim() != '') 
    $(this).siblings('.emptyfield-error').hide();
   else
    $(this).siblings('.emptyfield-error').show();
  });

//---------------------Branch - Master Form---------------------------------------------------


 

 //---------------------Brand - Master Form---------------------------------------------------

$("#brand-form").on("submit", function() {
  var check = true;
    var anyFieldIsEmpty8 = $("#brand-form input").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
           
         }
        });

    var anyFieldIsEmpty9 = $("#brand-form select").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
           
         }
        });

    var anyFieldIsEmpty9 = $("#brand-form textarea").not('.req').each(function() {
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

              
});

 $("#brand-form .mdl-textfield__input").on("change paste keyup", function() {
  if($(this).val().trim() != '') 
    $(this).siblings('.emptyfield-error').hide();
   else
    $(this).siblings('.emptyfield-error').show();
  });



