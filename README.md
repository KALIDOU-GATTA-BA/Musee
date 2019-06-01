# MuseeDuLouvre
****Installation****
After cloning the project run these commands:
$ composer install
$ yarn install
$ composer require encore
$ yarn add @symfony/webpack-encore --dev
$ npm install
$ composer require symfony/swiftmailer-bundle
****Running project****
PATH/your_project_location 
$ php bin/console s:r
****Emails confuguration****
Duplicate the .env file and rename the copy to .env.local
In .env.local file, add this line:
MAILER_URL=null://your_email_address:your_email_password@localhost?encryption=tls&auth_mode=oauth
If you are using GMAIL replace the "null" by "gmail"
****Database****
In .env file set this line:
DATABASE_URL=mysql://password:root@127.0.0.1:3306/DB_name
