let icons = document.getElementsByClassName("fa-reply");
let trashButtons = document.getElementsByClassName("fa-trash");
let likeButtons = document.getElementsByClassName("fa-thumbs-up");

for (let i = 0; i < icons.length; i++){
    icons[i].addEventListener("click", function(){
        let comment = icons[i]["parentNode"]["parentNode"]["parentNode"]["nextElementSibling"]["children"][0];
        if (comment.style.display == "block")
            comment.style.display = "none";
        else
        comment.style.display = "block";
    });
}

for (let i = 0; i < trashButtons.length; i++){
    trashButtons[i].addEventListener("click", function(){
        let form = trashButtons[i]["nextElementSibling"];
        form.submit();
    });
}

for (let i = 0; i < likeButtons.length; i++){
    likeButtons[i].addEventListener("click", function(){
        if (likeButtons[i].style.color == "rgb(3, 101, 140)"){
            likeButtons[i].style.color = "";
        }
        else{
            likeButtons[i].style.color = "rgb(3, 101, 140)";
        }

        let form = likeButtons[i]["nextElementSibling"];
        console.log(form);
        form.submit();
    });
}

