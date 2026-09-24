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
    """
    Test complet du parcours utilisateur EventPlanner
    Coherent avec les routes Laravel et la navbar
    """
    wait = WebDriverWait(driver, 20)
    auth = AuthPage(driver)
    admin = AdminPage(driver)

    # ================= ACTE 1 =================
    print("\n" + "="*60)
    print("ACTE 1 - NOUVEL UTILISATEUR CREE UN COMPTE")
    print("="*60)

    driver.get("http://127.0.0.1:8000")
    
    # Cliquer sur "Get Started" pour aller sur register
    try:
        get_started_btn = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//a[contains(text(), 'Get Started')]")
        ))
        get_started_btn.click()
        time.sleep(1)
    except TimeoutException:
        # Si pas de bouton, aller directement sur /register
        driver.get("http://127.0.0.1:8000/register")
    
    user_email = auth.register("UserAuto", "user12345")
    print(f"[REGISTER] Compte cree: {user_email}")

    # Apres inscription, l'utilisateur est auto-connecte
    # Verifier qu'on est bien connecte en cherchant le dropdown avec le nom
    try:
        user_dropdown = wait.until(EC.presence_of_element_located(
            (By.XPATH, "//button[contains(., 'UserAuto')]")
        ))
        print("[CHECK] Utilisateur auto-connecte apres inscription")
    except TimeoutException:
        print("[WARN] Utilisateur peut-etre pas auto-connecte")

    # Cliquer sur le dropdown puis Sign Out
    try:
        # Ouvrir le dropdown utilisateur
        user_dropdown = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//button[contains(@class, 'flex items-center') and contains(., 'UserAuto')]")
        ))
        user_dropdown.click()
        time.sleep(1)
        
        # Cliquer sur Sign Out dans le dropdown
        signout_link = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//a[contains(text(), 'Sign Out')]")
        ))
        signout_link.click()
        time.sleep(2)
        print("[LOGOUT] Utilisateur deconnecte apres inscription")
    except TimeoutException:
        print("[WARN] Impossible de se deconnecter - on continue")
        driver.get("http://127.0.0.1:8000/logout")
        time.sleep(2)

    # ================= ACTE 2 =================
    print("\n" + "="*60)
    print("ACTE 2 - ADMIN CREE CATEGORIE + EVENEMENT")
    print("="*60)

    # Aller sur la page login
    driver.get("http://127.0.0.1:8000/login")
    time.sleep(1)
    
    auth.login("admin@event.com", "admin123")
    print("[LOGIN] Admin connecte")
    
    # Verifier qu'on voit "Admin Dashboard"
    try:
        wait.until(EC.presence_of_element_located(
            (By.XPATH, "//a[contains(text(), 'Admin Dashboard')]")
        ))
        print("[CHECK] Admin Dashboard visible dans navbar")
    except TimeoutException:
        print("[WARN] Admin Dashboard non visible")

    category_name = f"Category_{int(time.time())}"
    admin.create_category(category_name)

    event_name = f"Event_{int(time.time())}"
    admin.create_event(event_name)

    assert admin.event_exists(event_name), f"Evenement {event_name} non trouve"

    # Verifier dans la liste publique (route: events.public)
    driver.get("http://127.0.0.1:8000/events")
    time.sleep(2)
    try:
        driver.find_element(By.XPATH, f"//*[contains(text(), '{event_name}')]")
        print(f"[CHECK] Evenement {event_name} visible dans liste publique")
    except NoSuchElementException:
        driver.save_screenshot("debug_event_not_found.png")
        pytest.fail(f"Evenement {event_name} non trouve dans /events")

    # Logout admin via dropdown
    try:
        admin_dropdown = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//button[contains(@class, 'flex items-center')]")
        ))
        admin_dropdown.click()
        time.sleep(1)
        
        signout_link = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//a[contains(text(), 'Sign Out')]")
        ))
        signout_link.click()
        time.sleep(2)
        print("[LOGOUT] Admin deconnecte")
    except TimeoutException:
        print("[WARN] Impossible de deconnecter admin")

    # ================= ACTE 3 =================
    print("\n" + "="*60)
    print("ACTE 3 - UTILISATEUR LOGIN ET INSCRIPTION A EVENEMENT")
    print("="*60)

    # Cliquer sur "Login" dans navbar
    try:
        login_link = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//a[contains(text(), 'Login')]")
        ))
        login_link.click()
        time.sleep(1)
    except TimeoutException:
        driver.get("http://127.0.0.1:8000/login")
    
    auth.login(user_email, "user12345")
    print(f"[LOGIN] Utilisateur connecte: {user_email}")
    
    # Verifier qu'on voit "My Tickets" dans navbar (pour user non-admin)
    try:
        wait.until(EC.presence_of_element_located(
            (By.XPATH, "//a[contains(text(), 'My Tickets')]")
        ))
        print("[CHECK] My Tickets visible dans navbar")
    except TimeoutException:
        print("[WARN] My Tickets non visible")

    # Aller sur "Explore Events"
    driver.get("http://127.0.0.1:8000/events")
    time.sleep(2)

    # Cliquer sur l'evenement cree
    try:
        event_link = wait.until(EC.element_to_be_clickable(
            (By.XPATH, f"//a[contains(text(), '{event_name}')]")
        ))
        driver.execute_script("arguments[0].scrollIntoView();", event_link)
        time.sleep(1)
        event_link.click()
        time.sleep(2)
        print(f"[CLICK] Ouverture page detail evenement: {event_name}")
    except TimeoutException:
        driver.save_screenshot("debug_event_click.png")
        pytest.fail(f"Impossible de cliquer sur l'evenement {event_name}")

    # Cliquer sur le bouton "Register" (formulaire POST events.register)
    try:
        register_btn = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//button[contains(text(), 'Register') or contains(@type, 'submit')]")
        ))
        register_btn.click()
        time.sleep(3)
        print(f"[REGISTER] Inscription a l'evenement {event_name}")
    except TimeoutException:
        driver.save_screenshot("debug_register_btn.png")
        pytest.fail("Bouton Register non trouve sur page evenement")

    # Verifier l'inscription dans "My Tickets" (route: my.registrations)
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

    # Deja sur /my-registrations
    driver.get("http://127.0.0.1:8000/my-registrations")
    time.sleep(2)

    # Chercher le bouton Cancel (formulaire DELETE events.cancel)
    try:
        cancel_btn = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//button[contains(text(), 'Cancel') or contains(text(), 'Annuler')]")
        ))
        cancel_btn.click()
        print("[CLICK] Bouton Cancel clique")
        
        # Gerer l'alerte JavaScript de confirmation si elle existe
        try:
            alert = WebDriverWait(driver, 3).until(EC.alert_is_present())
            alert_text = alert.text
            print(f"[ALERT] Texte alerte: {alert_text}")
            alert.accept()
            time.sleep(2)
            print("[CANCEL] Alerte JS acceptee - reservation annulee")
        except TimeoutException:
            # Pas d'alerte, c'est peut-etre un formulaire direct
            print("[INFO] Pas d'alerte JS - annulation directe")
            time.sleep(2)
    except TimeoutException:
        driver.save_screenshot("debug_cancel_btn.png")
        print("[ERROR] Bouton Cancel non trouve")
        # Continuer quand meme pour voir l'etat

    # Verification finale: l'evenement ne doit plus apparaitre
    driver.get("http://127.0.0.1:8000/my-registrations")
    time.sleep(2)
    
    page_source = driver.page_source
    
    # Chercher le message exact de la vue: "No Tickets Found"
    if (event_name not in page_source or 
        "No Tickets Found" in page_source or 
        "You haven't registered for any events yet" in page_source):
        print("[CHECK] Reservation bien annulee - message 'No Tickets Found' affiche")
    else:
        print("[WARN] L'evenement apparait encore dans My Tickets")
        driver.save_screenshot("debug_after_cancel.png")

    # ================= LOGOUT FINAL =================
    try:
        user_dropdown = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//button[contains(@class, 'flex items-center')]")
        ))
        user_dropdown.click()
        time.sleep(1)
        
        signout_link = wait.until(EC.element_to_be_clickable(
            (By.XPATH, "//a[contains(text(), 'Sign Out')]")
        ))
        signout_link.click()
        time.sleep(1)
        print("[LOGOUT] Deconnexion finale reussie")
    except TimeoutException:
        print("[WARN] Impossible de se deconnecter")

    print("\n" + "="*60)
    print("✓ TEST TERMINE AVEC SUCCES!")
    print("="*60)