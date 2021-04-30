# bilemo-api-sf

[![SymfonyInsight](https://insight.symfony.com/projects/17890c2c-074a-4d38-a269-95fc4e22ad0a/mini.svg)](https://insight.symfony.com/projects/17890c2c-074a-4d38-a269-95fc4e22ad0a)

Lien du repository: 

Lien Symfony Insight: https://insight.symfony.com/projects/17890c2c-074a-4d38-a269-95fc4e22ad0a

Lien de la doc: https://p7-bilemo-api.sebastien-thuret.fr/api/doc

# Installation

## Récupération des sources

```
git clone git@github.com:TheTakylo/p6-snowtricks.git
```

### Installation des dépendences via composer

```
composer install
```

## Configuration du projet

Configurer dans le fichier **.env**:
- DATABASE_URL

## Créer et remplir la base de données

#### Créer la base de données
```
php bin/console doctrine:database:create
```

#### Créer les tables
```
php bin/console doctrine:schema:create
```

#### Charges les fixtures
```
php bin/console doctrine:fixtures:load
```

# Identifiants:

#### Compte 1:
- **Email:** admin@marketplace1.fr
- **Mot de passe:** motdepasse

#### Compte 2:
- **Email:** admin@marketplace2.fr
- **Mot de passe:** motdepasse

# Tests unitaires:

#### Configuration

- Créer un fichier .env.test et le configurer en suivant les étapes précédentes
- Lancer les commandes avec l'argument --env=test

#### Lancer les tests unitaires
./bin/phpunit
