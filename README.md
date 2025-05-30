# SubEvents-exo ✅

## **Gestion d'un système de réservation d'activités**

### **Utilisation d'api platform** 
 * accès via url/api 
 * token bearer à récupérer dans /login_check en post: {  "email": "admin@aol.fr",  "password": "admin"  }
 * copier le token et le mettre dans le bouton authorize

#### **Installation**
* entrer sa cfg database du .env.local
* composer install
* symfony (php bin/console) d:d:c
* symfony d:m:m (yes)
* symfony d:f:l (yes)
* symfony serve 
* l'api est à URL/api

###  **TO DO** 🧠  
* Mini-application Symfony permettant de :
1. Créer et gérer des événements.
2. Permettre à des utilisateurs de s’y inscrire via un formulaire.
3. Gérer une logique d'inscription (limite de places, événements passés, etc.).
4. Exposer les données via une API REST sécurisée.
5. Envoyer un email de confirmation à chaque inscription.
6. Injecter un service pour le suivi des inscriptions.
7. Déclencher des events Symfony (ex: lors d’une inscription).
8. Créer des fixtures pour tester le tout.
9. Utiliser des tests unitaires et fonctionnels pour valider les cas clés.

---

## **Spécifications techniques** 🏗️

### 🧱 Entités :

* Event
 * id
 * title
 * description
 * maxParticipants
 * startAt
 * endAt
 * createdAt
 * updatedAt
 * participants (OneToMany avec Registration)

* User
 * id
 * email
 * roles
 * firstName
 * lastName
 * phone
 * password
 * registrations (OneToMany avec Registration)

* Registration
 * id
 * user (ManyToOne)
 * event (ManyToOne)
 * registeredAt

### 🔁 Repository :
* Méthodes custom dans EventRepository :
 * findUpcomingEvents()
 * countRegistrationsByEvent(Event $event)

### 🧩 Services :
* Créer un service RegistrationManager pour :
 * Vérifier qu’un utilisateur peut s’inscrire.
 * Vérifier si l’événement est complet.
 * Créer la Registration.
 * Lancer un Event Symfony UserRegisteredEvent.

### ⚙️ Event / Listener :
* Créer un Event UserRegisteredEvent avec un Listener qui :
 * Envoie un email de confirmation à l’utilisateur (MailerInterface).
 * Logue l’événement dans un fichier personnalisé.
 * Envoie un sms de confirmation à l’utilisateur (Twilio API).

### 📮 Email :
* Envoyer un mail de confirmation via Mailer (template twig, sender config via .env).

### 📝 Form :
* Créer un formulaire EventRegistrationFormType lié à Registration permettant :
 * Sélection d’un Event (non complet, non passé).
 * Utilisateur auto-prérempli via Security.

### 🔌 API :
* GET /api/events → liste des événements à venir.
* GET /api/events/{id} → détail d’un événement.
* POST /api/events/{id}/register → s’inscrire à un événement (avec token auth).
* Auth via JWT ou token simple (selon config souhaitée).

### 🧪 Fixtures :
* 10 users
* 5 events (passés / à venir)
* 50 inscriptions

### 🧪 Tests :
* Test unitaire sur le service RegistrationManager
* Test fonctionnel de la route /api/events/{id}/register

### 🔒 Sécurité :
* Authentification classique UserPasswordHasherInterface
* Accès à /api/events/* protégé

### 🧰 Bonus (facultatif)
* Dashboard admin CRUD avec EasyAdmin.
* Commande CLI pour envoyer des rappels 24h avant l’événement.
* Logger personnalisé pour chaque inscription dans un fichier log/event_registration.log.