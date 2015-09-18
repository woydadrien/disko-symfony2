Disko - Github Flow
=====================

![Disko logo](http://www.huaweibattle.com/images/logo-disko.jpg)


Créez un compte Github
--------------------

Vous êtes nouveau chez Disko (ou pas) et vous n'avez jamais travaillé avec Github (ou pas).

Dans tout les cas, il vous faut, avant toutes choses, [créer un compte](https://github.com/join) et mettre votre pseudo dans le format suivant : **DiskoPrenomLettrenom** (Par exemple: _DiskoAdrienJ_ )

1 - Préparer votre mac
--------------------

#### Installation/configuration de git

Installez **Git** en suivant le lien suivant : 

[(http://git-scm.com/download/mac](http://git-scm.com/download/mac)


Configurer git en ouvrant votre terminal et en executant ces commandes :

    git config --global color.ui true (Met la couleur dans votre git)
    git config --global user.name "{{ VOTRE-NOM-ET-PRENOM }}" (Ajoute votre nom et prénom)
    git config --global user.email VOTRE-EMAIL (Ajoute votre email)
    git config --global core.editor "nano" (Met votre éditeur par défaut à nano)
    git config --global push.default current (Push sur une branche au lieu de toutes les branches)


#### Préparation de la zone de travail

La première chose à faire est de créer votre répertoire pour accueillir vos projets.
Pour cela, nous allons créer un répertoire "Sites" et ouvrant votre terminal.


**Liste des commandes**

    cd ~/
    sudo mkdir Sites


Désormais, il vous suffira de faire un `cd ~/Sites/` pour vous rendre dans votre dossiers ou seront placés tous vos projets.


2 - Cloner un projet
--------------------

Cloner un projet signifie :  Faire une copie des sources d'un projet sur votre environnement local (votre ordinateur).


**Liste des commandes**

    cd ~/Sites/
    git clone git@github.com:diskoagency/NOM-DU-PROJET.git


Vous avez désormais toutes les sources du projet, en vous déplaçant dans le dossier qui vient de se créer, et vous êtes sur la branch `master`


3 - Connaître les branches existantes
--------------------

#### Sur son local

Cela vous montrera toutes les branches présentent sur votre ordinateur pour ce projet.


**Liste des commandes**

    git branch


#### Sur le serveur

Cela vous montrera toutes les branches présentent sur le repo central de disko pour ce projet.


**Liste des commandes**

    git branch -r


4 - Nouvelle fonctionnalité = Créer un nouvelle branche
--------------------

Imaginons qu'on vous demande de créer un nouvelle fontionnalité comme la **création d'une page de contact**.

Pour cela vous allez devoir **créer un nouvelle branche** (car on ne travail jamais sur `master` :p)

Il faut savoir qu'il est impossible de créer une branche vierge, une nouvelle branche **provient toujours d'une branche déjà existante**.

Et par défaut, il faut toujours partir de la branche **master**, et la nouvelle branche devra être nommé de cette façon :
    
    {prenom}/{fonctionnalité}-{originbranche}

Ce qui donnerait pour nous : **adrienj/contactPage-master**


**Liste des commandes**

    git checkout master
    git checkout -b adrienj/contactPage-master (pour dupliquer la branche master sous un nouveau nom)
    git push origin adrienj/contactPage-master (pour envoyer votre branche sur le serveur)


A partir de cet instant, vous pouvez travailler sur votre fonctionnalité ;)


5 - Sauvegarder votre travail (Push)
--------------------

Il est très important de sauvegarder votre travail sur le repo central de disko.

Ceci afin de **ne pas perdre votre travail** en cas de :
- Vol/Cambriolage
- D'ordinateur qui vient à ne plus marcher
- ...

Pour cela, chaque fois que vous avez terminé une partie de votre travail (qui marche), il vous faut réaliser un `commit`.


**Liste des commandes**

    git status (pour vérifier les fichiers prêt à être commité)
    git commit -a -m "Message descriptif en anglais pour mon commit" (l'anglais est indispensable pour permettre la lecture à un maximum de personnes)
    git pull    (Mettre à jour votre travail si quelqu'un à déjà envoyé du travail sur le repo central)
    
    /!\ ### Ici il y a un risque d'un message de merge ou conflits (Voir a section conflits pour corriger)
    
    git push (Envoyer votre travail sur le repo central)


6 - Mettre à jour votre branche par rapport à master (Merge)
--------------------

Il peut arriver que vous souhaitez mettre à jour votre branche par rapport à une autre branche.

Pour cela vous devez effectuez un `merge`.

Par exemple faisons un `merge` entre `master` et `adrienj/contactPage-master`.


**Liste des commandes**

    Point 5 => (Faire en sorte que vos dernières modifications sur votre branche soit commité)
    git checkout master (On va sur la branche master)
    git pull (On met à jour la branche master)
    git checkout adrienj/contactPage-master (On va sur la branche adrienj/contactPage-master)
    git pull (On met à jour la branche adrienj/contactPage-master)
    
    /!\ ### Ici il y a un risque d'un message de merge ou conflits (Voir a section conflits pour corriger)
    
    git merge --no-ff master  (On récupére les travaux de master sur notre branche)
    
    /!\ ### Ici il y a un risque d'un message de merge ou conflits (Voir a section conflits pour corriger)
    
    git push (On met à jour la branche adrienj/contactPage-master sur le repo centrale)


7 - Demander à ce que votre travail soit pris en compte sur master (Pull Request)
--------------------

Une fois que vous avez terminé votre travail sur votre branche. Par exemple : `adrienj/contactPage-master`.

Vous souhaitez qu'elle soit intégré à la branche `master`.

Tout d'abord, mettez votre branche à jour avec master et régler les conflits que vous avez (si vous en avez) **(point 6)**.

Ensuite, il faut vous rendre sur Gihub et faire une demande de pull request.

Un responsable du projet regardera votre code et **acceptera** ou **refusera** votre pull request.


=> En cas de **refus** :
Vous devrez prendre en comtpe les remarques du responsable et faire les corrections sur votre branche puis sauvegarder votre travail en pushant sur le repo central disko.


=> En cas d' **acceptation** :
Votre branche sera détruite et votre travail sera intégré dans master.

Votre travail est terminé ! Good job !


8 - Les différents état de fichier/dossier dans git
--------------------

Dans git, un fichier/dossier peut avoir 3 états différents :

--

=> **"Prêt à être commité"** : 

Dans ce cas, dès que vous ferai un `git commit`, le fichier/dossier  sera sauvegardé.

--

=> **"Modifié mais pas prêt à être commité"** : 

Dans ce cas, un `git commit` ne suffit pas, il faut faire soit un `git add {lefichier ou ledossier}` ou alors faire `git commit -a` et le fichier/dossier sera sauvegardé.

--

=> **"Inconnu de git"** : Dans ce cas, il ne sera jamais pris dans un commit.

Dans ce cas 2 choix : 

=====> Ajouter à git, en faisant un `git add {lefichier ou ledossier}` (par exemple: git add css/main.css)

=====> Ignorer de git **(point 9)**


9 - Ignorer un fichier/dossier
--------------------

Il arrive souvant que certain fichiers ou dossiers ne doivent pas être pris en compte dans le repo git.

Par exemple :

- Des dump SQL
- Des fichiers de config contenant des mots de passe (parameters.yml)
- Les vendors ou librairies externes
- ...

Pour cela, à la racine de votre projet, il vous faut créer/modifier le fichier `.gitignore`


**Liste des commandes**
 
    nano .gitignore

A l'intérieur du fichier par exemple :

    vendor/* 
    dumps/*
    test.html

Puis ajoutez ce fichier dans git si vous venez de le créer.

    git add .gitignore


10 - Gérer un conflit
--------------------

Imaginons 2 personnes **A** et **B**, travaillant respectivement sur la branche **BA** et **BB**.
Et un fichier nommé **test.txt** présent sur **BA** et **BB**, dont voici le contenu sur les deux branches :

    ma première phrase.
    
**A** va modifier le fichier comme ceci sur la branche **BA** :

    ma première phrase.
    ma deuxième phrase.
    ma troisième phrase.

**B** va modifier le fichier comme ceci sur la branche **BB**  :

    ma première phrase.
    ma seconde phrase.
    ma quatrième phrase.
    
**A** fait ça pull request en premier et il n'a aucun soucis.
**B** vient derrière et se rend compte que sa branche a un conflit.

**B** fait donc :
    git status (pour voir les fichiers qui sont en conflits)
    
Autre astuce : On peut faire une recherche de "<<<<<" dans le projet.

**B** se rend compte que c'est le fichier **test.txt** qui est en conflit.
En l'ouvrant, voici ce qu'il décourvre :

    ma première phrase.
    <<<<<<<<<<<<< master
    ma deuxième phrase.
    ma troisième phrase.
    >>>>>>>>>>>>>
    ma seconde phrase.
    ma quatrième phrase.
    <<<<<<<<<<<< 55G27DHD26G2R7R2HRFH2RYY
    
Quand on regarde bien, on s'aperçoit que **A** et **B** ont modifié la même ligne d'un même fichier.
Du coup git ne peut pas se débrouiller tout seul et choisir laquelle des deux versions est bonne.
C'est à vous de le faire ! ;)

On remarque que git a séparé le contenu en deux parties.
La première correspond à master et la seconde à votre travail.
On a aussi la phrase "ma deuxième phrase." et "ma seconde phrase." ou il va falloir faire un choix (pour ça, on va voir son collègue pour en discuter)

Ensuite voilà ce qu'écrit **B** pour corrigé le conflit (**B** et **A** se sont mis d'accord que seconde est plus cool) :

    ma première phrase.
    ma seconde phrase.
    ma troisième phrase.
    ma quatrième phrase.
    
Voilà le fichier est corrigé, maintenant il faut commité !

    git commit -a -m "Fixes conflicts on test.txt"
    git push
    
On peut refaire la pull request ;)
    


    


11 - Voir les derniers commit
--------------------

Il peut arriver parfois, que vous voulez savoir si oui ou non certaines modifications ont été appliquées sur une branche.
Pour cela il faut utiliser la commande : `git log`


**Liste des commandes**

    git checkout adrienj/contactPage-master
    git log

Résultat :

    commit bc9610698346895fc0f82be1f7e90944aeb390a4
    Author: Jerphagnon <jerphagnon@mbpdejerphagnon.home>
    Date:   Fri Sep 18 09:24:05 2015 +0200

        FIxes bug upload

    commit 76450550edf47c0817b215beddcd121524c240ff
    Merge: 07d9d38 bbf5b50
    Author: Jerphagnon <jerphagnon@mbpdejerphagnon.home>
    Date:   Fri Sep 18 09:20:36 2015 +0200

        Merge remote-tracking branch 'disko/master'
        
    ... etc
    
Ici on voit une liste de commits. On peut donc voir que le premier commit  est le numéro `bc9610698346895fc0f82be1f7e90944aeb390a4` créé par `Jerphagnon` le `Fri Sep 18 09:24:05 2015 +0200`.


12 - Changer de branche
--------------------

Pour changer de branche, il vous suffit de faire la commande `git checkout LeNomDeLaBranche`.


**Liste des commandes**

    git branch (pour voir sla branche sur laquelle on est)
    git checkout adrienj/contactPage-master (pour changer de branche)
    
13 - Mettre votre travail de coté
--------------------

Il existe dans git, un moyen simple de mettre votre travail de coté.
Imaginons que vous êtes sur la branche `adrienj/contactPage-master`, que vous avez travaillé durement dessus mais pa terminé encore.
Un chef de projet vient vous demander une urgence sur une autre branche appelé `jimmyZ/homepagePage-master`.

Si vous faites un `git checkout jimmyZ/homepagePage-master` directement, git vous dira que vous avez des fichiers modifiés et non commité sur votre branche en cours.

Du coup, 2 solutions s'offre à vous :
- 1 : Vous commitez votre travail et vous changer de branche
- 2 : Vous utilisez un stash pour mettre votre travail de coté, vous changez de branche, vous travaillez l'urgence et vous revenez si votre première branche.


**Liste des commandes**

    git stash (met votre travail de coté)
    git checkout jimmyZ/homepagePage-master (change de branche)
    git status (je vérifie mon taff)
    git commit -a -m "J'ai fini l'urgence"
    git checkout adrienj/contactPage-master (change de branche)
    git stash --apply (récupérer les anciennes modifications)
    
    
14 - Faire revenir un fichier comme avant
--------------------
   
Imaginons que vous avez modifié un fichier et que vous voulez revenir à son état avant modification.
Pour cela il faut utiliser la commande `git checkout CheminDuFichier` (oui c'est la même commande que de changer de branche)

**Liste des commandes**

    git checkout test.html (fait revenir test.html à l'état du dernier commit)
    git checkout folder/ (fait revenir tout le dossier à l'état du dernier commit)
    git reset --hard LeNuméroDuCommit (vous revenez à l'état du dernier commit et toutes vos modifications disparaissent)