SELECT
	
	tEtablissement.NomEtablissement,
	tEtablissement.VilleEtablissement,
	tEtablissement.RacineAnalytiqueEtablissement,
	tEtablissement.CodeEtablissement,
	
	tSalle.NomSalle,
	tSalle.TailleSalle,
	tSalle.CodeSalle

FROM tEtablissement
INNER JOIN tSalle
	ON tSalle.CodeEtablissement = tEtablissement.CodeEtablissement

WHERE
	tEtablissement.EtablissementUtilisable = 1

ORDER BY tEtablissement.RacineAnalytiqueEtablissement