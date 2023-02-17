<p  align="center"><a  href="https://vinnjeru.com"  target="_blank"><img  src="https://vinnjeru.com/images/vinn-logo.png"  width="100"  alt="Vinn Logo"></a></p>
## About Lara-Graphql

This is a GraphQL-Powered Laravel API.

Built with the help of [Laravel GraphQL](https://github.com/rebing/graphql-laravel).

It is a mini-project that one can use to upload document files to local storage or AWS S3 bucket.
If you choose to upload to both locations, it will store the AWS url in the database.

Here is a [guide](https://medium.com/@vinn_njeru) on how to upload to configure AWS for Laravel.

Front-end built with [Tailwind CSS](https://tailwindcss.com/) and [Vue.js](https://vuejs.org/)

## Set Up

Run `composer install && npm install` to install dependencies.
Run `php artisan storage:link` to create a symbolic link from `public/storage` to `storage/app/public` for local storage.
Ensure to set up your database and AWS S3 credentials in `.env` file

## Run

Run `php artisan serve` to run Laravel app in development environment.
Run `npm run dev` for Vite to bundle your application's CSS and JavaScript files into production ready assets.

## Contributors

This software is developed and maintained with love by [Vinn Njeru](https://github.com/vinnAnony).

## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
