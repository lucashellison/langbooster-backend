# LangBooster

Welcome to the LangBooster repository! LangBooster is an innovative online platform dedicated to assisting individuals in mastering English. With a focus on interactive learning through listening, dictation, spelling, and numerical exercises, we provide a comprehensive set of tools to enhance your English proficiency.

## Features

- Listening Module with over 2000 phrases
- Dictation Module containing a vast array of exercises
- Spelling Module to turn learners into word wizards
- Numbers Module for mastering numerical English
- Premium Plan for advanced and dedicated language learning


## Visit the Website
https://www.langbooster.com/

## Getting Started

Follow these instructions to set up your development environment.

### Prerequisites

Ensure you have the following installed:

- PHP >= 8.1
- Composer
- Node.js
- NPM

### Installation

Clone the repository:

```bash
git clone https://github.com/lucashellison/langbooster-backend.git
```

Navigate to the project directory:
```bash
cd langbooster
```

Install PHP dependencies:
```bash
composer install
```

Copy the example env file and make the required configuration changes in the .env file:
```bash
cp .env.example .env
```

Generate a new application key:
```bash
php artisan key:generate
```

Run the database migrations (Set the database connection in .env before migrating):
```bash
php artisan migrate
```

Seed the database with initial data:
```bash
php artisan db:seed
```

Start the local development server:
```bash
php artisan serve
```

You should now be able to access the server at http://localhost:8000.

### Running the Tests

How to run the automated:
```bash
php artisan test
```

### Author
Lucas Camargo


