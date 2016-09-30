  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<?php
/**
 * Created by PhpStorm.
 * User: Trah
 * Date: 27/09/2016
 * Time: 08:48
 */
$msg = $this->vars['msg'];
$pageTitle = $this->vars['pageTitle'];
$pageMessage = $this->vars['pageMessage'];
include_once  'views/header.inc'; ?>


<style>
	.formgroup{
		margin-top: 	10px;
		margin-bottom: 	15px;
	}
	
	.formgroup p{
		font-size: 15pt !important;
		
	}
	
	.graphical{
		width:	100%;
		height:	300px; 
		margin:	10px 0
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-5 col-xs-1">
			<form id="form" method="post" action="<?php echo URL_DIR.'sorties/ajoutsortie' ?>">
				<div class="row">
					<div class="col-md-6 formgroup">
						<p>Titre</p>
						<input id="title" name="title" type="text" required style="width:100%">
					</div>
					<div class="col-md-6 formgroup">
						<p>Personnes max</p>
						<input id="maxParticipants" name="maxParticipants" type="number" min="1" required style="width:50px">
					</div>
				</div>
				<div class="row">
					<div class="formgroup col-sm-6">
						<p>Catégorie</p>
						<select id="category" name="category" required>
							<option value="1">Marche</option>
							<option value="2">Peau de Phoque</option>
							<option value="3">Grimpe</option>
							<option value="4">Raquettes</option>
							<option value="5">Ski</option>
							<option value="6">Snowboard</option>
							<option value="7">Télémark</option>
							<option value="7">Ski de fond</option>
						</select>
					</div>
					<div class="formgroup col-sm-6">
						<p>Difficulté</p>
						<select id="difficulty" name="difficulty" required>
							<option value="1">Débutant</option>
							<option value="2">Modéré</option>
							<option value="3">Avancé</option>
							<option value="4">Très Avancé</option>
							<option value="5">Professionnel</option>
						</select>
					</div>
				</div>
				<div class="formgroup">
					<p>Date/Heure de début</p>
					<input id="startDate" name="startDate" type="date" required> 
					<input id="startTime" name="startTime" type="time" autocomplete="off">
				</div>
				<div class="formgroup">
					<p>Date/Heure de fin</p>
					<input id="endDate" name="endDate" type="date" required>
					<input id="endTime" name="endTime" type="time" autocomplete="off">
				</div>
				<div class="formgroup">
					<p>Description</p>
					<textarea id="description" rows="6" cols="50" name="description"></textarea>
				</div>
		</div>
		<div class="col-md-7 col-xs-10 text-center">
			<div class="formgroup">
				<h2>Parcours</h2>
				<input id="geocodeInput" type=text placeholder="Entrer un lieu"><button type="button" id="searchGeo" onclick="showAddress()">Go</button>

				<div id="trailIndication" style=" opacity:0 !important">
					<p style="font-size:12px !important;">cliquez sur la carte pour dessiner le parcours</p>
					<button type="button" onclick="removeLastPoint()">Suppr dernier point</button>
					<button type="button" onclick="removeAllPoints()">Suppr tous les points</button>
				</div>
				<div id="map" class="graphical"></div>
				<div id="chart" class="graphical" style="height:150px;"></div>
			</div>
		</div>
	</div>
	<div class="row" style="margin-bottom:50px">
		<div class="col-md-12 text-center">
			<input id="form_json" name="JSON" type="hidden">
			<button type="button" onclick="submit()">Ajouter</button>
			</form>
		</div>
	</div>
</div>

<!-- Google Visualizations -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

<script>
	
	var map = null;
	var geocoder = null;
	var addressMarker = null;
	var trailPoints = [];
	var trailShape = null;
	var elevator = null;
	var chart = null;
	var form = $("#form");
	form.validate();
	
	
	function initMap() {
		  
		  var mapCanvas = document.getElementById('map');
		  geocoder = new google.maps.Geocoder();
		  elevator = new google.maps.ElevationService();
		  var mapOptions = {
				center: {lat: 46.307174, lng: 7.473367},
				zoom: 9,
				mapTypeId: 'terrain'
		  };
		  map = new google.maps.Map(mapCanvas, mapOptions);
		google.maps.event.addListener(map, 'click', function(event){
			clickMap(event.latLng);
		});
		      google.charts.load('current', {'packages':['corechart']});

      }
	
	function showAddress(){
		var address = $("#geocodeInput").val();
		if(geocoder){
			geocoder.geocode({address: address}, 
				function(response, status){
					if(!response || status != google.maps.GeocoderStatus.OK){
						alert(address + " introuvable");
					}else{
						var point = response[0].geometry.location;
						addressMarker = new google.maps.Marker({
							position: point,
							map: map,
							title: "Point recherché"
						});
						
						map.setCenter(point)
						map.setZoom(12);
						
						$('#trailIndication').css("opacity", "1");
					}
				});
		}
	}
	
	function drawCoordinates(){
		if(trailShape)
			trailShape.setMap(null);
		trailShape = new google.maps.Polyline({
			path: trailPoints,
			strokeColor: '#FF0000',
			map: map
		});
		
		if(addressMarker)
			addressMarker.setMap(null);
		addressMarker = new google.maps.Marker({
			position: trailPoints[trailPoints.length-1],
			map: map
		});
		
		document.getElementById('form_json').value = JSON.stringify(trailPoints);
		console.log(JSON.stringify(trailPoints));
	}
    
	function clickMap(clickedPoint){
		
		trailPoints.push(clickedPoint);
		drawCoordinates();
		if (trailPoints.length >= 2)
			calculateElevation(getJSON(trailPoints));
		
		$('#trailIndication').css("opacity", "1");
	}
	
	function getJSON(points){
		var output = [];
		for(var i = 0; i < points.length; i++){
			var line = null;
			line = {
				lat: points[i].lat(),
				lng: points[i].lng()
			};
			output.push(line);
		}
		return output;
	}
	
	function calculateElevation(points){
		if(elevator){
			elevator.getElevationAlongPath({
				'path': points,
				'samples': 256
			}, plotElevation);
		}
	}
	
	function plotElevation(elevations, status){
		var chartCanvas = document.getElementById("chart");	
		if(status !== 'OK'){
			chartCanvas.innerHTML= "error " + status;
			return;
		}
		
		chart = new google.visualization.LineChart(chartCanvas);
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Sample');
		data.addColumn('number', 'Altitude');
		for(var i = 0; i < elevations.length; i++){
			data.addRow(['', elevations[i].elevation]);
		}
		
		chart.draw(data, {
			height: 150,
			legend: 'none',
			titleY: 'Altitude (m)'
		});
	}
	
	function removeLastPoint(){
		trailPoints.pop();
		drawCoordinates();
		if (trailPoints.length >= 2)
			calculateElevation(getJSON(trailPoints));
		else
			chart.clearChart();
	}
	
	function removeAllPoints(){
		trailPoints = [];
		drawCoordinates();
		chart.clearChart();
	}
	
	function updateSecondDate(){
		console.log($('#startDate').val());
		var date = new Date($('#startDate').val())
		console.log(date);
		$('#endDate').val(date);
	}
	
</script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfHSiXZQseH8j-pPHb9PiWwvGvpOUSDGw&callback=initMap"
    async defer></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<?php
include_once 'views/footer.inc';