<img src="images/logo-border.svg" width="55%" />

Ce dépôt fait partie du projet [helPHP](https://helphp.org), et a la même licence et règles de contribution que le [dépôt principal de helPHP](https://github.com/INRAI-helPHP/helPHP).

# HelPHP_instance

Qu'est-ce qu'une instance HelPHP ?

Si vous avez de l'expérience dans la création d'applications Web/sites Web, vous savez que vous utilisez souvent beaucoup de composants redondants.

HelPHP essaie de réduire la consommation de ressources mais aussi de réduire les tâches de maintenance etc...
Donc, si nous prenons tous les composants redondants et les mutualisons sur le serveur, nous pouvons réduire l'utilisation du stockage disque, mais aussi, si nous prenons soin que ces composants puissent être OpCached par PHP, nous gagnerons en mémoire, CPU et vitesse globale d'exécution !

Ainsi, HelPHP est composé d'une énorme partie redondante, le ["dépôt principal"](https://github.com/INRAI-helPHP/helPHP) (contenant les libs core, modules, et utils) qui sont partagés entre chaque projet qui les instancient.

Donc, une instance HelPHP est un ensemble de dossiers et de petits fichiers prêts à instancier tous ces composants partagés.

Pour vous aider à visualiser comment cela fonctionne, voici les relations entre eux :

![hphp-global.svg](images/hphp-global.svg)

Le plus important à savoir est que tous les modules partagés du dépôt principal sont appelés par un fichier index.php dans le dossier admin/module_name ou public_module_name, et si vous avez une exception à coder ou quelque chose à changer, vous pouvez étendre la classe du module dans le fichier index.php et le faire sans faire aucun changement dans le dépôt principal.

Comme ça, vous pouvez garder à jour le dépôt principal, héberger des tonnes de projets sur le même serveur, et créer des exceptions quand nécessaire sans casser quoi que ce soit.

# Installation :

Si vous n'avez pas configuré l'environnement nécessaire, veuillez regarder ce dépôt que nous avons préparé et sélectionnez votre saveur d'installation : [Installation d'environnement HelPHP](https://gitlab.com/dateam2/helphp-env-install)

Clonez simplement ce projet sur votre serveur avec git et clonez le [dépôt principal helphp](https://gitlab.com/dateam2/helphp) ailleurs sur le même serveur.

Si vous avez cloné l'instance dans un dossier prêt à être servi par votre service httpd, appelez simplement l'url correspondante pour ce dossier + installscript.php pour lancer l'installation...

# Documentation :

Veuillez aller sur [helphp.org/documentation/instance](https://helphp.org/documentation/instance)

## Faites un don pour nous aider

Sur la page d'accueil de [helphp.org](https://www.helphp.org), vous trouverez un bouton de don. 
Avec cela, vous pouvez faire un don unique ou récurrent pour soutenir notre travail.
Bien sûr, comme toute équipe, nous avons besoin d'argent pour payer les différents services (serveurs/domaines/électricité) et quand il y en a assez, nous pouvons embaucher de l'aide pour accélérer le WIP actuel. 
Donc, si vous voulez nous aider ou juste nous offrir un petit café, merci d'avance :)