## Cas de test : Connexion utilisateur valide

ID : AUTH-01  
Objectif : Vérifier qu’un utilisateur peut se connecter avec des identifiants valides  

Préconditions :
- L’utilisateur existe dans la base de données
- Le mot de passe est hashé

Étapes :
1. Aller sur la page /login
2. Entrer un email valide
3. Entrer le mot de passe correct
4. Cliquer sur "Se connecter"

Résultat attendu :
- Redirection vers le dashboard utilisateur
- Session active
- Aucun message d’erreur
