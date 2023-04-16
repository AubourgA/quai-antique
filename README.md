# INITIALISATION
taper dans le terminal
````
git clone https://github.com/AubourgA/quai-antique.git
````
puis :
````
cd quai-antique
````

Installer le dossier vendor :
````
composer install
````

# CONFIGURATION
creer un fichier à la racine du projet:

 ````
 touch ".env.local"
 ````

## CONNEXION BDD

Ouvrir se ficher dans votre editeur de code


et copier la ligne suivante  en remplacant id et mdp:


`DATABASE_URL="mysql://id:mdp@127.0.0.1:3306/lequaiantique?serverVersion=8&charset=utf8mb4"`
avec :

 id = votre identifiant

 mdp = votre mot de passe

## SERVICE MAIL

L'app est configurée pour une messagerie outlook. 

Donc pour une utilisation génerique, il est conseillé d'utiliser un service d'envoi de mail comme mailtrap.

Se connecter à un compte MAILTRAP (par exemple) et récuperer la clef pour symfony. 


copier ce code dans le fichier .env.local :

 `MAILER_DSN=VOTRE-CLEF`

 et remplacer `VOTRE-CLEF` par la clef symfony récupérée précédemment.




# BASE DE DONNEES

## INITIALISER LA BDD
lancer un serveur apache / mysql

taper dans le terminal  :
````
php bin/console doctrine:database:create
````

## GENERER LA BDD

un fichier SQL se trouve dans le dossier \SQL

Ce fichier comporte toutes les reqettes pour générer les tables et pour ajouter l'ensemble des données.

Se  connecter a MySql taper :

````
mysql -u [user] -p
````

puis :
````
 votre mot de passe
````


Ensuite taper sous l'invite mysql> :
```` 
use LEQUAIANTIQUE;
````

puis :
````
source path/bdd.sql;
````

Si le fichier bdd.sql ne se charge pas à l'emplacement acutel, déplacer le à la racine du disque exemple : C:\bdd.sql et taper :

````
source C:/bdd.sql;
````

La base de donnée devrait être importé à ce stade. Vous pouvez vous deconnecter de mysql en tapant :

````
exit
````


# DEMMARER un server local avec symfony
taper  dans le terminal:
 
 ````
 symfony serve
 ````


### ACCES MODE ADMIN

Pour acceder à l'espace admin :


ID : admin@admin.fr


MDP : passwordADMIN



