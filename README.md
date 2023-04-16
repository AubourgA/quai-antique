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
creer un fichier à la racine du projet: .env.local

## CONNEXION BDD
DATABASE_URL="mysql://id:mdp@127.0.0.1:3306/lequaiantique?serverVersion=8&charset=utf8mb4"
avec :
 id = votre identifiant
 mdp = votre mot de passe

## SERVICE MAIL

app configurer pour outlook donc pour une utilisation generique, il est conseillé d'utiliser un service d'envoie de mail comme mailtrap

Se connecter à un compte MAILTRAP (par exemple) et recuperer la clef pour symfony et copier la ligne dans le fichier

MAILER_DSN=xxxxxx


# CREATION DE LA BDD
lancer un serveur apache / mysql

taper dans le terminal :
````
php bin/console doctrine:database:create
````

## GENERER BDD

un fichier SQL se trouve dans le dossier SQL
Ce fichier comporte toutes les reqettes pour générer les tables et pour ajouter l'ensemble des donnée

pour se faire dans l'invite de commande taper :

mysql -u [user] -p
puis taper votre mot de passe

puis taper : 
mysql> use LEQUAIANTIQUE;
mysql> source path/bdd.sql;


La base de donnée a été importé

# DEMMARER un server local avec symfony
taper :
 > symfony serve

### ACCES MODE ADMIN

ID : admin@admin.fr
MDP : passwordADMIN



