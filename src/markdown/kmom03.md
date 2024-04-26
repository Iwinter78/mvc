<h1 id="kmom03">Kmom03</h1>

Berätta hur det kändes att modellera ett kortspel med flödesdiagram och psuedokod. Var det något som du tror stödjer dig i din problemlösning och tankearbete för att strukturera koden kring en applikation?
------------------------------------

Att göra flödesdiagramet hjälpte med att skriva psuedokoden och psuedokoden hjälpte med att skriva den riktiga koden när det väl var dags. Så jag skule säga att den både hjälpte mig att få en struktur i arbetet men också hur kan skulle strukturera upp applikationen. Så i det här fallet så fungerade det som ett stöd men också för att ha någonting att kolla tillbaka på. Någonting som faktiskt hjälpte då man fick som en ungefärlig uppfattning om vad behövs göras som samtidigt är öppen för förändringar.

Berätta om din implementation från uppgiften. Hur löste du uppgiften, är du nöjd/missnöjd, vilken förbättringspotential ser du i din koden, dina klasser och applikationen som helhet?
-----------------------------------
Jag blev väldigt nöjd med min implementation av spelet. Jag tyckte ändå att jag fick en någorlunda bra struktur på det. För att lösa uppgiften så använde jag mig främst av 2 klasser, BlackJack och Player. I dem klasserna så använde mig av methoder och att jobba åt samma klass hela tiden, vilket var BlackJack klassen. Då jag tyckte att det dels blev lättare att jobba mot samma klass hela tiden och inte hålla på att jobba mot flera olika. Någonting som fungerade väldigt bra i det här fallet då jag även bara behövde spara ner BlackJack objektet i en session och jobba mot den sessionen hela tiden när jag ville göra en förändinrg.

I Blackjack klassen så använder jag mig mest av listor för jag sedan sätter ihop och ändrar på med hjälp av metoderna som jag har skapat. Detta tyckte jag vart det lättaste sättet att göra det på och det var inte för rörigt på. I Player klassen så fungerar det lite samma att en spelare är en lista som jag sedan har metoder som jag använder för att sedan kunna ändra på innehållet inne i listan.

Detta eftersom att jag sparar all data mot objektet som jag sedan sparar i sessionen. Det blev även enklade då att hålla koll på enbart en session istället för flera. Någonting som jag hade velat överse är ifall det finns methoder som jag hade kunnat göra annorlunda så jag hade kunnat få in lite privata eller skyddade (protected) methoder in i båda klasserna. Som förbättring så hade jag velat hantera sessionerna i klasserna. Men eftersom att detta bryter mot MVC mönststret så är detta inte möjligt. Men hade det gått så hade det kunnat vara en förbättring då jag får mindre kod i mina routes.

Vilken är din känsla för att koda i ett ramverk som Symfony, så här långt in i kursen?
----------------------------------
Nu tycker inte att det inte är lika rörigt längre att använda mig av Symphony. Något jag tyckte var lite jobbigt i början då väldigt mycket var nytt. Jag är inte rikigt helt bekväm än med att koda i Symfony men det börjar bli bättre.

Vilken är din TIL för detta kmom?
---------------------------------
Mitt TIL är error_log som fungerar lite som print_r men att du skriver ut det i konsolen på webbserven tycket det var använtbart ifall det finns fall där man av någon anledingen inte får ut utskrivften på webbplatsen. Tyckte jag var väldigt smidigt.