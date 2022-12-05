import requests
import bs4

links = []
page = 2
while True:
    # try:
    Ppage = str(page)
    print('Fetching page ' + Ppage)
    source = requests.get('https://www.smulweb.nl/recepten?page=' + Ppage, timeout=10000).text
    soup = bs4.BeautifulSoup(source, features="html5lib")
    for link in soup.findAll('a'):
        link = link.get('href')
        if not link == None:
            if True in [char.isdigit() for char in link]:
                if 'https://www.smulweb.nl/recepten/' in link:
                    if not link in links:
                        links.append(link)
                        print(link)
                        with open('all_recipes.txt', 'a', encoding='utf-8') as output:
                            output.write(link + '\n')
    page += 1

    # except Exception as e:
    #     print(e)
    #     continue