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
	 * @return array
	 */
	public function getEtablissementBookings($racineAnalytiqueEtablissement, $date);

	/**
	 * Renvoie la liste des réservations pour un profile donné. Le format de données est le même que la
	 * fonction getEtablissementBookings.
	 * 
	 * @param $profile array Le contenu de la variable $_PROFILE.
	 * @param $date string La date voulue, au format 'DD/MM/YYYY'.
	 * @return array
	 * @see CAD::getEtablissementBookings()
	 */
	public function getProfileBookings($profile, $date);

}

class CSVDataReader implements CAD {

	public function getClassRoomsList() {
		return self::parseCsvFile(dirname(__FILE__) . '/../data/ListeSalles2017.csv');
	}

	public function getEtablissementBookings($racineAnalytiqueEtablissement, $date) {
		return self::parseCsvFile(dirname(__FILE__) . '/../data/ExempleJeuDeDonneesSeances.csv');
	}

	public function getProfileBookings($profile, $date) {
		$data = $this->getEtablissementBookings($profile['codeEtablissement'], $date);
		$rooms = explode(' ', $profile['salles']);
		$result = array();
		foreach ($data as $key => $item) {
			if (in_array("{$item['CodeSalle']}", $rooms)) {
				$result[] = $item;
			}
		}
		return $result;
	}

	private static function parseCsvFile($path) {
		if (!file_exists($path)) return NULL;
		$data = explode("\n", file_get_contents($path));
		$keys = array();
		$result = array();
		foreach ($data as $line) {
			if (empty($line)) continue;
			if (empty($keys)) {
				$keys = explode(';', $line);
			}
			else {
				$result[] = array_combine($keys, explode(';', $line));
			}
		}
		return $result;
	}

}

/*class FNG implements CAD {

	public function getClassRoomsList() {
		$file = dirname(__FILE__) . '/../data/ListeSalles.sql';
		$sql = file_get_contents($file);
	}

	public function getEtablissementBookings($racineAnalytiqueEtablissement, $date) {
		$file = dirname(__FILE__) . '/../data/ListeSeances.sql';
		$sql = file_get_contents($file);
		$sql = str_replace('{Racine analytique etablissement,Chaine,NULL}', "'{$racineAnalytiqueEtablissement}'", $sql);
		$sql = str_replace('{Date (JJ/MM/AAAA),Chaine,NULL}', "'{$date}'", $sql);
	}

}*/