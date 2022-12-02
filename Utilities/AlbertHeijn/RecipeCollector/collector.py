from bs4 import BeautifulSoup





from selenium import webdriver
from selenium.webdriver.firefox.service import Service
from webdriver_manager.firefox import GeckoDriverManager
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.remote.webelement import WebElement
from time import sleep
import requests
from time import sleep
from selenium.webdriver.firefox.options import Options
from random import randint





options = Options()
options.headless = False
driver = webdriver.Firefox(options=options, service=Service(GeckoDriverManager().install()))
driver.maximize_window()
driver.get("https://www.ah.nl/allerhande/recepten-zoeken")


sleep(5)





page = 1
active = True
while active:
    pPage = str(page)
    html = driver.execute_script("return document.getElementsByTagName('html')[0].innerHTML")
    # html = element.get_attribute('innerHTML')
    soup = BeautifulSoup(html)

    with open('output_dump.txt', 'a', encoding="utf-8") as out:
        out.write(soup.text + '\n')
    
    print(page)
    driver.get("https://www.ah.nl/allerhande/recepten-zoeken?page=" + pPage)
    page += 1
    sleep(3)
    if page == 290:
        active = False