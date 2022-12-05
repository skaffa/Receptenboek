"use strict"

const recipesPreview = document.getElementById('recipes-preview');

window.addEventListener('load', () => {
    fetchRandomItems();
});


async function fetchRandomItems() {
    let formData = new FormData();
    formData.append('getHomeItems', 'test');
    let res = await fetch(new Request('./Controllers/Request.php'), {
        method : 'POST',
        credentials: 'same-origin',
        body: formData,
    }).then(response => console.log(response));
    console.log(res);
    return res;
}