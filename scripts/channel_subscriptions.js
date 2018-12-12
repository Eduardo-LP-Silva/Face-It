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


let subscribeEl = document.getElementById("subscribe");
let channel = escapeHtml(document.getElementById("channel_name").textContent);

if(subscribeEl.children[1].textContent == "Subscribe")
    subscribeEl.children[0].addEventListener('click', subscribe);
else
    subscribeEl.children[0].addEventListener('click', unsubscribe);

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

function subscribe(event)
{
    let request = getNewXMLHttpRequest();

    request.onload = function()
    {  
        let unsubBtn = subscribeEl.children[0];

        unsubBtn.setAttribute("src", "../assets/subscribed.svg");
        unsubBtn.removeEventListener('click', subscribe);
        unsubBtn.addEventListener('click', unsubscribe);
        subscribeEl.children[1].textContent = "Subscribed";

        let channels = document.querySelectorAll("#channels > ul > *");
        let channels_aux = [];

        for(let i = 1; i < channels.length; i++)
            channels_aux[i - 1] = channels[i].children[0].textContent;

        channels_aux.push(channel);
        channels_aux.sort();

        let new_pos = -1;

        for(let i = 0; i < channels_aux.length; i++)
            if(channels_aux[i] == channel)
            {
                new_pos = i;
                break;
            }

        let new_el = document.createElement("li");
        let a_el = document.createElement("a");

        a_el.setAttribute("href", "./channel.php?channel=" + channel);
        a_el.textContent = channel;
        
        new_el.appendChild(a_el);

        channels[0].parentElement.insertBefore(new_el, channels[new_pos + 1]);
    }
    
    let linktoexecute = "../database/channels/subscribe.php?channel=" + channel; 
    request.open("GET", linktoexecute, true);
    request.send();
}

function unsubscribe(event)
{
    let request = getNewXMLHttpRequest();

    request.onload = function()
    {  
        let subscribeBtn = subscribeEl.children[0];

        subscribeBtn.setAttribute("src", "../assets/subscribe.svg");
        subscribeBtn.removeEventListener('click', unsubscribe);
        subscribeBtn.addEventListener('click', subscribe);
        subscribeEl.children[1].textContent = "Subscribe";

        let channels = document.querySelectorAll("#channels > ul > *");

        for(let i = 0; i < channels.length; i++)
            if(channels[i].children[0].textContent == channel)
                channels[i].parentElement.removeChild(channels[i]);

    }
    
    let linktoexecute = "../database/channels/unsubscribe.php?channel=" + channel; 
    request.open("GET", linktoexecute, true);
    request.send();
}