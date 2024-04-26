Pseudokod
==============
```
Funktionen startGame() {
    Skapa en instans av kortleken
    Skapa två spelarinstanser, en för spelaren och en för banken
    Blandar kortleken
    Delar ut 2 kort var till både spelaren och banken. Men gömmer ett av bankens kort
}


Funktionen playerTurn() {
    Medans spelarens hand fortfarande är mindre ön 21 {
        Ge frågan ifall spelaren vill dra ett till kort
        Kolla ifall spelaren ville dra ett kort {
            Ge ett kort till spelaren
        }
        Kolla ifall spelaren har en hand över 21 {
            Spelaren förlorar, spelet avslutas
        }

        Om spelaren stannar {
            Avsluta spelarens runda
        }
    }
}

Funktionen dealerTurn() {
    Kolla sålänge bankens hand är mindre än 17 {
        Dealern tar ett till kort
        Om banken hand är värd mer än 21 {
            Banken förlorar
        }
    }
}

Funktionen compareHands {
    Kolla ifall banken har mer än spelaren {
        Banken vinner
    } Annars om spelaren har mer än banken {
        Spelaren vinner
    } Annars kolla ifall spelaren och banken har lika mycket {
        Lika
    }
}
    
```

Vilka klasser behöver jag?
===========================

Jag behöver iallafall minst 2 st klasser. En klass för bara hur spelet körs som jag kallar för BlackJack. En klass som representerar en spelare behövs också som jag kallar för Player. En Player klass representerar både banken och spelaren då både är iprincip uppbygga detsamma fast men annan logik bakom dem. Men tänker att principen borde vara den samma i uppbyggnaden. Tänker även att BlackJack klassen sköter logiken bakom hela spelet så att klassen blir specialliserad för att enbart kunna köra blackjack med.