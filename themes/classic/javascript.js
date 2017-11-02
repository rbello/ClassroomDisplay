
var planningHeight = 0;
var move = -1;
var currentValue = 0;

var viewport = null;

/**
 * Startup code
 */
$(function () {
	window["viewport"] = $('#viewport');
	viewport.css('height', ($(window).height() - 130) + 'px');
	reloadData();
});

$(window).resize(function () {
	viewport.css('height', ($(window).height() - 130) + 'px');
});

function sleep(sleepDuration){
    var now = new Date().getTime();
    while (new Date().getTime() < now + sleepDuration); 
}

/**
 * Reload data from JSON api
 */
function reloadData() {
	$('#loading').show();
	var profile = $('body').attr('profile');
	$.ajax({
		url: 'data.php?profile=' + profile,
		success: function (data) {
			$('#error').hide();
			var table = $('#table-body');
			table.html('');
			data['data'].forEach(function (item) {
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
				tr.appendChild(td1);
				tr.appendChild(td2);
				tr.appendChild(td3);
				tr.appendChild(td4);
				tr.appendChild(td5);
				table.append(tr);
			});
			planningHeight = $('#table-body').height() - $('#viewport').height();
			$('#loading').hide();
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
 * Reload data each 5 minutes.
 */
setInterval(function () {
	reloadData();
}, 5 * 60 * 1000);