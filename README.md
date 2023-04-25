# Redis Admin

Redis Admin is a management app built on Laravel and Vue.js.

## Installation

1. After cloning the repository, run this command in the project's root folder

```bash
composer install
```

2. Copy the `.env.example` to `.env` and update it, if needed.

3. Point your web server to the `public` folder. Or, for a quick start, just run `php artisan serve` in the root of the project.

## Configuration

Like any other Laravel project, the configuration files are located in the `config` folder.
To setup your Redis connections, edit the `config/database.php` file and find the `redis` section in it.<br />
For more information, visit the official <a href="https://laravel.com/docs/10.x/database" target="_blank">Laravel Documentation</a>.

## Login

The default username and password are located in `database/seeders/DatabaseSeeder.php`, line 17-18.

## Contributing

Thank you for considering contributing to Redis Admin! Your contribution should follow standard guide lines.

## Security Vulnerabilities

If you discover a security vulnerability within Redis Admin,
please send an e-mail to Kiril Cvetkov via [kcvetkov@live.com](mailto:kcvetkov@live.com).
All security vulnerabilities will be promptly addressed.

## License

[MIT license](https://opensource.org/licenses/MIT).
