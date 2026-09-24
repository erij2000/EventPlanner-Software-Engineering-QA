import requests
from urllib.parse import unquote
import pytest

BASE_URL = "http://127.0.0.1:8000"

# On crée UNE SEULE session pour tous les tests de ce fichier
global_session = requests.Session()

def setup_module(module):
    """Cette fonction s'exécute UNE FOIS avant tous les tests du fichier"""
    # 1. Préparer les headers de base
    global_session.headers.update({
        "Referer": f"{BASE_URL}/login",
        "Origin": BASE_URL,
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest"
    })

    # 2. Récupérer le CSRF initial
    global_session.get(f"{BASE_URL}/login")
    if 'XSRF-TOKEN' in global_session.cookies:
        token = unquote(global_session.cookies['XSRF-TOKEN'])
        global_session.headers.update({"X-XSRF-TOKEN": token})

    # 3. Se connecter une bonne fois pour toutes
    login_payload = {"email": "admin@event.com", "password": "admin123"}
    global_session.post(f"{BASE_URL}/login", data=login_payload)
    
    # 4. TRÈS IMPORTANT : Après le login, Laravel change souvent le token. 
    # On rafraîchit le header avec le nouveau cookie reçu après login.
    if 'XSRF-TOKEN' in global_session.cookies:
        token = unquote(global_session.cookies['XSRF-TOKEN'])
        global_session.headers.update({"X-XSRF-TOKEN": token})

def test_register_event_success():
    payload = {"user_id": 1}
    response = global_session.post(f"{BASE_URL}/events/5/register", data=payload)
    # Si ça renvoie encore 419, on affiche le message pour debugger
    if response.status_code == 419:
        print(f"\nDEBUG: Session cookies: {global_session.cookies.get_dict()}")
    
    assert response.status_code in [200, 201, 302]

def test_register_event_capacity_limit():
    payload = {"user_id": 2}
    response = global_session.post(f"{BASE_URL}/events/5/register", data=payload)
    assert response.status_code in [302, 400, 422]

def test_cancel_registration():
    response = global_session.delete(f"{BASE_URL}/events/5/cancel")
    assert response.status_code in [200, 204, 302]

def test_my_registrations():
    response = global_session.get(f"{BASE_URL}/my-registrations")
    assert response.status_code == 200