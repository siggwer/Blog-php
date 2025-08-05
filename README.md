# Blog-php

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ebdf191541024da1b3364534f80935af)](https://www.codacy.com/app/siggwer/Blog-php?utm_source=github.com&utm_medium=referral&utm_content=siggwer/Blog-php&utm_campaign=Badge_Grade)

## Overview

OpenClassrooms Project 5: a professional blog built with PHP and object-oriented programming.

## Prerequisites

- PHP 8.3 or higher
- Composer
- MySQL or MariaDB
- A web server with virtual host support (e.g., Apache)
- SendGrid account for email delivery

## Installation

1. Clone this repository.
2. Install dependencies:
   ```bash
   composer install
   ```

## Configuration

1. Import the database schema from `bdd/blog.sql` into your database server.
2. Update `config/db.php` with your database connection settings.
3. Configure your web server's virtual host to point to `public/index.php`.
4. Add your SendGrid API key and mail settings in `config/mail.php`.

## Usage

After completing the configuration, access the site through the configured virtual host to manage and publish blog posts.

## Contributing

Contributions are welcome. Please open an issue or submit a pull request and run `phpcs` to ensure coding standards before submitting.

