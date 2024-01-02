var map = L.map('map').setView([50.087, 14.420], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Search input
    var searchInput = document.getElementById('searchInput');

    // Variable to store the current marker
    var currentMarker;

    // Function to update the map based on the search input
    function updateMap() {
      var searchText = searchInput.value;

      if (searchText.trim() !== '') {
        // Use OpenStreetMap Nominatim for geocoding
        var apiUrl = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(searchText);

        // Fetch geocoding results
        fetch(apiUrl)
          .then(response => response.json())
          .then(data => {
            if (data.length > 0) {
              var result = data[0];
              var lat = parseFloat(result.lat);
              var lon = parseFloat(result.lon);

              // Update hidden input fields with coordinates
              document.getElementById('accident_place').value = lat+','+lon;

              // Log the coordinates (optional)
              console.log('Latitude: ' + lat + ', Longitude: ' + lon);

              // Remove the current marker if it exists
              if (currentMarker) {
                map.removeLayer(currentMarker);
              }

              // Add a marker to the found location
              currentMarker = L.marker([lat, lon]).addTo(map).bindPopup(lat+','+lon)
              .openPopup();

              // Center the map on the found location
              map.setView([lat, lon], 13);
            } else {
              console.log('Location not found');
            }
          })
          .catch(error => console.error('Error fetching geocoding data:', error));
      }
    }

    // Event listener for Enter key
    searchInput.addEventListener('keyup', function (event) {
      if (event.key === 'Enter') {
        updateMap();
      }
    });

    // Event listener for change event
    searchInput.addEventListener('change', updateMap);

    // Add a click event listener to the map
    map.on('click', function (event) {
      var lat = event.latlng.lat;
      var lon = event.latlng.lng;

      // Update hidden input fields with coordinates
      document.getElementById('accident_place').value = lat+','+lon;

      // Log the coordinates (optional)
      console.log('Latitude: ' + lat + ', Longitude: ' + lon);

      // Remove the current marker if it exists
      if (currentMarker) {
        map.removeLayer(currentMarker);
      }

      // Add a marker to the clicked location
      currentMarker = L.marker([lat, lon]).addTo(map).bindPopup(lat+','+lon)
      .openPopup();
    });


setInterval(function() {
  map.invalidateSize();
}, 1000);