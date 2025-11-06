<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$host = 'localhost';
$dbname = 'greenaf_db';
$db_username = 'root';
$db_password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    header('Content-Type: application/json');
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit();
    }

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit();
    }

    $stmt = $pdo->prepare("
        SELECT admin_id, username, email, password_hash, full_name, role, is_active 
        FROM admins 
        WHERE email = ? AND username = ? AND is_active = 1
        LIMIT 1
    ");
    $stmt->execute([$email, $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin || !password_verify($password, $admin['password_hash'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid username, email, or password']);
        exit();
    }

    $pdo->prepare("UPDATE admins SET last_login = NOW() WHERE admin_id = ?")->execute([$admin['admin_id']]);

    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['email'] = $admin['email'];
    $_SESSION['username'] = $admin['username'];
    $_SESSION['full_name'] = $admin['full_name'];
    $_SESSION['role'] = $admin['role'];
    $_SESSION['login_time'] = date('Y-m-d H:i:s');

    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'user' => $admin
    ]);
    exit();
}

if (isset($_SESSION['admin_id'])) {
    header('Location: adminreports.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GreenAF - Admin Login</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
body { display:flex; align-items:center; justify-content:center; min-height:100vh; background:#e7f0db; }
.login-container { background:white; padding:40px 30px; border-radius:16px; box-shadow:0 10px 25px rgba(0,0,0,0.1); width:100%; max-width:400px; }
.login-header { text-align:center; margin-bottom:30px; }
.login-header h2 { color:#3d562b; margin-bottom:6px; }
.login-header p { color:#666; font-size:14px; }
.form-group { margin-bottom:20px; }
.form-group label { display:block; margin-bottom:6px; font-weight:500; color:#333; }
.form-group input { width:100%; padding:12px 15px; border:1.5px solid #ccc; border-radius:8px; font-size:14px; transition:0.3s; }
.form-group input:focus { outline:none; border-color:#3d562b; box-shadow:0 0 6px rgba(61,86,43,0.2); }
.btn-login { width:100%; padding:12px; background:#3d562b; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; transition:0.3s; }
.btn-login:hover { background:#5a7848; }
.alert { padding:10px 12px; border-radius:6px; margin-bottom:15px; font-size:14px; display:none; }
.alert.show { display:block; }
.alert-error { background:#ffe6e6; color:#c00; border:1px solid #fcc; }
.alert-success { background:#e6ffe6; color:#060; border:1px solid #cfc; }
.back-home { text-align:center; margin-top:15px; font-size:13px; }
.back-home a { color:#3d562b; text-decoration:none; }
.back-home a:hover { text-decoration:underline; }
</style>
</head>
<body>

<div class="login-container">
  <div class="login-header">
    <h2>GreenAF Admin</h2>
    <p>Sign in to access your dashboard</p>
  </div>

  <div id="alertBox" class="alert"></div>

  <form id="loginForm" onsubmit="handleLogin(event)">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Enter your username" required autocomplete="username">
    </div>

    <div class="form-group">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required autocomplete="email">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
    </div>

    <button type="submit" class="btn-login" id="loginBtn">Login</button>
  </form>

  <div class="back-home"><a href="home.php">← Back to Home</a></div>
</div>

<script>
function showAlert(msg, type='error') {
  const box=document.getElementById('alertBox');
  box.className=`alert alert-${type} show`;
  box.textContent=msg;
  setTimeout(()=>box.classList.remove('show'),5000);
}

function handleLogin(e){
  e.preventDefault();
  const username=document.getElementById('username').value.trim();
  const email=document.getElementById('email').value.trim();
  const password=document.getElementById('password').value.trim();
  const btn=document.getElementById('loginBtn');
  if(!username||!email||!password){showAlert('Please fill in all fields');return;}
  btn.textContent='Logging in...';btn.disabled=true;
  const fd=new FormData();
  fd.append('action','login');
  fd.append('username',username);
  fd.append('email',email);
  fd.append('password',password);
  fetch('adminlogin.php',{method:'POST',body:fd})
  .then(r=>r.json())
  .then(d=>{
    if(d.success){
      showAlert(`Welcome back, ${d.user.full_name}!`,'success');
      setTimeout(()=>window.location.href='adminreports.php',1000);
    }else{
      showAlert(d.message||'Login failed');
      btn.textContent='Login';btn.disabled=false;
    }
  })
  .catch(()=>{
    showAlert('Connection error.');
    btn.textContent='Login';btn.disabled=false;
  });
}
</script>
</body>
</html>
