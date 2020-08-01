import { map_styles } from './map_styles';

(function () {

	if(!shtMapData || !'google_api_key' in shtMapData || !shtTranslations) {
		// console.info('%cMap script not loaded as no map on this page', 'color: green;font-style:italic');
		return;
	}

	let iw = null;

	// Function to eiter re-centre the map or re-enclose all markers
	const resetView = function (map, markers, bounds) {
		if(iw) {
			iw.close();
		}

		if(markers.length > 1) {
			map.fitBounds(bounds);
		} else {
			map.setZoom(15);
			map.setCenter(new google.maps.LatLng(markers[0].location.lat, markers[0].location.lng));
		}
	}

	// The master function
	const initMaps = function () {

		iw = new google.maps.InfoWindow();
		google.maps.event.addListener(iw, 'closeclick', function (e) {
			e.preventDefault();
		});
		const icon = {
			url: shtThemeData.directory_uri + '/assets/img/icons/pt-map-pin.min.svg', // url
			scaledSize: new google.maps.Size(22, 52), // scaled size
			// origin: new google.maps.Point(0, 0), // origin
			anchor: new google.maps.Point(0, 52) // anchor
		};

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

			// https://github.com/jawj/OverlappingMarkerSpiderfier
			const oms = new OverlappingMarkerSpiderfier(map, {
				keepSpiderfied: true,
				circleSpiralSwitchover: Infinity
			});

			oms.addListener('spiderfy', function (markers) {
				iw.close();
			});

			let markers = map_data.map(function (pin, i) {
				let markerLocation = new google.maps.LatLng(pin.location.lat, pin.location.lng);
				var marker = new google.maps.Marker({
					position: markerLocation,
					map: map,
					visible: true,
					icon: icon
				});
				google.maps.event.addListener(marker, 'spider_click', function () {
					iw.setContent(pin.preview);
					iw.open(map, marker);
					// map.setZoom(17);
					map.setCenter(marker.getPosition());
				});
				marker.set('id', 'markerLocation' + pin.ID);
				bounds.extend(markerLocation);
				oms.addMarker(marker);
				return marker;
			});

			// Adjust map view to encompass all markers
			resetView(map, markers, bounds);

			// Add reset button to map
			var reset_button = document.createElement('button');
			reset_button.map = map;
			reset_button.markers = markers;
			reset_button.bounds = bounds;
			reset_button.setAttribute('class', 'c-googlemap__reset');
			reset_button.innerHTML = shtTranslations.reset;
			reset_button.addEventListener('click', function () {
				resetView(this.map, this.markers, this.bounds);
				this.blur();
			});
			mapContainer.appendChild(reset_button);
		});
	};


	// Load the Google Maps scripts and call the init function once they're loaded
	const ows_script = document.createElement('script');
	ows_script.setAttribute('src', 'https://cdnjs.cloudflare.com/ajax/libs/OverlappingMarkerSpiderfier/1.0.3/oms.min.js');
	ows_script.addEventListener('load', () => {
		const maps_script = document.createElement('script');
		maps_script.addEventListener('load', initMaps);
		maps_script.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=' + shtMapData['google_api_key']);
		document.head.appendChild(maps_script);
	});
	document.head.appendChild(ows_script);

	// Add a custom event so that the map can be initialized in the Gutenberg editor
	window.addEventListener('initMaps', initMaps);

})();
