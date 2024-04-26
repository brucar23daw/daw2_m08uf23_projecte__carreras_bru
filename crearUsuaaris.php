<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    $uidNumber = $_POST['uidNumber'];
    $gidNumber = $_POST['gidNumber'];
    $dir_pers = $_POST['dir_pers'];
    $sh = $_POST['sh'];
    $cn = $_POST['cn'];
    $sn = $_POST['sn'];
    $nom = $_POST['nom'];
    $mobil = $_POST['mobil'];
    $adressa = $_POST['adressa'];
    $telefon = $_POST['telefon'];
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    
    // Configura la conexión LDAP y otros datos necesarios
    $domini = 'dc=fjeclot,dc=net';
    $opciones = [
        'host' => 'zends-brcahe.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];

    // Crea una instancia LDAP y realiza la conexión
    $ldap = new Ldap($opciones);
    $ldap->bind();

    // Construye la entrada LDAP utilizando los datos del formulario
    $nova_entrada = [];
    Attribute::setAttribute($nova_entrada, 'objectClass', ['inetOrgPerson', 'organizationalPerson', 'person', 'posixAccount', 'shadowAccount', 'top']);
    Attribute::setAttribute($nova_entrada, 'uid', $uid);
    Attribute::setAttribute($nova_entrada, 'uidNumber', $uidNumber);
    Attribute::setAttribute($nova_entrada, 'gidNumber', $gidNumber);
    Attribute::setAttribute($nova_entrada, 'homeDirectory', $dir_pers);
    Attribute::setAttribute($nova_entrada, 'loginShell', $sh);
    Attribute::setAttribute($nova_entrada, 'cn', $cn);
    Attribute::setAttribute($nova_entrada, 'sn', $sn);
    Attribute::setAttribute($nova_entrada, 'givenName', $nom);
    Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
    Attribute::setAttribute($nova_entrada, 'postalAddress', $adressa);
    Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
    Attribute::setAttribute($nova_entrada, 'title', $titol);
    Attribute::setAttribute($nova_entrada, 'description', $descripcio);

    // DN de la nueva entrada
    $dn = 'uid=' . $uid . ',ou=' . $unorg . ',' . $domini;

    // Intento de añadir la nueva entrada LDAP
    if ($ldap->add($dn, $nova_entrada)) {
        echo "Usuario creado exitosamente.";
    } else {
        echo "Hubo un error al crear el usuario.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Creación de Usuario LDAP</title>
</head>
<body>
    <h2>Formulario de Creación de Usuario LDAP</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="uid">UID:</label>
        <input type="text" id="uid" name="uid" required><br><br>
        
        <label for="unorg">Unidad Organizativa:</label>
        <input type="text" id="unorg" name="unorg" required><br><br>
        
        <label for="uidNumber">UID Number:</label>
        <input type="number" id="uidNumber" name="uidNumber" required><br><br>

        <label for="gidNumber">GID Number:</label>
        <input type="number" id="gidNumber" name="gidNumber" required><br><br>
        
        <label for="dir_pers">Directorio Personal:</label>
        <input type="text" id="dir_pers" name="dir_pers" required><br><br>
        
        <label for="sh">Shell:</label>
        <input type="text" id="sh" name="sh" required><br><br>
        
        <label for="cn">Nombre Completo:</label>
        <input type="text" id="cn" name="cn" required><br><br>
        
        <label for="sn">Apellido:</label>
        <input type="text" id="sn" name="sn" required><br><br>

        <label for="nom">Nombre:</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="mobil">Teléfono Móvil:</label>
        <input type="tel" id="mobil" name="mobil"><br><br>

        <label for="adressa">Dirección Postal:</label>
        <input type="text" id="adressa" name="adressa"><br><br>

        <label for="telefon">Teléfono:</label>
        <input type="tel" id="telefon" name="telefon"><br><br>

        <label for="titol">Título:</label>
        <input type="text" id="titol" name="titol"><br><br>

        <label for="descripcio">Descripción:</label>
        <input type="text" id="descripcio" name="descripcio"><br><br>

        <input type="submit" value="Crear Usuario">
        <br>
		<a href="https://zends-brcahe.fjeclot.net/autent/index.php">Torna a la pàgina inicial</a>
    </form>
</body>
</html>
