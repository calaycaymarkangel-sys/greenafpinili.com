<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>GreenAF - About Us</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<style>
* { box-sizing:border-box; margin:0; padding:0; font-family:"Poppins",sans-serif; }

body { background:#f9f9f9; color:#1a1a1a; overflow-x:hidden; }

/* HEADER */
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
nav a:hover::after, nav a.active::after { width:100%; }

/* BURGER MENU */
.line-icon { width:25px; height:3px; background:#fff; cursor:pointer; border-radius:2px; position:relative; display:none; transition:0.3s; }
.line-icon::before, .line-icon::after { content:""; position:absolute; left:0; width:25px; height:3px; background:#fff; border-radius:2px; transition:0.3s; }
.line-icon::before { top:-8px; }
.line-icon::after { top:8px; }
.line-icon.active { background-color:transparent; }
.line-icon.active::before { transform:rotate(45deg); top:0; }
.line-icon.active::after { transform:rotate(-45deg); top:0; }

@media(max-width:768px){
  header{padding:12px 18px;}
  nav ul{display:none; position:absolute; top:60px; right:20px; background:#3d562b; border-radius:6px; padding:15px; flex-direction:column; gap:15px; text-align:right; box-shadow:0 4px 10px rgba(0,0,0,0.3);}
  nav ul.active{display:flex;}
  .line-icon{display:block;}
}

/* MAIN */
main { padding:40px 20px 60px; max-width:980px; margin:auto; position:relative; z-index:1; }
.section { margin-bottom:40px; }
h1, h2, h3 { color:#3d562b; margin-bottom:12px; }
h1 { font-size:2rem; }
h2 { font-size:1.5rem; }
h3 { font-size:1.2rem; }
p { margin-bottom:12px; font-size:0.95rem; line-height:1.5; }

.card-container { display:flex; flex-wrap:wrap; gap:20px; margin-top:20px; }
.card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.08); flex:1 1 250px; min-width:250px; }

.icon-circle { width:50px; height:50px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.5rem; color:#fff; margin-bottom:10px; }

.mission .icon-circle { background:#5a7848; }
.features .icon-circle { background:#3d562b; }
.team .icon-circle { background:#b6e388; }
.contact .icon-circle { background:#2d7a2d; }

ul { padding-left:20px; }
ul li { margin-bottom:8px; }

@media(max-width:768px){
  .card-container { flex-direction:column; }
}
</style>
</head>
<body>

<header>
  <div class="logo">GreenAF</div>
  <nav>
    <ul id="nav-links">
      <li><a href="adminhome.php">HOME</a></li>
      <li><a href="adminreports.php">REPORT</a></li>
      <li><a href="#" class="active">ABOUT US</a></li>
    </ul>
    <div class="line-icon" id="treeIcon" onclick="toggleNav()"></div>
  </nav>
</header>

<main>
  <!-- Mission Section -->
  <section class="section mission">
    <h1>About GreenAF</h1>
    <div class="card">
      <div class="icon-circle">🌿</div>
      <h2>Our Mission</h2>
      <p>GreenAF is a community-driven platform that empowers residents of Pinili, Ilocos Norte to report environmental incidents in real-time. Our mission is to keep the town clean, safe, and sustainable.</p>
    </div>
  </section>

  <!-- Features Section -->
  <section class="section features">
    <h2>What We Do</h2>
    <div class="card-container">
      <div class="card">
        <div class="icon-circle">📍</div>
        <h3>Report Incidents</h3>
        <p>Submit anonymous reports with accurate location tagging to help the community act fast.</p>
      </div>
      <div class="card">
        <div class="icon-circle">🔵</div>
        <h3>Track Status</h3>
        <p>Monitor the incident status: Submitted → Accepted → Completed, with live updates on the map.</p>
      </div>
      <div class="card">
        <div class="icon-circle">📊</div>
        <h3>Community Awareness</h3>
        <p>Keep residents informed and accountable, fostering a cleaner and safer environment.</p>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section class="section team">
    <h2>Meet the Team</h2>
    <div class="card-container">
      <div class="card">
        <div class="icon-circle">👨‍💻</div>
        <h3>Mark Angel Calaycay</h3>
        <p>Developer & Designer - Passionate about building tools for community-driven environmental protection.</p>
      </div>
      <div class="card">
        <div class="icon-circle">👨‍💻</div>
        <h3>Diom Mangrubang</h3>
        <p>Developer & Designer - Passionate about building tools for community-driven environmental protection.</p>
      </div>
      <div class="card">
        <div class="icon-circle">👩‍💻</div>
        <h3>Kristine Mae Miguel</h3>
        <p>Developer & Designer - Passionate about building tools for community-driven environmental protection.</p>
      </div>
      <div class="card">
        <div class="icon-circle">👩‍💻</div>
        <h3>Danica Vidad</h3>
        <p>Developer & Designer - Passionate about building tools for community-driven environmental protection.</p>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="section contact">
    <h2>Get Involved / Contact Us</h2>
    <div class="card">
      <div class="icon-circle">✉️</div>
      <p>Email: info@greenaf.com</p>
      <p>Join us in protecting the environment — report incidents, stay informed, and help Pinili thrive!</p>
    </div>
  </section>
</main>

<script>
function toggleNav() {
  const nav = document.getElementById("nav-links");
  const icon = document.getElementById("treeIcon");
  nav.classList.toggle("active");
  icon.classList.toggle("active");
}
</script>

</body>
</html>
