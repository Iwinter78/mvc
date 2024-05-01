<h1 id="kmom04">Kmom04</h1>

Berätta hur du upplevde att skriva kod som testar annan kod med PHPUnit och hur du upplever phpunit rent allmänt.
-------------------------
Jag tyckte att det gick väldigt smidigt att skriva tester i PHPUnit. Det som nog gjorde de så smidigt var att man kunde generera fram en kodrapport där man kunde se vart någonstans i koden man hade täkt med tester och vilka man inte har. Det var någonting som fick arbetet att flyta på väldigt mycket snabbare än att man själv behöver ha koll på vad som har täckts av testerna eller inte. Att skriva testkod i PHPunit var väldigt trevligt och hoppas i framtiden att man stötter på något liknande verktyg då att kunna generera fram en rapport på kodtäckningen var guld värt.

Hur väl lyckades du med kodtäckningen av din kod, lyckades du nå mer än 90% kodtäckning?
------------------------
Jag lyckades väldigt bra med få en bra kodtäckning på min kod. Testerna täckte både för huvudklassen som jag skrev tester för men också får en den andra klassen som jag använde mig av. Jag lyckades få 100% kodtäckning på båda klasserna med de testerna jag skrev. Dock så bör det noteras att det är tester som täcker allt i ganska stora drag då det ej påpekades hur mycket vi skulle testa en spesifik metod eller klass. Därav att jag har skrivit tester som åtminstånde täcker alla klasser och methoder samt deras utfall.

Upplever du din egen kod som “testbar kod” eller finns det delar i koden som är mer eller mindre testbar och finns det saker som kan göras för att förbättra kodens testbarhet?
-----------------------------
Till en början så trodde jag redan hade ganska så bra testbar kod. Vilket jag hade fram tills jag märkte att det fanns en metod som gick inte och täcka helt med hjälp av tester. Detta genom att det fanns kontroller innan som redan täckte alla utfall och därav inte kunde nå det "sista" utfallet av methoden. Jag löste dock detta genom att ändra på methoden så att alla utfall kunde täckas och därav få en bättre kodtäckning i min kod.

Det finns helt klart förbättrningar man kan göra för att göra den mer testbar men också förhindra den till att krascha. Någonting som jag tänkte lägga till tills jag märkte att phpdoc hindrar en från att lägga in någonting annat i parametern än det som står dokumenterat. Vilket gjorde att man sparade tid på någonting som man vanligt vis är A och O inom programmering. Men eftersom att kommenterarna finns där så behöver man alltså ej lägga till sådana utfall i koden. Vilket är första gången för mig det händer men jag kan inte klaga för mycket på det.

Valde du att skriva om delar av din kod för att förbättra den eller göra den mer testbar, om så berätta lite hur du tänkte.
----------------------------
Jag valde som sagt att skriva om lite i en av metoderna i BlackJack klassen där jag inte kunde få full kodtäckning i metoden. För att kunna få full kodtäckning så var ju tvungen att tänka på vad för utfall jag hade i methoden och om jag kunde göra mig av med något utfall och ändå få metoden att fortfarande fungera så som det är tänkt. Vilket var också det jag gjorde. Jag tog bort ett av utfallen och lade dess return längt ner i methoden. Koden fungerar fortfarande som det är tänkt och jag kunde få full kodtäckning i metoden. Perfekt!

Fundera över om du anser att testbar kod är något som kan identifiera “snygg och ren kod”.
---------------------------
Det kan den defnitivt göra. Jag skulle vilja tro att ju snyggare och ren koden är, ju lättare är den att testa. Hade det varit tvärt om så hade det inte varit lika enkelt att testa den. Kan man också testa bra så kan det nog bara en bra indikation om att koden är "snygg och ren".

Vilken är din TIL för detta kmom?
---------------------------------
Mitt TIL för detta kursmomentet är nog hur man använder sig av PHPUnit. Tog lite tid att förstå hur det fungerade men det när man vär väl igång med det så var det väldigt enkelt att använda och effektivt.
