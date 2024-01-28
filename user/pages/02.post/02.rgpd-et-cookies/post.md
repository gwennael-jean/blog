Au tout début de l'air d'internet, chaque requête HTTP était "sans état". Il était donc impossible de garder en mémoire les informations
d'un utilisateur. Mais ça, c'était avant ...

===

# Pour la petite histoire

En 1994, C'est l’avènement d'internet.

Les développeurs de Netscape travaillent sur le développement d'un serveur permettant la mise ne place de sites e-commerce.
Cependant, les développeurs se retrouvent face à un problème :

Comment garder en mémoire l'état du panier d'achat du client.

C'est alors que Lou Montulli et John Giannandrea eurent une idée. Ils proposent de stocker un état dans un fichier.

Le serveur déposerais un fichier sur l'ordinateur du client.
Celui-ci serrais renvoyé après chacune des requêtes HTTP.
Ainsi, le serveur aura ainsi la possibilité d'identifier l'utilisateur et ainsi, enregistrer l'état de son panier.

Le cookie était né.

Depuis, le cookie à évolué et des questions concernant le respect de la vie privée se posent. Aujourd'hui, Google en fait les frais. Une amende de 150 000 000 d'euros leur à été infligé par la CNIL. Le motif : il est facile d'accepter ou refuser, mais très difficile de modifier ses choix.

> La CNIL est une autorité administrative française chargée de veiller à ce que l’informatique soit au service du citoyen et qu’elle ne porte atteinte ni à l’identité humaine, ni aux droits de l’homme, ni à la vie privée, ni aux libertés individuelles ou publiques.

# Qu'est ce qu'un cookies

Comme vu plus haut, un cookie est un fichier déposé sur l'ordinateur du visiteur stockant une valeur, un état.

Il existe 3 grands types de cookie :

| Type | Info |
|------|------|
| Cookies de fonctionnement | Nécessaire au bon fonctionnement du site |
| Cookies d'analyse | Obligation du consentement de l'utilisateur |
| Cookies publicitaires | Obligation du consentement de l'utilisateur |

Les **cookies de fonctionnement** sont imposable à l'utilisateur. par exemple, pour authentifier un utilisateur qui aurait le droit d'accéder à certaines pages.
Ce sont généralement des cookies de session.

Les **cookies d'analyse** sont là pour analyser le trafic du site.

Les **cookies publicitaires** sont là pour proposer des publicité aux visiteurs. Ce sont ceux qui posent le plus de problème car les publicités affichées sont généralement des publicités qui peuvent vous intéresser. On parle ici de publicités ciblées.

> Le cookie s'appelle ainsi en référence au "fortune cookie" (biscuit chinois) qui contenait un petit message à l'intérieur.

Le règlement sur la protection des données personnelles (RGPD) est entré en vigueur le 25 mai 2018.
Depuis ce jour, vous pouvez voir sur un bon nombre de site internet un bandeau de cookies.
Celui-ci sert à vous demander un consentement sur le dépôt de certains cookies sur votre ordinateur.

Il existe un certain flou juridique sur le consentement des cookies qui consiste à forcer l'utilisateur a accepter les cookies,
ou bien de payer une certaines sommes. Ce système à rapporté énormément d'argent à ces entreprises.
En tant qu'utilisateur, et avec ce système, est-ce que mon consentement est libre ? Au sein de la CNIL, il y a débat (c'est compliqué. D'un point de vu éthique, ca se discute).

# Le cadre réglementaire applicable

Depuis le 1er avril 2021 de nouvelles règles ont été apporté :

 - Refuser les cookies doit être aussi simple que les accepter (en résumé, il faut afficher un bouton de refus)
 - La simple poursuite de la navigation sur le site ne peut plus être vu comme une acceptation du consentement
 - La modification du consentement doit être aussi simple que le consentement lui même
 - La date de validité d'un cookie ne doit pas dépasser 13 mois

> Bien que le bouton "refuser" soit obligatoire, la petite astuce consiste à le rendre plus discret que le bouton "accepter".

Pour le développement du bandeau de cookies, il existe des solutions :

 - [Tarteaucitron](https://tarteaucitron.io/fr/)
 - [Axeptio](https://www.axeptio.eu/en/home)
 - [Consent Manager](https://www.consentmanager.net/)

Il existe également [Quantcast](https://www.quantcast.com/), mais celui-ci est déconseillé par la CNIL.

# L'utilisation de Google Analytics

Jeudi 10 février, la CNIL a publié un communiqué indiquant la mise en demeure du gestionnaire d’un site Web français du fait de son utilisation de Google Analytics.
La raison ? Tout simplement parce que les données stockées par Google sont envoyé au États-Unis.

Il existe néanmoins d'autres outils d'analyse tout aussi performant :

- [Matomo](https://fr.matomo.org/)
- [Abla Analytics](https://abla.io/)
- [Open Web Analytics](https://www.openwebanalytics.com)

Il est même également possible de les paramétrer afin d'éviter la demande de consentement de l'utilisateur. Ce qui peut, peu-être, vous éviter l'affichage d'un bandeau de cookies.