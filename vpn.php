<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>prokls</title>
    <meta name="creator" content="Lukas Prokop" />
    <meta name="description" content="User-Website of prokls" />
    <meta name="language" content="en" />

    <meta name="robots" content="all" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
 </head>

 <body>
    <h1>VPN Configuration</h1>
    <p style="text-align:center">
        <img src="img/vpn_config_xubuntu_gnome_network_manager_0.9.8.8.png"
            alt="VPN Client Configuration TU Graz Linux xubuntu Network Manager 0.9.4.1">
    </p>
    <p>You can also import this <a href="TU_Graz.pcf">pcf-file</a>.</p>

    <p>Do you own a TUG IP address?</p>
<?php if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '129.27.') { ?>
    <p style="margin-left:30px">
        Yes, you are using a TUGraz IP address<br>
        <small>(Your IP address is matching 129.27.*)</small>
    </p>
<?php } else { ?>
    <p style="margin-left:30px">
        Nope, visit <a href="http://www.vpn.tugraz.at">vpn.tugraz.at</a> to obtain one<br>
    </p>
<?php } ?>

    <p>
        <strong>Note:</strong>
        <ul>
            <li>IPv4 Settings are set to "Automatic(VPN)"</li>
            <li>User password is your TUG online user password</li>
            <li>This works from extern to use a TUG IP address to access paper repositories
                and works inside the WLAN at TUG campuses. (But I never get a connection
                up and running to tug access points in Kopernikusgasse)
        </ul>
    </p>

    <pre id="signature">Lukas Prokop
student of <span class="s">Computer Science</span>
admi<!-- -->n<!-- @ -->@<!-- -->lukas&#45;prokop.at
License: Emailware</pre>
 </body>
</html>
