* DOCUMENTATION

** INSTALLATION
Extrahieren Sie den Inhalt dieses Archivs in Ihr Magento Verzeichnis
Ggf. ist das Leeren/Auffrischen des Magento-Caches notwendig. ACHTUNG: Das 
Attribut 'generate_meta' muss dem/einem Attributset hinzugefügt werden. 
Außerdem muss es manuell in der Attributverwaltung übersetzt werden.

** USAGE
Dieses Modul füllt die Meta-Daten eines Produktes automatisch mit dem 
Produktnamen und den Kategorien.

** FUNCTIONALITY
*** A: Fügt ein Produktattribut "Generate Meta Data" hinzu
*** B: Wenn dieses Drop-Down auf Ja steht, greift der observer und füllt den 
        Metatitel mit dem Produktnamen und die Beschreibung und Keywords mit 
        einer Komma-Seperierten Liste aus Produktnamen und Kategorienamen.
*** C: Auch wenn diese Drop-Down bei einer Massenbearbeitung auf "ja" gesetzt 
        wird, werden die Metadaten ausgefüllt.
*** D: Auch Multistore Umgebungen werden berücksichtigt. Die Kategorie- und 
        Produktnamen werden dann entsprechend dem store view eingetragen.

** TECHNINCAL
Via Migrationsskript wird ein Produktattribut 'generate_meta' eingefügt. Es 
ist ein Ja/Nein Drop-Down. Es wird das Event 'catalog_product_save_after' 
abgefangen, welches bei einer einfachen Produktspeicherung ausgelöst wird. 
Hier wird geprüft, ob das Produktattribut 'generate_meta' auf "Ja" steht. 
Tut es das, werden die Meta Felder entsprechend gefüllt.
Für Mass Actions wird das Event 
'controller_action_postdispatch_adminhtml_catalog_product_action_attribute_save'
abgefangen. Aus der Session werden dann die produkt IDs geholt und geprüft, 
ob das 'generate_meta' Drop-Down auf "Ja" gestellt wurde. Dann wird für jede 
ID das Produkt-Model geladen und die Werte gefüllt und gespeichert.

** PROBLEMS

* TESTCASES

** BASIC
*** A:  1. Prüfen Sie, ob das vom Migrationsskript angelegte Attribut 
            'generate_meta' im Attributset vorhanden ist. Es sollte dann 
            auftauchen, wenn man das Produkt bearbeitet.
        2. Prüfen Sie, ob in der Attributverwaltung das Attribut 
            'generate_meta' auftaucht.
*** B:	1. (1) Legen Sie im Backend über Catalog->Add Product ein neues 
            Produkt an.
  	       (2) Geben Sie wenigstens die benötigten Attribute und eine 
            Kategorie an
	       (3) Das Feld "Generate Meta Data" sollte auf "Ja" stehen
	       (4) Wählen Sie "Save & Continue Edit".
	       (5) Die Meta-Felder sollten nun mir den Kategorie und 
            Namensinformationen gefüllt werden.
	       (6) Ändern Sie den produkt namen und/oder die kategorien und 
            stellen das Drop-Down erneut auf "ja"
	       (7) Die Meta Daten sollten sich entsprechend aktualisieren.
	       (8) Wiederholen Sie die Schritte 1-5, wählen Sie bei Schritt 3 
            aber "nein" aus.
	       (9) Bearbeiten Sie das zuletzt angelegte Produkt und stellen das 
            Drop-Down auf "ja".
	       (10) Nach dem Speichern sollten die Meta Daten ausgefüllt worden 
            sein.
*** C:  1. (1) Wiederholen Sie die Schritte 1-5 in Testcase B mehrfach, 
            wählen Sie bei Schritt 3 aber "nein" aus.
           (2) Machen Sie eine Massen-Bearbeitung der Produkte und stellen 
            das Drop-Down auf "ja".
           (3) Prüfen Sie die Produkte einzeln, sie sollten jetzt alle die 
            entsprechenden Meta Daten haben.
*** D:  1. Wiederholen Sie die Testcases B+C aber wählen einen store-scope 
            aus.
	    
** STRESS
*** A:  Es ist kein sinnvoller Testfall bekannt
*** B:  Es ist kein sinnvoller Testfall bekannt
*** C:  Es ist kein sinnvoller Testfall bekannt
*** D:  Die Produkte müssen bei einer "Mass Action" alle einzeln geladen 
         werden. Dies kann sich negativ auf die Performance auswirken. Wenn 
         das Drop-Down "Generate Meta Data" nicht auf "ja" steht, werden die 
         Produkte aber nicht einzeln geladen.

