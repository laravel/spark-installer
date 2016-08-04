## Laravel Spark Installer

#### Installation

This guide assumes you have an existing Laravel 5.2+ project. If you do not have an active Laravel project, you can [follow these directions to create one](https://laravel.com/docs/5.2/installation).

1.  Clone this repository to any location on your system:  

    ```bash
    git clone git@github.com:laravel/spark-installer.git
    ```
1.  Run composer install to install laravel spark globally.  

    ```bash
    cd spark-installer && composer install
    ```
1.  Add the location to your system's `PATH` so that the `spark` executable can be run from anywhere on the sytem:  

    ```bash
    # use your favorite editor on one of the following files: ~/.bashrc, ~/.profile, ~/.bash_profile
    vim ~/.bashrc
    ```
1.  [Purchase a Spark license](https://spark.laravel.com/register).  
1.  After having purchased a Spark license, run the following `spark register` command with the API token that was generated from the [Laravel Spark](https://spark.laravel.com) website in the base directory of your project:  

    ````bash
    spark register token-value
    ```

#### Creating Projects

Once your Spark client has been registered, you can run the `new` command to create new projects:

```bash
spark new project-name
```

After the project has been created, don't forget to run your database migrations!

```bash
php artisan migrate
```
