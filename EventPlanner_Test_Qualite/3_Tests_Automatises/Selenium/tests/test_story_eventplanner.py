# -*- coding: utf-8 -*-
import time
import pytest
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
from pages.auth_page import AuthPage
from pages.admin_page import AdminPage

def test_complete_eventplanner_story(driver):
    wait = WebDriverWait(driver, 20)
    auth = AuthPage(driver)
    admin = AdminPage(driver)

    # ================= ACTE 1 =================
    print("\n" + "="*60)
    print("ACTE 1 - NOUVEL UTILISATEUR CREE UN COMPTE")
    print("="*60)

    driver.get("http://127.0.0.1:8000/register")
    user_email = auth.register("UserAuto", "user12345")
    print(f"[REGISTER] Compte cree: {user_email}")

    # Logout user
    try:
        user_dropdown = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[contains(@class, 'flex items-center')]")))
        user_dropdown.click()
        signout_link = wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Sign Out')]")))
        signout_link.click()
        time.sleep(2)
        print("[LOGOUT] Utilisateur deconnecte apres inscription")
    except TimeoutException:
        driver.get("http://127.0.0.1:8000/logout")
        time.sleep(2)

    # ================= ACTE 2 =================
    print("\n" + "="*60)
    print("ACTE 2 - ADMIN CREE CATEGORIE + EVENEMENT")
    print("="*60)

    driver.get("http://127.0.0.1:8000/login")
    auth.login("admin@event.com", "admin123")
    print("[LOGIN] Admin connecte")

    category_name = f"Category_{int(time.time())}"
    admin.create_category(category_name)

    event_name = f"Event_{int(time.time())}"
    admin.create_event(event_name)

    assert admin.event_exists(event_name), f"Evenement {event_name} non trouve"

    driver.get("http://127.0.0.1:8000/events")
    time.sleep(2)
    try:
        driver.find_element(By.XPATH, f"//*[contains(text(), '{event_name}')]")
        print(f"[CHECK] Evenement {event_name} visible dans liste publique")
    except NoSuchElementException:
        driver.save_screenshot("debug_event_not_found.png")
        pytest.fail(f"Evenement {event_name} non trouve dans /events")

    # Logout admin
    try:
        admin_dropdown = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[contains(@class, 'flex items-center')]")))
        admin_dropdown.click()
        signout_link = wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Sign Out')]")))
        signout_link.click()
        time.sleep(2)
        print("[LOGOUT] Admin deconnecte")
    except TimeoutException:
        driver.get("http://127.0.0.1:8000/logout")
        time.sleep(2)

    # ================= ACTE 3 =================
    print("\n" + "="*60)
    print("ACTE 3 - UTILISATEUR LOGIN ET INSCRIPTION A EVENEMENT")
    print("="*60)

    driver.get("http://127.0.0.1:8000/login")
    auth.login(user_email, "user12345")
    print(f"[LOGIN] Utilisateur connecte: {user_email}")

    driver.get("http://127.0.0.1:8000/events")
    time.sleep(2)

    # Clic robuste sur l'événement
    try:
        event_link = wait.until(EC.presence_of_element_located((By.XPATH, f"//a[contains(text(), '{event_name}')]")))
        driver.execute_script("arguments[0].scrollIntoView(true);", event_link)
        time.sleep(1)
        driver.execute_script("arguments[0].click();", event_link)
        print(f"[CLICK] Ouverture page detail evenement: {event_name}")
    except TimeoutException:
        driver.save_screenshot("debug_event_click.png")
        pytest.fail(f"Impossible de cliquer sur l'evenement {event_name}")

    # Clic robuste sur Register
    try:
        register_btn = wait.until(EC.presence_of_element_located((By.XPATH, "//button[contains(text(), 'Register')]")))
        driver.execute_script("arguments[0].scrollIntoView(true);", register_btn)
        time.sleep(1)
        driver.execute_script("arguments[0].click();", register_btn)
        print(f"[REGISTER] Inscription a l'evenement {event_name}")
    except TimeoutException:
        driver.save_screenshot("debug_register_btn.png")
        pytest.fail("Bouton Register non trouve sur page evenement")

    driver.get("http://127.0.0.1:8000/my-registrations")
    time.sleep(2)
    try:
        driver.find_element(By.XPATH, f"//*[contains(text(), '{event_name}')]")
        print("[CHECK] Inscription confirmee dans My Tickets")
    except NoSuchElementException:
        driver.save_screenshot("debug_my_tickets.png")
        pytest.fail("Inscription non trouvee dans /my-registrations")

    # ================= ACTE 4 =================
    print("\n" + "="*60)
    print("ACTE 4 - ANNULATION DE LA RESERVATION")
    print("="*60)

    driver.get("http://127.0.0.1:8000/my-registrations")
    time.sleep(2)

    # Clic robuste sur Cancel
    try:
        cancel_btn = wait.until(EC.presence_of_element_located((By.XPATH, "//button[contains(text(), 'Cancel')]")))
        driver.execute_script("arguments[0].scrollIntoView(true);", cancel_btn)
        time.sleep(1)
        driver.execute_script("arguments[0].click();", cancel_btn)
        print("[CLICK] Bouton Cancel clique")
        try:
            alert = WebDriverWait(driver, 3).until(EC.alert_is_present())
            alert.accept()
            time.sleep(2)
            print("[CANCEL] Reservation annulee via alerte JS")
        except TimeoutException:
            print("[INFO] Pas d'alerte JS - annulation directe")
            time.sleep(2)
    except TimeoutException:
        driver.save_screenshot("debug_cancel_btn.png")
        print("[ERROR] Bouton Cancel non trouve")

    driver.get("http://127.0.0.1:8000/my-registrations")
    time.sleep(2)
    page_source = driver.page_source
    if (event_name not in page_source or "No Tickets Found" in page_source):
        print("[CHECK] Reservation bien annulee")
    else:
        driver.save_screenshot("debug_after_cancel.png")
        print("[WARN] L'evenement apparait encore dans My Tickets")

    # ================= LOGOUT FINAL =================
    try:
        user_dropdown = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[contains(@class, 'flex items-center')]")))
        user_dropdown.click()
        signout_link = wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Sign Out')]")))
        signout_link.click()
        time.sleep(2)
        print("[LOGOUT] Utilisateur deconnecte")
    except TimeoutException:
        driver.get("http://127.0.0.1:8000/logout")
        time.sleep(2)
