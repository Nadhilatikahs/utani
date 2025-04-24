<!DOCTYPE html>
<html>
<head>
    <title>Map Kelompok Tani</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        #map { height: 90vh; }
    </style>
</head>
<body>
    <h2>Peta Kelompok Tani</h2>
    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([-6.98, 107.63], 10); // titik awal, bisa disesuaikan

        // Tambah tile (background peta)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Data dari Laravel ke JS
        const locations = @json($data);

        locations.forEach(loc => {
            L.marker([loc.latitude, loc.longitude])
                .addTo(map)
                .bindPopup(`<strong>${loc.nama}</strong><br>${loc.alamat}, ${loc.desa}`);
        });
    </script>
</body>
</html>
