import requests
import os
from random import randint
import bs4
import re
import shutil
import colorama
import json


os.system('cls||clear')


banner = """
 ▄▄▄       ██░ ██     ██▀███   ██▓ ██▓███  
▒████▄    ▓██░ ██▒   ▓██ ▒ ██▒▓██▒▓██░  ██▒
▒██  ▀█▄  ▒██▀▀██░   ▓██ ░▄█ ▒▒██▒▓██░ ██▓▒
░██▄▄▄▄██ ░▓█ ░██    ▒██▀▀█▄  ░██░▒██▄█▓▒ ▒
 ▓█   ▓██▒░▓█▒░██▓   ░██▓ ▒██▒░██░▒██▒ ░  ░
 ▒▒   ▓▒█░ ▒ ░░▒░▒   ░ ▒▓ ░▒▓░░▓  ▒▓▒░ ░  ░
  ▒   ▒▒ ░ ▒ ░▒░ ░     ░▒ ░ ▒░ ▒ ░░▒ ░     
  ░   ▒    ░  ░░ ░     ░░   ░  ▒ ░░░       
      ░  ░ ░  ░  ░      ░      ░           
                                           
"""
print(banner)

inputFile = 'alle_recepten_second.txt'

if not os.path.exists('output'):
    os.mkdir('output')
if not os.path.exists('output/images'):
    os.mkdir('output/images')

iteration = 0
for line in open(inputFile, 'r', encoding="utf-8").readlines():
    iteration += 1
    source = requests.get(line).text
    soup = bs4.BeautifulSoup(source, features="html5lib")
    print('[' + str(iteration) + '] Fetching ' + line.strip() + '...')

    for svg in soup.find_all("svg"): 
        svg.decompose()

    id = line.split('-')[1].split('/')[0]

    pageTitle = soup.title.text.replace(' - Allerhande | Albert Heijn', '') #Get page title

    title = soup.findAll("h1", {"data-testhook" : "header-title"})[0].text #Get the recipe title

    subTitle = soup.findAll("p", {"data-testhook" : "header-subtitle"})[0].text #Get the recipe subtitle

    imageLink = soup.findAll("img", {"srcset" : True})[0]['srcset'].split(', ')[-1].split(' ')[0] #Get the recipe image
    response = requests.get(imageLink, stream=True)
    with open('output/images/' + id + '.jpg', 'wb') as out_file:
        shutil.copyfileobj(response.raw, out_file)
    del response

    calories = soup.findAll("div", {"data-testhook" : "header-energy"})[0].text.split(' (voedingswaarden)')[0]

    times = soup.findAll("div", {"data-testhook" : "header-time"})[0] #Get preparation, baking and waiting times
    times = times.findChildren("div", recursive=False)
    prepTime = times[0].text
    bakeTime = ''
    waitTime = ''
    for time in times:
        if 'oventijd' in time.text:
            bakeTime = time.text
        if 'wachten' in time.text:
            waitTime = time.text

    try: #GET spiciness
        spiciness = soup.findAll("div", {"data-testhook" : "header-spiciness"})[0].text
    except:
        spiciness = ''

    tagList = [] #Get tags
    tags = soup.findAll("div", {"data-testhook" : "header-tags"})[0]
    tags = tags.findChildren("a", recursive=True)
    for tag in tags:
        tagList.append(tag.text)
    tags = tagList

    portions = soup.findAll("div", {"data-testhook" : "servings"})[0].text #Get portions

    ingredients = soup.findAll("div", {"data-testhook" : "ingredients"})[0] #Get ingredients
    ingredients = ingredients.findChildren("p", recursive=False)
    ingredients = [x.text+' '+y.text for x,y in zip(ingredients[0::2], ingredients[1::2])]

    necc = [] #Get appliances
    try:
        necessary = soup.findAll("ul", {"data-testhook" : "appliances"})[0]
        necessary = necessary.findChildren("li", recursive=False)
        for nec in necessary:
            necc.append(nec.text)
    except Exception as e:
        pass
    necessary = necc

    steps = [] #Get preparation steps
    preparation = soup.findAll("div", {"data-testhook" : "preparation-steps"})[0]
    prepSteps = preparation.findChildren("p", recursive=True)
    for step in prepSteps:
        steps.append(step.text)
    preparation = steps

    tips = [] #Get tips
    try:
        allTips = soup.findAll("div", {"data-testhook" : "preparation-tips"})[0]
        for tip in allTips:
            tipType = tip.findChildren("span", recursive=True)[0].text
            Atip = tip.text.replace(tipType, '')
            tips.append(Atip)
    except:
        pass

    nutrition = soup.findAll("div", {"data-testhook" : "footer-nutrition"})[0] #Get nutrition
    nutritionEntries = nutrition.findChildren("div", recursive=False)
    nutr = []
    for entry in nutritionEntries:
        nutrItem = entry.findChildren("span", recursive=True)
        nutrString = ''
        for child in nutrItem:
            nutrString = nutrString + ' ' + child.text
        nutr.append(nutrString.strip())
    nutr.remove('')
    nutrition = nutr
        
    
    data = {}
    data.update({"id": id})
    data.update({"pageTitle": pageTitle})
    data.update({"pageTitle": pageTitle})
    data.update({"title": subTitle})
    data.update({"calories": calories})
    data.update({"prepTime": prepTime})
    data.update({"bakeTime": bakeTime})
    data.update({"waitTime": waitTime})
    data.update({"spiciness": spiciness})
    data.update({"tags": tags})
    data.update({"portions": portions})
    data.update({"ingredients": ingredients})
    data.update({"necessary": necessary})
    data.update({"preparation": preparation})
    data.update({"tips": tips})
    data.update({"nutrition": nutrition})



    with open('output/' + id + ".json", "w") as save_json:
        json.dump(data, save_json, indent=4, sort_keys=True)