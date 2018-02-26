SELECT * 
FROM libtaxidb.StavObjednavky, Objednavka 
WHERE Objednavka.idStavObjednavky = StavObjednavky.idStavObjednavky;

