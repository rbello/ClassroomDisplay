function Horloge(){
	krucial = new Date;
	heure = krucial.getHours();
	min = krucial.getMinutes();
	sec = krucial.getSeconds();
	if (sec < 10)
		sec0 = "0";
	else
		sec0 = "";
	if (min < 10)
		min0 = "0";
	else
		min0 = "";
	if (heure < 10)
		heure0 = "0";
	else
		heure0 = "";

	DinaHeure = "" + heure0 + heure + ":" + min0 + min + ":" + sec0 + sec;
	which = DinaHeure
	if (document.getElementById){
		document.getElementById("Time").innerHTML=which;
	}
	setTimeout("Horloge()", 1000)
}

function gotopage(url, frame, timeout){
	setTimeout("ajaxpage(" + url +"," + frame + ")", timeout)
}

function refreshpage(url, timeout){
	setTimeout("window.location='" + url + "'", timeout)
}

function changePage(id){
	window.location = "admin.php?site=" + id;
}

function changeAfficheur(id,aff){
	window.location = "admin.php?afficheur=" + aff + "&site=" + id;
}

function PromoChangeSite(id){
	window.location = "admin.php?a=promo&site=" + id;
}

function SallesChangeSite(id){
	window.location = "admin.php?a=salles&site=" + id;
}

function AfficheurChangeSite(id){
	window.location = "admin.php?a=addafficheur&site=" + id;
}

function PubChangeSite(id){
	window.location = "admin.php?a=pub&site=" + id;
}

var loadedobjects=""
var rootdomain="http://"+window.location.hostname

function ajaxpage(url, containerid){
	var page_request = false
	if (window.XMLHttpRequest) // if Mozilla, Safari etc
		page_request = new XMLHttpRequest()
	else if (window.ActiveXObject){ // if IE
		try {
		page_request = new ActiveXObject("Msxml2.XMLHTTP")
		} 
		catch (e){
		try{
		page_request = new ActiveXObject("Microsoft.XMLHTTP")
		}
		catch (e){}
		}
	}
	else
		return false
	page_request.onreadystatechange=function(){
		loadpage(page_request, containerid)
	}
	page_request.open('GET', url, true)
	page_request.send(null)
}

function loadpage(page_request, containerid){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
	document.getElementById(containerid).innerHTML=page_request.responseText
}


 function checkForm(form)
  {
    if(form.newuser.value == "") {
      alert("Error: Username cannot be blank!");
      form.username.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.newuser.value)) {
      alert("Error: Username must contain only letters, numbers and underscores!");
      form.username.focus();
      return false;
    }

    if(form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) {
      if(form.pwd1.value.length < 6) {
        alert("Error: Password must contain at least six characters!");
        form.pwd1.focus();
        return false;
      }
      if(form.pwd1.value == form.newuser.value) {
        alert("Error: Password must be different from Username!");
        form.pwd1.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.pwd1.focus();
      return false;
    }

    return true;
  }

  function checkForm2(form)
  {
    if(form.user.value == "") {
      alert("Error: Username cannot be blank!");
      form.username.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.user.value)) {
      alert("Error: Username must contain only letters, numbers and underscores!");
      form.username.focus();
      return false;
    }

	if(form.pass1.value != "") {
		if(form.pass1.value == form.pass2.value){
			if(form.pass1.value.length < 6) {
				alert("Error: Password must contain at least six characters!");
				form.pass1.focus();
			return false;
			}
			if(form.pass1.value == form.username.value) {
				alert("Error: Password must be different from Username!");
				form.pass1.focus();
			return false;
			}
		} else {
			alert("Error :  Both password fields must match!");
			return false;
		}
	}
	
    return true;
  }
