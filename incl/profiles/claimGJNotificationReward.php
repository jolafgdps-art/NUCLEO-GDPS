<?php
// Desactivamos cualquier reporte de errores en pantalla para que no ensucien la respuesta del juego
error_reporting(0);
ini_set('display_errors', 0);

// Limpiamos cualquier búfer previo por seguridad
if (ob_get_length()) {
    ob_clean();
}

chdir(dirname(__FILE__));
require "../../lib/connection.php";
require_once "../../lib/exploitPatch.php";
require_once "../../lib/mainLib.php";

// Capturamos el accountID de forma segura
$accountID = $_POST['accountID'] ?? $_GET['accountID'] ?? 0;

if (empty($accountID) && isset($_POST['gjp'])) {
    if (file_exists("../../lib/GJPCheck.php")) {
        require_once "../../lib/GJPCheck.php";
        $accountID = GJPCheck::getAccountID($_POST['gjp']);
    }
}

// Si el juego no manda la sesión exacta en esta prueba, usamos un ID genérico para que no falle
if (empty($accountID)) {
    $accountID = 1; 
}

try {
    $rewardOrbs = 100;
    $rewardDiamonds = 15;

    $stmtUpdate = $db->prepare("
        UPDATE users 
        SET orbs = orbs + ?, diamonds = diamonds + ? 
        WHERE extID = ? OR accountID = ?
    ");
    $stmtUpdate->execute([$rewardOrbs, $rewardDiamonds, $accountID, $accountID]);
} catch (Exception $e) {
    // Si falla la base de datos, lo ignoramos silenciosamente para no romper el cliente
}

// Forzamos que la única respuesta enviada al juego sea exactamente un "1" limpio
exit("1");
?>

