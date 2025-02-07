// On recupere le boutton de chargement
const btnLoad = document.getElementById("load_pouch");
// On recupere le champ d'upload
const fileUpload = document.getElementById("album_imageFile");
// On recupere le champ img qui affiche l'image
const imagePoster = document.getElementById("changeUpload");

btnLoad.addEventListener("click", launchBrowse, false)

fileUpload.addEventListener("change", posterImage, false)

function launchBrowse() {
    fileUpload.click();
}

function posterImage() {
    const imageLoad = this.files[0];
    const urlImageLoad = URL.createObjectURL(imageLoad);
    imagePoster.setAttribute("src", urlImageLoad);
    console.log(urlImageLoad)
}