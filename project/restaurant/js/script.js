
//phần menu
const menuBtns = document.querySelectorAll('.menu-btn');
const dishItems = document.querySelectorAll('.dish');

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