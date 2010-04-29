* DOCUMENTATION

** INSTALLATION
Extrahieren Sie den Inhalt dieses Archivs in Ihr Magento Verzeichnis
Ggf. ist das Leeren/Auffrischen des Magento-Caches notwendig. ACHTUNG: Das 
Attribut 'generate_meta' muss dem/einem Attributset hinzugefügt werden. 
Außerdem muss es manuell in der Attributverwaltung übersetzt werden.

** USAGE
Dieses Modul füllt die Meta-Daten eines Produktes automatisch mit dem 
Produktnamen und den Kategorien. Diese Funktionalität wird durch die 
Erstellung des neuen Attributs (Ja/Nein Dropdowns) ermöglicht. D.h. wenn 
der Benutzer dieses Dropdown auf "Ja" setzt, werden die Metadaten des Produkts 
automatish aus Produktnamen und Kategorienamen gelesen. Außerdem ist die 
Multistore Umgebung berücksichtigt, nämlich, unterschiedliche "StoreViews" 
können unterschiedliche Werte haben. Es gibt auch die Unterstützung für 
Massenbearbeitung.

** FUNCTIONALITY
*** A: Fügt ein Produktattribut "Generate Meta Data" hinzu
*** B: Wenn dieses Dropdown auf "Ja" steht, greift der observer und füllt den 
        Metatitel mit dem Produktnamen und die Beschreibung und Keywords mit 
        einer Komma-Seperierten Liste aus Produktnamen und Kategorienamen.
*** C: Auch wenn diese Dropdown bei einer Massenbearbeitung auf "Ja" gesetzt 
        wird, werden die Metadaten ausgefüllt.
*** D: Auch Multistore Umgebungen werden berücksichtigt. Die Kategorie- und 
        Produktnamen werden dann entsprechend dem store view eingetragen.

** TECHNICAL
Via Migrationsskript wird ein Produktattribut 'generate_meta' eingefügt. Es 
ist ein Ja/Nein Dropdown. Es wird das Event 'catalog_product_save_after' 
abgefangen, welches bei einer einfachen Produktspeicherung ausgelöst wird. 
Hier wird geprüft, ob das Attribut des Produkts 'generate_meta' auf "Ja" 
steht. Tut es das, werden die Meta Felder entsprechend gefüllt.
Für Mass Actions wird das Event 
'controller_action_postdispatch_adminhtml_catalog_product_action_attribute_save'
abgefangen. Aus der Session werden dann die Produkten IDs geholt und geprüft, 
ob das 'generate_meta' Dropdown auf "Ja" gestellt wurde. Dann wird für jede 
ID das Produkt-Model geladen und die Werte gefüllt und gespeichert.

** PROBLEMS
Zur Zeit sind keine Probleme bekannt.

* TESTCASES

** BASIC
*** A:  1. Prüfen Sie, ob in der Attributverwaltung das Attribut 
            'generate_meta' auftaucht.
        2. Prüfen Sie, ob das vom Migrationsskript angelegte Attribut 
            'generate_meta' im Attributset vorhanden ist. Es sollte dann 
            auftauchen, wenn man das Produkt bearbeitet.
*** B:	1. (1) Legen Sie im Backend über Catalog->Add Product ein neues 
            Produkt an.
  	       (2) Geben Sie wenigstens die benötigten Attribute und eine 
            Kategorie an.
	       (3) Das Feld "Generate Meta Data" (Dropdown) sollte auf "Ja" 
            stehen.
	       (4) Wählen Sie "Save & Continue Edit".
	       (5) Die Meta-Felder sollten nun mit den Kategorie und 
            Namensinformationen gefüllt werden.
	       (6) Ändern Sie den Produkt namen und/oder die Kategorien und 
            stellen das Dropdown erneut auf "Ja".
	       (7) Die Meta Daten sollten sich entsprechend aktualisieren.
	    2. (1) Wiederholen Sie die Schritte 1-5 in B.1, wählen Sie bei 
            Schritt 3 aber "nein" aus.
	       (2) Bearbeiten Sie das zuletzt angelegte Produkt und stellen das 
            Dropdown auf "Ja".
	       (3) Nach dem Speichern sollten die Meta Daten ausgefüllt worden 
            sein.
*** C:  1. (1) Wiederholen Sie die Schritte 1-5 im Testfall B mehrfach, 
            wählen Sie bei Schritt 3 aber "nein" aus.
           (2) Machen Sie eine Massen-Bearbeitung der Produkte und stellen 
            das Dropdown auf "Ja". Klicken Sie "Speichern".
           (3) Prüfen Sie die Produkte einzeln, sie sollten jetzt alle die 
            entsprechenden Meta Daten haben.
*** D:  1. Wiederholen Sie den Testfall B aber wählen Sie einen "StoreView" 
            aus. D.h.:
           (1) Gehen Sie im Back-End auf "Produkte verwalten". 
           (2) Legen Sie ein neues Produkt an. Dabei Geben Sie wenigstens 
            die benötigten Attribute, Webseite und eine Kategorie an. Wählen 
            Sie "Save & Continue Edit".
	       (3) Wechseln Sie den "StoreView" auf "English".
	       (4) Ändern Sie den Namen des Produkts und stellen Sie das Dropdown 
            erneut auf "Ja".
           (5) Wählen Sie "Save & Continue Edit".
           (6) Überprüfen Sie, ob die Metadaten entsprechend aktualisiert 
            wurden.
           (7) Wechseln Sie den "StoreView" auf "Standardwerte". Überprüfen 
            Sie, ob die Metadaten wieder die Standardwerte haben.
        2. Wiederholen Sie den Testfall C mit dem "StoreView" Auswahl, 
            ähnlich wie im Punkt D.1. D.h.:
           (1) Wiederholen Sie die Schritte 1-5 im Testfall B mehrfach, 
            wählen Sie bei Schritt 3 aber "nein" aus.
           (2) Wechseln Sie das "StoreView" auf "English" und ändern die 
            Namen von ein paar Produkten in der Bearbeitung.
           (3) Machen Sie eine Massen-Bearbeitung der Produkte im "StoreView" 
            "English" und stellen das Dropdown auf "Ja". Klicken Sie 
            "Speichern".
           (4) Prüfen Sie die Produkte einzeln, sie sollten jetzt alle die 
            entsprechenden Meta Daten haben. D.h. die Werte müssen mit 
            der richtigen "StoreView" ("English") gelesen und gespeichert sein.
	    
** STRESS
*** A:  Es ist kein sinnvoller Testfall bekannt
*** B:  Es ist kein sinnvoller Testfall bekannt
*** C:  Es ist kein sinnvoller Testfall bekannt
*** D:  Die Produkte müssen bei einer "Mass Action" alle einzeln geladen 
         werden. Dies kann sich negativ auf die Performance auswirken. Wenn 
         das Dropdown "Generate Meta Data" nicht auf "Ja" steht, werden die 
         Produkte aber nicht einzeln geladen.

