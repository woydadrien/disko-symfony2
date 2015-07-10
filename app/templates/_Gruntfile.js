"use strict";

module.exports = function (grunt) {
<% if (gruntcompass) { %>
  grunt.loadNpmTasks('grunt-contrib-compass');<% } %>
<% if (gruntTypescript || gruntcoffee || gruntBabel) { %>
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');<% } %>
<% if (gruntTypescript) { %>
  grunt.loadNpmTasks('grunt-typescript');<% } %>
<% if (gruntcoffee) { %>
  grunt.loadNpmTasks('grunt-contrib-coffee');<% } %>

  var path = {
    app: 'app/Resources',
    assets: 'app/Resources/assets',
    build: 'build',
    bower_components: './bower_components'
  };

  var libSources = [
    path.bower_components + ''
  ];

  var sources = [
    path.build + '/js/*.js'
  ];

  grunt.initConfig({
      <% if (gruntcompass) { %>
      /**
       * grunt-contrib-compass
       * @see https://github.com/gruntjs/grunt-contrib-compass
       *
       * Compile Sass to CSS using Compass.
       */
      compass: {
        sass: {
          options: {
            sourcemap: true,
            sassDir: path.app + '/scss',
            cssDir: 'web/css',
            importPath: path.bower_components,
            imagesDir: 'images',
            imagesPath: path.assets,
            generatedImagesDir: 'web/images',
            outputStyle: 'compressed',
            noLineComments: true
          }
        }
      },<% } %>
      <% if (gruntTypescript) { %>
      /**
       * grunt-typescript
       * @see https://www.npmjs.com/package/grunt-typescript
       *
       * Run predefined tasks whenever watched file patterns are added, changed or deleted.
       */
      typescript: {
        base: {
          src: [path.app + '/js/**/*.ts'],
          dest: 'build/js/typescript.js',
          options: {
            module: 'commonjs', //amd or commonjs
            target: 'es5', //or es3
            sourceMap: true,
            declaration: true
            //watch: true //Detect all target files root. eg: 'path/to/typescript/files/'
          }
        }
      },<% } %>
      <% if (gruntcoffee) { %>
      /**
       * grunt-coffee
       * @see https://www.npmjs.com/package/grunt-coffee
       *
       *  JavaScripts your Coffee
       */
      coffee: {
        compileBare: {
          options: {
            sourceMap: true,
            bare: true,
            join: true
          },
          files: {
            'build/js/coffee.js': [
              path.app + '/js/Checklist.coffee',
              path.app + '/js/ChecklistManager.coffee'
            ]
          }
        }
      },<% } %>
      <% if (gruntcoffee || gruntTypescript || gruntBabel) { %>
      /**
       * grunt-contrib-uglify
       * @see https://github.com/gruntjs/grunt-contrib-uglify
       *
       */
      uglify: {
        options: {
          mangle: false,
          sourceMap : true,
          sourceMapIncludeSources : true
        },
        all: {
          files: {
            'web/js/vendor.min.js': ['build/js/vendor.js'],
            'web/js/app.min.js': ['build/js/app.js'],
            <% if (gruntcoffee) { %>'web/js/coffee.min.js': ['build/js/coffee.js'],<% } %>
            <% if (gruntTypescript) { %>'web/js/typescript.min.js': ['build/js/typescript.js'],<% } %>
          }
        }
      },

        <% } %>

        <% if (gruntCopy) { %>

      /**
         * grunt-contrib-copy
         * @see https://github.com/gruntjs/grunt-contrib-copy
       *
         * Run predefined tasks whenever watched file patterns are added, changed or deleted.
       */
        copy: {
        dist: {
          files: [{
                    expand: true,
                    cwd: app + '/libs/Fontello/fonts',
                    dest: 'web/fonts',
                     src: ['**']
          }]
        }
        },

        <% } %>

  });

  /****************************************************************
   * Grunt Task Definitions
   ****************************************************************/

    <% if (gruntTypescript) { %>grunt.registerTask('javascript', ['typescript', 'uglify']);<% } %>
    <% if (gruntcoffee) { %>grunt.registerTask('javascript', ['coffee', 'uglify']);<% } %>
    <% if (gruntcompass) { %>grunt.registerTask('css', ['compass','cssmin']);<% } %>
    <% if (gruntSass) { %>grunt.registerTask('css', ['sass','cssmin']);<% } %>
    <% if (gruntCopy) { %>grunt.registerTask('cp', ['copy']);<% } %>
};
