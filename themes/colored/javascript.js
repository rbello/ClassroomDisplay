
var planningHeight = 0;
var move = -1;
var currentValue = 0;

var viewport = null;

var val=0;
var count = 0;

var hideItem = 0;
var showItem = 0;
var limit = 0;

/**
 * Startup code
 */
$(function () {
	//window["viewport"] = $('#viewport');
	//viewport.css('height', ($(window).height() - 130) + 'px');
	reloadData();
	setActualDate();
	setInfoText("hey");
});

/*$(window).resize(function () {
	viewport.css('height', ($(window).height() - 130) + 'px');
});

function sleep(sleepDuration){
    var now = new Date().getTime();
    while (new Date().getTime() < now + sleepDuration); 
}*/

/**
 * Reload data from JSON api
 */
function reloadData() {
	$('#loading').show();
	var profile = $('body').attr('profile');
	$.ajax({
		url: 'data.php?profile=' + profile,
		success: function (data) {
			console.log(data);
			$('#error').hide();
			var table = $('#table-body');
			var strip = "";
			var first = 0;
			table.html(' ');
			console.log(count);
			count = 0;
			data['data'].forEach(function (item) {
				if(first==0){
					strip = "strip";
					first = 1;
				}else{
					strip="";
					first = 0;
				}
				var tr = document.createElement('tr');
				var td1 = document.createElement('td');
				td1.textContent = item['NomSession'];
				var td2 = document.createElement('td');
				td2.textContent = item['NomSalle'];
				var td3 = document.createElement('td');
				td3.textContent = item['NomMatiere'];
				var td4 = document.createElement('td');
				td4.textContent = item['NomIntervenant'];
				var td5 = document.createElement('td');
				td5.textContent = item['HeureDebut'] + '-' + item['HeureFin'];
				tr.className = strip;
				tr.className = 'res'+count;
				tr.appendChild(td1);
				tr.appendChild(td2);
				tr.appendChild(td3);
				tr.appendChild(td4);
				tr.appendChild(td5);
				table.append(tr);
				count ++;
			});
			planningHeight = $('#table-body').height() - $('#viewport').height();
			$('#loading').hide();
		},
		error: function () {
			$('#error').text('Impossible de se connecter au serveur').show();
		}
	});
}

function setVisible(){
	hideItem = count;
	for(hideItem; hideItem>=0;hideItem--){
		$('.res'+hideItem).hide();
	}
	val = val + 11;
	showItem = val;
	limit = val-11;
	for(showItem; showItem>=limit; showItem--){
		$('.res'+showItem).fadeIn(2000);
	}

	if(val>count){
		val=0;
	}
}

setInterval(function(){setVisible();}, 12000);

/**
 * Scrolling
 */
setInterval(function () {
	
	if (viewport == null) return;
	if (planningHeight <= viewport.height()) return;
	//console.log(currentValue + "/" + planningHeight);
	
	if (currentValue > planningHeight || currentValue <= 0) {
		sleep(5000);
		move *= -1;
	}
	
	currentValue += move;

	viewport.scrollTop(currentValue);
	
}, 20);

/**
 * Update clock (legacy code)
 */
setInterval(function () {
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
}, 1000);

/**
 * Reload data each 5 minutes.
 */
setInterval(function () {
	reloadData();
}, 5 * 60 * 1000);

function setActualDate(){
	var today = new Date();
	var day = today.getDate();
	var month = today.getMonth()+1;
	var year = today.getFullYear();
	var month = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
"Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"][today.getMonth()];
	var str = '<h4>' +day + ' ' +month + ' ' + today.getFullYear() + '</h4>';
	$('#date').html(str);
};

setInterval(function(){setActualDate();}, 60000);

function setInfoText(text){
		var marq  = $('marquee#info font');
		$(marq).text(text);
	}

$(document).ready(function() {
  $.simpleWeather({
    location: loc,
    woeid: 'km',
    unit: 'c',
    success: function(weather) {
    	console.log("weather");
      html = '<div clas="row"><h4 id="temp" class="col s3 offset-s3"><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</h4>';
      html += '<img id="weatherImage" class="col s6" src="'+weather.forecast[0].image+'"></div>';
  
      $("#weather").html(html);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });
});

function weather(){
	$.simpleWeather({
    location: loc,
    woeid: 'km',
    unit: 'c',
    success: function(weather) {
    	console.log(weather);
      html = '<div clas="row"><h4 id="temp" class="col s3 offset-s3"><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</h4>';
      html += '<img id="weatherImage" class="col s6" src="'+weather.forecast[0].image+'"></div>';
  
      $("#weather").html(html);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });
}

setInterval(function(){weather();}, 60000);

	