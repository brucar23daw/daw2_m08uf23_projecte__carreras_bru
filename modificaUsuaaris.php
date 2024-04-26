<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

$atributos_modificables = [
    'uidNumber',
    'gidNumber',
    'Directori personal',
    'Shell',
    'cn',
    'sn',
    'givenName',
    'PostalAdress',
    'mobile',
    'telephoneNumber',
    'title',
    'description'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    $atributo_seleccionado = $_POST['atributo'];
    $nuevo_valor = $_POST['nuevo_valor'];
    
    $opciones = [
        'host' => 'zends-brcahe.fjeclot.net',
        'username' => 'cn=admin,dc=fjeclot,dc=net',
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    
    $ldap = new Ldap($opciones);
    $ldap->bind();
    
    $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';
    
    try {
        $entrada = $ldap->getEntry($dn);
        if ($entrada) {
            Attribute::setAttribute($entrada, $atributo_seleccionado, $nuevo_valor);
            $ldap->update($dn, $entrada);
            echo "<p><b>Atributo modificado exitosamente</b></p>";
        } else {
            echo "<p><b>Esta entrada no existe</b></p>";
        }
    } catch (Exception $e) {
        echo "<p><b>Error al modificar el atributo: " . $e->getMessage() . "</b></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificación de Atributos de Usuario LDAP</title>
</head>
<body>
    <h2>Modificación de Atributos de Usuario LDAP</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="uid">UID:</label>
        <input type="text" id="uid" name="uid" required><br><br>
        
        <label for="unorg">Unidad Organizativa:</label>
        <input type="text" id="unorg" name="unorg" required><br><br>

        <label>Atributo a Modificar:</label><br>
        <?php
        foreach ($atributos_modificables as $atributo) {
            echo "<input type='radio' id='$atributo' name='atributo' value='$atributo'>";
            echo "<label for='$atributo'>$atributo</label><br>";
        }
        ?>
        
        <label for="nuevo_valor">Nuevo Valor:</label>
        <input type="text" id="nuevo_valor" name="nuevo_valor" required><br><br>
        
        <input type="submit" value="Modificar Atributo">
        <br>
		<a href="https://zends-brcahe.fjeclot.net/autent/index.php">Torna a la pàgina inicial</a>
    </form>
</body>
</html>
