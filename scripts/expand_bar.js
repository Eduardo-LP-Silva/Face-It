let expand_bar = document.getElementById("expand_bar");

expand_bar.addEventListener('click', function(event)
{
    let class_value = document.getElementsByClassName("channel_info")[0];

    class_value.classList.toggle("channel_info_shrunk");

    if(this.textContent == "<<")
        this.textContent = ">>";
    else
        this.textContent = "<<";
});