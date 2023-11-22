const buttonADD = document.getElementById("adici")
const modal = document.querySelector("dialog")
const buttaoFechar = document.getElementById("enviado")

buttonADD.onclick = function (){
    modal.showModal()

}

buttaoFechar.onclick = function(){
    modal.close()
}