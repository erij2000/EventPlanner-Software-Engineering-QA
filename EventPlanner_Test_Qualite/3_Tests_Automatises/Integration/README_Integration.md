# Tests d’Intégration – EventPlanner

## 1. Objectif
Ce dossier contient les **tests d’intégration** du projet EventPlanner.  
Ils visent à vérifier les **interactions entre les modules backend** (API Laravel, base de données, authentification) et à garantir que les fonctionnalités exposées par l’API fonctionnent correctement.

---

## 2. Organisation du dossier
Integration/
│
├── test_api_event_registration.py   # Tests Pytest pour l’API d’inscription aux événements
├── test_auth_api.py                 # Tests Pytest pour l’API d’authentification
└── EventPlanner_API_Collection.json # Collection Postman pour tester les endpoints


---

## 3. Outils utilisés
- **Pytest** : exécution des tests automatisés en Python.  
- **Requests (Python)** : envoi de requêtes HTTP vers l’API Laravel.  
- **Postman** : exécution manuelle ou automatisée des tests via une collection JSON.  
- **Swagger** : documentation et vérification des endpoints API.

---

## 4. Tests inclus

### 🔹 Authentification
- `test_auth_api.py`  
  - Vérifie la connexion avec des identifiants valides (retourne un token).  
  - Vérifie l’échec de connexion avec des identifiants invalides (retourne 401).

### 🔹 Inscription à un événement
- `test_api_event_registration.py`  
  - Vérifie qu’un utilisateur peut s’inscrire à un événement (201 Created).  
  - Vérifie que la capacité maximale est respectée (400 ou 422 si dépassée).

### 🔹 Collection Postman
- `EventPlanner_API_Collection.json`  
  - Contient les requêtes principales : Login, Register Event, Cancel Registration.  
  - Peut être importée dans Postman pour exécution manuelle ou automatisée.

---

## 5. Exécution des tests

### 🔹 Avec Pytest
Depuis le dossier `Integration/` :
```bash
pytest -v
