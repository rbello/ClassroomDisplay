# ClassroomDisplay

Ce projet est un afficheur de salle pour un centre de formation.

## Configuration

La configuration de l'afficheur se fait au travers d'un fichier de configuration présent dans le répertoire `config`. Ce répertoire contient par défaut un fichier nommé `default.config.php` et qui est utilisé par défaut. Ce fichier ne doit pas être modifié directement : il faut le dupliquer et nommer la copie `production.config.php`. C'est ce fichier qui pourra ensuite être modifié, et qui contient les informations générales pour le programme :
- Le thème utilisé pour l'affichage graphique
- Le mode `debug` qui active les messages d'erreur

Ensuite, l'afficheur utilise un système de **profile** pour configurer les salles qui doivent être affichées. Dans le répertoire `config`, un fichier `default.profile.php` est déjà présent. Il faut ici encore le dupliquer mais le nommage va dépendre du profile qui sera créé. Par exemple, nous allons créer ici le profile `Toulouse` : le fichier dupliqué devra donc porter le nom `Toulouse.profile.php`.

## Utilisation

Entrer l'URL suivante : `http://mon-serveur/<Profile>/`
L'affichage apparaît automatiquement si le fichier de configuration est bien paramétré. Si non, un message d'erreur apparaît.

Le serveur utilise une API REST renvoyant du JSON qui s'utilise de cette manière :
