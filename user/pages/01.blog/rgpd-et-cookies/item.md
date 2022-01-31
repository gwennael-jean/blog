---
title: 'RGPD et cookies : Définition, règlementation et solutions à mettre en place'
date: '13:34 01/27/2022'
author: 'Gwennael Jean'
hero_classes: 'text-light title-h1h2 overlay-dark-gradient hero-large parallax'
show_sidebar: true
taxonomy:
    category:
        - blog
    tag:
        - développement
        - HTTP
feed:
    limit: 10
media_order: web-analytics.jpg
hero_image: web-analytics.jpg
---

Au tout début de l'air d'internet, chaque requete HTTP était "sans état". Il était donc impossible de garder en mémoire les informations
d'un utilisateur.

===

En 1994, C'est l'avenement d'internet.

Les développeurs de netscape travaillent sur le développement d'un serveur perettant la mise ne place de sites e-commerce.
Cependant, les développeurs se retrouvent face à un problème :
Comment garder en mémoire l'état du panier d'achat du client.

C'est alors que Lou Montulli et John Giannandrea urent une idée. Ils proposent de stocker un état dans un fichier.

Le cookie est né.

L'idée est simple : Le serveur dépose un fichier sur l'ordinateur du client.
Celui-ci renverra ce fichier à chacune de ses requête HTTP.
Le serveur aura ainsi la possibilité d'identifier l'utilisateur et ainsi, enregistrer l'état de son panier.

Depuis, le cookie à évolué et des questions concernant le respect de la vie privée se posent, et aujourd'hui, c'est Facebook, Google et Youtube qui font les frais. Une amende de 150 000 000 d'euros à été infligé à Google. En effet, il est facile d'accepter ou refuser, mais très difficile de modifier ses choix.
Ils ont 3 mois pour faire les modifications. Au delà, c'est 100 000 € par jour de retard.

> La CNIL est une autorité administrative française chargée de veiller à ce que l’informatique soit au service du citoyen et qu’elle ne porte atteinte ni à l’identité humaine, ni aux droits de l’homme, ni à la vie privée, ni aux libertés individuelles ou publiques.

# Qu'est ce qu'un cookies

Un cookie est un fichier qui permet de tracer et analyser le comportement de l'utilisateur.

Il existe 3 grands types de cookie :

| Type | Info |
|------|------|
| Cookies de fonctionnement | Necessaire au bon fonctionnement du site |
| Cookies d'analyse | Obligation du concentement de l'utilisateur |
| Cookies publicitaires | Obligation du concentement de l'utilisateur |

Les cookies publicitaires sont ceux qui posent le plus de problème.

> Pourquoi un cookie s'appelle ainsi ? En reference au "fortune cookie" (biscuit chinois) qui contenait un petit message à l'intérieur.

Il existe un certain flou juridique sur le consentement des cookies qui consiste à forcer l'utilisateur a accepter les cookies,
ou bien de payer une certaines sommes. Ce système à rapporté énormément d'argent à ces entreprises.
En tant qu'utilisateur, et avec ce système, est-ce que mon consentement est libre ? Au sein de la CNIL, il y a débat (c'est compliqué. D'un point de vu éthique, ca se discute).

# Le cadre reglementaire applicable

 - Les cookies doivent être déposé *après* le consentement
 - La simple poursuite de la navigation sur le site ne peut plus être vu comme une acceptation du consentement
 - La modification du consentement doit être aussi simple que le consentement lui même
 - Date de validité de cookie : 13 mois
 - Le bouton de refus est obligatoire (mais il peut être plus petit que les autres bouton)

> Bien que le bouton "refuser" est obligatoire, la petite asctuce est de le rendre plus petit que le bouton "accepter".

Consentement necessaire :

 - Cookies pour la publicité ciblée
 - Cookies de mesures d'audience (sauf exemptions)
 - Cookies des réseaux sociaux
 
Consentement non nécessaire :

 - Cookies strictement nécessaires à la fourniture d'un service expressement demandés par l'utilisateur (cookies d'authentification, panier d'achats)
 - 
# Les solutions a mettre en place

 - Avoir une page dédié à la gestion des cookies (avec un tableau en 2 colonnes : Nom du cookies / Finalité)
 - Il existe plein d'outils de gestion des cookies : Rarteaucitron, Axeptio, Consent Manager (Quantcast est déconseillé)
 - Sans paramétrage, Google Analytics nécessite le consentement (Il faut changer la localisation (pas plus précis que la récupération de la ville) et l'IP pour évité le consentement).
 - Matomo, Abla Analytics ne nécessite pas de consentement.
