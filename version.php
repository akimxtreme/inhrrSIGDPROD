<?php
/****** browser engine detection **************/
//browsers
define("UNKNOWN", 0);
define("TRIDENT", 1);
define("GECKO", 2);
define("PRESTO", 3);
define("WEBKIT", 4);
define("VALIDATOR", 5);
define("ROBOTS", 6);

if(!isset($_SESSION["info"]['browser'])) {
    $_SESSION["info"]['browser']['engine'] = UNKNOWN;
    $_SESSION["info"]['browser']['version'] = UNKNOWN;
    $_SESSION["info"]['browser']['platform'] = 'Unknown';

    $navigator_user_agent = ' ' . strtolower($_SERVER['HTTP_USER_AGENT']);

    if (strpos($navigator_user_agent, 'linux')) :
        $_SESSION["info"]['browser']['platform'] = 'Linux';
    elseif (strpos($navigator_user_agent, 'mac')) :
        $_SESSION["info"]['browser']['platform'] = 'Mac';
    elseif (strpos($navigator_user_agent, 'win')) :
        $_SESSION["info"]['browser']['platform'] = 'Windows';
    endif;

    if (strpos($navigator_user_agent, "trident")) {
        $_SESSION["info"]['browser']['engine'] = TRIDENT;
        $_SESSION["info"]['browser']['version'] = floatval(substr($navigator_user_agent, strpos($navigator_user_agent, "trident/") + 8, 3));
    }
    elseif (strpos($navigator_user_agent, "webkit")) {
        $_SESSION["info"]['browser']['engine'] = WEBKIT;
        $_SESSION["info"]['browser']['version'] = floatval(substr($navigator_user_agent, strpos($navigator_user_agent, "webkit/") + 7, 8));
    }
        elseif (strpos($navigator_user_agent, "presto")) {
        $_SESSION["info"]['browser']['engine'] = PRESTO;
        $_SESSION["info"]['browser']['version'] = floatval(substr($navigator_user_agent, strpos($navigator_user_agent, "presto/") + 6, 7));
    }
    elseif (strpos($navigator_user_agent, "gecko")) {
        $_SESSION["info"]['browser']['engine'] = GECKO;
        $_SESSION["info"]['browser']['version'] = floatval(substr($navigator_user_agent, strpos($navigator_user_agent, "gecko/") + 6, 9));
    }
    elseif (strpos($navigator_user_agent, "robot"))
        $_SESSION["info"]['browser']['engine'] = ROBOTS;
    elseif (strpos($navigator_user_agent, "spider"))
        $_SESSION["info"]['browser']['engine'] = ROBOTS;
    elseif (strpos($navigator_user_agent, "bot"))
        $_SESSION["info"]['browser']['engine'] = ROBOTS;
    elseif (strpos($navigator_user_agent, "crawl"))
        $_SESSION["info"]['browser']['engine'] = ROBOTS;
    elseif (strpos($navigator_user_agent, "search"))
        $_SESSION["info"]['browser']['engine'] = ROBOTS;
    elseif (strpos($navigator_user_agent, "w3c_validator"))
        $_SESSION["info"]['browser']['engine'] = VALIDATOR;
    elseif (strpos($navigator_user_agent, "jigsaw"))
        $_SESSION["info"]['browser']['engine'] = VALIDATOR;

echo "<pre>\n\nEngine detected: ".$_SESSION["info"]['browser']['engine'];
switch($_SESSION["info"]['browser']['engine']) {
    case UNKNOWN: echo " (unknown)";
    break;
    case TRIDENT: echo " (trident)";
    break;
    case GECKO: echo " (gecko)";
    break;
    case PRESTO: echo " (presto)";
    break;
    case WEBKIT: echo " (Webkit)";
    break;
    case VALIDATOR: echo " (validator)";
    break;
    case ROBOTS: echo " (robot)";
}
echo "\nEngine version: ".$_SESSION["info"]['browser']['version'];
echo "\nPlataform detected: ".$_SESSION["info"]['browser']['platform'];
echo " \n\n</pre>";
}
?>
<?php





?>