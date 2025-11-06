<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>GreenAF - Report an Issue</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
* { box-sizing:border-box; margin:0; padding:0; font-family:"Poppins",sans-serif; }
body { background:#f9f9f9; color:#1a1a1a; overflow-x:hidden; }
header { 
  background:#3d562b; 
  display:flex; 
  align-items:center; 
  justify-content:space-between; 
  padding:15px 40px; 
  position:sticky; 
  top:0; 
  z-index:1000; 
  flex-wrap:wrap; 
  gap:10px; 
}
.logo { color:#fff; font-weight:600; font-size:1.2rem; }
nav ul { display:flex; gap:28px; list-style:none; }
nav a { color:#fff; text-decoration:none; font-weight:500; position:relative; padding-bottom:4px; }
nav a::after { content:""; position:absolute; left:0; bottom:0; width:0; height:2px; background-color:#b6e388; transition:width 0.3s ease; }
nav a:hover::after { width:100%; }
.line-icon { width:25px; height:3px; background:#fff; cursor:pointer; border-radius:2px; position:relative; display:none; transition:0.3s; }
.line-icon::before, .line-icon::after { content:""; position:absolute; left:0; width:25px; height:3px; background:#fff; border-radius:2px; transition:0.3s; }
.line-icon::before { top:-8px; }
.line-icon::after { top:8px; }
.line-icon.active { background-color:transparent; }
.line-icon.active::before { transform: rotate(45deg); top:0; }
.line-icon.active::after { transform: rotate(-45deg); top:0; }

@media(max-width:768px){
  header{padding:12px 18px;}
  nav ul{display:none; position:absolute; top:60px; right:20px; background:#3d562b; border-radius:6px; padding:15px; flex-direction:column; gap:15px; text-align:right; box-shadow:0 4px 10px rgba(0,0,0,0.3);}
  nav ul.active{display:flex;}
  .line-icon{display:block;}
}

main { padding:30px 20px 60px; max-width:980px; margin:auto; position:relative; z-index:1; }
.report-section { background:#fff; padding:22px; border-radius:10px; margin-bottom:20px; box-shadow:0 10px 25px rgba(0,0,0,0.08); }
h2 { color:#3d562b; margin-bottom:12px; }
p { margin-bottom:12px; font-size:0.95rem; line-height:1.5; }
.form-group { margin-bottom:10px; display:flex; flex-direction:column; }
.form-group label { margin-bottom:6px; font-weight:500; font-size:0.95rem; }
input[type="text"], textarea, select, input[type="file"], input[type="tel"] {
  padding:10px; border:1px solid #ccc; border-radius:8px; font-size:0.95rem; width:100%;
}
textarea { resize: vertical; }
.btn {
  display:inline-block; background:#3d562b; color:#fff; font-weight:500;
  border:none; padding:10px 14px; border-radius:8px; cursor:pointer;
  transition: background .2s; text-align:center;
}
.btn:hover { background:#5a7848; }
#map { 
  height:400px; 
  width:100%; 
  border-radius:12px; 
  margin-top:12px; 
  border:3px solid black;
  z-index:0; 
  position:relative;
}
.location-display {
  margin-top:8px; font-size:0.9rem; color:#333; background:#f5f7f3;
  border:1px dashed #d7e5cc; padding:8px; border-radius:8px; word-break:break-word;
}
.validation-note {
  font-size:0.85rem; color:#666; margin-top:4px; font-style:italic;
}
</style>
</head>
<body>

<header>
  <div class="logo">GreenAF</div>
  <nav>
    <ul id="nav-links">
      <li><a href="home.php">HOME</a></li>
      <li><a href="map.php">MAP</a></li>
      <li><a href="report.php">REPORT</a></li>
      <li><a href="#about">ABOUT US</a></li>
    </ul>
    <div class="line-icon" id="treeIcon" onclick="toggleNav()"></div>
  </nav>
</header>

<main>
  <section class="report-section" id="report">
    <h2>Submit a Report (Anonymous)</h2>
    <p>Mark the location of the incident within Pinili, Ilocos Norte.</p>

    <div id="map"></div>

    <div class="form-group">
      <label for="location">Coordinates</label>
      <input type="text" id="location" readonly placeholder="Coordinates will appear after moving the pin or using current location">
      <div class="validation-note" id="locationNote">Move the pin or use your current location</div>
      <button class="btn" style="margin-top:8px;" onclick="markCurrentLocation()">Use My Current Location</button>
    </div>

    <!-- Added Mobile Number Field -->
    <div class="form-group">
      <label for="mobile">Mobile Number (Optional)</label>
      <input type="tel" id="mobile" placeholder="Enter your mobile number (optional)" pattern="[0-9]{11}" maxlength="11">
      <div class="validation-note">Format: 11 digits (e.g. 09171234567)</div>
    </div>

    <div class="form-group">
      <label for="incidentType">Type of Incident</label>
      <select id="incidentType">
        <option value="">-- Select Type --</option>
        <option value="Illegal Dumping">Illegal Dumping</option>
        <option value="Deforestation">Deforestation</option>
        <option value="Water Pollution">Water Pollution</option>
        <option value="Air Pollution">Air Pollution</option>
        <option value="Wildlife Disturbance">Wildlife Disturbance</option>
        <option value="Other">Other</option>
      </select>
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" rows="4" placeholder="Describe the incident"></textarea>
    </div>

    <div class="form-group">
      <label for="fileUpload">Upload Picture or Video (Optional)</label>
      <input type="file" id="fileUpload" accept="image/*,video/*">
    </div>

    <button class="btn" onclick="submitReport()">Submit Report</button>
    <div id="refIdDisplay" class="location-display" style="display:none;"></div>
  </section>
</main>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
function toggleNav() {
  const nav = document.getElementById("nav-links");
  const icon = document.getElementById("treeIcon");
  nav.classList.toggle("active");
  icon.classList.toggle("active");
}

// MAP SETUP
const centerPinili = [17.9475, 120.5265];
const piniliBounds = { north: 18.05, south: 17.88, east: 120.62, west: 120.45 };
const southWest = L.latLng(piniliBounds.south, piniliBounds.west);
const northEast = L.latLng(piniliBounds.north, piniliBounds.east);
const bounds = L.latLngBounds(southWest, northEast);
const map = L.map('map', { minZoom: 13, maxZoom: 18, maxBounds: bounds, maxBoundsViscosity: 1.0 }).setView(centerPinili, 14);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);

const marker = L.marker(centerPinili, { draggable: true }).addTo(map);
let highlightCircle = null;
let userHasMovedPin = false;

function isWithinPiniliBounds(lat, lon) {
  return lat >= piniliBounds.south && lat <= piniliBounds.north && lon >= piniliBounds.west && lon <= piniliBounds.east;
}

async function checkIfInPinili(lat, lon) {
  try {
    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
    const data = await response.json();
    const displayName = (data.display_name || "").toLowerCase();
    const containsPinili = displayName.includes("pinili");
    return containsPinili || isWithinPiniliBounds(lat, lon);
  } catch {
    return isWithinPiniliBounds(lat, lon);
  }
}

function updateCoordinatesDisplay(lat, lon) {
  document.getElementById('location').value = `Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}`;
}

function clearCoordinates() {
  document.getElementById('location').value = "";
  document.getElementById('locationNote').textContent = "Location outside Pinili. Please select a valid area.";
  document.getElementById('locationNote').style.color = "red";
}

async function validateMarkerPosition() {
  const pos = marker.getLatLng();
  userHasMovedPin = true;
  const isInPinili = await checkIfInPinili(pos.lat, pos.lng);

  if (isInPinili) {
    updateCoordinatesDisplay(pos.lat, pos.lng);
    showHighlight(pos.lat, pos.lng);
    document.getElementById('locationNote').textContent = "Location validated ✓";
    document.getElementById('locationNote').style.color = "#2d7a2d";
  } else {
    alert("That location is outside Pinili municipality.");
    marker.setLatLng(centerPinili);
    map.setView(centerPinili, 14);
    removeHighlight();
    clearCoordinates();
    userHasMovedPin = false;
  }
}

marker.on('dragend', validateMarkerPosition);

function showHighlight(lat, lon) {
  removeHighlight();
  highlightCircle = L.circle([lat, lon], { radius: 25, color: 'black', weight: 2, fill: false }).addTo(map);
}

function removeHighlight() {
  if (highlightCircle) {
    map.removeLayer(highlightCircle);
    highlightCircle = null;
  }
}

async function markCurrentLocation() {
  if (!navigator.geolocation) {
    alert("Geolocation not supported.");
    return;
  }
  document.getElementById('locationNote').textContent = "Getting your location...";
  document.getElementById('locationNote').style.color = "#666";

  navigator.geolocation.getCurrentPosition(async (pos) => {
    const lat = pos.coords.latitude;
    const lon = pos.coords.longitude;
    const isInPinili = await checkIfInPinili(lat, lon);

    if (isInPinili) {
      userHasMovedPin = true;
      marker.setLatLng([lat, lon]);
      map.setView([lat, lon], 15);
      showHighlight(lat, lon);
      updateCoordinatesDisplay(lat, lon);
      document.getElementById('locationNote').textContent = "Location validated ✓";
      document.getElementById('locationNote').style.color = "#2d7a2d";
    } else {
      alert("You are outside Pinili municipality.");
      marker.setLatLng(centerPinili);
      map.setView(centerPinili, 14);
      removeHighlight();
      clearCoordinates();
      userHasMovedPin = false;
    }
  }, () => {
    alert("Unable to get your location.");
    clearCoordinates();
  }, { enableHighAccuracy: true });
}

function generateRefId() { return 'GAF-' + new Date().getTime(); }

function submitReport() {
  const coords = document.getElementById('location').value;
  const type = document.getElementById('incidentType').value;
  const desc = document.getElementById('description').value.trim();
  const mobile = document.getElementById('mobile').value.trim();

  if (!userHasMovedPin || !coords || !type || !desc) {
    alert('Please move the pin or use your current location, select a type, and describe the incident.');
    return;
  }

  const report = {
    refId: generateRefId(),
    location: coords,
    type,
    description: desc,
    mobile: mobile || "Not provided",
    createdAt: new Date().toISOString()
  };

  const existing = JSON.parse(localStorage.getItem('greenaf_reports') || '[]');
  existing.unshift(report);
  localStorage.setItem('greenaf_reports', JSON.stringify(existing));

  const display = document.getElementById('refIdDisplay');
  display.style.display = 'block';
  display.innerHTML = `Report submitted. Reference ID: <strong>${report.refId}</strong>`;

  document.getElementById('description').value = '';
  document.getElementById('incidentType').value = '';
  document.getElementById('fileUpload').value = '';
  document.getElementById('mobile').value = '';
  removeHighlight();
  marker.setLatLng(centerPinili);
  map.setView(centerPinili, 14);
  clearCoordinates();
  userHasMovedPin = false;
}
</script>
</body>
</html>
