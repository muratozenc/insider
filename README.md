1. Clone this repository
2. Copy the file .env.example as .env
3. Replace database information with yours
4. In terminal install laravel dependencies with the command ```composer install```
5. Generate a new key in .env file with using ```php artisan key:generate```
6. Migrate tables with ugind the command ```php artisan migrate```
7. Teams and Nation of the teams are seperate tables and should contain information. To provide this data you seed the tables with the comman ```php artisan db:seed```
6. Install npm packages with the command ```npm install & npm run watch```
7. System may guide you to run the mix again, to do that use the command : ```npm run watch```
8. To start the application use ```php artisan serve``` command.

IMPORTANT NOTE :

If you getting -> Error: Cannot find module ‘webpack/lib/rules/DescriptionDataMatcherRulePlugin’ Require stack error message then you need to update your vue-loader


