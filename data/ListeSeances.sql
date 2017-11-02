SELECT

	tSalle.NomSalle,
	tSalle.CodeSalle,
	DateDebut = CONVERT(VARCHAR(10), tSeance.DebutSeance, 103),
	HeureDebut = CONVERT(VARCHAR(5), tSeance.DebutSeance, 108),
	DateFin = CONVERT(VARCHAR(10), tSeance.FinSeance, 103),
	HeureFin = CONVERT(VARCHAR(5), tSeance.FinSeance, 108),
	tSession.NomSession,
	tSession.CodeSession,
	SousGroupe = ISNULL(tGroupeSession.NomGroupe, 'Session complète'),
	NomMatiere = ISNULL(ThemeSeance, NomMatiere),
	NomIntervenant = NomPersonne + ISNULL(' ' + PrenomPersonne, '')

FROM tEtablissement
INNER JOIN tSalle ON tSalle.CodeEtablissement = tEtablissement.CodeEtablissement
INNER JOIN tReservation ON tReservation.CodeSalle = tSalle.CodeSalle
INNER JOIN tSeance ON tSeance.CodeSeance = tReservation.CodeSeance

LEFT OUTER JOIN tMatiere ON tMatiere.CodeMatiere = tSeance.CodeMatiere
LEFT OUTER JOIN tPlanifier ON tPlanifier.CodeSeance = tSeance.CodeSeance
LEFT OUTER JOIN tSession ON tSession.CodeSession = tPlanifier.CodeSession
LEFT OUTER JOIN tAnimation ON tAnimation.CodeSeance = tSeance.CodeSeance
LEFT OUTER JOIN tPersonne ON tPersonne.CodePersonne = tAnimation.CodeIntervenant
LEFT OUTER JOIN tGroupeSession ON tGroupeSession.CodeGroupe = tPlanifier.CodeGroupe

WHERE
	tEtablissement.RacineAnalytiqueEtablissement = UPPER({Racine analytique etablissement,Chaine,NULL})
AND
	CONVERT(VARCHAR(10), tSeance.DebutSeance, 103) = {Date (JJ/MM/AAAA),Chaine,NULL}

ORDER BY tSeance.DebutSeance ASC