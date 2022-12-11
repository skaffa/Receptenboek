"use strict"

const recipesPreview = document.getElementById('recipes-preview');

window.addEventListener('load', () => {
    fetchRandomItems();
    setInterval(fetchRandomItems, 1000 * 10);
});

async function fetchRandomItems() {
    console.log('random');
    let formData = new FormData();
    formData.append('getHomeItems', 'test');
    let res = await fetch(new Request('./Controllers/Request.php'), {
        method : 'POST',
        credentials: 'same-origin',
        body: formData
    }).then(response => response.json());
    
    while (recipesPreview.hasChildNodes()){
        recipesPreview.removeChild(recipesPreview.firstChild);
    }

    for (let r in res){ 
        createHomeItem(res[r]);
    }
    return res;
}

function createHomeItem(item) {
    
    let div = document.createElement('div');
    let a = document.createElement('a');
    // a.classList.add('recipe');

    let img = document.createElement('img');
    img.src = "Utilities/AlbertHeijn/RecipeRipper/output/images/" + item.imageLink;
    img.alt = '';

    let ul = document.createElement('ul');
    let li = document.createElement('li');
    li.innerText = item.preptime;

    ul.appendChild(li);
    li = document.createElement('li');
    li.innerText = item.calories;

    ul.appendChild(li);

    li = document.createElement('li');
    li.innerText = item.portions;
    
    ul.appendChild(li);

    let p = document.createElement('p');
    p.innerText = item.title;

    a.href = "./Views/Recipe.php?recipeId=" + item.id;
    a.appendChild(img);
    a.appendChild(ul);
    a.appendChild(p);

    div.appendChild(a);
    recipesPreview.appendChild(div);
}