<h1 id="kmom06">Kmom06</h1>

Hur uppfattade du verktyget phpmetrics och fann du några särskilda bitar mer värdefulla än andra? Var det några särskilda metrics eller bilder du uppskattade?
==============================
Det jag nog uppskattade mest med phpmetrics var nog att den visade visuellt vad man hade mest komplexitet någonstans. Vilket gjorde det enklare att se vart problemen vart någonstans istället för att försöka själv kolla vart problemet är någonstans. Så bilden till vänster på startsidan av rapporten var väldigt bra. Sen att den visade den genomsnittliga komplexiteten tyckte jag också var bra för att få en större överblick över hela kodbasen.

Berätta hur det gick att integrera med Scrutinizer och vilken är din första känsla av verktyget och dess badges? Vilken kodtäckning och kodkvalitet fick du efter första bygget?
=================================
Jag tyckte att Scrutinizer var ett väldigt intressant verktyg och ett spännande koncept på att få en bättre koll kodbasen samt att du får sedan ett betyg i from av bagdes var också lite roligt och samtidigt lite motivierande då man ville ha den bästa badgen. Jag fick en väldigt bra kodkvalitet på 9.98 och en kodtäckning på enbart 18%. Kodteckningen var inte alls bra men detta berodde mest på att den plockade upp på filer som inte heller gick att skriva tester till eller på filer som man inte hade någon kontroll över. I mitt fall försökte jag skriva tester till mina controllers men mitt problem var att de vägrade fungera när Scrutinizer skulle bygga upp projektet igen och lyckades inte att lösa det på något bra sätt. Vilket resulterade i att jag skrotade den idén istället och försökte lägga mer till på att lösa kod komplexitet.

Hur är din egen syn på kodkvalitet, berätta lite om den? Tror du man kan man påvisa kodkvalitet i någon viss mån med badges eller vad tror du?
=======================================
Jag tror att det kan fungera som en riktlinje men skulle inte vilja säga att man borde förlita sig helt på det. Det kan nog ge en ganska snabb överblick över koden och hur den kommer vara men det ger nog inte en jätteklar bild över hela kodbasen kontra ifall man hade kollat på koden själv. Så att kunna mäta på kodkvalité tycker jag är bra men enbart bara som ett riktvärde och inget annat. Sedan att ha ett snyggt sätt att visa upp det genom en badge är ju inte fel det heller.

Vilken är din TIL för detta kmom?
==================================
Mitt TIL för detta kursmomentet måste vara Scrutinizer. Har enbart bara sätt det när jag har kollat på andras projekt på GitHub men har själv aldrig fattat vad det används för. Men nu har jag äntligen fått lära mig det och det är en kunskap jag kommer att ta med mig.