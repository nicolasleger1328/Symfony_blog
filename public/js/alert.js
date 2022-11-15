
let alerte = document.querySelector(".alert-container");
let alertBtn = document.querySelector(".btn-close");
let delBtn = document.querySelector(".remove");
if(alertBtn){
alertBtn.addEventListener("click", (e)=>{
    e.preventDefault();
    alerte.remove();
})
}
if(delBtn){
delBtn.addEventListener("click", (e)=>{
    e.preventDefault();
    if (window.confirm('Êtes-vous certain de vouloir supprimer cet article ?')){
        const link = e.currentTarget;
        console.log(link);
        location.assign(link);
    }
})
}