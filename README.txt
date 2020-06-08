Projet - WorkShop [EQUIPE 2]

Ce projet a nécessité du développement Web utilisant les langages PHP, HTML, CSS, JS, et MySQL.
Par conséquent, le dossier de projet a besoin d'une base de donnée MySQL, d'un interpréteur PHP ainsi que d'un serveur Apache.

Afin de vous faciliter la tâche, nous vous conseillons le logiciel que nous avons utilisé pour le développement :
--> XAMP (Linux) qui a ses équivalents sous Mac (MAMP) et Windows (WAMP). Il regroupe tout ce dont nous avons besoin.

Une fois les conditions réunis, il ne reste plus que 2 étapes à faire :
--> Créer une base de donnée appelée "photoweb_workshop" et y lire le fichier photoweb_workshop.sql ci-joint au projet
	- Si vous avez utilisé XAMPP ou un équivalent cité ci-dessus tout se passe dans l'onglet "Importer".
	- Sinon, \i photoweb_workshop.sql dans la base de donnée "photoweb_workshop".
--> Mettre à la racine de votre serveur Apache le dossier de projet "workshop".

Quand tout est mis en place, le point d'entrée du workshop se fait par son accueil qui est l'URL suivante :
	
	http://localhost/*[votre chemin d'accès]*/workshop/controler/main.ctrl.php

Un accès à la documentation technique est disponible par ce chemin :

	http://localhost/*[votre chemin d'accès]*/workshop/doc/workshop_doc/html/annotated.html

pour accéder à un profil privé, une authentification est nécessaire. Pour cela, vous avez à disposition dans la table de pw_user de la base de donnée
les différents utilisateurs déjà créés. Vous avez l'embarras du choix !
--> Soit avec une requête en mode commande,
--> Soit avec phpmyadmin (si XAMPP ou MAMP ou WAMP) ici : http://localhost/phpmyadmin, dans la table pw_user de la BDD photoweb_workshop.


Si toutefois vous rencontrez des problèmes, veuillez contacter le chef de projet à l'adresse e-mail suivante : 

				loic.dubois-termoz@iut2.univ-grenoble-alpes.fr

Un accès grâce à un serveur en ligne pourra être fait en cas de problème.