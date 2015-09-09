
Installation DEBIAN
-----------------

### Installtion de firefox
```
sudo apt-get remove iceweasel
sudo nano /etc/apt/sources.list
```

=> Ajouter cette ligne : ``deb http://packages.linuxmint.com debian import``

```
sudo apt-get update
sudo gpg --keyserver pgp.mit.edu --recv-keys 3EE67F3D0FF405B2
sudo gpg --export 3EE67F3D0FF405B2 > 3EE67F3D0FF405B2.gpg
sudo apt-key add ./3EE67F3D0FF405B2.gpg
sudo rm ./3EE67F3D0FF405B2.gpg
sudo apt-get install firefox
```

### Installtion de java

Java nous servira à lancer Selenium2 afin de réaliser des tests fonctionnels javascript de l'application.

```
sudo apt-get install python-software-properties
sudo apt-get install openjdk-7-jre
```

### Installtion de xvfb Frame

xvfb servira à la simulation d'un écran pour firefox et Selenium2.

```
sudo apt-get install xvfb
sudo Xvfb :10 -ac
export DISPLAY=:1.0
```



Installation SF2
-----------------

### Création des bin utilitaires

Ajouter/Créer les bin suivant dans le dossier `bin/`.

**launch-selenium-server** :

Permet de lancer le serveur Selenium2.

```
#!/bin/bash

export DISPLAY=:1.0
java -jar src/Disko/BehatBundle/Server/selenium-server-standalone-2.39.0.jar
```

**launch-xvbf-server** :

```
#!/bin/bash

export DISPLAY=:1.0
Xvfb :1 -screen 0 1024x768x24
```

### Hériter le bundle

Créer un BehatBundle qui héritera de BehatBundle puis remplir le dossier Features/Stories/ et definir le behat.yml

[Documentation sur comment faire un héritage](http://symfony.com/fr/doc/current/cookbook/bundles/inheritance.html)

### Lancer les test behat


bin/behat  --config src/Disko/BehatBundle/behat.yml