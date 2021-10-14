Nom de l'étudiant : Alexandre Chaussard

Etapes réalisées :
 - initialisation du projet Symfony
 - gestion du code source avec Git (https://github.com/AlexandreChaussard/Projet-PHP)
 - ajout au modèle des données des entités liées Propriétaire et Couette-et-café
 - ajout d'une association entre Couette et café et Propriétaire
 - ajout de l'entités Région
 - ajout d'une association entre Régions et Couette et cafés
 - ajout des menus de navigation dans l'application
 - ajout de CRUDs en "backoffice"
 - ajout des Utiisateurs au modèle de données
 - ajout de l'authentification
 - ajout de la gestion de la mise en ligne d'images pour des photos dans les annonces
 - ajout de mise en forme avec Bootstrap (ou un autre framework CSS)
 - ajout d'une gestion de marque-pages/panier dans le front-office
 - particularisation de l'affichage des pages selon le profil d'utilisateur
 - protection de l'accès aux routes interdites selon le profil

Indications :
 | Route d'acceuil:
   http://localhost:8000/room/
 
 | L'entité Owner est en relation OneToOne avec User, et n'est qu'une spécificité d'un User
   De fait les champs initialement présents dans Owner (familyName, etc...) ont tous été
   décalés dans User afin de ne pas répéter l'information, à l'exception évidemment des
   Rooms affiliées elle à un Owner.
 
 | Modification/Suppression des annonces :
   La modification et la suppression d'une annonce peut être faite par le vendeur de l'annonce
   ou un administrateur par l'intermédiaire d'un bouton "Modifier" présent au dessus du nom de
   l'annonce une fois celle-ci visualisé.
   Ce bouton n'est pas présent pour tout autre utilisateur que le vendeur ou un administrateur.
 
 | Certains utilisateurs enregistrés :
   anna:
     Email: anna@localhost
     MDP: anna
     Role: ADMIN
   chris:
     Email: chris@localhost
     MDP: chris
     Role: USER	 
   yoann:
     Email: yoann@localhost
     MDP: yoann
     Role: OWNER
  
  | Fonctionnement du panier :
    Ajouter un élément au panier l'enregistre à l'aide du marque-pages.
	La réalisation de cet évènement est marqué par l'incrément du nombre d'éléments
	dans le panier (= taille des éléments dans le marque-page du panier)
  
  | Filtrage par région dans l'onglet "Nos régions"
  