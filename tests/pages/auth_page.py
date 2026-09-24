# -*- coding: utf-8 -*-
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
import time
import random

class AuthPage:
    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 20)

    def register(self, username, password):
        try:
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
            return email
        except Exception as e:
            raise Exception(f"Erreur lors de inscription: {str(e)}")

    def login(self, email, password):
        try:
            email_field = self.wait.until(EC.presence_of_element_located((By.NAME, "email")))
            email_field.clear()
            email_field.send_keys(email)
            
            password_field = self.driver.find_element(By.NAME, "password")
            password_field.clear()
            password_field.send_keys(password)
            password_field.send_keys(Keys.ENTER)
            time.sleep(3)
            self.wait.until(EC.presence_of_element_located((By.TAG_NAME, "body")))
        except Exception as e:
            raise Exception(f"Erreur lors de connexion: {str(e)}")

    def logout(self):
        try:
            logout_btn = self.wait.until(EC.element_to_be_clickable(
                (By.XPATH, "//a[contains(text(), 'Logout') or contains(text(), 'Sign Out')]")
            ))
            logout_btn.click()
            time.sleep(2)
        except Exception as e:
            raise Exception(f"Erreur lors de deconnexion: {str(e)}")