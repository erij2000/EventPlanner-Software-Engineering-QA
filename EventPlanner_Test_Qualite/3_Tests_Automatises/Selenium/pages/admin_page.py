# -*- coding: utf-8 -*-
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
import time

class AdminPage:
    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 20)

    def create_category(self, cat_name):
        try:
            self.driver.get("http://127.0.0.1:8000/admin/categories/create")
            time.sleep(1)

            name_field = self.wait.until(EC.presence_of_element_located((By.NAME, "name")))
            name_field.clear()
            name_field.send_keys(cat_name)

            # Bouton Save (pas de type="submit" dans ton Blade)
            submit_btn = self.wait.until(EC.element_to_be_clickable(
                (By.XPATH, "//button[contains(text(), 'Save')]")
            ))
            self.driver.execute_script("arguments[0].scrollIntoView(true);", submit_btn)
            time.sleep(1)
            self.driver.execute_script("arguments[0].click();", submit_btn)

            time.sleep(3)
            print(f"[ADMIN] Categorie '{cat_name}' creee")

        except Exception as e:
            self.driver.save_screenshot("error_create_category.png")
            raise Exception(f"Erreur creation categorie: {str(e)}")

    def create_event(self, title):
        try:
            self.driver.get("http://127.0.0.1:8000/admin/events/create")
            time.sleep(2)

            # Title
            title_field = self.wait.until(EC.presence_of_element_located((By.NAME, "title")))
            title_field.clear()
            title_field.send_keys(title)
            print(f"[DEBUG] Titre: {title}")

            # Description
            desc_field = self.driver.find_element(By.NAME, "description")
            desc_field.clear()
            desc_field.send_keys("Test automatique Selenium")

            # Start Date (datetime-local → YYYY-MM-DDTHH:MM)
            start_date = self.driver.find_element(By.NAME, "start_date")
            self.driver.execute_script("arguments[0].value = '2026-12-25T10:00';", start_date)
            print("[DEBUG] Start Date: 2026-12-25T10:00")

            # End Date
            end_date = self.driver.find_element(By.NAME, "end_date")
            self.driver.execute_script("arguments[0].value = '2026-12-31T18:00';", end_date)
            print("[DEBUG] End Date: 2026-12-31T18:00")

            # Location / Place
            place_field = self.driver.find_element(By.NAME, "place")
            place_field.clear()
            place_field.send_keys("Test Location")
            print("[DEBUG] Place: Test Location")

            # Category
            from selenium.webdriver.support.select import Select
            category_select = Select(self.driver.find_element(By.NAME, "category_id"))
            category_select.select_by_index(1)
            print("[DEBUG] Categorie selectionnee (index 1)")

            # Capacity
            capacity_field = self.driver.find_element(By.NAME, "capacity")
            capacity_field.clear()
            capacity_field.send_keys("50")
            print("[DEBUG] Capacity: 50")

            # Price
            price_field = self.driver.find_element(By.NAME, "price")
            price_field.clear()
            price_field.send_keys("0")
            print("[DEBUG] Price: 0")

            # Screenshot avant submit
            self.driver.save_screenshot("before_submit_event.png")

            # Bouton Publish Event / Update Event
            submit_btn = self.wait.until(EC.presence_of_element_located(
                (By.XPATH, "//button[contains(text(), 'Publish Event') or contains(text(), 'Update Event')]")
            ))

            # Scroll + clic forcé via JS
            self.driver.execute_script("arguments[0].scrollIntoView(true);", submit_btn)
            time.sleep(1)
            self.driver.execute_script("arguments[0].click();", submit_btn)
            print("[DEBUG] Clic forcé via JS sur bouton submit...")

            time.sleep(4)
            print(f"[DEBUG] URL apres submit: {self.driver.current_url}")
            self.driver.save_screenshot("after_submit_event.png")

        except Exception as e:
            self.driver.save_screenshot("error_create_event.png")
            raise Exception(f"Erreur creation evenement: {str(e)}")

    def event_exists(self, event_name):
        """
        Vérifie si un événement existe dans la liste admin
        """
        try:
            self.driver.get("http://127.0.0.1:8000/admin/events")
            time.sleep(2)
            self.driver.find_element(By.XPATH, f"//*[contains(text(), '{event_name}')]")
            print(f"[ADMIN] Evenement {event_name} trouvé dans la liste admin")
            return True
        except NoSuchElementException:
            print(f"[ADMIN] Evenement {event_name} introuvable")
            return False
