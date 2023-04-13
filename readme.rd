# INITIALISATION

git clone https://github.com/AubourgA/quai-antique.git

composer install


# CONFIGURATIN
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


$entree_title = ['Salade de saumon', 'formage et son lit de lit', 'mini burger et sa salade'];
      $entree_desc = ['Salde, saumon, sauce', 'poisson de la peche','paim moeilleux'];
      $entree_price = ['15.90','17.90','19.90'];
       
      $day = ['Lundi', 'Mardi','Mercredi','Jeudi', 'Vendredi','Samedi','Dimanche'];
      $lunchStart = ['00:00','12:00','12:00','12:00','12:00','12:00','00:00'];
      $lunchEnd = ['00:00','14:00','14:00','14:00','14:00','14:00','00:00'];
      $dinnerStart = ['19:00','19:00','19:00','19:00','19:00','19:00','00:00'];
      $dinnerEnd = ['21:30','21:00','21:00','21:00','21:00','22:00','00:00'];

      $day = ['Lundi', 'Mardi','Mercredi','Jeudi', 'Vendredi','Samedi','Dimanche'];
      $lunchStart = ['00:00','12:00','12:00','12:00','12:00','12:00','00:00'];
      $lunchEnd = ['00:00','14:00','14:00','14:00','14:00','14:00','00:00'];
      $dinnerStart = ['19:00','19:00','19:00','19:00','19:00','19:00','00:00'];
      $dinnerEnd = ['21:30','21:00','21:00','21:00','21:00','22:00','00:00'];

      //entree
        for ($i =0; $i < count($entree_title); $i++) {
            $entrees = new Entree;
            $entrees->setTitle($entree_title[$i]);
            $entrees->setDescription($entree_desc[$i]);
            $entrees->setPrice($entree_price[$i]);
            $entrees->setCreatedAt(new \DateTimeImmutable());
            $entrees->setIsActive(1);
            $manager->persist($entrees);

        }

     for ($i =0; $i < count($day); $i++) {
            $schedule = new Schedule;
            $schedule->setAdmin(new Admin);
            $schedule->setDay($day[$i]);
            $schedule->setLunchStart(new DateTime($lunchStart[$i]));
            $schedule->setLunchEnd(new DateTime($lunchEnd[$i]));
            $schedule->setDinnerStart(new DateTime($dinnerStart[$i]));
            $schedule->setDinnerStart(new DateTime($dinnerEnd[$i]));
         
            $manager->persist($schedule);

        }