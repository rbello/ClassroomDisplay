# Classroom Display

Ce projet est un afficheur de salle pour un centre de formation.

## Configuration

Cette application utilise PHP (version 5.2 minimum) uniquement. Elle est faite pour tourner sur Apache ou sur Microsoft IIS (avec l'extension PHP). Le module de réécriture d'URL doit être installé également (sous Apache il s'agit du module `mod_rewrite`).

La configuration de l'afficheur se fait au travers d'un fichier de configuration présent dans le répertoire `config`. Ce répertoire contient par défaut un fichier nommé `default.config.php` et qui est utilisé par défaut. Ce fichier ne doit pas être modifié directement : il faut le dupliquer et nommer la copie `production.config.php`. C'est ce fichier qui pourra ensuite être modifié, et qui contient les informations générales pour le programme :
- Le thème utilisé pour l'affichage graphique
- Le mode `debug` qui active les messages d'erreur

Ensuite, l'afficheur utilise un système de **profile** pour configurer les salles qui doivent être affichées. Dans le répertoire `config`, un fichier `default.profile.php` est déjà présent. Il faut ici encore le dupliquer mais le nommage va dépendre du profile qui sera créé. Par exemple, nous allons créer ici le profile `Toulouse` : le fichier dupliqué devra donc porter le nom `Toulouse.profile.php`.

Le fichier doit être complété avec les éléments suivants :
- Le nom de l'établissement, qui sera affiché sur la page d'accueil
- La racine du code analytique de l'établissement
- La liste des numéros (ID) de salles à afficher

Voici un exemple de fichier :

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

Affichage des publicités : `http://mon-serveur/pub/<Profile>`
