<?php
// Configuración de la ruta del Dashboard
$dashboard_path = "../dashboard";

// Verifica si la ruta existe en el servidor
$dashboard_exists = is_dir(__DIR__ . '/' . $dashboard_path) || file_exists(__DIR__ . '/' . $dashboard_path);
$redirect_url = $dashboard_exists ? $dashboard_path : "#";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Panel de Control</title>
    <!-- Fuentes Cyberpunk/Futuristas -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #070913;
            --card-bg: rgba(13, 17, 33, 0.75);
            --neon-cyan: #00f3ff;
            --neon-purple: #9d00ff;
            --text-main: #e2e8f0;
            --text-dim: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Rajdhani', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Fondo animado de malla cybertéchica */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 50% 50%, rgba(157, 0, 255, 0.12), transparent 50%),
                radial-gradient(circle at 20% 20%, rgba(0, 243, 255, 0.1), transparent 40%),
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
            animation: gridMove 20s linear infinite;
            z-index: 0;
        }

        @keyframes gridMove {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(1deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }

        /* Tarjeta Cyber Glassmorphism */
        .glass-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            padding: 2.5rem;
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 243, 255, 0.2);
            border-radius: 16px;
            box-shadow: 
                0 0 30px rgba(0, 0, 0, 0.8),
                inset 0 0 15px rgba(0, 243, 255, 0.05);
            text-align: center;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(0, 243, 255, 0.1);
            border: 1px solid var(--neon-cyan);
            border-radius: 20px;
            font-size: 0.85rem;
            letter-spacing: 2px;
            color: var(--neon-cyan);
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: var(--neon-cyan);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--neon-cyan);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.8); }
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 0.8rem;
            background: linear-gradient(135deg, #ffffff 0%, var(--neon-cyan) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 243, 255, 0.3);
        }

        p {
            color: var(--text-dim);
            font-size: 1.05rem;
            line-height: 1.5;
            margin-bottom: 2rem;
        }

        /* Barra de carga de redirección */
        .progress-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--neon-purple), var(--neon-cyan));
            box-shadow: 0 0 12px var(--neon-cyan);
            transition: width 0.1s linear;
        }

        /* Botón Futurista */
        .btn-action {
            display: inline-block;
            width: 100%;
            padding: 14px 28px;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            color: #ffffff;
            background: linear-gradient(135deg, rgba(157, 0, 255, 0.6) 0%, rgba(0, 243, 255, 0.6) 100%);
            border: 1px solid var(--neon-cyan);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(0, 243, 255, 0.2);
        }

        .btn-action:hover {
            box-shadow: 0 0 25px rgba(0, 243, 255, 0.6);
            transform: translateY(-2px);
            background: linear-gradient(135deg, rgba(157, 0, 255, 0.8) 0%, rgba(0, 243, 255, 0.8) 100%);
        }

        .error-msg {
            color: #ff4757;
            border-color: #ff4757;
            background: rgba(255, 71, 87, 0.1);
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <?php if ($dashboard_exists): ?>
            <div class="status-badge">
                <span class="status-dot"></span> Sistema En Línea
            </div>
            
            <h1>GESTIÓN DE CUENTA</h1>
            <p>Conectando con el servidor central para abrir tu panel de usuario...</p>

            <div class="progress-container">
                <div class="progress-bar" id="progressBar"></div>
            </div>

            <a href="<?php echo htmlspecialchars($redirect_url); ?>" class="btn-action">
                Ingresar al Dashboard
            </a>
        <?php else: ?>
            <div class="status-badge error-msg">
                <span class="status-dot" style="background:#ff4757; box-shadow:0 0 8px #ff4757;"></span> Error de Ruta
            </div>
            <h1>DASHBOARD NO ENCONTRADO</h1>
            <p>No se localizó la carpeta o archivo del Dashboard en la dirección <code>../dashboard</code>.</p>
        <?php endif; ?>
    </div>

    <?php if ($dashboard_exists): ?>
    <script>
        const redirectUrl = "<?php echo $redirect_url; ?>";
        const duration = 2500; // Tiempo en ms (2.5 segundos)
        const progressBar = document.getElementById('progressBar');
        let startTime = null;

        function animateProgress(timestamp) {
            if (!startTime) startTime = timestamp;
            const elapsed = timestamp - startTime;
            const progress = Math.min((elapsed / duration) * 100, 100);
            
            progressBar.style.width = progress + '%';

            if (elapsed < duration) {
                requestAnimationFrame(animateProgress);
            } else {
                window.location.href = redirectUrl;
            }
        }

        requestAnimationFrame(animateProgress);
    </script>
    <?php endif; ?>

</body>
</html>
