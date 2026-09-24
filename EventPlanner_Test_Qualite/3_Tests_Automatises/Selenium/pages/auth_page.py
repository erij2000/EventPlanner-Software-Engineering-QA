# -*- coding: utf-8 -*-
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import TimeoutException
import time
import random

class AuthPage:
    """
    Page Object pour l'authentification
    Coherent avec les routes Laravel Breeze
    """
    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 20)

    def register(self, username, password):
        """
        Inscription d'un nouvel utilisateur
        Route: /register
        Champs: name, email, password, password_confirmation
        Retourne: l'email genere
        """
        try:
            if "register" not in self.driver.current_url:
                self.driver.get("http://127.0.0.1:8000/register")
                time.sleep(1)

            timestamp = int(time.time())
            random_num = random.randint(1000, 9999)
            email = f"{username.lower()}_{timestamp}_{random_num}@test.com"

            name_field = self.wait.until(EC.presence_of_element_located((By.NAME, "name")))
            name_field.clear()
            name_field.send_keys(username)

            email_field = self.driver.find_element(By.NAME, "email")
            email_field.clear()
            email_field.send_keys(email)

            password_field = self.driver.find_element(By.NAME, "password")
            password_field.clear()
            password_field.send_keys(password)

            try:
                password_confirm = self.driver.find_element(By.NAME, "password_confirmation")
                password_confirm.clear()
                password_confirm.send_keys(password)
            except:
                pass

            password_field.send_keys(Keys.ENTER)
            time.sleep(3)

            self.wait.until(EC.presence_of_element_located((By.TAG_NAME, "body")))
            print(f"[AUTH] Utilisateur inscrit: {email}")
            return email

        except Exception as e:
            self.driver.save_screenshot("error_register.png")
            raise Exception(f"Erreur lors de l'inscription: {str(e)}")

    def login(self, email, password):
        """
        Connexion d'un utilisateur existant
        Route: /login
        Champs: email, password
        """
        try:
            if "login" not in self.driver.current_url:
                self.driver.get("http://127.0.0.1:8000/login")
                time.sleep(1)

            email_field = self.wait.until(EC.presence_of_element_located((By.NAME, "email")))
            email_field.clear()
            email_field.send_keys(email)

            password_field = self.driver.find_element(By.NAME, "password")
            password_field.clear()
            password_field.send_keys(password)

            password_field.send_keys(Keys.ENTER)
            time.sleep(3)

            # ✅ Vérification plus fiable : attendre un élément de la navbar
            try:
                self.wait.until(EC.presence_of_element_located(
                    (By.XPATH, "//a[contains(text(), 'My Tickets')]")
                ))
                print(f"[AUTH] Connexion reussie (user): {email}")
            except TimeoutException:
                self.wait.until(EC.presence_of_element_located(
                    (By.XPATH, "//a[contains(text(), 'Admin Dashboard')]")
                ))
                print(f"[AUTH] Connexion reussie (admin): {email}")

        except Exception as e:
            self.driver.save_screenshot("error_login.png")
            raise Exception(f"Erreur lors de la connexion: {str(e)}")

    def logout(self):
        """
        Deconnexion via le dropdown
        Route: POST /logout (formulaire dans navbar)
        """
        try:
            dropdown = self.wait.until(EC.element_to_be_clickable(
                (By.XPATH, "//button[contains(@class, 'flex items-center')]")
            ))
            dropdown.click()
            time.sleep(1)

            signout_link = self.wait.until(EC.element_to_be_clickable(
                (By.XPATH, "//a[contains(text(), 'Sign Out')]")
            ))
            signout_link.click()
            time.sleep(2)
            
            print("[AUTH] Deconnexion reussie")

        except Exception as e:
            self.driver.save_screenshot("error_logout.png")
            raise Exception(f"Erreur lors de la deconnexion: {str(e)}")
