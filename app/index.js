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

    this.projectName = 'disko-project';

    var prompts = [{
      type: 'question',
      name: 'projectName',
      message: 'Quel est le nom de votre  projet ?',
      default: null
    }];

    this.prompt(prompts, function(answers) {
      this.projectName = answers.projectName;
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
    console.log('');
    var done = this.async();

    var prompts = [{
      type: 'checkbox',
      name: 'addBundle',
      message: 'Which bundle would you like to use?',
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

      this.writingConfirm = answers.confirmInstall;
      this.log('');
      this.log('');

      if (this.writingConfirm)
      {
        this.log(chalk.green.bold('\n\n\n\n          ======================================= \n '));
        this.log('                    '+chalk.green.bold('Generation in progress \n'));
        this.log(chalk.green.bold('          ======================================= \n\n\n\n '));


      }

      done();
    }.bind(this));
  },


  writing: {
    App: function () {

      this.log('');
      this.fs.copy(this.templatePath(this.projectMode + '/app'), this.destinationPath('app'));
      this.fs.copy(this.templatePath(this.projectMode + '/bin'), this.destinationPath('bin'));
      this.fs.copy(this.templatePath(this.projectMode + '/src'), this.destinationPath('src'));
      this.fs.copy(this.templatePath(this.projectMode + '/web'), this.destinationPath('web'));

      this.template(this.projectMode + '/.gitignore', '.gitignore');
      this.template(this.projectMode + '/package.json', 'package.json');
      this.template(this.projectMode + '/composer.json', 'composer.json');
      this.template(this.projectMode + '/gulpfile.js', 'gulpfile.js');
      this.template(this.projectMode + '/.gitignore', '.gitignore');

      this.fs.copy(this.templatePath(this.projectMode + '/editorconfig'),this.destinationPath('.editorconfig'));
      this.fs.copy(this.templatePath(this.projectMode + '/jshintrc'), this.destinationPath('.jshintrc'));
      this.log('');
      this.log('');
    }
  },

  end: {

    installVendors: function(){
      if (this.writingConfirm)  {
        var done = this.async();

        this.log(chalk.green.bold('Install Vendors...'));
        child_process.exec('php composer.phar update', function (error, stdout, stderr) {
          if (error != null)
          {
            console.log(chalk.red.bold(error));
            console.log(chalk.red.bold('Error'));
          }
          else{
            console.log(chalk.green.bold('Success'));
          }
          console.log('');
          done();
        });
      }
    },

    fixturesBundle: function(){
      if (this.writingConfirm)  {
        var done = this.async();
        if (this.fixturebundle) {
          this.log(chalk.green.bold('Add & Install : doctrine/doctrine-fixtures-bundle...'));
          child_process.exec('php composer.phar require doctrine/doctrine-fixtures-bundle', function (error, stdout, stderr) {
            if (error != null)
            {
              console.log(chalk.red.bold('Error'));
            }
            else{
              console.log(chalk.green.bold('Success'));
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
      if (this.writingConfirm)  {
        var done = this.async();
        if (this.migrationbundle) {
          this.log(chalk.green.bold('Add & Install : doctrine/doctrine-migrations-bundle...'));
          child_process.exec('php composer.phar require doctrine/doctrine-migrations-bundle', function (error, stdout, stderr) {
            if (error != null)
            {
              console.log(chalk.red.bold('Error'));
            }
            else{
              console.log(chalk.green.bold('Success'));
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
        this.log(chalk.green.bold('\n\n\n\n          ======================================= \n '));
        this.log('                    '+chalk.green.bold('Generation Successfull \n'));
        this.log(chalk.green.bold('          ======================================= \n\n\n\n '));
      }
      else{
        this.log(chalk.red.bold('\n\n\n\n          ======================================= \n '));
        this.log('                    '+chalk.red.bold('Generation Canceled \n'));
        this.log(chalk.red.bold('          ======================================= \n\n\n\n '));
      }
    }
  }
});
