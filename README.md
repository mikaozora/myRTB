<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

#### Install myRTB webapps

* Clone this repository

```bash
  git clone https://github.com/mikaozora/myRTB.git
```

* Install all dependency laravel

```bash
  composer update
```

* Install for vite js

```bash
  npm install
```

* Migrate the database

```bash
  php artisan migrate
```

* Seed the database

```bash
  php artisan db:seed --class=UserSeeder
  php artisan db:seed --class=StatusSeeder
  php artisan db:seed --class=RoomSeeder
  php artisan db:seed --class=WashingMachineSeeder
  php artisan db:seed --class=KitchenStuffSeeder
  php artisan db:seed --class=ForumSeeder
```

## Run Code

#### Go to the directory where you clone the code
* terminal 1  

```bash
  php artisan serve
```
* terminal 2

```bash
  npm run dev
```
* terminal 3 (run the scheduler)

```bash
  php artisan schedule:work
```
