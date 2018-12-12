let entityMap = 
{
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;'
};

function escapeHtml(string) 
{
    return String(string).replace(/[&<>"'\/]/g, function (s) 
    {
      return entityMap[s];
    });
}

function validate_post()
{
    let post_title = document.querySelector("#post_title").value;
    let post_image_url = document.querySelector("#post_image").value;
    let post_text = document.querySelector("#post_text").value;

    if(post_image_url && post_image_url.matches(/\.(jpeg|jpg|gif|png)$/))
    {
        alert("Link provided does not link to an image");
        return false;
    }

    document.querySelector("#post_title").value = escapeHtml(post_title);
    document.querySelector("#post_text").value = escapeHtml(post_text);

    return true;
}
