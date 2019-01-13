1ére etape : git clone https://gitlab.com/yosser/location-de-voiture.git
2éme étape : ouvrir l'emplacement du projet , exemple: c:\xamp\www\gestionLocation puis lance la commande composer.update
3éme étape: crée votre bse de donné avec le nom qui se trouve dans le fichier app\parametres.yml pour la creation de la base donnée lance la commnde suivante :
 php bin/console doctrine:database:create

4éme étape : lance la commande   php bin/console doctrine:schema:validate
si toute est bien 
lance la commande suivante : php bin/console doctrine:schema:update --force

5éme étape : avec la ligne de commande crée un super admin  lance la commande suivante :
php bin/console fos:user:create puis entrée et suis les étapes

6éme attribus un role super admin a l'utilisateur que tu as crée lance la commande suivante : 
php bin/console fos:user:promote testuser ROLE_SUPER_ADMIN

7éme étape run le projet : php bin/console server:run

8éme étape : ouvrir le navigateur localhost:8000/login
