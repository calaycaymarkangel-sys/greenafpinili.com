<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GreenAF - Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

<style>
body, html {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: 'Poppins', sans-serif;
  overflow: hidden;
}

header {
  background: #3d562b;
  color: white;
  padding: 12px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  z-index: 50;
}

header nav a {
  color: white;
  margin-left: 20px;
  text-decoration: none;
  font-weight: 500;
}

header nav a.active {
  border-bottom: 2px solid #b6e388;
}

.main-container {
  display: flex;
  height: calc(100vh - 60px);
  position: relative;
  z-index: 1;
}

/* Map area */
#map {
  flex-grow: 1;
  width: 100%;
  height: 100%;
  position: relative;
  z-index: 1;
}

/* CRITICAL: Override ALL Leaflet z-index values */
.leaflet-map-pane {
  z-index: 1 !important;
}

.leaflet-tile-pane {
  z-index: 1 !important;
}

.leaflet-overlay-pane {
  z-index: 2 !important;
}

.leaflet-shadow-pane {
  z-index: 3 !important;
}

.leaflet-marker-pane {
  z-index: 4 !important;
}

.leaflet-tooltip-pane {
  z-index: 5 !important;
}

.leaflet-popup-pane {
  z-index: 99999 !important;
}

.leaflet-popup {
  z-index: 99999 !important;
  position: absolute !important;
}

.leaflet-popup-content-wrapper {
  z-index: 99999 !important;
}

.leaflet-popup-tip-container {
  z-index: 99999 !important;
}

.leaflet-pane {
  z-index: auto !important;
}

.leaflet-pane.leaflet-popup-pane {
  z-index: 99999 !important;
}

/* Report summary vertical, centered on left side */
.summary-panel {
  position: absolute;
  top: 50%;
  left: 20px;
  transform: translateY(-50%);
  width: 200px;
  background: #f5f7f3;
  padding: 15px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.3);
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  z-index: 10;
}

.summary-header {
  font-size: 16px;
  font-weight: 600;
  color: #3d562b;
  border-bottom: 2px solid #b6e388;
  padding-bottom: 5px;
}

.summary-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
}

.summary-item .pin {
  width: 16px;
  height: 24px;
  background-size: cover;
  display: inline-block;
}
.pin.submitted { background-image: url('https://maps.google.com/mapfiles/ms/icons/red-dot.png'); }
.pin.accepted { background-image: url('https://maps.google.com/mapfiles/ms/icons/blue-dot.png'); }
.pin.done { background-image: url('https://maps.google.com/mapfiles/ms/icons/green-dot.png'); }

/* Filters on top-right */
.filter-container {
  position: absolute;
  top: 70px;
  right: 20px;
  display: flex;
  flex-direction: row;
  gap: 10px;
  z-index: 10;
}

.filter-panel, .type-filter-panel {
  background: rgba(255,255,255,0.9);
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.3);
}

.filter-panel button {
  margin: 3px;
  padding: 6px 10px;
  border: none;
  border-radius: 6px;
  background: #3d562b;
  color: white;
  cursor: pointer;
}
.filter-panel button:hover { background: #5a7848; }

.type-filter-panel select {
  padding: 6px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

/* Popup styling */
.popup-box {
  width: 250px;
  font-size: 13px;
}

.popup-img {
  width: 100%;
  height: 130px;
  object-fit: cover;
  border-radius: 6px;
  margin-bottom: 6px;
}

.popup-details b {
  color: #3d562b;
}

.comment-section {
  margin-top: 8px;
  border-top: 1px solid #ddd;
  padding-top: 6px;
}

.comment-section textarea {
  width: 100%;
  height: 50px;
  resize: none;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-family: 'Poppins';
  padding: 5px;
  box-sizing: border-box;
}

.comment-section button {
  width: 100%;
  margin-top: 4px;
  background: #3d562b;
  color: white;
  border: none;
  padding: 5px;
  border-radius: 6px;
  cursor: pointer;
}

.comment-section button:hover {
  background: #5a7848;
}

.comment-list {
  margin-top: 6px;
  max-height: 70px;
  overflow-y: auto;
  font-size: 12px;
  background: #f8f8f8;
  border-radius: 4px;
  padding: 4px;
}

/* Mobile responsiveness - scale down but keep original positions */
@media (max-width: 768px) {
  .summary-panel {
    width: 150px;
    padding: 10px;
    left: 10px;
  }

  .summary-header {
    font-size: 13px;
  }

  .summary-item {
    font-size: 11px;
    gap: 5px;
  }

  .summary-item .pin {
    width: 12px;
    height: 18px;
  }

  .filter-container {
    top: 70px;
    right: 10px;
    flex-direction: column;
    gap: 8px;
  }

  .filter-panel, .type-filter-panel {
    padding: 8px;
  }

  .filter-panel button {
    padding: 4px 7px;
    font-size: 10px;
    margin: 2px;
  }

  .type-filter-panel select {
    font-size: 11px;
    padding: 5px;
  }

  .filter-panel strong,
  .type-filter-panel label strong {
    font-size: 11px;
  }
}

@media (max-width: 480px) {
  .summary-panel {
    width: 120px;
    padding: 8px;
    left: 5px;
  }

  .summary-header {
    font-size: 11px;
  }

  .summary-item {
    font-size: 9px;
    gap: 4px;
  }

  .summary-item .pin {
    width: 10px;
    height: 15px;
  }

  .filter-container {
    right: 5px;
    top: 70px;
  }

  .filter-panel, .type-filter-panel {
    padding: 6px;
  }

  .filter-panel button {
    padding: 3px 5px;
    font-size: 9px;
    margin: 1px;
  }

  .type-filter-panel select {
    font-size: 10px;
    padding: 4px;
  }

  .filter-panel strong,
  .type-filter-panel label strong {
    font-size: 10px;
  }
}
</style>
</head>
<body>

<header>
  <div class="logo">GreenAF Dashboard</div>
  <nav>
    <a href="home.php">Home</a>
    <a href="map_dashboard.php" class="active">Map</a>
    <a href="report.php">Report</a>
  </nav>
</header>

<div class="main-container">
  <div id="map"></div>
</div>

<!-- Report summary panel -->
<div class="summary-panel">
  <div class="summary-header">Reports Summary</div>
  <div class="summary-item">
    <span class="pin submitted"></span> Submitted: <span id="totalSubmitted">0</span>
  </div>
  <div class="summary-item">
    <span class="pin accepted"></span> Accepted: <span id="totalAccepted">0</span>
  </div>
  <div class="summary-item">
    <span class="pin done"></span> Done: <span id="totalDone">0</span>
  </div>
</div>

<!-- Filters panel -->
<div class="filter-container">
  <div class="filter-panel">
    <strong>Status:</strong><br>
    <button onclick="filterMarkers('all')">All</button>
    <button onclick="filterMarkers('Submitted')">Submitted</button>
    <button onclick="filterMarkers('Accepted')">Accepted</button>
    <button onclick="filterMarkers('Done')">Done</button>
  </div>
  <div class="type-filter-panel">
    <label><strong>Type:</strong></label><br>
    <select id="typeFilter" onchange="filterByType()">
      <option value="All">All</option>
      <option value="Illegal Dumping">Illegal Dumping</option>
      <option value="Deforestation">Deforestation</option>
      <option value="Water Pollution">Water Pollution</option>
      <option value="Air Pollution">Air Pollution</option>
      <option value="Wildlife Disturbance">Wildlife Disturbance</option>
    </select>
  </div>
</div>

<script>
var map = L.map('map', { zoomControl: true }).setView([17.9475, 120.5265], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
  maxZoom: 19,
  zIndex: 1
}).addTo(map);

var markers = L.markerClusterGroup();

var reports = [
  { lat: 17.9475, lon: 120.5265, status: "Submitted", type: "Illegal Dumping", description: "Dumping area near river", timestamp: "2025-11-03 08:00", img: "https://via.placeholder.com/200x120?text=Illegal+Dumping", comments: [] },
  { lat: 17.955, lon: 120.53, status: "Accepted", type: "Deforestation", description: "Tree cutting observed", timestamp: "2025-11-02 10:00", img: "https://via.placeholder.com/200x120?text=Deforestation", comments: [] },
  { lat: 17.94, lon: 120.52, status: "Done", type: "Water Pollution", description: "Drainage cleaned", timestamp: "2025-11-01 15:00", img: "https://via.placeholder.com/200x120?text=Water+Pollution", comments: [] }
];

function buildPopup(r, index) {
  let commentsHTML = r.comments.map(c => `<div>• ${c}</div>`).join("");
  if (!commentsHTML) commentsHTML = "<i>No comments yet.</i>";

  return `
    <div class="popup-box">
      <img src="${r.img}" class="popup-img">
      <div class="popup-details">
        <b>Status:</b> ${r.status}<br>
        <b>Type:</b> ${r.type}<br>
        <b>Description:</b> ${r.description}<br>
        <b>Time:</b> ${r.timestamp}<br>
      </div>
      <div class="comment-section">
        <div class="comment-list" id="comments-${index}">${commentsHTML}</div>
        <textarea id="comment-input-${index}" placeholder="Add a comment..."></textarea>
        <button onclick="addComment(${index})">Submit</button>
      </div>
    </div>`;
}

var markerObjects = [];
reports.forEach((r, i) => {
  let color = r.status === "Submitted" ? "red" : r.status === "Accepted" ? "blue" : "green";
  let marker = L.marker([r.lat, r.lon], {
    icon: L.icon({
      iconUrl: `https://maps.google.com/mapfiles/ms/icons/${color}-dot.png`,
      iconSize: [32, 32],
      iconAnchor: [16, 32]
    }),
    zIndexOffset: 1000
  }).bindPopup(buildPopup(r, i), {
    maxWidth: 300,
    className: 'custom-popup',
    closeButton: true,
    autoClose: true,
    autoPan: true
  });

  markers.addLayer(marker);
  markerObjects.push({ marker, status: r.status, type: r.type });
});

map.addLayer(markers);

// Force popup pane to highest z-index after map loads
setTimeout(function() {
  var popupPane = map.getPane('popupPane');
  if (popupPane) {
    popupPane.style.zIndex = '99999';
  }
}, 100);

function addComment(i) {
  let input = document.getElementById(`comment-input-${i}`);
  let text = input.value.trim();
  if (text) {
    reports[i].comments.push(text);
    input.value = "";
    document.getElementById(`comments-${i}`).innerHTML = reports[i].comments.map(c => `<div>• ${c}</div>`).join("");
  }
}

function updateSummary() {
  document.getElementById('totalSubmitted').innerText = reports.filter(r => r.status === "Submitted").length;
  document.getElementById('totalAccepted').innerText = reports.filter(r => r.status === "Accepted").length;
  document.getElementById('totalDone').innerText = reports.filter(r => r.status === "Done").length;
}
updateSummary();

function filterMarkers(status) {
  markers.clearLayers();
  markerObjects.forEach(o => {
    if (status === "all" || o.status === status) markers.addLayer(o.marker);
  });
}

function filterByType() {
  const type = document.getElementById("typeFilter").value;
  markers.clearLayers();
  markerObjects.forEach(o => {
    if (type === "All" || o.type === type) markers.addLayer(o.marker);
  });
}
</script>
</body>
</html>