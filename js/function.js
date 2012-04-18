 // When the document is ready set up our sortable with it's inherant function(s)
var base_url = 'http://catercare.oscillosoft.com.au/';
function checkEmail(email) {
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email)) {
		return false;
	}else{
		return true;
	}
}


function doCheckSpChar(objId){
	var curStr=document.getElementById(objId).value;
	var newStr='';
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?~_"; // All special Characters
	// var iChars = "!^&[]<>"; // Our Invalid Characters
    for (var i = 0; i < curStr.length; i++) {		  
  		if (iChars.indexOf(curStr.charAt(i)) != -1) {
  	  		alert ("Your string has special characters "+iChars+". \nThese are not allowed.");
  		}
  		else {
  	  		newStr=newStr+curStr.charAt(i);
  	  	}
	}
	document.getElementById(objId).value=newStr;
}


function changeLocation(url){
	if(url=='') return false;
	window.location = url;
}

function userupdate(){
	
	var fname = $('input[name="fname"]').val();
	var lname = $('input[name="lname"]').val();
	var address = $('input[name="address"]').val();
	var addresstwo = $('input[name="addresstwo"]').val();
	var phone = $('input[name="phone"]').val();

	var zip = $('input[name="zip"]').val();
	var city = $('input[name="city"]').val();
	var country = $('input[name="country"]').val();
	var userid = $('input[name="userid"]').val();
	
	//var regtype = $('input[name="regtype"]:checked').val();
	
	
	
	if(fname == ''){
		alert('First name is mandatory');
		$('input[name="fname"]').focus();
		return false;
	}
	if(address == ''){
		alert('Address is mandatory');
		$('input[name="address"]').focus();
		return false;
	}

		
	$.post(base_url+"user/ajax/update_registration.php",
  			{id:userid, fname:fname,lname:lname,address:address,addresstwo:addresstwo,phone:phone,zip:zip,city:city,country:country}, 
			   function(data){
  				alert(data);
  				if(parseInt(data)==1){
  					 $('#registrationFormDiv').slideUp('slow');	
  					 $('#registrationFormSuccess').slideDown('slow');
				 }else{
					 alert('Update is not successfull. Try try again');
				 }
				});	
	
}


function userregistration(){
	
	var fname = $('input[name="fname"]').val();
	var lname = $('input[name="lname"]').val();
	var address = $('input[name="address"]').val();
	var addresstwo = $('input[name="addresstwo"]').val();
	var phone = $('input[name="phone"]').val();
	var email = $('input[name="email"]').val();
	var zip = $('input[name="zip"]').val();
	var city = $('input[name="city"]').val();
	var country = $('input[name="country"]').val();
	var group_id = $('input[name="group_id"]').val();
	//var regtype = $('input[name="regtype"]:checked').val();
	
	var regtype = $('input[name="regtype"]').val();

	
	if(fname == ''){
		alert('First name is mandatory');
		$('input[name="fname"]').focus();
		return false;
	}
	if(address == ''){
		alert('Address is mandatory');
		$('input[name="address"]').focus();
		return false;
	}
	if(email == ''){
		alert('Please enter a valid email');
		$('input[name="email"]').focus();
		return false;
	}else{
		if(checkEmail(email)==false){
			alert('Invalid email id');
			$('input[name="email"]').focus();
			return false;
		}
	}
		
	$.post(base_url+"user/ajax/registration.php",
  			{fname:fname,lname:lname,group_id:group_id, address:address,addresstwo:addresstwo,phone:phone,email:email,zip:zip,city:city,country:country,regtype:regtype}, 
			   function(data){
  				
  				if(parseInt(data)==1){
  					 $('#registrationFormDiv').slideUp('slow');	
  					 $('#registrationFormSuccess').slideDown('slow');
				 }else{
					 alert('Registration is not successfull. Try try another email address');
				 }
				});	
	
}

  $(document).ready(function() {
	  $('#btnChangePass').click(function(){
		 
		  
		  var oldpass = $('#oldpassword').val();
		  var newpass = $('#newpassword').val();
		  var retypepass= $('#retypepass').val();
		  var userid= $('#userid').val();
		
		  if(oldpass==''){
			  alert('Old password can not be null');return false;
			  }
		  if(newpass==''){
			  alert('New password can not be null');return false;
			  }
		  if(retypepass==''){
			  alert('Retype the password.');return false;
			  }
		  
		  
		 
		  $.post(base_url+"user/ajax/changepassword.php",
		  			{oldpass:oldpass,newpass:newpass,userid:userid}, 
					   function(data){
		  				
		  				if(parseInt(data)==1){
		  					alert('Password changed successfully');
		  					$('#oldpassword').val('');
		  					$('#newpassword').val('');
		  					$('#retypepass').val('');
						 }else{
								alert('Can not change the password at this moments. Please try later');
						 }
						});	
		
	  });
	 
	  $('#btnJobPost').click(function(){
		  
		  var postingtitle = $('input[name=postingtitle]').val();
		  if(postingtitle==''){
			  alert('Posting title is mandatory.'); return false;
		  }
		  var introduction = $('#introduction').val();
		  if(introduction==''){
			  alert('Introduction is mandatory.'); return false;
		  }

		  var description = $("#cke_description iframe").contents().find("body").text();
		  if(description==''){
			  alert('Description is mandatory.'); return false;
		  }
		  
		 
		  var noofposition = $('input[name=noofposition]').val();
		  
		  if(noofposition==''){
			  alert('No of position is mandatory.'); return false;
		  }
		  
		  var publishedin = $('#publishedin').val();
		  
		  if(publishedin==''){
			  alert('Published in is mandatory.'); return false;
		  }
		  
		  
		  var sellingpointone = $('input[name=sellingpointone]').val();
		  var sellingpointtwo = $('input[name=sellingpointtwo]').val();
		  var sellingpointthree = $('input[name=sellingpointthree]').val();
		  /*
		  if(sellingpointone==''){
			  alert('Selling point one is mandatory.'); return false;
		  }
		 
		  if(sellingpointtwo==''){
			  alert('Selling point two is mandatory.'); return false;
		  }
		 
		  if(sellingpointthree==''){
			  alert('Selling point three is mandatory.'); return false;
		  }
		  
		  */
		  
		  var classification = $('#seekClassification').val();
		  if(classification==''){
			  alert('Please select a classification'); return false;
		  }
		  
		  var subclassification = $('#seekSubClassification').val();
		  if(subclassification==''){
			  alert('Please select a sub classification'); return false;
		  }
		  
		  
		  
		  
		  var postedon = $('input[name=postedon]').val();
		  if(postedon==''){
			  alert('Please put the posting date.'); return false;
		  }
		  
		  $('#formJobPost').submit();
		 
		  
	  });
	 $("#seekClassification").change(function(){
		 var classification = $(this).val();
		 $.post(base_url+"user/ajax/subclassification.php",
		  			{classification:classification}, 
					   function(data){
		  				 $('#seekSubClassification').html(data);
						});	
	 });
	 
    $("#dataFieldMap").sortable({
      handle : '.handler',
      update : function () {
		  var order = $('#dataFieldMap').sortable('serialize');
		// $("#info").load("http://jobs.oscillosoft.com/user/process-sortable.php?"+order);
		 $.post("http://jobs.oscillosoft.com/user/process-sortable.php?"+order,    			
    			function(data) {    				
 					alert('Ordering done succesfully.');
    			})    	   
      }
    });
    $("#candidateFieldMap").sortable({
        handle : '.handler',
        update : function () {
  		  var order = $('#candidateFieldMap').sortable('serialize');
  		// $("#info").load("http://jobs.oscillosoft.com/user/process-sortable.php?"+order);
  		 $.post("http://jobs.oscillosoft.com/user/process-sortable.php?"+order,    			
      			function(data) {    				
   					alert('Ordering done succesfully.');
      			})    	   
        }
      });
    
    $("#seekCredentialSubmit").click(function(){
    	var seekid = $('#userid').val();
    	var seekpass = $('#userpass').val();
    	var role = $('#role').val();
    	if((seekid)==''){
    		alert('SEEK User Id can\'t be empty.');
    		$('#userid').focus();
    		return false;
    	}
    	
    	if((seekpass)==''){
    		alert('SEEK password can\'t be empty.');
    		$('#userpass').focus();
    		return false;
    	}
    	if((role)==''){
    		alert('Role can\'t be empty.');
    		$('#role').focus();
    		return false;
    	}
    	 $('#seekCredentialForm').submit();
    	 
    	 
       });
    
    $("#zohoCredentialSubmit").click(function(){
    	var zohoid = $('#userid').val();
    	var zohopass = $('#userpass').val();
    	var api = $('#api').val();
    	   	
    	if((zohoid)==''){
    		alert('Zoho User Id can\'t be empty.');
    		$('#userid').focus();
    		return false;
    	}
    	
    	if((zohoid!='')||(zohoid!=null)){
    		if(checkEmail(zohoid)==false){
    			alert('Invail email id');
    			$('#userid').focus();
    			return false;
    		}
    	}
    	
     	if((zohopass)==''){
    		alert('Zoho password can\'t be empty.');
    		$('#userpass').focus();
    		return false;
    	}
    	if((api)==''){
    		alert('API can\'t be empty.');
    		$('#api').focus();
    		return false;
    	}
    	 $('#zohoCredentialForm').submit();
       });
    
   
    $('#jobId').change(function(){
    	window.location = "index.php?pg=mapping&jobid="+$(this).val();
    });
    
    
    
    $('.displayNo').click(function(event){
    	event.preventDefault();

    	var id = $(this).attr('title');
    	 $.post("http://jobs.oscillosoft.com/user/updatejobfield.php",
    			 { field: "iswebsite", value: 1,id : id},
    			 	function(data) {
    				 $('#display'+id).removeClass('displayNo').addClass('displayYes');
    				 $(this).trigger('click');    				
    				 $(this).bind('click', function(){ alert('Working.');});
 				
    			 	})    	   
    });
    
    
    $('.displayYes').click(function(event){
    	event.preventDefault();
    	var id = $(this).attr('title');
    			$.post("http://jobs.oscillosoft.com/user/updatejobfield.php",
    				{ field: "iswebsite", value: 0,id : id},
   			 	function(data) {
   				 $('#display'+id).removeClass('displayYes').addClass('displayNo');				
   			 	})    	   
    	});
    
    $('.mandatoryNo').click(function(event){
    	event.preventDefault();
    	var id = $(this).attr('title');
    			$.post("http://jobs.oscillosoft.com/user/updatejobfield.php",
    				{ field: "ismandatory", value: 1,id : id},
   			 	function(data) {
   				 $('#mandatory'+id).removeClass('mandatoryNo').addClass('mandatoryYes');				
   			 	})  
    });
    
    $('.mandatoryYes').click(function(event){
    	event.preventDefault();
    	var id = $(this).attr('title');
    			$.post("http://jobs.oscillosoft.com/user/updatejobfield.php",
    				{ field: "ismandatory", value: 0,id : id},
   			 	function(data) {
   				 $('#mandatory'+id).removeClass('mandatoryYes').addClass('mandatoryNo');				
   			 	})  
    });
    
    $('#candidateformlist').click(function(){
    	$('#dataFieldMap').hide();
    	$('#candidateFieldMap').show();
    	$('#listofjob').hide();
    	
    	 $('#candidateformlist').removeClass('candidate').addClass('active');	
    	 $('#jobopeningslist').removeClass('active').addClass('jobopenings');
    });
    
    $('#jobopeningslist').click(function(){
    	$('#candidateFieldMap').hide();
    	$('#dataFieldMap').show();
    	$('#listofjob').show();
    	 $('#jobopeningslist').removeClass('jobopenings').addClass('active');	
    	 $('#candidateformlist').removeClass('active').addClass('candidate');
    	
    });
    
    
    
});