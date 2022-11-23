let btn = document.querySelector(".formBtn");
let svgDiv = document.querySelector(".svg");
let form = document.querySelector(".svgForm")
let hidden = document.querySelector(".svgHidden")
console.log(btn)


btn.addEventListener("click", onClickBtn)

function onClickBtn(e){


    let data = new FormData(form);
    console.log(data)
    let url = document.querySelector(".data").dataset.avatar
    console.log(url);
    e.preventDefault();
    fetch(url, {method: "POST", body: data})
        .then((response)=> response.text())
        .then((data)=>{
            console.log("eee");
            hidden.value = data;
           svgDiv.innerHTML = data })


}
btn.click();
