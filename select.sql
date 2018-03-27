SELECT * 
FROM libtaxidb.StavObjednavky, Objednavka 
WHERE Objednavka.idStavObjednavky = StavObjednavky.idStavObjednavky;

select * from libtaxidb.Uzivatel WHERE nickName='admin'