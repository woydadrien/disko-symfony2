Disko - Symfony2 - Contributors
=====================

![Disko logo](http://www.huaweibattle.com/images/logo-disko.jpg)

## Comment administrer le module npm ?

Vous voulez améliorer ou upgrader le module npm **generator-disko-symfony2**, rien de plus simple :p

Pour cela, il vous suffit de cloner le repo :

> git clone https://github.com/woydadrien/generator-disko-symfony2.git

Ensuite dans le dossier généré **generator-disko-symfony2** vous pouvez apporter vos modifications :

Pour tester le module en locale :
> npm link

Pour publier vos modifications sur npm (attention, il vous faut monter la version dans le package.json)
> npm publish

Si vous avez un problème d'authentification, il vous faut créer un compte npmjs avec la commande :
> npm adduser

Voilà ;)


#### PS: Références

https://quickleft.com/blog/creating-and-publishing-a-node-js-module/
http://yeoman.io/learning/index.html