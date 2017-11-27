
var planningHeight = 0;
var move = -1;
var currentValue = 0;

var countGlobal = 0;
var countLocal = 0;
var number = 0;
var ok = false;
var viewport = null;

/**
 * Startup code
 */
$(function () {
	//window["viewport"] = $('#viewport');
	//viewport.css('height', ($(window).height() - 130) + 'px');
	reloadData();
	setActualDate();
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
			number = data['data'].length / 8;
			console.log(number);
			console.log(data);
			$('#error').hide();
			var table = $('.card-container');
			var color = "Grey lighten-1";
			var count = 0;
			countLocal = 0;
			table.html("");
			data['data'].forEach(function (item) {
				if((countGlobal+1 )* 8 > countLocal && countGlobal *8 <= countLocal){
					if(count==0){
						color = "grey lighten-3";
						count = 1;
					}else{
						color = "grey lighten-2";
						count = 0;
					}

					var div_a = document.createElement('div');
					div_a.className = "col s3";

					var div_b = document.createElement('div');
					div_b.className = "card " + color;

					var div_c = document.createElement('div');
					div_c.className = "card-content";

					var div_c_1 = document.createElement('div');
					div_c_1.className = "row valign-wrapper center-align bordered";
					var div_c_1_content = document.createElement('div');
					div_c_1_content.className = "col s12";
					div_c_1_content.textContent = "Session : " + item['NomSession'];
					div_c_1.appendChild(div_c_1_content);

					var div_c_2 = document.createElement('div');
					div_c_2.className = "row valign-wrapper center-align bordered";
					var div_c_2_content = document.createElement('div');
					div_c_2_content.className = "col s5";
					div_c_2_content.textContent = "Salle : " + item['NomSalle'];
					var div_c_2_content2 = document.createElement('div');
					div_c_2_content2.className = "col s7";
					div_c_2_content2.textContent = "Matière : " + item['NomMatiere'];
					div_c_2.appendChild(div_c_2_content);
					div_c_2.appendChild(div_c_2_content2);

					var div_c_3 = document.createElement('div');
					div_c_3.className = "row valign-wrapper center-align bordered";
					var div_c_3_content = document.createElement('div');
					div_c_3_content.className = "col s12";
					div_c_3_content.textContent = "Intervenant : " + item['NomIntervenant'];
					div_c_3.appendChild(div_c_3_content);

					var div_c_4 = document.createElement('div');
					div_c_4.className = "row valign-wrapper center-align bordered";
					var div_c_4_content = document.createElement('div');
					div_c_4_content.className = "col s12";
					div_c_4_content.textContent = "Période : " + item['HeureDebut'] + '-' + item['HeureFin'];
					div_c_4.appendChild(div_c_4_content);
					
					div_c.appendChild(div_c_1);
					div_c.appendChild(div_c_2);
					div_c.appendChild(div_c_3);
					div_c.appendChild(div_c_4);
					div_b.appendChild(div_c);
					div_a.appendChild(div_b);
					table.append(div_a);
				}
				countLocal ++;
			});
			planningHeight = $('#table-body').height() - $('#viewport').height();
			$('#loading').hide();
			countGlobal ++;
			if(countGlobal > number){
				countGlobal = 0;
			}
		},
		error: function () {
			$('#error').text('Impossible de se connecter au serveur').show();
		}
	});
}

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
 * Reload data each 10 seconds.
 */
setInterval(function () {
	reloadData();
}, 10 * 1000);

function setActualDate(){
	var today = new Date();
	var day = today.getDate();
	var month = today.getMonth()+1;
	var year = today.getFullYear();

	/*if(day<10){
		day = '0'+day;
	}

	if(month<10){
		month = '0'+month;
	}*/
	//var mydate = new Date(form.startDate.value);
	var month = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
"Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"][today.getMonth()];
	var str = '<h4>' +day + ' ' +month + ' ' + today.getFullYear() + '</h4>';
	$('#date').html(str);
};

setInterval(function(){setActualDate();}, 60000);

$(document).ready(function() {
  $.simpleWeather({
    location: loc,
    woeid: 'km',
    unit: 'c',
    success: function(weather) {
      html = '<div clas="row"><h4 class="col s6"><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</h4>';
      html += '<img id="weatherImage" class="col s6" src="'+weather.forecast[0].image+'"></div>';
  
      $("#weather").html(html);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });
});

setInterval(function(){simpleWeather();}, 60000);