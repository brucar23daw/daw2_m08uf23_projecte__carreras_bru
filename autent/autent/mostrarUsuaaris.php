<!DOCTYPE html>
<html>
<head>
    <title>Visualización de datos de usuario LDAP</title>
</head>
<body>
    <h2>Visualización de datos de usuario LDAP</h2>
    <form action="" method="GET">
        <label for="ou">Unitat organitzativa:</label>
        <input type="text" id="ou" name="ou" required><br>
        <label for="usr">Usuari:</label>
        <input type="text" id="usr" name="usr" required><br>
        <input type="submit" value="Mostrar datos">
        <input type="reset" value="Limpiar">
    </form>

    <?php
    require 'vendor/autoload.php';
    use Laminas\Ldap\Ldap;
    ini_set('display_errors', 0);

    if ($_GET['usr'] && $_GET['ou']){
        $domini = 'dc=fjeclot,dc=net';
        $opcions = [
            'host' => 'zends-brcahe.fjeclot.net',
            'username' => "cn=admin,$domini",
            'password' => 'fjeclot',
            'bindRequiresDn' => true,
            'accountDomainName' => 'fjeclot.net',
            'baseDn' => 'dc=fjeclot,dc=net',
        ];
        $ldap = new Ldap($opcions);
        $ldap->bind();
        $entrada='uid='.$_GET['usr'].',ou='.$_GET['ou'].',dc=fjeclot,dc=net';
        $usuari=$ldap->getEntry($entrada);

        echo "<h3>Datos del usuario:</h3>";
        echo "<b><u>".$usuari["dn"]."</b></u><br>";
        foreach ($usuari as $atribut => $dada) {
            if ($atribut != "dn") echo $atribut.": ".$dada[0].'<br>';
        }
    }
    ?>
</body>
</html>
