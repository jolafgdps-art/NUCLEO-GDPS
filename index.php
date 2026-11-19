<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to GDPS</title>
  <style>
    :root {
      color-scheme: dark;
      --cyan: #00f0ff;
      --blue: #2563eb;
      --purple: #9d4edd;
      --text: #f0f6fc;
      --muted: #8b949e;
    }
    * { box-sizing: border-box; }
    html, body { min-height: 100%; }
    body {
      margin: 0;
      min-height: 100vh;
      display: grid;
      place-items: center;
      overflow: hidden;
      color: var(--text);
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background:
        radial-gradient(circle at 20% 20%, rgba(0,240,255,.12), transparent 40%),
        radial-gradient(circle at 80% 80%, rgba(157,78,221,.12), transparent 40%),
        linear-gradient(135deg, #020617 0%, #050b18 55%, #030712 100%);
    }
    
    /* Cybernetic Grid Matrix */
    body::before {
      content: "";
      position: fixed;
      inset: 0;
      pointer-events: none;
      opacity: .28;
      background-image:
        linear-gradient(rgba(0,240,255,.08) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,240,255,.08) 1px, transparent 1px);
      background-size: 48px 48px;
      mask-image: radial-gradient(circle at center, #000 45%, transparent 90%);
    }

    /* Holographic Rotating Orbits */
    .orbit, .orbit::before, .orbit::after {
      position: fixed;
      content: "";
      border: 1px dashed rgba(0,240,255,.18);
      border-radius: 50%;
      pointer-events: none;
      animation: spinOrbit 70s linear infinite;
    }
    .orbit { width: 600px; height: 600px; }
    .orbit::before { inset: 55px; animation-duration: 50s; animation-direction: reverse; border-color: rgba(157,78,221,.18); }
    .orbit::after { inset: 120px; animation-duration: 35s; border-color: rgba(0,240,255,.25); }

    @keyframes spinOrbit {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* Sci-Fi HUD Card Container */
    .card {
      position: relative;
      z-index: 10;
      width: min(92vw, 600px);
      padding: 56px 44px 40px;
      text-align: center;
      background: linear-gradient(145deg, rgba(8, 15, 31, 0.9), rgba(3, 7, 18, 0.95));
      border: 1px solid rgba(0, 240, 255, 0.35);
      border-radius: 16px;
      box-shadow: 
        0 0 0 1px rgba(157, 78, 221, 0.15), 
        0 0 60px rgba(0, 240, 255, 0.15), 
        inset 0 0 35px rgba(0, 240, 255, 0.04);
      backdrop-filter: blur(16px);
    }

    /* HUD Corner Tech Brackets */
    .card::before, .card::after {
      content: "";
      position: absolute;
      width: 14px;
      height: 14px;
      border-color: var(--cyan);
      border-style: solid;
      pointer-events: none;
    }
    .card::before { top: -2px; left: -2px; border-width: 2px 0 0 2px; }
    .card::after { bottom: -2px; right: -2px; border-width: 0 2px 2px 0; }

    /* Status Badge */
    .status {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 6px 16px;
      background: rgba(0, 240, 255, 0.05);
      border: 1px solid rgba(0, 240, 255, 0.35);
      border-radius: 6px;
      color: var(--cyan);
      font-size: 10px;
      font-weight: 800;
      letter-spacing: .2em;
      text-transform: uppercase;
      box-shadow: 0 0 15px rgba(0,240,255,0.1);
    }
    .status::before { 
      content: ""; 
      width: 6px; 
      height: 6px; 
      border-radius: 50%; 
      background: #10b981; 
      box-shadow: 0 0 12px #10b981, 0 0 24px #10b981; 
    }

    /* Typography */
    h1 {
      margin: 24px 0 14px;
      font-size: clamp(2.2rem, 6.5vw, 3.8rem);
      line-height: 1.02;
      letter-spacing: .08em;
      text-transform: uppercase;
      text-shadow: 0 0 30px rgba(0, 240, 255, 0.4);
    }
    .accent { 
      color: var(--cyan);
      background: linear-gradient(90deg, var(--cyan), #c084fc);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .subtitle { 
      margin: 0 auto 32px; 
      max-width: 430px; 
      color: var(--muted); 
      font-size: 14px; 
      line-height: 1.7; 
      letter-spacing: 0.02em;
    }

    /* Cyber Dashboard Button */
    .dashboard {
      position: relative;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      min-width: 240px;
      padding: 15px 26px;
      color: #020617;
      background: linear-gradient(135deg, var(--cyan), #38bdf8 50%, #a855f7);
      border-radius: 8px;
      box-shadow: 0 0 30px rgba(0, 240, 255, 0.3);
      font-size: 12px;
      font-weight: 900;
      letter-spacing: .15em;
      text-decoration: none;
      text-transform: uppercase;
      transition: transform .25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow .25s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
    }
    .dashboard::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
      transform: translateX(-100%);
      transition: transform 0.6s ease;
    }
    .dashboard:hover { 
      transform: translateY(-3px); 
      box-shadow: 0 0 50px rgba(0, 240, 255, 0.6); 
    }
    .dashboard:hover::after {
      transform: translateX(100%);
    }

    /* Footer */
    footer {
      margin-top: 40px;
      color: #64748b;
      font-size: 10px;
      letter-spacing: .15em;
      text-transform: uppercase;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
    }
    .powered-btn {
      background: rgba(0, 240, 255, 0.05);
      border: 1px solid rgba(0, 240, 255, 0.2);
      color: var(--cyan);
      font-family: inherit;
      font-size: 9px;
      font-weight: 700;
      letter-spacing: .15em;
      text-transform: uppercase;
      padding: 6px 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: all .2s ease;
    }
    .powered-btn:hover {
      background: rgba(0, 240, 255, 0.15);
      border-color: var(--cyan);
      box-shadow: 0 0 20px rgba(0, 240, 255, 0.3);
      transform: translateY(-2px);
    }

    /* Futuristic Modal Overlay & Card */
    .modal-overlay {
      position: fixed;
      inset: 0;
      z-index: 100;
      background: rgba(2, 6, 23, 0.8);
      backdrop-filter: blur(10px);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }
    .modal-overlay.active {
      opacity: 1;
      pointer-events: auto;
    }
    .modal-box {
      width: min(90vm, 430px);
      background: linear-gradient(145deg, rgba(11, 20, 38, 0.95), rgba(3, 7, 18, 0.98));
      border: 1px solid rgba(0, 240, 255, 0.4);
      border-radius: 16px;
      padding: 30px 24px;
      text-align: center;
      box-shadow: 0 0 60px rgba(0, 240, 255, 0.25);
      transform: scale(0.92) translateY(10px);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .modal-overlay.active .modal-box {
      transform: scale(1) translateY(0);
    }
    .modal-title {
      font-size: 1.05rem;
      font-weight: 900;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--cyan);
      margin-bottom: 12px;
    }
    .modal-text {
      font-size: 13px;
      color: var(--text);
      line-height: 1.6;
      margin-bottom: 22px;
      text-transform: none;
      letter-spacing: normal;
    }
    .modal-text a {
      color: var(--cyan);
      text-decoration: none;
      border-bottom: 1px dotted var(--cyan);
      word-break: break-all;
      transition: color 0.2s;
    }
    .modal-text a:hover {
      color: #38bdf8;
    }
    .modal-close {
      background: linear-gradient(135deg, var(--cyan), #38bdf8);
      border: none;
      color: #020617;
      font-weight: 900;
      font-size: 10px;
      letter-spacing: .15em;
      text-transform: uppercase;
      padding: 9px 24px;
      border-radius: 6px;
      cursor: pointer;
      box-shadow: 0 0 20px rgba(0, 240, 255, 0.3);
      transition: opacity 0.2s ease, transform 0.2s ease;
    }
    .modal-close:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }
    @media (max-width: 520px) { .card { padding: 40px 20px 28px; } .orbit { width: 340px; height: 340px; } }
  </style>
</head>
<body>
  <div class="orbit" aria-hidden="true"></div>
  <main class="card">
    <div class="status">System Online</div>
    <h1>Welcome<br><span class="accent">to GDPS</span></h1>
    <p class="subtitle">Your Geometry Dash Private Server is ready. Enter the control panel to start managing your server.</p>
    <a class="dashboard" href="/dashboard">🚀 Open Dashboard</a>
    <footer>
      <div>Rights : GDPS CORE BY JOLAF 2026</div>
      <button class="powered-btn" onclick="openModal()">⚡ Powered by GDPS Core</button>
    </footer>
  </main>

  <!-- Floating Modal Window -->
  <div class="modal-overlay" id="gdpsModal" onclick="closeModalOnOverlay(event)">
    <div class="modal-box">
      <div class="modal-title">GDPS Management Panel</div>
      <p class="modal-text">
        Welcome to the GDPS management panel! This GDPS was created with GDPS Core. If you want to make your own GDPS, go to <a href="https://jolafgdpscore.netlify.app/" target="_blank" rel="noopener">https://jolafgdpscore.netlify.app/</a>
      </p>
      <button class="modal-close" onclick="closeModal()">Close</button>
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById('gdpsModal').classList.add('active');
    }
    function closeModal() {
      document.getElementById('gdpsModal').classList.remove('active');
    }
    function closeModalOnOverlay(e) {
      if (e.target.id === 'gdpsModal') {
        closeModal();
      }
    }
  </script>
</body>
</html>

