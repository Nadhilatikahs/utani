@section('script')
<script>
    // Initialize the map
    var map = L.map('map').setView([-6.1751, 106.8650], 13); // Coordinates for Jakarta

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Variable to hold the single marker (for current input)
    var marker = null;

    // Function to update marker and form inputs
    function updateMarker(latlng, name = null) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(latlng).addTo(map);
        if (name) {
            marker.bindPopup(name).openPopup();
        }
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
    }

    // Add Leaflet Control Geocoder
    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        var bbox = e.geocode.bbox;
        var latlng = e.geocode.center;
        map.fitBounds([
            [bbox.getSouthWest().lat, bbox.getSouthWest().lng],
            [bbox.getNorthEast().lat, bbox.getNorthEast().lng]
        ]);
        updateMarker(latlng, e.geocode.name);
    })
    .addTo(map);

    // Add event listener to detect click on the map
    map.on('click', function(e) {
        updateMarker(e.latlng);
    });

    // Tampilkan marker semua UPT dari database
    @if(isset($upts) && count($upts) > 0)
        @foreach($upts as $upt)
            @if(!empty($upt->latitude) && !empty($upt->longitude))
                L.marker([{{ $upt->latitude }}, {{ $upt->longitude }}])
                    .addTo(map)
                    .bindPopup("<strong>{{ $upt->nama_upt }}</strong><br>{{ $upt->alamat }}<br>Lat: {{ $upt->latitude }}<br>Lng: {{ $upt->longitude }}");
            @endif
        @endforeach
    @endif
</script>
@endsection
