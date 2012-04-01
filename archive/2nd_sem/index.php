<?php
    $quotes[] = 'Always keep on the bright side of life';
    $quotes[] = 'See a Penny, pick her up and all the day will have good luck';
    $quotes[] = 'Wir werden es schaffen! Ich habe eine Uhr mit Minutenzeiger';
    $quotes[] = 'Penny? I am hungry!';
    $quotes[] = 'O(uni) = n!';
    $quotes[] = 'Have you tried turning off and on again?';
    $quotes[] = 'Do not yak-shave!';
    $quotes[] = 'Who sacrifices freedom for security deserves neither.';
    $quotes[] = 'Quod erat faciendum';
    $quotes[] = 'Quo vadis?';
    $quotes[] = 'Metalinguistische Abstraktion';
    $quotes[] = 'Schwanzus Longus';
    $quotes[] = 'Controlling complexity is the essence of computer science';
    $quotes[] = 'Science is what we understand well enough to explain to a computer. Art is everything else we do.';
    $quotes[] = 'I define UNIX as 30 definitions of regular expressions living under one roof.';
    $quotes[] = 'I can’t go to a restaurant and order food because I keep looking at the fonts on the menu.';
    $quotes[] = 'summa summarum';
    $quotes[] = '10 is always the base';
    $quote = $quotes[mt_rand(0, count($quotes)-1)];
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<!-- HTML 4 sucks. HTML 5 to go -->
<html>
  <head>
    <title>prokls</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="creator" content="Lukas Prokop">
    <meta name="description" content="User website of prokls">
    <meta name="language" content="en">

    <meta name="robots" content="all">
    <link rel="lukas' weblog" title="MyBlog" href="http://lukas-prokop.at/blog/">
    <link rel="stylesheet" type="text/css" href="main.css">
 </head>

 <body>
<?php if (mt_rand(0, 10) < 2) { ?>
    <div style="position:fixed; left:2px; bottom:2px; text-shadow: #334 3px 3px 5px">
      Bazinga!
    </div>
<?php } ?>

    <object type="image/svg+xml" data="/theme/smiley.svg" width="150" id="logo">
      <img src="./smiley.png" alt="Logo">
    </object>

    <h1 class="bbg"><?=$quote; ?></h1>

    <ul class="bbg">
      <li>
        2nd semester, 12 LVs, 37.5 ECTS, 81% success rate

        <!-- ECTS * 2, 22.5 ECTS as base (CS, only compulsory subjects) -->
        <div style="border:#333 solid 1px; padding:1px; width:336px">
          <div style="background-color:#9AC; width:102px; overflow:visible">
            study
          </div>
        </div>
        <!-- #(abgeschlossene LVs) * 30 -->
        <div style="border:#333 solid 1px; padding:1px; width:360px">
          <div style="background-color:#DDA; width:270px; overflow:visible">
            2.&nbsp;Semester
          </div>
        </div>
      </li>
      <li>
        <a href="vpn.php">My VPN Client Configuration for TUGraz using Linux Fedoras builtin VPN client</a>
      </li>
      <li>
        <a href="jabber.html">
          My pidgin configuration for TU Graz Jabber Server
        </a>
      </li>
      <li>
        <a href="../../pub/img498.jpg">L</a><a href="../../pub/img499.jpg">ö</a><a href="../../pub/img500.jpg">s</a><a href="../../pub/img501.jpg">u</a><a href="../../pub/img502.jpg">n</a><a href="../../pub/img503.jpg">g</a><a href="../../pub/img504.jpg">e</a><a href="../../pub/img505.jpg">n</a> <a href="../../pub/img506.jpg">für</a> <a href="../../pub/img507.jpg">R</a><a href="../../pub/img509.jpg">O</a> <a href="../../pub/img510.jpg">Mus</a><a href="../../pub/img511.jpg">ter</a><a href="../../pub/img512.jpg">bei</a><a href="../../pub/img513.jpg">sp</a><a href="../../pub/img514.jpg">ie</a><a href="../../pub/img515.jpg">le</a>
      </li>
      <li><a href="../1st_sem">Previous semester</a></li>
    </ul>

    <h1>Ausarbeitungen</h1>

    <ul>
      <li><span class="lv" title="Diskrete Mathematik">DM</span>
        Zahlentheorie Cheatsheet
            <a href="../../pub/number_theory.pdf">[PDF]</a>
            <a href="../../pub/number_theory.tex">[TeX]</a>
      </li>
      <li><span class="lv" title="Softwareentwicklungspraktikum">SEP</span>

        <a href="../../pub/dexalyse.py">Dexalyse Tool (PY)</a>
      </li>
      <li><span class="lv" title="Rechnerorganisation &amp; Rechnernetze und -Organisation">RNO &amp; RO</span>

        <a href="../../pub/rno_io_generate.py" class="wo">I/O Generate Skript (PY)</a>
        <a href="../../pub/rno_toy2asm.c" class="wo">TOY Disassembler (C)</a>
      </li>
      <li><span class="lv" title="Datenbanken 1">DB1</span>

        <a href="../../pub/terms.pdf">Terms and Definitions</a>
      </li>
      <li><span class="lv" title="Einführung in das Wissensmanagement">EiWM</span>

        <a href="../../pub/ewm_fragen">Possible exam questions</a>
        <a href="../../pub/ewm_answers">Some exam question answers</a>
        <a href="../../pub/ewm_terms">EWM buzzword list</a>
      </li>
      <li><span class="lv" title="Mensch-Maschine-Kommunikation">HCI</span>
      </li>
      <li><span class="lv" title="Anwendung von Betriebs- und Informationssystemen">ABIS</span>
      </li>
    </ul>

    <h1>Aufgaben</h1>

    <ul>
      <li>
        <img src="/theme/smiley/happy.gif" alt=":-)">
        <span class="lv" title="Diskrete Mathematik">DM:</span>

        <span class="hw done">Übung 8.3</span>
        <span class="hw done">Übung 15.3</span>
        <span class="hw done">Übung 22.3</span>
        <span class="hw done">Übung 29.3</span>
        <span class="hw done">Übung 5.4</span>
        <span class="hw done">Übung 12.4</span>
        <span class="hw done">Übung 17.5</span>
        <span class="hw done">Übung 24.5</span>
        <span class="hw done">Übung 31.5</span>
        <span class="hw done">Übung 7.6</span>
        <span class="hw done">Übung 21.6</span>
        <span class="hw done">Übung 28.6</span>
      </li>
      <li>
        <img src="/theme/smiley/confused.gif" alt=":-/">
        <span class="lv" title="Softwareentwicklungspraktikum">SEP:</span>

        <span class="hw done">EX1</span>
        <span class="hw done">EX2 DD</span>
        <span class="hw done">EX2</span>
        <span class="hw done">EX3 DD</span>
        <span class="hw done">EX3</span>
      </li>
      <li>
        <img src="/theme/smiley/happy.gif" alt=":-)">
        <span class="lv" title="Rechnerorganisation">RO:</span>

        <span class="hw done">Aufgabe 1</span>
        <span class="hw done">Aufgabe 2</span>
        <span class="hw done">Aufgabe 3</span>
        <span class="hw done">Aufgabe 4</span>
      </li>
      <li>
        <img src="/theme/smiley/happy.gif" alt=":-)">
        <span class="lv" title="Rechnernetze &amp; -Organisation">RNO:</span>

        <span class="hw done">Assignment 1</span>
        <span class="hw done">Assignment 2</span>
        <span class="hw done">Assignment 3</span>
      </li>
      <li>
        <img src="/theme/smiley/confused.gif" alt=":-)">
        <span class="lv" title="Datenbanken 1">DB1:</span>

        <span class="hw done">Abgabe</span>
      </li>
      <li>
        <img src="/theme/smiley/confused.gif" alt=":-/">
        <span class="lv" title="Einführung in das Wissensmangement">EiWM:</span>

        <span class="hw done">Exercise 1</span>
        <span class="hw done">Exercise 2</span>
        <span class="hw done">Exercise 3</span>
        <span class="hw done">Exercise 4</span>
        <span class="hw done">Exercise 5</span>
        <span class="hw done">Exercise 6</span>
        <span class="hw done">Exercise 7</span>
        <span class="hw done">Exercise 8</span>
      </li>
      <li>
        <img src="/theme/smiley/happy.gif" alt=":-)">
        <span class="lv" title="Mensch-Maschine-Kommunikation">HCI:</span>


        <span class="hw done">HE Plan</span>
        <span class="hw done">HE</span>
        <span class="hw done">TA Plan</span>
        <span class="hw done">TA</span>
      </li>
      <li>
        <img src="/theme/smiley/happy.gif" alt=":-/">
        <span class="lv" title="Anwendung von Betriebs- und Informationssystemen">ABIS</span>

        <span class="hw done">Blogbeitrag</span>
        <span class="hw done">Blogbeitrag</span>
      </li>
    </ul>

    <h1>Prüfungstermine</h1>
    <dl style="-moz-column-count:2; -webkit-column-count:2">
      <dt>2011.05.11</dt>
        <dd>DM I (done.)</dd>
      <dt>2011.05.13</dt>
        <dd>GET (done.)</dd>
      <dt>2011.06.09</dt>
        <dd>SEP (done.)</dd>
      <dt>2011.06.09</dt>
        <dd>ABIS (done.)</dd>
      <dt>2011.06.20</dt>
        <dd>DB 1 (done.)</dd>
      <dt>2011.06.21</dt>
        <dd>HCI (done.)</dd>
      <dt>2011.06.24</dt>
        <dd>RNO (done.)</dd>
      <dt>2011.06.30</dt>
        <dd>DM II (done.)</dd>
      <dt>2011.06.30</dt>
        <dd>EWM (done.)</dd>
      <dt>2011.07.01 / 07.02</dt>
        <dd>RO (done.)</dd>
    </dl>

    <p><b>Last Update:</b> Wed, 07th of July 2011</p>


    <p class="s">See also: <a href="http://lukas-prokop.at/proj.php">http//lukas-prokop.at/proj.php</a></p>

    <pre id="signature">Lukas Prokop
student of <span class="s">Computer Science</span> and <span class="s">Software Development and Business Management</span>
admi<!-- -->n<!-- @monthpy -->@<!-- -->lukas&#45;prokop.at
License: Emailware</pre>
 </body>
</html>
