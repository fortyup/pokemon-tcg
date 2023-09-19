# Projet Pokemon TCG avec Laravel

Ce projet est une application web Laravel qui utilise l'API Pokemon TCG pour afficher des informations sur les cartes Pokemon. Vous pouvez afficher une liste de cartes, ainsi que les détails d'une carte spécifique en fonction de son ID.

## Configuration de l'environnement

Pour exécuter ce projet localement, suivez les étapes ci-dessous :

1. **Prérequis** : Assurez-vous d'avoir PHP, Composer et Laravel installés sur votre système. Si ce n'est pas le cas, vous pouvez les installer en suivant les instructions sur [le site officiel de Laravel](https://laravel.com/docs/10.x/installation).

2. **Cloner le projet** : Clonez ce projet depuis GitHub en utilisant la commande suivante :

   ```bash
   git clone https://github.com/fortyup/projet-pokemon-tcg-laravel.git
   ```

3. **Installer les dépendances** : Accédez au répertoire du projet et installez les dépendances en exécutant la commande suivante :

   ```bash
   composer install
   ```

4. **Configurer l'environnement** : Copiez le fichier `.env.example` et renommez-le en `.env`. Ensuite, générez une clé d'application Laravel en utilisant la commande suivante :

   ```bash
   php artisan key:generate
   ```

5. **Configuration de l'API Pokemon TCG** : Dans le fichier `.env`, configurez les informations de l'API Pokemon TCG, telles que la clé d'API et l'URL de l'API.

   ```env
   POKEMON_API_KEY=VotreCleAPI
   POKEMON_API_URL=https://api.pokemontcg.io/v2/
   ```

6. **Exécution du serveur de développement** : Démarrez le serveur de développement Laravel en utilisant la commande suivante :

   ```bash
   php artisan serve
   ```

7. **Accéder à l'application** : Ouvrez votre navigateur web et accédez à l'URL `http://localhost:8000` pour voir l'application en action.

## Fonctionnalités de l'application

- `localhost/cards` : Affiche une liste de cartes Pokemon.
- `localhost/cards/{id}` : Affiche les détails d'une carte spécifique en fonction de son ID.

## Auteur

- Maxime Capel

N'hésitez pas à contribuer à ce projet en soumettant des pull requests ou en signalant des problèmes.

Merci d'utiliser cette application Pokemon TCG avec Laravel ! Amusez-vous bien !
```
