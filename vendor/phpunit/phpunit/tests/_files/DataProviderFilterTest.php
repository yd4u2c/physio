{
  "name": "prettus/l5-repository",
  "description": "Laravel 5 - Repositories to  the database layer",
  "keywords": ["laravel", "repository", "eloquent", "model", "cache"],
  "license": "MIT",
  "authors": [
    {
      "name": "Anderson Andrade",
      "email": "contato@andersonandra.de",
      "role": "Developer"
    }
  ],
  "support": {
    "email": "contato@andersonandra.de",
    "issues":"https://github.com/andersao/l5-repository/issues",
    "wiki":"https://github.com/andersao/l5-repository",
    "source":"https://github.com/andersao/l5-repository"
  },
  "require": {
    "illuminate/http": "~5.0",
    "illuminate/config": "~5.0",
    "illuminate/support": "~5.0",
    "illuminate/database": "~5.0",
    "illuminate/pagination": "~5.0",
    "illuminate/console": "~5.0",
    "illuminate/filesystem": "~5.0",
    "prettus/laravel-validation": "1.1.*"
  },
  "autoload": {
    "psr-4": {
      "Prettus\\Repository\\": "src/Prettus/Repository/"
    }
  },
  "config": {
    "preferred-install": "dist