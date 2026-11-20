<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/mainLib.php";

/**
 * Función avanzada para calcular el tiempo transcurrido exacto
 */
function getTimeAgo($timestamp) {
    if (!$timestamp) return "Recently";
    
    // Si la base de datos guarda la fecha como texto (ej: "1 day", "2 hours") o como timestamp numérico:
    if (!is_numeric($timestamp)) {
        return $timestamp; // Si ya es un texto descriptivo del GDPS, lo devolvemos tal cual
    }

    $diff = time() - (int)$timestamp;

    if ($diff < 5) {
        return "Just a moment";
    } elseif ($diff < 60) {
        return $diff . ($diff == 1 ? " second ago" : " seconds ago");
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ($mins == 1 ? " minute ago" : " minutes ago");
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ($hours == 1 ? " hour ago" : " hours ago");
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ($days == 1 ? " day ago" : " days ago");
    } elseif ($diff < 2592000) { 
        $weeks = floor($diff / 604800);
        return $weeks . ($weeks == 1 ? " week ago" : " weeks ago");
    } elseif ($diff < 31536000) { 
        $months = floor($diff / 2592000);
        return $months . ($months == 1 ? " month ago" : " months ago");
    } else {
        $years = floor($diff / 31536000);
        return $years . ($years == 1 ? " year ago" : " years ago");
    }
}

$notificationsArray = [];

try {
    // 1. Obtenemos los niveles y su columna real de fecha (uploadDate)
    $stmtLevels = $db->prepare("
        SELECT l.levelID, l.levelName, l.uploadDate, a.userName, a.accountID as creatorID 
        FROM levels l 
        JOIN accounts a ON l.extID = a.accountID 
        ORDER BY l.levelID DESC 
        LIMIT 10
    ");
    $stmtLevels->execute();
    $recentLevels = $stmtLevels->fetchAll(PDO::FETCH_ASSOC);

    foreach ($recentLevels as $lvl) {
        $notificationID = 800000 + (int)$lvl['levelID'];
        $notificationType = "13"; 
        $notificationIcon = "level";

        $title = "New Level!";
        $description = "@" . $lvl['userName'] . " has uploaded <cy>" . $lvl['levelName'] . "</cy>";

        $notificationTitle = ExploitPatch::url_base64_encode($title);
        $notificationDescription = ExploitPatch::url_base64_encode($description);

        // Usamos el tiempo real de la base de datos
        $notificationTime = getTimeAgo($lvl['uploadDate']);

        $notificationsArray[] = [
            'sortKey' => (int)$lvl['levelID'],
            'data' => "1:".$notificationID.":2:".$notificationType.":3:".$notificationIcon.":4:".$notificationTitle.":5:".$notificationDescription.":6:".$notificationTime.":7:1:8:0:9:0:10::11:0:12:0:13:0:14:0:15:".$lvl['creatorID']
        ];
    }
} catch (Exception $e) {}

try {
    // 2. Obtenemos las cuentas y su columna real de registro (registerDate o timestamp)
    // Nota: Si en tu tabla accounts la columna se llama diferente (ej. 'timestamp'), cámbiala aquí.
    $stmtAccounts = $db->prepare("
        SELECT accountID, userName, registerDate 
        FROM accounts 
        ORDER BY accountID DESC 
        LIMIT 10
    ");
    $stmtAccounts->execute();
    $recentAccounts = $stmtAccounts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($recentAccounts as $acc) {
        $notificationID = 900000 + (int)$acc['accountID'];
        $notificationType = "13"; 
        $notificationIcon = "profile";

        $title = "New User!";
        $description = "Welcome <cy>@" . $acc['userName'] . "</cy> to the server!";

        $notificationTitle = ExploitPatch::url_base64_encode($title);
        $notificationDescription = ExploitPatch::url_base64_encode($description);

        // Usamos el tiempo real de registro de la cuenta
        $notificationTime = getTimeAgo($acc['registerDate'] ?? time());

        $notificationsArray[] = [
            'sortKey' => (int)$acc['accountID'], 
            'data' => "1:".$notificationID.":2:".$notificationType.":3:".$notificationIcon.":4:".$notificationTitle.":5:".$notificationDescription.":6:".$notificationTime.":7:1:8:0:9:0:10::11:0:12:0:13:0:14:0:15:".$acc['accountID']
        ];
    }
} catch (Exception $e) {}

// Ordenamos todas las notificaciones combinadas cronológicamente
usort($notificationsArray, function($a, $b) {
    return $b['sortKey'] - $a['sortKey'];
});

$finalOutputArray = [];
foreach ($notificationsArray as $item) {
    $finalOutputArray[] = $item['data'];
}

if (empty($finalOutputArray)) {
    exit("#1:0:10");
}

exit(implode("|", $finalOutputArray)."#1:0:10");
?>

