import requests

BASE_URL = "http://127.0.0.1:8000/api"

def test_register_event_success():
    payload = {
        "user_id": 1,
        "event_id": 5
    }
    response = requests.post(f"{BASE_URL}/registrations", json=payload)
    assert response.status_code == 201
    assert response.json()["status"] == "success"

def test_register_event_capacity_limit():
    payload = {
        "user_id": 2,
        "event_id": 5
    }
    response = requests.post(f"{BASE_URL}/registrations", json=payload)
    assert response.status_code in [400, 422]  # dépend de ton backend
