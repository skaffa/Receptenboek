import requests
import bs4

source = requests.get('https://www.smulweb.nl/recepten').text

soup = bs4.BeautifulSoup(source, features="html5lib")

print(source)
# searchPagination
pageContent = soup.find("div", {"id": "searchPagination"})

# pageContent = pageContent.findChildren("a", recursive=True)
pageContent = pageContent.findChildren("article", recursive=True)

for page in pageContent:
    print(page.text)