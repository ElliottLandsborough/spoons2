<html>
  <head>
    <title>Angular 2 QuickStart</title>
    <script src="https://code.angularjs.org/tools/system.js"></script>
    <script src="https://code.angularjs.org/tools/typescript.js"></script>
    <script src="https://code.angularjs.org/2.0.0-alpha.45/angular2.dev.js"></script>
    <script>
        System.config({
            packages: {'app': {defaultExtension: 'js'}}
        });
        System.import('js/angular/app');
    </script>
  </head>
  <body>
    <my-app>loading...</my-app>
  </body>
</html>