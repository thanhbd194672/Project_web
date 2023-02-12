
//phần menu
const menuBtns = document.querySelectorAll('.menu-btn');
const dishItems = document.querySelectorAll('.dish');

const searchBar = document.querySelector("#search-bar")

function normalize(text){
    text = text.normalize('NFD');
    // xóa các ký tự dấu tổ hợp
    text = text.replace(/[\u0300-\u036f]/g, '');
    // chuyển chữ đ/Đ thành d/D
    text = text.replace(/[đĐ]/g, m => m === 'đ' ? 'd' : 'D');
    return text;
}
    

searchBar.addEventListener("input", (event) => {
    if(event.target.value == ""){
        showFoodMenu(activeBtn);
        return;
    };
    var text = normalize(event.target.value);
    dishItems.forEach((item) => {
        if(normalize(item.children[1].textContent).toLowerCase().includes(text) & item.classList.contains(activeBtn)){
            item.style.display = null;
        } else {
            item.style.display = "none";
        }
    });
})

let activeBtn = "all";

showFoodMenu(activeBtn);

menuBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        resetActiveBtn();
        showFoodMenu(btn.id);
        btn.classList.add('active-btn');
    });
});

function resetActiveBtn(){
    menuBtns.forEach((btn) => {
        btn.classList.remove('active-btn');
    });
}

function showFoodMenu(newMenuBtn){
    activeBtn = newMenuBtn;
    dishItems.forEach((item) => {
        if(item.classList.contains(activeBtn)){
            item.style.display = null;
        } else {
            item.style.display = "none";
        }
    });
}
//hết phần menu 