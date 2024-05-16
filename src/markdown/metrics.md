Introduktion
=========================
I denna rapport så kommer jag att att gå igenom de 6 olika C:n när det kommer till att skriva ren och och hur det kan påverka kvalitén på koden. I rapporten kommer jag även att gå igenom mätvärden från både Scrutinizer och Phpmetrics.

Codestyle – Codestyle eller kodstil är när man skriver kod där man följer vissa riktlinjer och regler där man låter koden se ut på ett visst sätt så att det ska vara enklare att följa med i vad som händer i koden. Typiska exempel på Codestyle kan vara hur variabelnamn är skriva samt hur många indenteringar man använder sig utav.

Coverage – Detta är är ett sätt att mäta så kallad kodtäckning på. Detta begreppet associeras oftast till när man testar kod för att se att den täcker alla utfall som finns i den koden man testar mot. Coverage kan användas som ett riktvärde på hur mycket kod man har täckt med hjälp av tester. Detta mätvärde används också för att kolla kvalitén på din kod då ifall det är väldigt lätt att testa så indikerar det oftast på att koden är väldigt tydligt och lätt att förstå.

Complexity – Complexity eller komplexitet är ett sätt att mäta hur pass komplex din kod är genom att bland att kolla vad för operationer du kör i din kod samt mängden av kod du exempelvis har i en metod i en av dina klasser eller i en funktion. Komplexitet är någonting man vill undvika så mycket som det bara går när man skriver kod då det oftast leder till att koden blir väldigt svårt att förstå väldigt snabbt ifall flera operationer körs i samma scope i koden.

Cohesion – Detta refererar till vilken grad koden fungerar med varandra där man tittar efter hur beroende koden är av annan kod i kodbasen. Om man har hög cohesion i det här fallet så beror det på att koden är beroende av annan kod. Vilket ofta indikerar på att koden kan vara dåligt skriven beroende på användningsområden då det anses inte vara bra att skriva för ”inkapslad” kod som är för beroende av annan kod. När det kommer till att skriva bra kod så vill man ha att koden är så oberoende av som möjligt för att kunna återanvända den.

Coupling – Detta kan man säga är lite motsatsen till cohesion där där man kollar på en hel modul istället och vad för beroende den mot alla andra moduler istället för innehållet som finns i modulen. Här kollar man beroendet mellan moduler istället och vad det har för påverkan på varandra. Har man låg coupling betyder det att det har lite påverkan ifall man skulle ta bort modulen ur kodbasen. Medans hög coupling betyder att modulerna är väldigt beroende av varandra. När man skriver kod vill man skriva så generiskt som möjligt då för att kunna använda samma kod i andra scenarion.

CRAP – Change Risk Analyzer and Predictor är en metod för att beräkna hur pass ”CRAP” eller dålig ens kod är. För att undvika det så skriver man testfall för att göra den bättre. Ju mer testfall det finns för en bit av koden ju bättre blir den. Det är ingenting fel med att använda sig av komplexa metoder för att skriva koden men enligt CRAP så ska det finnas tillräckligt med många testfall för det för att backa upp komplexiteten i koden.

Phpmetrics
=============================
I min Phpmetrics rapport så framkommer det att jag kan göra ett antal förbättrningar i min kod för att göra den bättre. I det här fallet så klagar rapporten på att jag antingen har buggar någonstans i koden baserat på komplexiteten på klassen samt hur många testfall det finns mot den klassen. Att skriva testfallen för klasserna för att lösa den delen borde inte vara ett problem då jag känner att jag har väldigt mycket mer jag hade kunnat skriva mer av. En annan förbättring är att bryta upp innehållet i metoderna så att det blir mindre kod i metoderna för att göra dem enklare att förstå. En annan åtgärd hade kunnat vara att om fakturera om kod i klassen för att göra den enklare att förstå

<img src="../../img/phpmetrics-violation.png">

När det kommer till komplexitet så såg det ut som följande:
<img src="../../img/phpmetrics-before.png">

Scrutinizer
============================
I min Scrutinizer rapport så kan vi se att verktyget ger kod kvalitén 9.96 av 10 möjliga. Vilket är väldigt bra men också indikerar på att det finns förbättringspotential i koden för att kunna öka kodkvalitén. Vi kan även se att den lyckades bygga vårt projekt från början till slut. Någonting som är mindre bra är kodtäckningen i koden då endast är 19%.
<img src="../../img/scrutinizer-before.png">

För att kunna förbättra resultaten i rapporten så kan jag först och främst skriva fler tester de klasser jag har då det inte finns tester för alla klasser. Därav att det förmodligen finns väldigt dåligt kodtäckning i kodbasen. Dock så är det väldigt svårt att försöka skriva tester som täcker kontrollers eller klasser som tillhör ramverk. Rapporten räknar även med filer som har varit från övningar ifrån andra kursmoment. En annan förbättring hade varit att kolla efter de fel som Scrutinizer klagar på och åtgärda dem. Enligt rapporten så klagar den på bland annat att det finns fall där en variabel kan vara null. Någonting som inte är optimalt i det här fallet. En annan förbättring är även att uppdatera de rader kod som är ”Deprecated”. Detta är metoder som har fått uppdateringar och används numera inte längre och har fått bättre motsvarigheter som uppfyller samma syfte. Detta för att kunna öka kodkvalitén på koden.

I mina upptäckter i rapporten så har jag märkt att coverage på mycket av filerna har varit väldigt dålig på mycket av koden. Detta då det ej finns tester för för all kod som har skrivits eller att det redan finns tester som täcker en del av koden men inte allt. Någonting annat jag även upptäckte var att det finns metoder som har högre komplexitet än väntat. Dock så behöver inte detta vara någonting dåligt då jag anser att koden utför ett arbete på ett bra sätt och därav inte behöver faktureras om eller ändras om. I fall jag skulle behöva göra en återgärd så hade det varit att ha mer coverage i metoden för att styrka dess komplexitet.

Förbättringar
===========================
De förbättringar som jag främst hade velat fokusera på är att öka mitt kvalitéindex på Scrutinizer och fixa de buggar och rader med kod som den varnar för. En annan förbättring hade jag velat implementera är att öka kodtäckningen på de klasser och metoder som antingen inte har någon eller har en väldigt liten kodtäckning men som inte täcker hela klassen eller metoden. Jag skulle även vilja fixa de issues där det finns tydliga indikationer på att det finns delar i koden som är utdaterade och behöves fixas genom att utnyttja de nyare metoderna för att lösa problemet. Även de buggar som både Phpmetrics och Scrutinizer varnar för vill jag även försöka lösa så att de inte existerar längre.

Mina förslag på förbättringar kommer att påverka främst code coverage över koden då fler tester kommer att implementeras där det är möjligt att göra det. Det kommer även att förhoppningsvis öka kvalién på koden då jag har förhoppningsvis har fixat till buggarna. I den stora utsträckningen så hoppas jag att kunna åstadkomma något högre mätvärde än vad jag redan har.

För att då försöka åstadkomma detta så valde jag först att fixa de buggar som scrutinizer varnade för samt att skriva lite fler tester för delar i koden som mina tester inte täckte innan. 

Kollar vi på de nya resultaten så kan man se att buggarna som både vart introducerade under tidensamt de buggarna som var det från första början.

<img src="../../img/scrutinizer-after.png">

Kodtäckningen ökade med 2% efter att ha skrivit fler tester till den kod om jag kunde skriva kod till. Anledningen till att jag inte kunde få högre kodtäckning var då mycket av koden ligger i controllers om jag inte kunde komma på ett bra sätt att testa utan att scrutinizer klagade på testerna medans testarna fungerade lokalt. Jag märkte även ganska så snabbt att de varningar jag fick av phpmetrics var inte värt att lägga ner tid på då det var väldigt avancerat att lösa. Istället valde jag istället att fokusera på att försöka få ner komplexiteten i koden istället. Detta genom att omfakturera delar i koden för att göra den mer simpel, men fortfarande ha att den utför samma syfte. 

Tittar vi sedan närmare på phpmetrics rapporten så kan man inte där heller se någon större skillnad där.

<img src="../../img/phpmetrics-after.png">

Det vi främst kan se är i cirklarna till vänster nere på bilden att några har bytt färg. Detta då jag har faktorerat om just i dem delarna av kodbasen för att försöka få ner komplexiteten. Vilket jag också har gjort men att de thar inte har påverkat det genomsnittet någonting. Enbart complexiteten i just den filerna men att det inte har gjort någon större skillnad på komplexiteten i helhet.

Diskussion
==============================
Så med detta sagt, går det att förbättra kvalitén och får ”clean code” på detta sättet? Jag skulle vilja säga att det fungerar förvånansvärt bra. Då jag tycker att att hänvisningen till där man kan förbättra koden är väldigt mycket än att själv försöka gissa sig fram till vart man kan förbättra eller vad någonstans det inte finns kodtäckning. Så det går definitivt att jobba på detta sättet då du kan få aktiv feedback på de områden som du kan förbättra. Skulle säga dock att den största fördelen med att jobba såhär är just att du kan ta reda på vart felen finns någonstans och du kan se på ett ungefär vart någonstans du behöver kolla för att åtgärda det. Speciellt i phpunit med deras coverage report.

En annan fördel med att just arbeta på det här sättet var att det upptäcker saker som du annars inte hade möjligtvis hade upptäckt ifall man inte hade hade arbetet på just detta sättet. Typ som buggar i mitt fall eller andra metoder som fungerar bättre att använda men utför samma syfte. Jag tror dock att detta kombinerat med linters fungerar utmärkt för att kunna få ”clean code” i sin kodbas, trots att det tar lite tid att sätta upp, något som tog lite tid att sätta upp. Någonting annat som var negativt om det var att allt var tvunget att ligga på repot i scrutinzer för att se ifall det fungerar. Något som jag inte tyckte var optimalt och var lite tidskrävande. Andra möjligheter hade även kunnat vara att man har en ”code review” där vi byter code mellan varandra och ger feedback på den. En annan ha koll på fler design patters som man sedan kan använda sig av för att sedan få en renare kod.
