

# 🌱 EcoLocal — Plateforme de Crowdfunding Écologique et Local

EcoLocal est une plateforme de financement participatif dédiée aux projets à impact positif, axés sur l’écologie et le développement local. L’objectif est de permettre à des porteurs de projets durables de collecter des fonds tout en mobilisant une communauté engagée autour de valeurs environnementales et sociales.

---

## 🔗 Lien vers le site

👉 [Accéder à EcoLocal](http://ecolocal.bizienadam.fr/)

---

## 🗃️ Structure de la base de données

La base de données est organisée autour des entités principales suivantes :

![WhatsApp Image 2025-04-18 à 17 55 58_7f4de1b1](https://github.com/user-attachments/assets/056bc407-3a98-431e-ba8c-db1ab5190e1b)

c = createdAt
u = updatetedAt

## 🔄 Relations entre les entités

- **Projet et Niveaux de projet**  
  - Relation **un-à-plusieurs** (1,N)  
  - Un projet peut avoir plusieurs niveaux de projet  
  - Chaque niveau de projet appartient à un seul projet

- **Projet et Catégorie**  
  - Relation **plusieurs-à-un** (N,1)  
  - Plusieurs projets peuvent appartenir à une même catégorie  
  - Chaque projet appartient à une seule catégorie

- **Projet et Utilisateur**  
  - Relation **plusieurs-à-un** (N,1)  
  - Un utilisateur peut posséder plusieurs projets  
  - Chaque projet appartient à un seul utilisateur

- **Projet et Donation**  
  - Relation **un-à-plusieurs** (1,N)  
  - Un projet peut recevoir plusieurs donations  
  - Chaque donation est associée à un seul projet

- **Projet et Niveau de récompense**  
  - Relation **un-à-plusieurs** (1,N)  
  - Un projet peut avoir plusieurs niveaux de récompense  
  - Chaque niveau de récompense appartient à un seul projet

- **Niveau de récompense et Donation**  
  - Relation **plusieurs-à-plusieurs** (N,M)  
  - Une donation peut être associée à plusieurs niveaux de récompense  
  - Un niveau de récompense peut être associé à plusieurs donations

- **Utilisateur et Donation**  
  - Relation **un-à-plusieurs** (1,N)  
  - Un utilisateur peut effectuer plusieurs donations  
  - Chaque donation est associée à un seul utilisateur

---

## 🧭 Parcours utilisateur

Voici les différents parcours proposés sur la plateforme :

### Contributions
![WhatsApp Image 2025-04-18 à 17 57 39_a9739e47](https://github.com/user-attachments/assets/693a48f1-e402-4e32-b991-94f7f325ee74)


### Porteur de projet
![WhatsApp Image 2025-04-18 à 17 57 14_dba61706](https://github.com/user-attachments/assets/8ac442cf-b0a8-4af4-80e6-36bcddb46736)


### Administrateur
![WhatsApp Image 2025-04-18 à 17 57 02_82d82b20](https://github.com/user-attachments/assets/77b8212f-cb77-48c2-9351-30986834275f)


