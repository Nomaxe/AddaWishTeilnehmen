//Countdown
var knotenCountdown;
    //0 = Tage
    //1 = Stunden
    //2 = Minuten
    //3 = Sekunden
var tage;
var stunden;
var minuten;
var sekunden;
var interval;

//Progressbar
var knotenProgressbar;
    //1 = Erste Progressbar
    //3 = Zweite Progressbar
var knotenMomentan;
var knoten100Prozent;
var knotenSubmit;
var momentan;
var teilbetrag;
var maximal;

//Bezahlart
var radioPaypal;
var radioUeberweisung;
var radioVisa;
var radioMasterCard;
var knotenPaypal;
var knotenUeberweisung;
var knotenVisa;
var knotenMasterCard;

//Fehlerüberprüfung
var knotenFormular;
var knotenVorname;
var knotenNachname;
var knotenEmail;
var knotenTeilbetrag;
var knotenBezahlarten;
var knotenUeberweisungInhaber;
var knotenUeberweisungNummer;
var knotenUeberweisungBLZ;
var knotenVisaNummer;
var knotenVisaInhaber;
var knotenVisaMonat;
var knotenVisaJahr;
var knotenVisaPruefnummer;
var knotenMastercardNummer;
var knotenMastercardInhaber;
var knotenMastercardMonat;
var knotenMastercardJahr;
var knotenMastercardPruefnummer;


window.onload = function()
{
    //Countdown
    knotenCountdown = document.querySelectorAll('.timer');

    tage = parseInt(knotenCountdown[0].innerHTML);
    stunden = parseInt(knotenCountdown[1].innerHTML);
    minuten = parseInt(knotenCountdown[2].innerHTML);
    sekunden = parseInt(knotenCountdown[3].innerHTML);

    interval = window.setInterval("countDownZaehler()", 1000);

    //Progressbar
    document.getElementsByName('teilbetrag')[0].addEventListener('input', changeProzent);
    knotenProgressbar = document.getElementById('progressbar').childNodes;
    knotenMomentan = document.getElementById('momentan');
    knoten100Prozent = document.getElementById('prozent100');
    knotenSubmit = document.getElementById('buttonSubmit');
    momentan = parseFloat(knotenMomentan.innerHTML.substr(knotenMomentan.innerHTML.search("Erreicht: ") + 10, 5));
    maximal = parseFloat(knoten100Prozent.innerHTML.substr(knoten100Prozent.innerHTML.search("Zielbetrag: ") + 12, 5));
    changeProzent();

    //Bezahlart
    radioPaypal = document.getElementById('bezahlArtPaypal');
    radioUeberweisung = document.getElementById('bezahlArtSofortueberweisung');
    radioVisa = document.getElementById('bezahlArtVisa');
    radioMasterCard = document.getElementById('bezahlArtMasterCard');
    knotenPaypal = document.getElementById('paypal');
    knotenUeberweisung = document.getElementById('sofortueberweisung');
    knotenVisa = document.getElementById('visa');
    knotenMasterCard = document.getElementById('mastercard');

    radioPaypal.addEventListener('change', showInputFelder);
    radioUeberweisung.addEventListener('change', showInputFelder);
    radioVisa.addEventListener('change', showInputFelder);
    radioMasterCard.addEventListener('change', showInputFelder);
    showInputFelder();

    //Fehlerüberprüfung
    knotenFormular = document.forms[0];
    knotenVorname = document.getElementsByName('vorname')[0];
    knotenNachname = document.getElementsByName('nachname')[0];
    knotenEmail = document.getElementsByName('email')[0];
    knotenTeilbetrag = document.getElementsByName('teilbetrag')[0];
    knotenBezahlarten = document.getElementById('bezahlArten');
    knotenUeberweisungInhaber = document.getElementsByName('inhaberUeberweisung')[0];
    knotenUeberweisungNummer = document.getElementsByName('nummerUeberweisung')[0];
    knotenUeberweisungBLZ = document.getElementsByName('blzUeberweisung')[0];
    knotenVisaNummer = document.getElementsByName('nummerVisa')[0];
    knotenVisaInhaber = document.getElementsByName('inhaberVisa')[0];
    knotenVisaMonat = document.getElementsByName('ablaufmonatVisa')[0];
    knotenVisaJahr = document.getElementsByName('ablaufJahrVisa')[0];
    knotenVisaPruefnummer = document.getElementsByName('pruefnummerVisa')[0];
    knotenMastercardNummer = document.getElementsByName('nummerMasterCard')[0];
    knotenMastercardInhaber = document.getElementsByName('inhaberMasterCard')[0];
    knotenMastercardMonat = document.getElementsByName('ablaufmonatMasterCard')[0];
    knotenMastercardJahr = document.getElementsByName('ablaufJahrMasterCard')[0];
    knotenMastercardPruefnummer = document.getElementsByName('pruefnummerMasterCard')[0];
}

//Countdown
function countDownZaehler()
{
    sekunden--;

    if (sekunden < 0)
    {
        sekunden = 59;
        minuten--;

        if (minuten < 0)
        {
            minuten = 59;
            stunden--;

            if (stunden < 0)
            {
                tage--;

                if (tage < 0)
                {
                    //Wenn Zeit abgelaufen, zeige nur noch 0 an
                    tage = 0;
                    stunden = 0;
                    minuten = 0;
                    sekunden = 0;
                    window.clearInterval(interval);
                }
            }
        }
    }

    schreibeWerte()
}

function schreibeWerte()
{
    knotenCountdown[0].innerHTML = getZweistellig(tage);
    knotenCountdown[1].innerHTML = getZweistellig(stunden);
    knotenCountdown[2].innerHTML = getZweistellig(minuten);
    knotenCountdown[3].innerHTML = getZweistellig(sekunden);
}

function getZweistellig(zahl)
{
    return parseInt(zahl / 10) + "" + zahl % 10;
}

//Progressbar
function changeProzent()
{
    teilbetrag = parseFloat(document.getElementsByName('teilbetrag')[0].value);
    knotenSubmit.value = "Teilnehmen mit " + teilbetrag + "€";
    var teiler;

    if (momentan + teilbetrag > maximal)
    {
        teiler = momentan + teilbetrag;
    }
    else
    {
        teiler = maximal;
    }

    knotenProgressbar[1].style.width = momentan * 100 / teiler + "%";
    knotenProgressbar[3].style.width = teilbetrag * 100 / teiler + "%";
    knoten100Prozent.style.width = maximal * 100 / teiler + "%";
    knotenMomentan.style.width = momentan * 100 / teiler + "%";
}

//Bezahlart
function showInputFelder()
{
    if (radioPaypal.checked)
    {
        setClasses(knotenPaypal, "block");
        setClasses(knotenUeberweisung, "none");
        setClasses(knotenVisa, "none");
        setClasses(knotenMasterCard, "none");
    }
    else if (radioUeberweisung.checked)
    {
        setClasses(knotenPaypal, "none");
        setClasses(knotenUeberweisung, "block");
        setClasses(knotenVisa, "none");
        setClasses(knotenMasterCard, "none");
    }
    else if (radioVisa.checked)
    {
        setClasses(knotenPaypal, "none");
        setClasses(knotenUeberweisung, "none");
        setClasses(knotenVisa, "block");
        setClasses(knotenMasterCard, "none");
    }
    else if (radioMasterCard.checked)
    {
        setClasses(knotenPaypal, "none");
        setClasses(knotenUeberweisung, "none");
        setClasses(knotenVisa, "none");
        setClasses(knotenMasterCard, "block");
    }
    else
    {
        setClasses(knotenPaypal, "none");
        setClasses(knotenUeberweisung, "none");
        setClasses(knotenVisa, "none");
        setClasses(knotenMasterCard, "none");
    }
}

function setClasses(knoten, classes)
{
    knoten.className = classes;
}

//Fehlerüberprüfung
function formularTest()
{
    resetErrors();
    classes = "form-control error";
    abschicken = true;

    if (!isText(knotenVorname.value))
    {
        setClasses(knotenVorname, classes);
        abschicken = false;
    }
    if (!isText(knotenNachname.value))
    {
        setClasses(knotenNachname, classes);
        abschicken = false;
    }
    if (!isEmail(knotenEmail.value))
    {
        setClasses(knotenEmail, classes);
        abschicken = false;
    }
    if (!isEuro(knotenTeilbetrag.value))
    {
        setClasses(knotenTeilbetrag, classes);
        abschicken = false;
    }

    if (radioUeberweisung.checked)
    {
        if (!isName(knotenUeberweisungInhaber.value))
        {
            setClasses(knotenUeberweisungInhaber, classes);
            abschicken = false;
        }
        if (!isNumber(knotenUeberweisungNummer.value))
        {
            setClasses(knotenUeberweisungNummer, classes);
            abschicken = false;
        }
        if (!isNumber(knotenUeberweisungBLZ.value))
        {
            setClasses(knotenUeberweisungBLZ, classes);
            abschicken = false;
        }
    }
    else if (radioVisa.checked)
    {
        if (!isNumber(knotenVisaNummer.value))
        {
            setClasses(knotenVisaNummer, classes);
            abschicken = false;
        }
        if (!isName(knotenVisaInhaber.value))
        {
            setClasses(knotenVisaInhaber, classes);
            abschicken = false;
        }
        if (!isMonth(knotenVisaMonat.value))
        {
            setClasses(knotenVisaMonat, "btn btn-default error");
            abschicken = false;
        }
        if (!isYear(knotenVisaJahr.value))
        {
            setClasses(knotenVisaJahr, "btn btn-default error");
            abschicken = false;
        }
        if (!isNumber(knotenVisaPruefnummer.value))
        {
            setClasses(knotenVisaPruefnummer, classes);
            abschicken = false;
        }
    }
    else if (radioMasterCard.checked)
    {
        if (!isNumber(knotenMastercardNummer.value))
        {
            setClasses(knotenMastercardNummer, classes);
            abschicken = false;
        }
        if (!isName(knotenMastercardInhaber.value))
        {
            setClasses(knotenMastercardInhaber, classes);
            abschicken = false;
        }
        if (!isMonth(knotenMastercardMonat.value))
        {
            setClasses(knotenMastercardMonat, "btn btn-default error");
            abschicken = false;
        }
        if (!isYear(knotenMastercardJahr.value))
        {
            setClasses(knotenMastercardJahr, "btn btn-default error");
            abschicken = false;
        }
        if (!isNumber(knotenMastercardPruefnummer.value))
        {
            setClasses(knotenMastercardPruefnummer, classes);
            abschicken = false;
        }
    }
    else if (!radioPaypal.checked)
    {
        setClasses(knotenBezahlarten, "error");
        abschicken = false;
    }

    return abschicken;
}

function resetErrors()
{
    classes = "form-control";
    setClasses(knotenVorname, classes);
    setClasses(knotenNachname, classes);
    setClasses(knotenEmail, classes);
    setClasses(knotenTeilbetrag, classes);
    setClasses(knotenBezahlarten, "");
    setClasses(knotenUeberweisungNummer, classes);
    setClasses(knotenUeberweisungInhaber, classes);
    setClasses(knotenUeberweisungBLZ, classes);
    setClasses(knotenVisaNummer, classes);
    setClasses(knotenVisaInhaber, classes);
    setClasses(knotenVisaMonat, "btn btn-default");
    setClasses(knotenVisaJahr, "btn btn-default");
    setClasses(knotenVisaPruefnummer, classes);
    setClasses(knotenMastercardNummer, classes);
    setClasses(knotenMastercardInhaber, classes);
    setClasses(knotenMastercardMonat, "btn btn-default");
    setClasses(knotenMastercardJahr, "btn btn-default");
    setClasses(knotenMastercardPruefnummer, classes);
}

function isText(variable)
{
     return variable;
}

function isEmail(variable)
{
    regex = /^([^\s@,:"<>]+)@([^\s@,:"<>]+\.[^\s@,:"<>.\d]{2,}|(\d{1,3}\.){3}\d{1,3})$/;

    return variable.match(regex);
}

function isEuro(variable)
{
    return !isNaN(variable) && variable * 100 % 1 == 0;
}

function isNumber(variable)
{
    return !(isNaN(variable) || variable == "");
}

function isName(variable)
{
    regex = /(\w.+) (\w.+)/;

    return variable.match(regex);
}

function isMonth(variable)
{
    return !isNaN(variable) && variable > 0 && variable < 13;
}

function isYear(variable)
{
    return !isNaN(variable) && variable % 1 == 0;
}