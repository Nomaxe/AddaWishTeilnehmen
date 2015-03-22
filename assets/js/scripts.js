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

//Prohressbar
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
    momentan = parseFloat(knotenMomentan.innerHTML);
    maximal = parseFloat(knoten100Prozent.innerHTML);
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
        setClasses(knotenSubmit, "btn btn-default block")
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