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
        /* recipesPreview.firstChild.className = 'remove-recipe'; */
        
        recipesPreview.removeChild(recipesPreview.firstChild);
    }

    for (let r in res){ 
        createHomeItem(res[r]);
    }
    return res;
}

function createHomeItem(item) {
    let div = document.createElement('div');
    div.classList.add('show-recipe');
    let a = document.createElement('a');

    let img = document.createElement('img');
    img.src = "Utilities/AlbertHeijn/RecipeRipper/output/images/" + item.imageLink;
    img.alt = '';

    let ul = document.createElement('ul');
    let li = document.createElement('li');
    let clock = document.createElement('img');
    clock.src = "assets/img/clock.svg";
    li.appendChild(clock);
    li.innerHTML += item.preptime.replace('bereiden', '');

    ul.appendChild(li);
    let cal = document.createElement('img');
    li = document.createElement('li');
    cal.src = "assets/img/calorie.svg";
    li.appendChild(cal);
    li.innerHTML += item.calories.replace(/[^\d]/g, '');

    ul.appendChild(li);

    li = document.createElement('li');
    let pers = document.createElement('img');
    pers.src = "assets/img/persons.svg";
    li.appendChild(pers);
    li.innerHTML += item.portions.replace(/[^\d]/g, '');
    
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