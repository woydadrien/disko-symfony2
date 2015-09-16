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

> `git config --global color.ui true` _( Met la couleur dans votre git )_

> `git config --global user.name "{{ VOTRE-NOM-ET-PRENOM }}"` _( Ajoute votre nom et prénom )_

> `git config --global user.email VOTRE-EMAIL` _( Ajoute votre email )_

> `git config --global core.editor "nano"` _( Met votre éditeur par défaut à nano )_

> `git config --global push.default current` _( Push sur une branche au lieu de toutes les branches )_


#### Préparation de la zone de travail

La première chose à faire est de créer votre répertoire pour accueillir vos projets.
Pour cela, nous allons créer un répertoire "Sites" et ouvrant votre terminal.


**Liste des commandes**

> `cd ~/`

> `sudo mkdir Sites`


Désormais, il vous suffira de faire un `cd ~/Sites/` pour vous rendre dans votre dossiers ou seront placés tous vos projets.


2 - Cloner un projet
--------------------

Cloner un projet signifie :  Faire une copie des sources d'un projet sur votre environnement local (votre ordinateur).


**Liste des commandes**

> `cd ~/Sites/`

> `git clone git@github.com:diskoagency/NOM-DU-PROJET.git`


Vous avez désormais toutes les sources du projet, en vous déplaçant dans le dossier qui vient de se créer, et vous êtes sur la branch `master`


3 - Connaître les branches existantes
--------------------

#### Sur son local

Cela vous montrera toutes les branches présentent sur votre ordinateur pour ce projet.


**Liste des commandes**

> `git branch`


#### Sur le serveur

Cela vous montrera toutes les branches présentent sur le repo central de disko pour ce projet.


**Liste des commandes**

> `git branch -r`


4 - Nouvelle fonctionnalité = Créer un nouvelle branche
--------------------

Imaginons qu'on vous demande de créer un nouvelle fontionnalité comme la **création d'une page de contact**.

Pour cela vous allez devoir **créer un nouvelle branche** (car on ne travail jamais sur `master` :p)

Il faut savoir qu'il est impossible de créer une branche vierge, une nouvelle branche **provient toujours d'une branche déjà existante**.

Et par défaut, il faut toujours partir de la branche **master**, et la nouvelle branche devra être nommé de cette façon :
> **{prenom}/{fonctionnalité}-{originbranche}**

Ce qui donnerait pour nous : **adrienj/contactPage-master**


**Liste des commandes**

> `git checkout master`

> `git checkout -b adrienj/contactPage-master` _( pour dupliquer la branche master sous un nouveau nom )_

> `git push origin adrienj/contactPage-master` _( pour envoyer votre branche sur le serveur )_


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

> `git status` _( pour vérifier les fichiers prêt à être commité )_

> `git commit -a -m "Message descriptif en anglais pour mon commit"` _( l'anglais est indispensable pour permettre la lecture à un maximum de personnes )_

> `git pull`    _( Mettre à jour votre travail si quelqu'un à déjà envoyé du travail sur le repo central )_

> /!\ ### Ici il y a un risque d'un message de merge ou conflits _( Voir a section conflits pour corriger)_

> `git push` _( Envoyer votre travail sur le repo central )_


6 - Mettre à jour votre branche par rapport à master (Merge)
--------------------

Il peut arriver que vous souhaitez mettre à jour votre branche par rapport à une autre branche.

Pour cela vous devez effectuez un `merge`.

Par exemple faisons un `merge` entre `master` et `adrienj/contactPage-master`.


**Liste des commandes**

> _( Fait en sorte que vos dernières modifications sur votre branche soit commité )_

> `git checkout master` _( On va sur la branche master )_

> `git pull` _( On met à jour la branche master )_

> `git checkout adrienj/contactPage-master` _( On va sur la branche adrienj/contactPage-master )_

> `git pull` _( On met à jour la branche adrienj/contactPage-master )_

> /!\ ### Ici il y a un risque d'un message de merge ou conflits _( Voir a section conflits pour corriger)_

> `git merge --no-ff master`  _( On récupére les travaux de master sur notre branche )_

> /!\ ### Ici il y a un risque d'un message de merge ou conflits _( Voir a section conflits pour corriger)_

> `git push` _( On met à jour la branche adrienj/contactPage-master sur le repo centrale )_


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

=====> Ajouter à git, en faisant un `git add {lefichier ou ledossier}` _( par exemple: git add css/main.css )_

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
 
> `nano .gitignore`

A l'intérieur du fichier par exemple :

> vendor/* 

> dumps/*

> test.html

Puis ajoutez ce fichier dans git si vous venez de le créer.

> `git add .gitignore`


10 - Gérer un conflit
--------------------

@Todo


