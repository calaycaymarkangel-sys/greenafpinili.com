<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GreenAF - Ilocos Pinili</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<!-- CSS (with cache-busting to force reload) -->
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<header>
  <div class="logo">GreenAF</div>
  <nav>
    <ul id="nav-links">
      <li><a href="#home">HOME</a></li>
      <li><a href="map.php">MAP</a></li>
      <li><a href="report.php">REPORT</a></li>
      <li><a href="about.php">ABOUT US</a></li>
    </ul>
    <div class="line-icon" id="treeIcon" onclick="toggleNav()"></div>
  </nav>
</header>

<section class="hero" id="home">
  <div class="hero-content">
    <h2>Environmental and Community Issue Reporting System for Ilocos Pinili, Ilocos Norte</h2>
  </div>
</section>

<section class="image-section">
  <div class="image-wrap">
    <img id="envImage" src="images/image1.jpg" alt="Philippine Nature Image" />
    <div class="overlay" id="advocacyText">Protecting nature begins in our own community.</div>
  </div>
</section>

<script>
function toggleNav() {
  const nav = document.getElementById("nav-links");
  const icon = document.getElementById("treeIcon");
  nav.classList.toggle("active");
  icon.classList.toggle("active");
}

const images = [
  "images/mak.jpg",
  "images/net.jpg",
  "images/plant.jpg",
  "images/jek.jpg"
];

const advocacies = [
  "Salakniban tayo dagiti kakaykayuan ta da met ti mangsalaknib iti biagtayo ken ti komunidad tayo.",
  "No agmula tayo iti kayo ita nga aldaw, masigurado tayo ti nasayaat ken nadekket a masakbayan.",
  "Ti kinadalus ket saan laeng a panaglinis ti aglawlaw, nudiket panangipakita ti respeto iti biag ken iti kapwa.",
  "Ti aglawlaw ket isu ti pagtaengan tayo amin — awan ti panagbiag no mapukaw daytoy, isunga aywanan ken salakniban tayo."
];

const imgEl = document.getElementById("envImage");
const advText = document.getElementById("advocacyText");

function updateContent() {
  const randomImg = images[Math.floor(Math.random() * images.length)];
  const randomText = advocacies[Math.floor(Math.random() * advocacies.length)];

  imgEl.style.opacity = 0;
  setTimeout(() => {
    imgEl.src = randomImg;
    imgEl.onload = () => imgEl.style.opacity = 1;
    advText.textContent = randomText;
  }, 300);
}

// Initial load
updateContent();
setInterval(updateContent, 10000);
</script>

</body>
</html>
