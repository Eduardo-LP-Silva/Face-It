let voteBts = document.querySelectorAll('.story > img:nth-child(1), .story > img:nth-child(3)');

for(let i = 0; i < voteBts.length; i++)
{
    voteBts[i].addEventListener('click', function(event)
    {
        let user_likes = getNewXMLHttpRequest();

        user_likes.onload = function()
        {
            let results = JSON.parse(this.responseText);
            let aditionalInstruction = false;

            if (results.length != 0) //Already Voted
            {
                if(results[0]['points'] == 1)
                {
                    //Downvote
                    if(voteBts[i].nextElementSibling.nodeName != "P")
                        aditionalInstruction = true;

                    remove_story_upvote(voteBts[i], aditionalInstruction);
                    
                }
                else
                {
                    if(voteBts[i].nextElementSibling.nodeName == "P")
                        aditionalInstruction = true;

                    remove_story_downvote(voteBts[i], aditionalInstruction);
                    
                }
            }
            else 
            {
                //Downvote
                if(voteBts[i].nextElementSibling.nodeName != "P")
                {
                    downvote_story(voteBts[i]);
                }
                else
                {
                    upvote_story(voteBts[i]);
                }
            }
        }
        
        //Mudar para user
        let linktoexecute = "../database/votes/get_personal_story_votes.php?client=" + "Des_locado" + "&story=" 
            + this.parentNode.id; 
        user_likes.open("GET", linktoexecute, true);
        user_likes.send();
    });
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

function upvote_story(button)
{
    let request = getNewXMLHttpRequest();

    request.onload = function()
    {
        if(request.responseText != 0)
            console.log("Error in upvoting story - " + request.responseText);
        else
        {
            //Update points number
            let parentNode = button.parentNode;
            let n_points = parentNode.children[1];
            let updated_points = document.createTextNode(parseInt(n_points.firstChild.nodeValue) + 1);
            n_points.replaceChild(updated_points, n_points.firstChild);

            //Replace Symbol
        }
    }

    //Mudar para user
    let linktoexecute = "../database/votes/vote_story.php?client=" + "Des_locado" + "&story_id=" + button.parentNode.id 
        + "&vote=" + 1; 
    request.open("GET", linktoexecute, true);
    request.send();
}

function downvote_story(button)
{
    let request = getNewXMLHttpRequest();

    request.onload = function()
    {
        if(request.responseText != 0)
            console.log("Error in downvoting story - " + request.responseText);
        else
        {
            //Update points number
            let parentNode = button.parentNode;
            let n_points = parentNode.children[1];
            let updated_points = document.createTextNode(parseInt(n_points.firstChild.nodeValue) - 1);
            n_points.replaceChild(updated_points, n_points.firstChild);

            //Replace Symbol
        }
    }

    //Mudar para user
    let linktoexecute = "../database/votes/vote_story.php?client=" + "Des_locado" + "&story_id=" + button.parentNode.id 
        + "&vote=" + "-1"; 
    request.open("GET", linktoexecute, true);
    request.send();
}

function remove_story_upvote(button, downvote)
{
    let request = getNewXMLHttpRequest();

    request.onload = function()
    {
        if(request.responseText != 0)
            console.log("Error in removing upvote from story - " + request.responseText);
        else
        {
            //Update points number
            let parentNode = button.parentNode;
            let n_points = parentNode.children[1];
            let updated_points = document.createTextNode(parseInt(n_points.firstChild.nodeValue) - 1);
            n_points.replaceChild(updated_points, n_points.firstChild);

            //Replace Symbol

            //Execute Second Instruction
            if(downvote)
                downvote_story(button);
        }
    }

    //Mudar para user
    let linktoexecute = "../database/votes/remove_story_vote.php?client=" + "Des_locado" + "&story_id=" 
        + button.parentNode.id + "&vote=" + 1; 
    request.open("GET", linktoexecute, true);
    request.send();
}

function remove_story_downvote(button, upvote)
{
    let request = getNewXMLHttpRequest();

    request.onload = function()
    {
        if(request.responseText != 0)
            console.log("Error in removing downvote from story - " + request.responseText);
        else
        {
            //Update points number
            let parentNode = button.parentNode;
            let n_points = parentNode.children[1];
            let updated_points = document.createTextNode(parseInt(n_points.firstChild.nodeValue) + 1);
            n_points.replaceChild(updated_points, n_points.firstChild);

            //Replace Symbol

            //Executes Second Instruction
            if(upvote)
                upvote_story(button);
        }
    }

    //Mudar para user
    let linktoexecute = "../database/votes/remove_story_vote.php?client=" + "Des_locado" + "&story_id=" 
        + button.parentNode.id + "&vote=" + "-1"; 
    request.open("GET", linktoexecute, true);
    request.send();
}


    