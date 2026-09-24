# -*- coding: utf-8 -*-
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
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
            
            # Chercher et cliquer sur le bouton submit
            try:
                submit_btn = self.driver.find_element(By.XPATH, "//button[@type='submit']")
                submit_btn.click()
            except NoSuchElementException:
                name_field.send_keys(Keys.ENTER)
            
            time.sleep(3)
            print(f"[ADMIN] Categorie '{cat_name}' creee")
            print(f"[DEBUG] URL apres creation categorie: {self.driver.current_url}")

        except Exception as e:
            self.driver.save_screenshot("error_create_category.png")
            raise Exception(f"Erreur creation categorie: {str(e)}")

    def create_event(self, title):
        try:
            self.driver.get("http://127.0.0.1:8000/admin/events/create")
            time.sleep(2)
            
            print(f"[DEBUG] Sur page: {self.driver.current_url}")

            title_field = self.wait.until(EC.presence_of_element_located((By.NAME, "title")))
            title_field.clear()
            title_field.send_keys(title)
            print(f"[DEBUG] Titre saisi: {title}")

            desc_field = self.driver.find_element(By.NAME, "description")
            desc_field.clear()
            desc_field.send_keys("Test automatique Selenium")

            capacity_field = self.driver.find_element(By.NAME, "capacity")
            capacity_field.clear()
            capacity_field.send_keys("50")

            # Champs optionnels
            try:
                date_field = self.driver.find_element(By.NAME, "date")
                date_field.clear()
                date_field.send_keys("2026-12-31")
                print("[DEBUG] Date saisie: 2026-12-31")
            except NoSuchElementException:
                print("[DEBUG] Pas de champ date")

            try:
                time_field = self.driver.find_element(By.NAME, "time")
                time_field.clear()
                time_field.send_keys("18:00")
                print("[DEBUG] Time saisie: 18:00")
            except NoSuchElementException:
                print("[DEBUG] Pas de champ time")

            # Categorie
            try:
                category_select = self.driver.find_element(By.NAME, "category_id")
                category_select.click()
                time.sleep(0.5)
                category_select.send_keys(Keys.ARROW_DOWN)
                category_select.send_keys(Keys.ENTER)
                print("[DEBUG] Categorie selectionnee")
            except NoSuchElementException:
                print("[DEBUG] Pas de champ category_id")

            # Screenshot avant submit
            self.driver.save_screenshot("before_submit_event.png")
            
            # Soumettre le formulaire
            try:
                submit_btn = self.driver.find_element(By.XPATH, "//button[@type='submit']")
                print("[DEBUG] Bouton submit trouve, clic...")
                submit_btn.click()
            except NoSuchElementException:
                print("[DEBUG] Pas de bouton submit, utilisation de ENTER")
                title_field.send_keys(Keys.ENTER)
            
            time.sleep(3)
            
            print(f"[DEBUG] URL apres submit: {self.driver.current_url}")
            self.driver.save_screenshot("after_submit_event.png")
            
            # Verifier s'il y a des erreurs de validation
            if "create" in self.driver.current_url:
                print("[WARN] Toujours sur page create - possible erreur validation")
                try:
                    errors = self.driver.find_elements(By.CLASS_NAME, "text-red-600")
                    if errors:
                        print(f"[ERROR] Erreurs de validation trouvees: {len(errors)}")
                        for error in errors:
                            print(f"  - {error.text}")
                except:
                    pass
            
            print(f"[ADMIN] Evenement '{title}' cree (ou tentative)")

        except Exception as e:
            self.driver.save_screenshot("error_create_event.png")
            print(f"[ERROR] Exception: {str(e)}")
            raise Exception(f"Erreur creation evenement: {str(e)}")

    def event_exists(self, event_name):
        try:
            print(f"[ADMIN] Verification de '{event_name}' dans /admin/events...")
            self.driver.get("http://127.0.0.1:8000/admin/events")
            time.sleep(2)

            self.wait.until(EC.presence_of_element_located((By.TAG_NAME, "body")))
            
            # Screenshot pour debug
            self.driver.save_screenshot("admin_events_list.png")
            print(f"[DEBUG] URL liste admin: {self.driver.current_url}")
            
            # Chercher dans le HTML
            page_source = self.driver.page_source
            
            # Afficher une partie du contenu pour debug
            if "<table" in page_source or "<div" in page_source:
                print("[DEBUG] Page contient du contenu HTML")
            
            if event_name in page_source:
                print(f"[ADMIN] ✓ Evenement '{event_name}' trouve")
                return True
            else:
                print(f"[ADMIN] ✗ Evenement '{event_name}' NON trouve")
                print(f"[DEBUG] Page contient 'Event_': {'Event_' in page_source}")
                
                # Chercher tous les evenements visibles
                try:
                    events = self.driver.find_elements(By.XPATH, "//*[contains(text(), 'Event_')]")
                    print(f"[DEBUG] Evenements trouves avec 'Event_': {len(events)}")
                    for evt in events[:3]:
                        print(f"  - {evt.text[:50]}")
                except:
                    pass
                
                return False

        except Exception as e:
            print(f"[ADMIN] Erreur verification: {str(e)}")
            self.driver.save_screenshot("error_event_exists.png")
            return False

    def delete_event(self, event_name):
        try:
            self.driver.get("http://127.0.0.1:8000/admin/events")
            time.sleep(2)

            delete_btn = self.wait.until(EC.element_to_be_clickable(
                (By.XPATH, f"//tr[contains(., '{event_name}')]//button[contains(text(), 'Delete')]")
            ))
            delete_btn.click()

            try:
                alert = WebDriverWait(self.driver, 3).until(EC.alert_is_present())
                alert.accept()
            except TimeoutException:
                pass

            time.sleep(2)
            print(f"[ADMIN] Evenement '{event_name}' supprime")

        except Exception as e:
            self.driver.save_screenshot("error_delete_event.png")
            raise Exception(f"Erreur suppression: {str(e)}")

    def delete_category(self, category_name):
        try:
            self.driver.get("http://127.0.0.1:8000/admin/categories")
            time.sleep(2)

            delete_btn = self.wait.until(EC.element_to_be_clickable(
                (By.XPATH, f"//tr[contains(., '{category_name}')]//button[contains(text(), 'Delete')]")
            ))
            delete_btn.click()

            try:
                alert = WebDriverWait(self.driver, 3).until(EC.alert_is_present())
                alert.accept()
            except TimeoutException:
                pass

            time.sleep(2)
            print(f"[ADMIN] Categorie '{category_name}' supprimee")

        except Exception as e:
            self.driver.save_screenshot("error_delete_category.png")
            raise Exception(f"Erreur suppression categorie: {str(e)}")