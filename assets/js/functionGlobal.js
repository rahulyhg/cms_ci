function xssAttack(strinput,type){
	var res = null;
	if(type == "email"){
		var regexChar = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
		if(regexChar.exec(strinput))
			res = 1;
	}else if(type == "script"){
		var regexChar = /<script(?:(?!<\/script>).)*<\/script>/;
		if(!regexChar.exec(strinput))
			res = 1;
	}else if(type == "url"){
		var regexChar = /^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/;
		if(regexChar.exec(strinput))
			res = 1;
	}else if(type == "number"){
		var regexChar = /[^0-9]/; 
		if(regexChar.exec(strinput) == null)
			res = 1;
	}else if(type == "msisdn"){
		var regexChar = /^((?:\+62|62)|0)([1-9]{3})([0-9]{6,8})+$/; 
		if(regexChar.exec(strinput))
			res = 1;
	}else{
		var regexChar = /[^a-zA-Z0-9\s_@.-]/; 
		if(regexChar.exec(strinput) == null)
			res = 1;
	}
	
	return (res);
}

function restrictToNumbers(myfield, e) {
	var key;
	var keychar;
	if (window.event) {
		key = window.event.keyCode;
	} else if (e) {
		key = e.which;
	} else {
		return true;
	}
	keychar = String.fromCharCode(key);
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) {
		return true;
	} else if ((("0123456789").indexOf(keychar) > -1)) {
		return true;
	} else {
		return false;
	}
}

function restrictToLetters(myfield, e) {
	var key;
	var keychar;
	if (window.event) {
		key = window.event.keyCode;
	} else if (e) {
		key = e.which;
	} else {
		return true;
	}
	keychar = String.fromCharCode(key);
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) {
		return true;
	} else if ((("AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz_0123456789").indexOf(keychar) > -1)) {
		return true;
	} else {
		return false;
	}
}

function numericonly(input){
  var num = input.value.replace(/\./g,'');
  if(!isNaN(num)){
      
  }
  else{ 
        input.value = input.value.substring(0,input.value.length-1);
  }  
}

function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}