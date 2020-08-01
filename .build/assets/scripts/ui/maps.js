import { map_styles } from './map_styles';

(function () {

	if(!shtMapData || !'google_api_key' in shtMapData || !shtTranslations) {
		// console.info('%cMap script not loaded as no map on this page', 'color: green;font-style:italic');
		return;
	}


	// Function to eiter re-centre the map or re-enclose all markers
	const resetView = function (map, map_data, bounds) {
		if(map_data.length > 1) {
			map.fitBounds(bounds);
		} else {
			map.setZoom(15);
			map.setCenter(new google.maps.LatLng(map_data[0].location.lat, map_data[0].location.lng));
		}
	}

	// The master function
	const initMaps = function () {

		const icon = {
			url: shtThemeData.directory_uri + '/assets/img/icons/pt-map-pin.min.svg', // url
			scaledSize: new google.maps.Size(22, 52), // scaled size
			origin: new google.maps.Point(0, 0), // origin
			anchor: new google.maps.Point(0, 52) // anchor
		};

		let activeInfoWindow = null;

		document.querySelectorAll('[data-map]').forEach(function (mapContainer) {
			mapContainer.markers = [];
			const bounds = new google.maps.LatLngBounds();

			// Add the map to the block
			const map_data = JSON.parse(mapContainer.getAttribute('data-map-data')),
				map = new google.maps.Map(mapContainer, {
					center: { lat: 46.7985286, lng: 8.2296061 }, // Älggialp
					zoom: 8,
					disableDefaultUI: true,
					mapTypeControl: true,
					mapTypeControlOptions: {
						mapTypeIds: [google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.ROADMAP]
					},
					mapTypeId: google.maps.MapTypeId.HYBRID,
					scrollwheel: false,
					zoomControl: true,
					zoomControlOptions: {
						position: google.maps.ControlPosition.LEFT_BOTTOM
					},
					styles: map_styles
				});

			let markers = [];

			// Add the markers to the map
			map_data.forEach(pin => {
				if(!!pin.location && !!pin.location.lat && !!pin.location.lng) {
					var markerLocation = new google.maps.LatLng(pin.location.lat, pin.location.lng),
						marker = new google.maps.Marker({
							position: markerLocation,
							map: map,
							visible: true,
							icon: icon
						});
					marker.set('infowindow', new google.maps.InfoWindow({
						content: pin.preview,
						map: map
					}));
					google.maps.event.addListener(marker, 'click', function () {
						if(activeInfoWindow) { activeInfoWindow.close(); }
						this.get('infowindow').open(map, this);
						activeInfoWindow = this.get('infowindow');
					});
					marker.set('id', 'markerLocation' + pin.ID);
					mapContainer.markers['markerLocation' + pin.ID] = marker;

					google.maps.event.addListener(marker, 'mouseover', function () {
						event.target.closest('[data-map-block]').querySelectorAll('[data-map-entry-id="' + this.id.replace('markerLocation', '') + '"]').forEach(element => {
							element.classList.add('is--hovered');
						});
					});
					google.maps.event.addListener(marker, 'mouseout', function () {
						event.target.closest('[data-map-block]').querySelectorAll('[data-map-entry-id="' + this.id.replace('markerLocation', '') + '"]').forEach(element => {
							element.classList.remove('is--hovered');
						});
					});
					bounds.extend(markerLocation);
				}

			});

			// Adjust map view to encompass all markers
			resetView(map, map_data, bounds);

			// Add reset button to map
			var reset_button = document.createElement('button');
			reset_button.map = map;
			reset_button.map_data = map_data;
			reset_button.bounds = bounds;
			reset_button.setAttribute('class', 'c-googlemap__reset');
			reset_button.innerHTML = shtTranslations.reset;
			reset_button.addEventListener('click', function () {
				resetView(this.map, this.map_data, this.bounds);
				this.blur();
			});
			mapContainer.appendChild(reset_button);
		});
	};

	// Load the Google Maps script and call the init function once it's loaded
	const maps_script = document.createElement('script');
	maps_script.addEventListener('load', initMaps);
	maps_script.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=' + shtMapData['google_api_key']);
	document.head.appendChild(maps_script);


	// Add a custom event so that the map can be initialized in the Gutenberg editor
	window.addEventListener('initMaps', initMaps);

})();
