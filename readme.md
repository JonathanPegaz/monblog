# MonBlog
    Utilisation du framework dans le cadre de la réalisation d'un blog

## Installation 

    Executer dans le repertoire du projet :
    1 - composer install
    2 - npm install
    3 - npm run build
    4 - php bin/console doctrine:migrations:migrate
    5 - php bin/console doctrine:fixtures:load
    6 - symfony serve

## Utilisation

    Connection:
        Admin: 
            login: Admin
            mdp: password
        Auteur:
            login: Author
            mdp: password
        Utilisateur:
            login: User
            mdp: password
    
    Possibilité de consulter le blog et commenter les articles en tant qu'utilisateur.

    Possibilité de rajouter du contenu au blog en tant qu'auteur.

    Possibilité de créer des utilisateurs en plus du reste en tant qu'administrateur.

    Utilisation d'EasyAdmin pour gérer un backoffice pour les auteurs et les administrateurs.
