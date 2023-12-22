# Pokemon TCG Collection

## Description 📄

Pokémon TCG Collection is a web application that allows users to explore and manage their Pokémon Trading Card Game
collections. It provides features for viewing Pokémon cards, adding them to your collection, and more.

## Table of Contents 📋

- [Description](#description-) 📄
- [Table of Contents](#table-of-contents-) 📋
- [Features](#features-) ✨
- [Getting Started](#getting-started-) 🚀
    - [Prerequisites](#prerequisites-) 📦
    - [Installation](#installation-) 🛠️
- [API Key](#api-key-) 🔑
- [Usage](#usage-) 📝
- [Contributing](#contributing-) 🤝
- [License](#license-) 📜

## Features ✨

- Browse and search for Pokémon cards.
- Add Pokémon cards to your collection.
- View detailed information about each card.
- Explore different sets and their cards.
- User-friendly and responsive design.

## Getting Started 🚀

Follow these instructions to get the project up and running on your local machine.

### Prerequisites 📦

- [PHP](https://www.php.net/) (>=7.0)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) or another database system
- [Node.js](https://nodejs.org/) (for frontend assets, optional)

### Installation 🛠️

1. Clone the repository: ```git clone https://github.com/your-username/pokemon-tcg.git```
2. Navigate to the project directory: ```cd pokemon-tcg```
3. Install PHP dependencies using Composer: ```composer install```
4. Configure your database connection by creating a .env file and updating the database
   settings: ```cp .env.example .env```
   Update the following lines in
   .env: ```DB_DATABASE```, ```DB_USERNAME```, ```DB_PASSWORD```, ```DB_HOST```, ```DB_PORT```, ```DB_CONNECTION```
5. Generate an application key: ```php artisan key:generate```
6. Run database migrations and seed the database: ```php artisan migrate --seed```
7. Start the development server: ```php artisan serve```
   The application should now be accessible at http://localhost.

## To compile frontend assets 🛠️
1. Enter in a terminal of your container: ```./vendor/bin/sail bash```
2. Install npm dependencies: ```npm install```
3. Compile assets: ```npm run dev```

## API Key 🔑

To fetch Pokémon card data, you'll need an API key from https://pokemontcg.io/. Once you have the API key, add it to
your .env file: ```POKEMON_TCG_API_KEY=your-api-key```

## Usage 📝

- Open your web browser and navigate to http://localhost.
- Sign up for an account or log in if you already have one.
- Start exploring Pokémon cards, adding them to your collection, and managing your collection.

## Contributing 🤝

Contributions are welcome! If you'd like to contribute to this project, please follow these steps:

1. Fork the project on GitHub.
2. Create a new branch with a descriptive
   name: ```git checkout -b feature/my-feature or git checkout -b bugfix/issue-description.```
3. Make your changes and commit them: ```git commit -m "Description of changes".```
4. Push your changes to your fork: ```git push origin feature/my-feature.```
5. Create a pull request on the original repository.
   ######Please make sure to follow the project's coding standards

## License 📜

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
