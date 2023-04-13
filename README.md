# INITIALISATION

git clone https://github.com/AubourgA/quai-antique.git

composer install


# CONFIGURATION
creer un fichier .env.local

AJOUTER LIGNE POUR BDD
DATABASE_URL="mysql://id:mdp@127.0.0.1:3306/basename?serverVersion=8&charset=utf8mb4"
avec :
 id = votre identifiant
 mdp = votre mot de passe
 basename = nom de la base de donnée

AJOUTER LIGNE POUR SERVICE MAIL
 pour ajouter service mail (exemple pour un service hotmail):

MAILER_DSN=smtp://votremail:mdp@smtp-mail.outlook.com:587?verify_peer=0

# CREATION DE LA BDD
lancer un serveur apache et mysql

taper php bin/console doctrine:database:create

taper php bin/console doctrine:migrations:migrate

# JEU DE DONNEE
taper php bin/console doctrine:fixtures:load


