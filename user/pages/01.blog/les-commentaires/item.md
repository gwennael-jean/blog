---
title: 'Les commentaires'
date: '13:34 01/17/2022'
author: 'Gwennael Jean'
hero_classes: 'text-light title-h1h2 overlay-dark hero-large parallax'
hero_image: maisonjaune-800x600.jpg
show_sidebar: true
taxonomy:
    category:
        - blog
    tag:
        - journal
feed:
    limit: 10
media_order: maisonjaune-800x600.jpg
---

Cette article concerne le développement d'une fonctionnalité sur https://maisonjaune.org. L'idée est de pouvoir laisser les visiteurs publier des commentaires sur différents articles.

===

# Introduction
L'idée est de pouvoir laisser les visiteurs publier des commentaires sur différents articles.

# Partie clients
Sur chaque article, nous afficherons un mini formulaire permettant aux lecteurs de publier des commentaires. Ce formulaire sera composé de 3 champs :
 - Nom
 - Adresse Email
 - Commentaire

Pour un utilisateur connecté, nous n'afficherons que le champ Commentaire.

Sous ce formulaire, nous afficherons les commentaires.

Pour nous aider à la gestion des commentaires, nous utiliserons [Akismet](https://akismet.com/).

# Partie Admin

## CRUD des commentaires
Sur le BO, nous aurons une partie consacré à la gestion des commentaires. Nous pourrons choisir Afficher / Bloquer / Supprimer un commentaire.

 - Les commentaires Afficher seront, par définition, affiché sur le site
 - Les commentaires Bloquer ne seront pas affiché sur le site
 - Les commentaires Supprimer seront supprimé de la base de données

## Activation des commentaires sur chaque article
Depuis la page article, les utilisateurs pourront, s'ils le souhaitent, activer ou désactiver la publication de commentaire. Ils pourront également autoriser, s'ils le souhaitent, la publication de commentaire uniquement aux utilisateurs connecté.

Par défaut, les commentaires seront activé sur les articles, mais seront désactiver sur les brèves et les pages.

## Paramétrage des commentaires
Une page de paramétrage sera accessible pour les administrateurs. Il sera possible, depuis cette page paramètres de :

 - Indiquer la clé Akismet
 - Indiquer le nombre de commentaires affiché par page
 - Indiquer le tri des commentaires (tri par date de publication ASC / DESC)
 - Indiquer certains mot clé interdit dans les commentaires (par exemple : Connard / Abruti / Kita / ...)

## A propos d'Akismet
Akismet est une API permettant de détécter les spams. Chaque publication de commentaire sera soumis à Akismet.
Elle est gratuite pour un usage non commercial. Ce qui veut dire que nous devrons payer une licence le jour ou :

- Nous aurons des pubs sur le site
- Nous Aurons une boutique en ligne
