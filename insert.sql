
/*
	Testovaci data insert pro jednoduchy a pouzitelny datovy model
	Spouštět vždy po create scriptu - perd kazdou tabulkou je Truncate, pri vyvolani defaultniho stavu databaze po upravach
*/

/*
	Role Uzivatele
1 dispecer
2 ridic
3 master
*/
TRUNCATE TABLE `libtaxidb`.`RoleUzivatele`;
INSERT INTO `libtaxidb`.`RoleUzivatele` 
	(`idRoleUzivatele`, `nazevRole`) 
VALUES 
	(NULL, 'dispecer'), 
    (NULL, 'ridic'), 
    (NULL, 'master');
 
/*
	Stav Ridic
1 volny
2 obsazeny
3 vedle
4 mimo
5 daleko
6 čekání
7 tankování
8 přestávka
9 soukromé
10 porucha
*/
TRUNCATE TABLE `libtaxidb`.`StavUzivatele`;
INSERT INTO `libtaxidb`.`StavUzivatele` 
	(`idStavUzivatele`, `nazevStavu`) 
VALUES 
	(NULL, 'volny'), 
	(NULL, 'obsazeny'), 
	(NULL, 'vedle'), 
	(NULL, 'mimo'), 
	(NULL, 'daleko'), 
	(NULL, 'čekání'), 
	(NULL, 'tankování'), 
	(NULL, 'přestávka'), 
	(NULL, 'soukromé'), 
	(NULL, 'porucha');


/*
	Typ Prace směna, klouzák - k dispozici 
1 směna
2 k dispozici
*/
TRUNCATE TABLE `libtaxidb`.`TypPraceUzivatele`;
INSERT INTO `libtaxidb`.`TypPraceUzivatele`
	(`idTypPraceUzivatele`, `typPrace`) 
VALUES 
	(NULL, 'směna'), 
    (NULL, 'k dispozici');

/*
	Uzivatel - zamestnanec firmy
1 dispecer
2 ridic
3 master
*/
TRUNCATE TABLE `libtaxidb`.`Uzivatel`;
INSERT INTO `libtaxidb`.`Uzivatel` 
	(`idUzivatel`, `nickName`, `celeJmeno`, `adresa`, `veFirmeOd`, `ico`, `idRoleUzivatele`, `login`, `password`, `token`, `tokenExpire`) 
VALUES 
	/*Dispeceri*/
	(NULL, 'Sváťa', 'Svatopluk', "Mariánská 3", NOW(), 999999, 1, NULL, NULL, NULL, NULL),
	(NULL, 'Eva', 'Eva', "Mariánská 3", NOW(), 999999, 1, NULL, NULL, NULL, NULL),
	(NULL, 'Jana', 'Jana', "Mariánská 3", NOW(), 999999, 1, NULL, NULL, NULL, NULL),
	(NULL, 'Patrik', 'Patrik', "Mariánská 3", NOW(), 999999, 1, NULL, NULL, NULL, NULL),	
    
    /*Ridici*/
    (NULL, 'Honza', 'Jan Špecián', "Schillerova 177/15 Liberec 12", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
    (NULL, 'Jenda', 'Jan Špecián ml.', "Schillerova 177/15 Liberec 12", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
    (NULL, 'Filip', 'Filip Jánský', "Mariánská 3 Liberec 1", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
    (NULL, 'Radek', 'Radek Kříž', "Křižanská 150 Liberec", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
    (NULL, 'Lúďa', 'Luděk Dousek', "Purkyňova 1", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
    (NULL, 'Michal', 'Michal Zolák', "Oldřichov 1150", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
    (NULL, 'Tomáš', 'Tomáš Dvořáček', "Svojsíkova 5", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
    (NULL, 'Dali', 'Dalibor Čirlič', "Alšova 20", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
	(NULL, 'Jarda', 'Jaroslav Jeřábek', "Kunratická 15", NOW(), 46035290, 2, NULL, NULL, NULL, NULL),
    
    (NULL, 'Admin', 'admin', "V Praci 1", NOW(), 12345678, 3,  'admin', MD5('admin'), NULL, NULL);

/*
	Auta
*/
TRUNCATE TABLE `libtaxidb`.`Auto`;
INSERT INTO `libtaxidb`.`Auto` 
	(`idAuto`, `znacka`, `typ`, `barva`, `rokVyroby`, `pocetMist`, `idVysilacka`, `cisloMagistratni`, `registracniZnacka`) 
VALUES 
	/*Firemni*/
	(NULL, 'Škoda', 'Octavia Combi', 'bílá', 2004, 4, 20, 156, '1L24567'),
	(NULL, 'Škoda', 'Octavia Sedan', 'bílá', 1998, 4, 18, 164, '1L24567'),	
	/*Zivnostnici*/
	(NULL, 'Audi', 'A6 Avant', 'červená', 2001, 4, 4, 177, '4L76178'),
    (NULL, 'Audi', 'A6 Avant', 'modrá', 2000, 4, 17, 178, '8B67890'),
    (NULL, 'Škoda', 'Superb Combi', 'stříbrná', 2015, 4, 2, 179, '6A42345'),
    (NULL, 'Volkswagen', 'Passat Combi', 'černá', 2015, 4, 19, 171, '4L51234'),
    (NULL, 'Škoda', 'Octavia 2 Combi', 'stříbrná', 2011, 4, 8, 172, '5L67890'),
    (NULL, 'Volkswagen', 'Touran', 'modrá', 2010, 4, 12, 173, '6L87894'),
    (NULL, 'Opel', 'Zafira', 'stříbrná', 1999, 6, 15, 174, '2L34567');


/*
	StavObjednavky
1 Zadaná
2 Přidělená
3 Obsluhovaná
4 Vyřízená
5 Zrušená řidičem
6 Zrušená klientem
*/
TRUNCATE TABLE `libtaxidb`.`StavObjednavky`;
INSERT INTO `libtaxidb`.`StavObjednavky` (`idStavObjednavky`, `nazevStavu`) 
VALUES 
	(NULL, 'Zadaná'),
    (NULL, 'Přidělená'),
    (NULL, 'Obsluhovaná'),
    (NULL, 'Vyřízená'),
    (NULL, 'Zrušená řidičem'),
    (NULL, 'Zrušená klientem');
    
/*
	Dochazka demonstrativně
*/
TRUNCATE TABLE `libtaxidb`.`Dochazka`;
INSERT INTO `libtaxidb`.`Dochazka` 
	(`idDochazka`, `prichod`, `odchod`, `idUzivatel`, `idTypPraceUzivatele`, `idStavUzivatele`, `idAuto`) 
VALUES 
	(NULL, '2018-02-21 07:58:03.000', '2018-02-21 11:58:03.000', '5', '1', '4', '3'),
	(NULL, '2018-02-22 07:58:03.000', NULL, '5', '1', '1', '3'),
    (NULL, '2018-02-22 07:59:03.000', NULL, '6', '1', '1', '4'),
    (NULL, '2018-02-22 07:56:03.000', NULL, '7', '2', '1', '1'),
    (NULL, '2018-02-22 07:55:03.000', NULL, '8', '2', '1', '5');

/*
	Objednavka demonstrativně
*/
TRUNCATE TABLE `libtaxidb`.`Objednavka`;
INSERT INTO `libtaxidb`.`Objednavka` 
	(`idObjednavka`, `idStavObjednavky`, `idDochazka`, `adresaKam`, `pocetAut`, `casVzniku`, `casPristaveniVozu`, `casVyrizeni`, `kontaktNaKlienta`) 
VALUES 
	(NULL, '4', '1', 'Kaplického 361', '1', '2018-02-21 09:00:00', '2018-02-21 09:30:00', '2018-02-21 09:50:00', '739551887'),
	(NULL, '1', '2', 'Kaplického 361', '1', '2018-02-22 09:00:00', '2018-02-22 09:30:00', NULL, '739551887');
    
/*
	Hodnocení demonstrativně
*/
TRUNCATE TABLE `libtaxidb`.`Hodnoceni`;
INSERT INTO `libtaxidb`.`Hodnoceni` 
	(`idHodnoceni`, `text`, `znamka`, `idObjednavka`) 
VALUES 
	(NULL, "V poradku a rychle", 1, 1);

/*
	Log Stavu neco
*/
TRUNCATE TABLE `libtaxidb`.`LogStavu`;
INSERT INTO `libtaxidb`.`LogStavu` 
    (`idLogStavu`, `idStavUzivatele`, `idUzivatel`, `cas`) 
VALUES 
    (NULL, '2', '3', NOW()),
    (NULL, '3', '3', NOW());








