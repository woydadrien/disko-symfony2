"use strict";

var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var path = require('path');
var yaml = require('js-yaml');
var fs = require('fs-extra');
var rmdir = require('rimraf');
var child_process = require('child_process');
var http = require("http");

module.exports = yeoman.generators.Base.extend({





  initializing: function () {
    this.pkg = require('../package.json');
    var diskoLogo = "\n\n           ----------------------------- \n\n"+chalk.green.bold("\n      _______   __       _______. __  ___   ______   "+
                   "\n     |       \\ |  |     /       ||  |/  /  /  __  \\"+
                   "\n     |  .--.  ||  |    |   (----`|  '  /  |  |  |  | "+
                   "\n     |  |  |  ||  |     \\   \\    |    <   |  |  |  |"+
                   "\n     |  '--'  ||  | .----)   |   |  .  \\  |  `--'  | "+
                   "\n     |_______/ |__| |_______/    |__|\\__\\  \\______/");

    var diskoDesc = '\n\n           ----------------------------- \n\n   A '+chalk.green.bold('Yeoman generator')+' for the Symfony2 framework\n   Created by ' + chalk.cyan.bold('@Woydadrien - adrien.j@disko.fr') +  '\n\n           ----------------------------- \n\n';
    this.log(diskoLogo);
    this.log(diskoDesc);
  },


  askName: function () {
    var done = this.async();

    this.projectName = '';

    var prompts = [{
      type: 'question',
      name: 'projectName',
      message: 'Quel est le nom de votre  projet ?',
      default: 'newproject'
    }];

    this.prompt(prompts, function(answers) {
      this.projectName = answers.projectName;
      done();
    }.bind(this));
  },

  askDomainName: function () {
    var done = this.async();

    this.domainName = '';

    var prompts = [{
      type: 'question',
      name: 'domainName',
      message: "Quelle est l'url en local de votre projet ?",
      default: 'newproject.dev'
    }];

    this.prompt(prompts, function(answers) {
      this.domainName = answers.domainName;
      done();
    }.bind(this));
  },

  askIpVagrant: function () {
    var done = this.async();

    this.ipVagrant = '';

    var prompts = [{
      type: 'question',
      name: 'ipVagrant',
      message: "Quelle est l'ip en local de votre vagrant ? (juste à changer le dernier chiffre entre 102 et 250)",
      default: '192.168.56.102'
    }];

    this.prompt(prompts, function(answers) {
      this.ipVagrant = answers.ipVagrant;
      done();
    }.bind(this));
  },


  choiceProjectMode: function () {
    var done = this.async();

    var prompts = [{
      type: 'list',
      name: 'projectMode',
      message: 'Choisissez le mode du projet',
      default: 'standard',
      choices: ['standard']
    }];

    this.prompt(prompts, function(answers) {
      this.projectMode = answers.projectMode;
      done();
    }.bind(this));
    this.log('');
    this.log('');
    this.log('');
  },

  informConfiguration: function (){
    this.log('');
    this.log('     Symfony :  '+chalk.green.bold('2.7'));
    this.log('     Mode :  '+chalk.green.bold(this.projectMode));
  },






  installComposer: function() {
    this.log('');
    var done = this.async();
    this.log(chalk.green.bold('     Installation de composer'));
    child_process.exec('php -r "readfile(\'https://getcomposer.org/installer\');" | php', function(error, stdout, stderr) {
      if (error)
      {
        console.log('     Composer : '+chalk.red.bold('Error.'));
      }
      else{
        console.log('     Composer : '+chalk.green.bold('Install success.'));
      }
      done();
    }.bind(this));
  },






  installGulp: function() {
    this.log('');
    var done = this.async();

    this.log(chalk.green.bold('     Installation de Gulp') + ' (' + chalk.yellow('le mot de passe sudo peut être demandé') + ')');
    child_process.execFile('gulp', ['-v'], function(error, stdout, stderr) {
      if (error !== null) {
        child_process.exec('sudo npm install -g gulp', function(error, stdout, stderr) {
          if (error)
          {
            console.log('     Gulp : '+chalk.red.bold('Error.'));
          }
          else{
            console.log('     Gulp : '+chalk.green.bold('Install success.'));
          }
          done();
        }.bind(this));
      } else {
        console.log('     Gulp : '+chalk.green.bold('Already install.'));
        done();
      }
    });

  },



  askOptionnalBundle: function() {
    this.log('');
    var done = this.async();

    var prompts = [{
      type: 'checkbox',
      name: 'addBundle',
      message: 'Quels bundles optionnels voulez-vous utiliser ?',
      choices: [
        {
          name: 'DoctrineFixturesBundle',
          value: 'fixturebundle',
          checked: true
        },
        {
          name: 'DoctrineMigrationsBundle',
          value: 'migrationbundle',
          checked: true
        }
      ]
    }];

    this.prompt(prompts, function(answers) {
      function hasFeature(feat){
        return answers.addBundle.indexOf(feat) !== -1;
      }

      this.fixturebundle = hasFeature('fixturebundle');
      this.migrationbundle = hasFeature('migrationbundle');
      done();
    }.bind(this));
  },


  vagrantReinstall: function () {
    var done = this.async();

    this.installVagrant = false;

    var prompts = [{
      type: 'question',
      name: 'installVagrant',
      message: "Voulez vous monter la vagrant automatiquement ?",
      default: false
    }];

    this.prompt(prompts, function(answers) {
      this.installVagrant = answers.installVagrant;
      done();
    }.bind(this));
  },

  confirmInstall: function(){
    console.log('');
    var done = this.async();

    var prompts = [{
      type: 'confirm',
      name: 'confirmInstall',
      message: 'Confirm generation project ?',
      default: true
    }];

    this.prompt(prompts, function(answers) {

      var nb = 0;
      var maxnb = 10;

      fs.removeSync(this.destinationPath('app/'), allRemoveEnd());
      fs.removeSync(this.destinationPath('bin/'), allRemoveEnd());
      fs.removeSync(this.destinationPath('src/'), allRemoveEnd());
      fs.removeSync(this.destinationPath('web/'), allRemoveEnd());
      fs.removeSync(this.destinationPath('puphpet/'), allRemoveEnd());
      fs.removeSync(this.destinationPath('.gitignore'), allRemoveEnd());
      fs.removeSync(this.destinationPath('package.json'), allRemoveEnd());
      fs.removeSync(this.destinationPath('composer.json'), allRemoveEnd());
      fs.removeSync(this.destinationPath('gulpfile.js'), allRemoveEnd());
      fs.removeSync(this.destinationPath('Vagrantfile'), allRemoveEnd());

      function allRemoveEnd(){
        nb++;
        if (nb >= maxnb)
        {
          done();
        }
      }

      this.writingConfirm = answers.confirmInstall;
      this.log('');

    }.bind(this));
  },


  writing: {
    App: function () {
      if (this.writingConfirm)  {
        this.log('');
        this.fs.copy(this.templatePath(this.projectMode + '/app'), this.destinationPath('app'));
        this.fs.copy(this.templatePath(this.projectMode + '/bin'), this.destinationPath('bin'));
        this.fs.copy(this.templatePath(this.projectMode + '/src'), this.destinationPath('src'));
        this.fs.copy(this.templatePath(this.projectMode + '/web'), this.destinationPath('web'));
        this.fs.copy(this.templatePath(this.projectMode + '/puphpet'), this.destinationPath('puphpet'));

        this.template(this.projectMode + '/.gitignore', '.gitignore');
        this.template(this.projectMode + '/package.json', 'package.json');
        this.template(this.projectMode + '/composer.json', 'composer.json');
        this.template(this.projectMode + '/gulpfile.js', 'gulpfile.js');
        this.template(this.projectMode + '/puphpet/config.yaml', 'puphpet/config.yaml');
        this.template(this.projectMode + '/Vagrantfile', 'Vagrantfile');

        this.fs.copy(this.templatePath(this.projectMode + '/editorconfig'),this.destinationPath('.editorconfig'));
        this.fs.copy(this.templatePath(this.projectMode + '/jshintrc'), this.destinationPath('.jshintrc'));
        this.log('');
        this.log('');
      }
    }
  },

  end: {

    installVagrant: function(){
      if (this.installVagrant)  {
        console.log('');
        var done = this.async();

        this.log(chalk.cyan('         Install Vagrant...') + chalk.yellow(" (L'opération peut prendre plusieurs minutes)"));
        child_process.exec('vagrant destroy --force && vagrant up', function (error, stdout, stderr) {
          if (error != null)
          {
            console.log(chalk.red.bold(error));
            console.log(chalk.red.bold('         Error'));
          }
          else{
            console.log(chalk.green.bold('         Success'));
          }
          console.log('');
          done();
        });
      }
    },

    installVendors: function(){
      if (this.writingConfirm)  {
        var done = this.async();

        var command = 'cd /var/www && php composer.phar update';
        if (this.installVagrant)
        {
          command = 'vagrant ssh -c "'+command+'"';
        }

        console.log('');
        this.log(chalk.cyan('         Install Vendors...'));
        child_process.exec(command, function (error, stdout, stderr) {
          if (error != null)
          {
            console.log(chalk.red.bold(error));
            console.log(chalk.red.bold('         Error'));
          }
          else{
            console.log(chalk.green.bold('         Success'));
          }
          console.log('');
          done();
        });
      }
    },

    fixturesBundle: function(){
      var diskoProcess = this;
      if (this.writingConfirm)  {
        var done = this.async();
        if (this.fixturebundle) {


          var command = 'cd /var/www && php composer.phar require doctrine/doctrine-fixtures-bundle';
          if (this.installVagrant)
          {
            command = 'vagrant ssh -c "'+command+'"';
          }

          this.log(chalk.cyan('         Add & Install : doctrine/doctrine-fixtures-bundle...'));
          child_process.exec(command, function (error, stdout, stderr) {
            if (error != null)
            {
              console.log(chalk.red.bold('         Error'));
            }
            else{


              var appKernelContents = diskoProcess.readFileAsString('app/AppKernel.php');
              var newAppKernelContents = appKernelContents.replace('##Yeoman', '        $bundles[] = new Doctrine\\Bundle\\FixturesBundle\\DoctrineFixturesBundle();\n##Yeoman');
              fs.writeFileSync('app/AppKernel.php', newAppKernelContents);

              console.log(chalk.green.bold('         Success'));
            }
            console.log('');
            done();
          });
        }
        else
        {
          done();
        }
      }
    },

    migrationBundle: function(){
      var diskoProcess = this;
      if (this.writingConfirm)  {
        var done = this.async();
        if (this.migrationbundle) {


          var command = 'cd /var/www && php composer.phar require doctrine/doctrine-migrations-bundle';
          if (this.installVagrant)
          {
            command = 'vagrant ssh -c "'+command+'"';
          }

          this.log(chalk.cyan('         Add & Install : doctrine/doctrine-migrations-bundle...'));
          child_process.exec(command, function (error, stdout, stderr) {
            if (error != null)
            {
              console.log(chalk.red.bold('         Error'));
            }
            else{
              var appKernelContents = diskoProcess.readFileAsString('app/AppKernel.php');
              var newAppKernelContents = appKernelContents.replace('##Yeoman', '        $bundles[] = new Doctrine\\Bundle\\MigrationsBundle\\DoctrineMigrationsBundle();\n##Yeoman');
              fs.writeFileSync('app/AppKernel.php', newAppKernelContents);

              console.log(chalk.green.bold('         Success'));
            }
            console.log('');
            done();
          });
        }
        else
        {
          done();
        }
      }
    },


    binInstall: function(){
      if (this.writingConfirm)  {

        var done = this.async();
        if (this.installVagrant) {


          var command = 'cd /var/www && sh bin/install';
          command = 'vagrant ssh -c "'+command+'"';

          this.log(chalk.cyan('         Install Project on vagrant'));
          child_process.exec(command, function (error, stdout, stderr) {
            if (error != null)
            {
              console.log(chalk.red.bold('         Error'));
            }
            else{
              console.log(chalk.green.bold('         Success'));
            }
            console.log('');
            done();
          });
        }
        else
        {
          done();
        }
      }
    },

    finish: function(){
      if (this.writingConfirm)  {

        var appKernelContents = this.readFileAsString('app/AppKernel.php');
        var newAppKernelContents = appKernelContents.replace('##Yeoman', '');
        fs.writeFileSync('app/AppKernel.php', newAppKernelContents);

        this.log('\n\n\n                    '+chalk.green.bold('Generation Successfull'));
        this.log('                    '+chalk.green('-----------------------\n'));


        this.log(chalk.magenta.bold('         Ajoutez cette ligne dans votre /etc/hosts :'));
        this.log(chalk.magenta('         '+this.ipVagrant+' '+this.domainName));
        this.log('');

        if(!this.installVagrant)
        {
          this.log(chalk.magenta.bold('         Pour monter votre vagrant :'));
          this.log(chalk.magenta('         vagrant destroy '));
          this.log(chalk.magenta('         vagrant up'));
          this.log('');
          this.log(chalk.magenta.bold('         Pour installer le projet :'));
          this.log(chalk.magenta('         vagrant ssh '));
          this.log(chalk.magenta('         cd /var/www\ '));
          this.log(chalk.magenta('         sh bin/install\n\n\n\n '));
        }
      }
      else{
        this.log('                    '+chalk.red.bold('Generation Canceled \n'));
      }
    }
  }
});
