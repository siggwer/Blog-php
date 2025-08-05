# Blog-php

OpenClassrooms Project 5: a professional blog in PHP using object-oriented programming.

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ebdf191541024da1b3364534f80935af)](https://www.codacy.com/app/siggwer/Blog-php?utm_source=github.com&utm_medium=referral&utm_content=siggwer/Blog-php&utm_campaign=Badge_Grade)

Welcome to my OpenClassrooms Project 5.

Project description: the goal is to develop a professional blog.

## Installation

This project requires PHP 8.3 or higher.

```bash
git clone https://github.com/siggwer/Blog-php.git
cd Blog-php
composer install
```

Import the database dump located in `bdd/Dump_base_de_donnees_projet_5_blog.sql` into your MySQL server, for example:

```bash
mysql -u <user> -p <database> < bdd/Dump_base_de_donnees_projet_5_blog.sql
```

Configure the `config/db.php` file to match your database settings.

To test the project you can log in as administrator with the account `admin` (`password: 123456789`).

To start the project create a virtual host that points to `/public/index.php`.

For email sending the project uses SendGrid; edit the `/config/mail.php` file to configure it.
