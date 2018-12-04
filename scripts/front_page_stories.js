let stories;

function get_front_page_stories()
{
    let request = getNewXMLHttpRequest();
    request.onload = function()
    {
        stories = JSON.parse(this.responseText);

        console.log(stories);
    }

    let linktoexecute = "../database/stories/get_front_page_stories.php";
    request.open("GET", linktoexecute, true);
    request.send();
}




function getNewXMLHttpRequest()
{
    let request;

    if (window.XMLHttpRequest) 
    {
        request = new XMLHttpRequest();
    }
    else 
    {
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }

    return request;
}