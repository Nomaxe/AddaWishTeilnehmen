<!DOCTYPE html>
<html>
<head lang="de">
    <title>AddaWish - Teilnehmen</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../assets/bilder/addawish.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="../assets/bilder/addawish.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.3.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <script language="JavaScript" type="text/javascript" src="../assets/js/jquery-1.11.2.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="../assets/js/scripts.js"></script>
</head>
<body>
    <div id="background-image">
        <?php echo "<img src='". $pool->getBildPfad() ."'>"; ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5" id="pool">
                <h1>
                    <a href="http://www.addawish.de">
                        <img src="../assets/bilder/add-a-wish.jpg" alt="AddaWish Logo" title="AddaWish">
                    </a>
                </h1>
                <?php echo "<h2>" . $pool->getName() . "</h2> "; ?>
                <div class="row">
                    <div class="col-md-6">
                        <h3><i class="fa fa-user-plus"></i> Initiator:</h3>
                        <?php echo "<p>" . $pool->getInitiator() . "</p>"; ?>
                    </div>
                    <div class="col-md-6">
                        <h3><i class="fa fa-info"></i> Beschreibung:</h3>
                        <p>
                            <?php echo $pool->getBeschreibung(); ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-12" id="slider">
                    <?php echo '<p class="momentan" id="momentan" style="width:' . $pool->getErreichtProzent($teilnehmer->getTeilbetrag()) . '">'; ?>
                        <?php echo 'Erreicht: '. $pool->getErreichtEuro(); ?>
                    </p>
                    <div class="progress progress-striped" id="progressbar">
                        <?php echo '<div class="progress-bar progress-bar-custom active" role="progressbar" style="width: ' . $pool->getErreichtProzent($teilnehmer->getTeilbetrag()) . '">'; ?>
                        </div>
                        <?php echo '<div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: ' . $teilnehmer->getTeilbetragProzent($pool->getErreicht(), $pool->getZiel()) . '">'; ?>
                        </div>
                    </div>
                        <?php echo '<p class="maximal" style="width: ' . $pool->getZielProzent($teilnehmer->getTeilbetrag()) . ';" id="prozent100">'; ?>
                        <?php echo 'Zielbetrag: ' . $pool->getZiel() . '€'; ?>
                    </p>
                </div>
                <div class="col-md-12" id="countdown">
                    <div class="row">
                        <div class="col-md-6 links">
                            <div class="countdownFeld pull-left">
                                <p class="timer">
                                    <?php echo $pool->getTage(); ?>
                                </p>
                                <p>Tage</p>
                            </div>
                            <div class="countdownFeld pull-right">
                                <p class="timer">
                                    <?php echo $pool->getStunden(); ?>
                                </p>
                                <p>Stunden</p>
                            </div>
                        </div>
                        <div class="col-md-6 rechts">
                            <div class="countdownFeld pull-left">
                                <p class="timer">
                                    <?php echo $pool->getMinuten(); ?>
                                </p>
                                <p>Minuten</p>
                            </div>
                            <div class="countdownFeld pull-right">
                                <p class="timer">
                                    <?php echo $pool->getSekunden(); ?>
                                </p>
                                <p>Sekunden</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="teilnehmen">
                <h2>Gemeinsam mit Freunden Schenken</h2>
                <div class="col-md-12">
                    <div class="formular">
                        <form action="#" method="post" onsubmit="return formularTest()">
                            <div class="input-group">
                                <span class="input-group-addon eingabeBeschreibung" id="labelVorname"><span class="glyphicon glyphicon-user"></span> Vorname</span>
                                <?php echo '<input type="text" class="form-control" placeholder="Vorname" value="' . $teilnehmer->getVorname() . '" name="vorname" aria-describedby="labelVorname">'; ?>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon eingabeBeschreibung" id="labelNachname"><span class="glyphicon glyphicon-user"></span> Nachname</span>
                                <?php echo '<input type="text" class="form-control" placeholder="Nachname" value="' . $teilnehmer->getNachname() . '" name="nachname" aria-describedby="labelNachname">'; ?>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon eingabeBeschreibung" id="labelEmail"><span class="glyphicon glyphicon-envelope"></span> E-Mail</span>
                                <?php echo '<input type="email" class="form-control" placeholder="E-Mail" value="' . $teilnehmer->getEmail() .'" name="email" aria-describedby="labelEmail">'; ?>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon eingabeBeschreibung" id="labelTeilbetrag"><span class="glyphicon glyphicon-heart"></span> Teilbetrag</span>
                                <?php echo '<input type="number" step="0.01" class="form-control" value="' . $teilnehmer->getTeilbetrag() .'" name="teilbetrag" aria-describedby="labelTeilbetrag">'; ?>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                            </div>
                            <div id="bezahlArten">
                                <ul>
                                    <li>
                                        <?php echo '<input type="radio" name="bezahlart" value="paypal" id="bezahlArtPaypal" ' . $teilnehmer->isChecked('paypal') . '>'; ?>
                                        <label for="bezahlArtPaypal">
                                            <img src="../assets/bilder/paypal.png" title="Pay Pal" alt="Pay Pal">
                                        </label>
                                    </li>
                                    <li>
                                        <?php echo '<input type="radio" name="bezahlart" value="sofortueberweisung" id="bezahlArtSofortueberweisung" ' . $teilnehmer->isChecked('sofortueberweisung') . '>'; ?>
                                        <label for="bezahlArtSofortueberweisung">
                                            <img src="../assets/bilder/sofortueberweisung.png" title="Sofortüberweisung" alt="sofortüberweisung">
                                        </label>
                                    </li>
                                    <li>
                                        <?php echo '<input type="radio" name="bezahlart" value="visa" id="bezahlArtVisa" ' . $teilnehmer->isChecked('visa') . '>'; ?>
                                        <label for="bezahlArtVisa">
                                            <img src="../assets/bilder/visa.png" title="Visa" alt="Visa">
                                        </label>
                                    </li>
                                    <li>
                                        <?php echo '<input type="radio" name="bezahlart" value="mastercard" id="bezahlArtMasterCard" ' . $teilnehmer->isChecked('mastercard') . '>'; ?>
                                        <label for="bezahlArtMasterCard">
                                            <img src="../assets/bilder/mastercard.png" title="MasterCard" alt="MasterCard">
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div id="bezahlArt">
                                <div id="paypal" class="none">
                                </div>
                                <div id="sofortueberweisung" class="none">
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelKontoinhaberUeberweisung"><span class="glyphicon glyphicon-user"></span> Kontoinhaber</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Kontoinhaber" value="' . $teilnehmer->getUeberweisungInhaber . '" name="inhaberUeberweisung" aria-describedby="labelKontoinhaberUeberweisung">'; ?>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelKontonummerUeberweisung"><span class="glyphicon glyphicon-user"></span> Kontonummer</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Kontonummer" value="' . $teilnehmer->getUeberweisungNummer() . '" name="nummerUeberweisung" aria-describedby="labelKontonummerUeberweisung">'; ?>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelBLZUeberweisung"><span class="glyphicon glyphicon-user"></span> Bankleitszahl</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Beankleitszahl" value="' . $teilnehmer->getUeberweisungBLZ() . '" name="blzUeberweisung" aria-describedby="labelBankleitszahlUeberweisung">'; ?>
                                    </div>
                                </div>
                                <div id="visa" class="none">
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelKartennummerVisa"><span class="glyphicon glyphicon-user"></span> Kartennummer</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Kartennummer" value="' . $teilnehmer->getVisa()->getNummer() . '" name="nummerVisa" aria-describedby="labelKartennummerVisa">'; ?>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelKarteninhaberVisa"><span class="glyphicon glyphicon-user"></span> Karteninhaber</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Karteninhaber" value="' . $teilnehmer->getVisa()->getInhaber() . '" name="inhaberVisa" aria-describedby="labelKarteninhabervisa">'; ?>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelablaufdatumVisa"><span class="glyphicon glyphicon-user"></span> Ablaufdatum</span>
                                        <select type="button" class="btn btn-default" name="ablaufmonatVisa">
                                            <option class="none">Monat</option>
                                            <?php showMonths($teilnehmer->getVisa()->getMonat()); ?>
                                        </select>
                                        <select type="button" class="btn btn-default" name="ablaufJahrVisa">
                                            <option class="none">Jahr</option>
                                            <?php showYears($teilnehmer->getVisa()->getJahr()); ?>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelPruefnummerVisa"><span class="glyphicon glyphicon-user"></span> Prüfnummer</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Prüfnummer" value="' . $teilnehmer->getVisa()->getPruefnummer() . '" name="pruefnummerVisa" aria-describedby="labelPruefnummerVisa">'; ?>
                                    </div>
                                </div>
                                <div id="mastercard" class="none">
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelKartennummerMasterCard"><span class="glyphicon glyphicon-user"></span> Kartennummer</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Kartennummer" value="' . $teilnehmer->getMasterCard()->getNummer() . '" name="nummerMasterCard" aria-describedby="labelKartennummerMasterCard">'; ?>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelKarteninhaberMasterCard"><span class="glyphicon glyphicon-user"></span> Karteninhaber</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Karteninhaber" value="' . $teilnehmer->getMasterCard()->getInhaber() . '" name="inhaberMasterCard" aria-describedby="labelKarteninhabervisa">'; ?>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelablaufdatumMasterCard"><span class="glyphicon glyphicon-user"></span> Ablaufdatum</span>
                                        <select type="button" class="btn btn-default" name="ablaufmonatMasterCard">
                                            <option class="none">Monat</option>
                                            <?php showMonths($teilnehmer->getMasterCard()->getMonat()); ?>
                                        </select>
                                        <select type="button" class="btn btn-default" name="ablaufJahrMasterCard">
                                            <option class="none">Jahr</option>
                                            <?php showYears($teilnehmer->getMasterCard()->getJahr()); ?>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon eingabeBeschreibung" id="labelPruefnummerMasterCard"><span class="glyphicon glyphicon-user"></span> Prüfnummer</span>
                                        <?php echo '<input type="text" class="form-control" placeholder="Prüfnummer" value="' . $teilnehmer->getMasterCard()->getPruefnummer() . '" name="pruefnummerMasterCard" aria-describedby="labelPruefnummerMasterCard">'; ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo '<input type="submit" value="Teilnehmen mit ' . $pool->getTeilbetrag() . '€" class="btn btn-default" id="buttonSubmit">'; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3" id="erklaerung">
                <div class="banner">
                    <h3>Deine Vorteile</h3>
                    <h4>So geht's</h4>
                    <ul>
                        <li>Event auswählen</li>
                        <li>Freunde einladen</li>
                        <li>Teilnehmen</li>
                        <li>Gutschein verschenken</li>
                    </ul>
                    <h4>Kundenservice</h4>
                    <ul>
                        <li>05203-91668111</li>
                        <li><a href="mailto:kundenbetreuuung@addawish.de">kundenbetreuung@addawish.de</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p>
                <i class="fa fa-copyright"></i> 2015 AddaWish |
                <a href="http://www.addawish.de/faq">FAQ/Hilfe</a> |
                <a href="http://www.addawish.de/presse">Presse</a> |
                <a href="http://www.addawish.de/impressum">Impressum</a> |
                <a href="http://www.addawish.de/datenschutz">Datenschutz</a> |
                <a href="http://www.addawish.de/agb">AGB</a> |
                <a href="http://www.addawish.de/versandkosten">Versandkosten</a>
            </p>
        </div>
    </footer>
</body>
</html>