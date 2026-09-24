import requests
from urllib.parse import unquote

BASE_URL = "http://127.0.0.1:8000"

def get_session_with_csrf():
    """Crée une session et configure tous les headers de sécurité Laravel"""
    session = requests.Session()
    
    # 1. Premier appel pour obtenir le cookie
    # On ajoute déjà les headers 'Referer' pour que Laravel ne panique pas
    session.headers.update({
        "Referer": f"{BASE_URL}/login",
        "Origin": BASE_URL
    })
    
    session.get(f"{BASE_URL}/login")
    
    # 2. Configuration du Token CSRF
    if 'XSRF-TOKEN' in session.cookies:
        xsrf_token = unquote(session.cookies['XSRF-TOKEN'])
        session.headers.update({
            "X-XSRF-TOKEN": xsrf_token,
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "application/json",
            # On réaffirme l'origine pour les requêtes POST suivantes
            "Referer": f"{BASE_URL}/login",
            "Origin": BASE_URL
        })
    
    return session

def test_login_success():
    session = get_session_with_csrf()
    
    payload = {
        "email": "admin@event.com",
        "password": "admin123"
    }
    
    response = session.post(f"{BASE_URL}/login", data=payload)
    
    # Debug: Si ça plante encore, on veut voir pourquoi
    if response.status_code == 500:
        print("\n--- ERREUR 500 DETECTEE ---")
        print("Il faut vérifier le fichier 'storage/logs/laravel.log' dans votre projet Laravel")
        # On affiche un petit bout de la réponse pour aider
        print(response.text[:500]) 

    assert response.status_code in [200, 204, 302]

def test_login_fail():
    session = get_session_with_csrf()
    
    payload = {
        "email": "wrong@event.com",
        "password": "badpass"
    }
    
    response = session.post(f"{BASE_URL}/login", data=payload)
    assert response.status_code in [401, 422, 302]