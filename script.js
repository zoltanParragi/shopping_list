document.querySelector('#hamburger').onclick = () => {
    document.querySelector('#mobileMenu').style.display = "block";
}

document.querySelector('#mobileMenu>div>img').onclick = () => {
    document.querySelector('#mobileMenu').style.display = "none";
}

document.querySelector('#addListItem').onclick = () => {
    document.querySelector('#listItemForm').style.display = "block";
}

document.querySelector('#listItemForm>div:first-child').onclick = () => {
    document.querySelector('#listItemForm').style.display = "none";
}

let idToDel
let description
document.querySelectorAll('.del').forEach((e, i)=> {
    e.onclick = () => {
        idToDel = e.parentElement.id
        description = e.parentElement.dataset.description
        document.querySelector('#delConfirmationPopup>div').innerText = description
        document.querySelector('#delConfirmationPopup').style.display = "block"
        document.querySelector('#delConfirmationPopup>a').href= "server.php?referrer_page=index&id_to_del=" + idToDel
    }
}) 


document.querySelectorAll('.inTrolley').forEach((e, i)=> {
    e.onclick = () => {
        idInTrolley = e.parentElement.id
        document.getElementById(idInTrolley).style.display = "none"
    }
}) 

document.querySelector('#delConfirmationPopup>button:nth-child(3)').onclick = () => {
    document.querySelector('#delConfirmationPopup').style.display = "none"
}
