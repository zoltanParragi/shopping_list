async function getResponse() {
    const response = await fetch('place_codes.json');
    const data = await response.json();
    return data;
  }
  
  getResponse().then(data => {
    data.forEach(e => {
        document.querySelector("#placeCodes").innerHTML += `<div class="codeLines"><span class="code">${e.code}: </span> <span class="items">${e.items}</span></div>`
    });
    console.log(data);
  });