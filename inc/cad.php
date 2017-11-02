<?php

/**
 * Interface des objets permettant d'accéder à la données.
 *
 * @version 2.0
 * @date Nov 2017
 */
interface CAD {
	
	/**
	 * Renvoie la liste de toutes les salles dans tous les établissements. Cette fonction renvoie un
	 * tableau de tableaux associatifs dont les clés sont les suivantes :
	 *
	 *  | Nom du champ                  | Type       | Description                                                 |
	 *  |-------------------------------|------------|-------------------------------------------------------------|
	 *	| NomEtablissement              | varchar    | Nom long de l'établissement.                                |
	 *	| VilleEtablissement            | varchar    | Nom de la ville de l'établissement.                         |
	 *	| RacineAnalytiqueEtablissement | varchar(2) | Code à deux lettres majuscules identifiant l'établissement. |
	 *	| CodeEtablissement             | ID (int)   | Identifiant dans la base de l'établissement.                |
	 *	| NomSalle                      | varchar    | Nom de la salle.                                            |
	 *	| TailleSalle                   | int        | Effectif maximal dans la salle.                             |
	 *	| CodeSalle                     | ID (int)   | Identifiant dans la base de la salle.                       |
	 *
	 * @return array
	 */
	public function getClassRoomsList();
	
	/**
	 * Renvoie la liste des séances programmées pour un établissement et une date donnés. Cette fonction
	 * renvoie un tableau de tableaux associatifs dont les clés sont les suivantes :
	 *
	 *  | Nom du champ   | Type        | Description                                            |
	 *  |------------------------------|------------|-------------------------------------------|
	 *	| NomSalle       | varchar     | Nom de la salle.                                       |
	 *	| CodeSalle      | ID (int)    | Identifiant en base de la salle.                       |
	 *	| DateDebut      | varchar(10) | Date de démarrage de la séance au format 'DD/MM/YYYY'. |
	 *	| HeureDebut     | varchar(5)  | Heure de démarrage de la séance au format 'HH:MM'.     |
	 *	| DateFin        | varchar(10) | Date de fin de la séance au format 'DD/MM/YYYY'.       |
	 *	| HeureFin       | varchar(5)  | Heure de fin de la séance au format 'HH:MM'.           |
	 *	| NomSession     | varchar     | Nom complet de la session.                             |
	 *	| CodeSession    | ID (int)    | Identifiant en base de la session.                     |
	 *	| SousGroupe     | varchar     | Nom du groupe de découpage pédagogique.                |
	 *	| NomMatiere     | varchar     | Intitulé de la matière.                                |
	 *	| NomIntervenant | varchar     | Nom complet de l'intervenant (optionnel).              |
	 *
	 * @param $racineAnalytiqueEtablissement string La racine analytique sur 2 caractères de l'établissement.
	 * @param $date string La date voulue, au format 'DD/MM/YYYY'.
	 */
	public function getClassRoomsBookings($racineAnalytiqueEtablissement, $date);
	
}

/*class FNG implements CAD {
	
}*/

class CSVDataReader implements CAD {
	
	public static final $ROOT = dirname(__FILE__);
	
	public function getClassRoomsList() {
		echo self::$ROOT;
	}
	
}

$cad = new CSVDataReader();
print_r($cad->getClassRoomsList());