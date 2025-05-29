#Ligne de commande disponible

> Pour excécuter ces commandes vous devez absolument avoir installé l'utilitaire [wpcli](https://wp-cli.org/fr/) sur votre machine locale.

Créer un composant pour le thème

```
 wp component:create
```

Créer un composant pour sendify

```
 wp cv-sendify-component %component-slug-name%
```

N'oubliez pas de charger le nouveau composant dans le fichier ```app/Services/Hooks/SendifyService.php``` dans la méthode ```registerComponents```
