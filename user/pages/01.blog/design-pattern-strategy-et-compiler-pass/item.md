---
title: 'Design pattern Strategy et Compiler Pass'
date: '14:55 01/24/2022'
author: 'Gwennael Jean'
hero_classes: 'text-light title-h1h2 overlay-dark-gradient hero-large parallax'
hero_image: luca-bravo-XJXWbfSo2f0-unsplash.jpg
show_sidebar: true
taxonomy:
    category:
        - blog
    tag:
        - développement
        - symfony
feed:
    limit: 10
media_order: luca-bravo-XJXWbfSo2f0-unsplash.jpg
---

Avant de commencer, voici une brève description d'un projet sur lequel nous avons travaillé : Cléa.

Cléa, c'est quoi ? C'est une application, développée pour notre client Qualitel, qui a pour vocation de
fournir aux occupants des informations et des services pour le bon usage de leur logement et le
maintien de sa qualité dans le temps.

===

L'application permet à un propriétaire de :

- Saisir différentes caractéristiques de son logement
- Déposer et partager différents documents
- Garder en mémoire différents intervenants (constructeur, électricien, plombier, ...)
- Et plein d'autres encore ...

Une des fonctionnalités développées est d'obtenir et d'afficher les consommations de son logement.
Au départ, il n'était possible que de saisir manuellement le relevé de son compteur (électrique, gaz ou autre).
Les consommations étant calculées selon la saisie de ces relevés.

Puis une mise à jour est arrivé.
Notre client nous a demandé de récupérer les consommations depuis les compteurs Linky et Gazpar.
Mais comment le faire sans toucher au code déjà fonctionnel ?

La solution : **Le design pattern Strategy**.

# Le design pattern Strategy

Le design pattern Strategy est un patron de conception permettant la sélection et l'exécution d'algorithmes
selon certaines conditions, le tout en respectant l'un des principes SOLID, le Single Responsability
(la responsabilité unique). Pour info, ce principe veut qu'un service ne réponde qu'a un seul et unique objectif.

Nous aurons donc un service qui sera chargé d'exécuter ces différents algorithmes.
Nous nommerons ce service `ExternalConsommationProvider`.
Chaque algorithmes sera représenté par un service que nous appelerons provider.
Un provider aura pour objectif de nous fournir les consommations d'une certaine catégorie.

Dans notre exemple, nous aurons 2 providers :

- `EnedisDataConnectProvider` : Qui nous retournera les consommations de notre compteur Linky.
- `GrdfGazparProvider` : Qui nous retournera les consommations de notre compteur Gazpar.

Voici un schéma pour mieux comprendre :

![Image description](file:///C:/Users/gjean/OneDrive - TRSB/Documents/Publii/sites/le-blog-de-gwenn/input/media/posts/1/UML-Strategy-2.png =643x361)

Sur ce diagramme, nous retrouvons notre service `ExternalConsommationProvider` (Le gros bloc jaune toute en haut).
Celui-ci contiendra une liste de providers (la propriété visible via le petit carré rouge).
Chaque provider sera une instance de `ConsommationProviderInterface` (le bloc jaune au milieu).
Ce qui obligera chaque provider de développer 2 méthodes (`support()` et `findByRange()`).
Enfin, nous retrouvons nos 2 providers `EnedisDataConnectProvider` et `GrdfGazparProvider`
(chacun implémentant l'interface en question, symbolisé par la flèche en pointillé).

L'objectif de notre service `ExternalConsommationProvider` est, via sa méthode `findByRange`,
de nous retourner les consommations. Sans même avoir développer nos 2 providers,
nous pouvons déjà développer cette méthode :

```php
public function findByRange(Logement $logement, DateTime $start, DateTime $end, User $user): array
{
    $consommations = [];

    foreach ($this->getProviders() as $provider) {
        if ($provider->support($logement, $user)) {
            $consommations = array_merge(
                $consommations,
                $provider->findByRange($logement, $start, $end, $user)
            );
        }
    }

    return $consommations;
}
```

Voyons ce code : on boucle sur les providers de notre service.
Si chaque provider est supporté (pour résumer, si l'utilisateur souhaite obtenir les
consommations depuis ce provider), on ajoute dans notre tableau `$consommations` les
consommations récupéré grâce au provider.

En ce qui concerne nos providers, il suffit de développer les méthodes obtenues grâce à notre interface :

```php
class EnedisDataConnectProvider implements ConsommationProviderInterface
{
    public function support(Logement $logement, User $user): bool
    {
        // On vérifie si notre logement est bien connecté au compteur Linky
    }

    public function findByRange(Logement $logement, DateTime $start, DateTime $end, User $user): array
    {
        // On retourne les consommations de notre compteur Linky grâce à l'API Data Connect d'Enedis
    }
}
```

Maintenant que nous avons implémenté notre service `ExternalConsommationProvider` ainsi que nos 2 providers,
comment intégrer ces providers dans notre service ?

C'est là qu'intervient le Compiler Pass de Symfony.

# Le Compiler Pass

Pour ajouter un provider à notre service, nous disposons de la méthode `addProvider()`, qui attends
en paramètre une instance de `ConsommationProviderInterface`.

Avec Symfony, nous avons la possibilité de tagger nos services, afin de les identifier plus
facilement dans notre application.

Nous allons donc ajouter un tag sur tous nos services implémentant l'interface
`ConsommationProviderInterface`. Pour cela, il suffit d'ajouter les lignes suivantes dans
notre fichier `config/services.yaml` :

```yaml
_instanceof:
  App\Service\ConsommationProviderInterface:
    tags: [ app.rt2012.external_consommation_provider ]
```

Ainsi, nos 2 providers auront le tags `app.rt2012.external_consommation_provider`.

Maintenant que nous pouvons identifier nos providers, nous pouvons créer un CompilerPass.
Pour cela, Créons la class `ExternalConsommationProviderPass` comme ceci :

```php
class ExternalConsommationProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ExternalConsommationProvider::class)) {
            return;
        }

        $definition = $container->findDefinition(ExternalConsommationProvider::class);

        $taggedServices = $container->findTaggedServiceIds('app.rt2012.external_consommation_provider');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
```

Dans notre méthode `process()`, nous vérifions si le service `ExternalConsommationProvider` existe.
Ensuite, nous récupérons tous les services tagués sous le nom `app.rt2012.external_consommation_provider`,
soit nos 2 providers. Enfin, nous bouclons sur ces services pour les ajouter dans notre service
`ExternalConsommationProvider` grâce à la méthode `addProvider()`.

Pour terminer, il faut que notre application prenne en compte ce CompilerPass. Pour cela,
il suffit de l'ajouter dans le container, via la méthode `build` de la class `App\Kernel` :

```php
class Kernel extends BaseKernel
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExternalConsommationProviderPass());
    }
}
```

## Conclusion

L'intérêt principal du design pattern Strategy est de nous permettre d'ajouter autant de
provider que nous le souhaitons. Imaginons que, demain, Qualitel nous demande d'afficher
les consommations d'une autre API, nous n'aurons qu'à créer un provider implémentant
l'interface `ConsommationProviderInterface`. Celui-ci sera automatiquement tagué et
inséré dans notre service `ExternalConsommationProvider` grâce au CompilerPass.
