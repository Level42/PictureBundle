PictureBundle (fr)
=========

Ce bundle permet de redimensionner facilement des images dans Twig.

1) Installation
----------------------------------
A l'ancienne, télécharger le contenu du Bundle dans : `src/Level42/PictureBundle`

ou plus moderne, l'ajouter à votre fichier composer.json

    "require": {
        ...
        "Level42/picture-bundle": "1.0.*"
        ...
    },

Si vous n'avez pas encore composer, téléchargez le et suivez la procédure d'installation sur
[http://getcomposer.org/](http://getcomposer.org/ "http://getcomposer.org/").

2) Utilisation
-------------------------------
### 2.1) Dans twig ###
Dans votre template twig, rien de plus simple :
`<img src="{{ asset('uploads/avatars/7f63002197c85583b7f5b9e260d43ce75644ce17.jpeg' | resize(30, 30)) }}" height="30px" width="30px" />`
`resize(hauteur, largeur)`

### 2.2) Roadmap
1. Gèrer le cache navigateur

### 2.3) Changelog
#### Version 1.0
Date : 2013-02-19
Première version stable



PictureBundle (en)
=========

A bundle to resize easily pictures in twig.

1) Installing
----------------------------------
Download bundle in `src/Level42/PictureBundle`

or add in your composer.json file

    "require": {
        ...
        "Level42/picture-bundle": "1.0.*"
        ...
    },

If you don't have Composer yet, download it following the instructions on
[http://getcomposer.org/](http://getcomposer.org/ "http://getcomposer.org/").

2) Using
-------------------------------
### 2.1) In Twig ###
In your twig template, easy :
`<img src="{{ asset('uploads/avatars/7f63002197c85583b7f5b9e260d43ce75644ce17.jpeg' | resize(30, 30)) }}" height="30px" width="30px" />`
`resize(height, width)`

### 2.2) Roadmap
1. Use navigator cache

### 2.3) Changelog
#### Version 1.0
Date : 2013-02-19
First stable version