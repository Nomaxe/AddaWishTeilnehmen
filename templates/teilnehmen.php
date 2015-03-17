<!DOCTYPE html>
<html>
<head lang="de">
    <title>AddaWish - Teilnehmen</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                       <?php echo $pool->getErreichtEuro(); ?>
                   </p>
                    <div class="progress progress-striped" id="progressbar">
                        <?php echo '<div class="progress-bar progress-bar-custom active" role="progressbar" style="width: ' . $pool->getErreichtProzent($teilnehmer->getTeilbetrag()) . '">'; ?>
                        </div>
                        <?php echo '<div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: ' . $teilnehmer->getTeilbetragProzent($pool->getErreicht(), $pool->getZiel()) . '">'; ?>
                        </div>
                    </div>
                    <p class="maximal" style="width: 100%;" id="prozent100">
                        <?php echo $pool->getZiel() . '€'; ?>
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
                        <form action="#" method="post">
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
                            <?php require_once("php/heidelpay/hcoFastLane.php"); ?>
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
