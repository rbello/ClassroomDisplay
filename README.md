# Classroom Display

Ce projet est un afficheur de salle pour un centre de formation.

## Installation

Les composants logiciels suivants doivent être installés :
- Serveur HTTP (Apache sous linux, IIS sous Windows)
- PHP (version 5.2 minimum)
- Module HTTP de réécritude d'URL (sous Apache il s'agit du module `mod_rewrite`, sous Windows une option à cocher)
- Module PDO pour PHP pour l'accès à SQL Server intitulé `PDO_SQLSRV` (disponible [ici](https://www.microsoft.com/en-us/download/details.aspx?id=20098))

Les sources doivent être installées dans le répertoire des sites web :
- Sur linux, ce répertoire est par convention `/var/www/` (il faut donc créer un sous-répertoire à l'intérieur)
- Sur Windows, ce répertoire est choisi au moment de la création du site

Plus de détails sur la création d'un [site web sur IIS](https://msdn.microsoft.com/fr-fr/library/bb763173(v=vs.100).aspx) et la configuration du [module PDO](https://www.vulgarisation-informatique.com/pdo-php-mssql.php).

## Configuration

La configuration de l'afficheur se fait au travers d'un fichier de configuration présent dans le répertoire `config`. Ce répertoire contient par défaut un fichier nommé `default.config.php` et qui est utilisé par défaut. Ce fichier ne doit pas être modifié directement : il faut le dupliquer et nommer la copie `production.config.php`. C'est ce fichier qui pourra ensuite être modifié, et qui contient les informations générales pour le programme :
- Le thème utilisé pour l'affichage graphique
- Le mode `debug` qui active les messages d'erreur
- Ainsi que les paramètres de connexion à la BDD

Voici un exemple de configuration :
```
<?php

return array(
    'debug'        => true,
    'theme'        => 'classic',
    'sql_host'     => 'BDDCOM',
    'sql_user'     => 'afficheur',
    'sql_password' => '',
    'sql_database' => 'FNG'
);
```

Ensuite, l'afficheur utilise un système de **profile** pour configurer les salles qui doivent être affichées. Dans le répertoire `config`, un fichier `default.profile.php` est déjà présent. Il faut ici encore le dupliquer mais le nommage va dépendre du profile qui sera créé. Par exemple, nous allons créer ici le profile `Toulouse` : le fichier dupliqué devra donc porter le nom `Toulouse.profile.php`.

Le fichier doit être complété avec les éléments suivants :
- Le nom de l'établissement, qui sera affiché sur la page d'accueil
- La racine du code analytique de l'établissement
- La liste des numéros (ID) de salles à afficher

Voici un exemple de fichier de profile :

```
return array(
    'nomEtablissement' => "Toulouse - Bâtiment Omega",
    'codeEtablissement' => "TL",
    'salles' => '1101 1102 1103 1104 1105 1106 1107 1108 1109 1110 1111 1112 1113 1114'
);
```

La liste des salles et leurs IDs peut être obtenue grâce à la page `/rooms.php`

## Utilisation

Affichage des réservations pour un profile donné : `http://mon-serveur/<Profile>` (sans le slash final)

## Evolution

L'architecture sommaire du système est la suivante :

```
 -----------                   ------------                     -------------
| Source de |       API       |  Site PHP  |  API REST JSON    | Application |
|  données  |---------------> |  <<CAD>>   |-----------------> |  JavaScript |
 -----------                   ------------                    --------------
Ex: SQLServer    Ex: SQL
```

Ainsi, le système a été prévu pour pouvoir modifier la source d'accès aux données (`CAD`). Actuellement, le système est prévu
pour interroger une base de données de type SQL, mais demain il est envisageable de modifier la CAD afin de récupérer les
informations sur une autre source (par exemple un WebService). La couche intermédiaire en PHP sert justement à formatter les
données pour l'application JavaScript.