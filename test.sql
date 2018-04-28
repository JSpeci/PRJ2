SELECT * 
FROM Uzivatel
INNER JOIN RoleUzivatele 
ON RoleUzivatele.idRoleUzivatele = Uzivatel.idRoleUzivatele


/*SELECT * FROM Uzivatel WHERE Uzivatel.login is null*/
