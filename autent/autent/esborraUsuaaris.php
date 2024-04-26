<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

// Verifica si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    
    // Configura la conexión LDAP y otros datos necesarios
    $opciones = [
        'host' => 'zends-brcahe.fjeclot.net',
        'username' => 'cn=admin,dc=fjeclot,dc=net',
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];

    // Crea una instancia LDAP y realiza la conexión
    $ldap = new Ldap($opciones);
    $ldap->bind();

    // DN de la entrada a borrar
    $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';

    // Intento de borrar la entrada LDAP
    try {
        $ldap->delete($dn);
        echo "<p><b>Entrada borrada</b></p>"; 
    } catch (Exception $e) {
        echo "<p><b>Esta entrada no existe</b></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Borrado de Usuario LDAP</title>
</head>
<body>
    <h2>Formulario de Borrado de Usuario LDAP</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="uid">UID:</label>
        <input type="text" id="uid" name="uid" required><br><br>
        
        <label for="unorg">Unidad Organizativa:</label>
        <input type="text" id="unorg" name="unorg" required><br><br>
        
        <input type="submit" value="Borrar Usuario">
        <br>
		<a href="https://zends-brcahe.fjeclot.net/autent/index.php">Torna a la pàgina inicial</a>
    </form>
</body>
</html>
