const commentBox = document.querySelector('.comment-session')
const commentTrigger = document.querySelector('#comment-button')

commentTrigger.addEventListener("click", (event) => {
    if(commentBox.style.display === "none") commentBox.style.display = "block";
    else commentBox.style.display = "none";
})

function followButtonTrigger(to_follow, stall_id){
    var is_follow = !to_follow;
    const followButton = document.querySelector('.like-button')  
    followButton.addEventListener("click", (event) => {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if(this.responseText == "success"){
            if(is_follow) followButton.innerHTML = '<i class="fa-regular fa-heart"></i>';
            else followButton.innerHTML = '<i class="fa-solid fa-heart"></i>';
            is_follow = !is_follow;
          }
        }
      };
      xmlhttp.open("GET", `controller/comment.php?action=follow&stall_id=${stall_id}&value=${Number(!is_follow)}`, true);
      xmlhttp.send();
  })
}

function likeButtonsTrigger(status_dict){
    const likeButtons = document.querySelectorAll('.dish-like')
    
    likeButtons.forEach(likeButtonTrigger);

    function likeButtonTrigger(likeButton) {
        var item_id = likeButton.classList.item(1)
        var is_liked = status_dict[item_id]
        likeButton.addEventListener("click", (event) => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                if(this.responseText == "success"){
                if(is_liked) likeButton.innerHTML = '<i class="fa-regular fa-thumbs-up"></i>';
                else likeButton.innerHTML = '<i class="fa-sharp fa-solid fa-thumbs-up"></i>';
                is_liked = !is_liked;
                }
            }
            };
            xmlhttp.open("GET", `controller/comment.php?action=like&item_id=${item_id}&value=${Number(!is_liked)}`, true);
            xmlhttp.send();
        })
}
}




