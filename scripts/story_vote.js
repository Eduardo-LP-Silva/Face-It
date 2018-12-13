let voteBts = document.querySelectorAll('.story > img:nth-child(1), .story > img:nth-child(3)');

for(let i = 0; i < voteBts.length; i++)
{
    voteBts[i].addEventListener('click', function(event)
    {
        let user_likes = getNewXMLHttpRequest();

        user_likes.onload = function()
        {
            let results = JSON.parse(this.responseText);
            let aditionalInstruction = 0;

            if (results.length != 0) //Already Voted
            {
                if(results[0]['points'] == 1)
                {
                    //Downvote
                    if(voteBts[i].nextElementSibling.nodeName != "P")
                        aditionalInstruction = -1;

                    remove_story_vote(voteBts[i], 1, aditionalInstruction);
                }
                else
                {
                    if(voteBts[i].nextElementSibling.nodeName == "P")
                        aditionalInstruction = 1;

                    remove_story_vote(voteBts[i], -1, aditionalInstruction);
                    
                }
            }
            else 
            {
                //Downvote
                if(voteBts[i].nextElementSibling.nodeName != "P")
                    vote_story(voteBts[i], -1);
                else
                    vote_story(voteBts[i], 1);
            }
        }
        
        let linktoexecute = "../database/votes/get_personal_story_votes.php?story=" + this.parentNode.id; 
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

function vote_story(button, votes, substitue_items = true)
{
    let request = getNewXMLHttpRequest();

    request.onload = function()
    {
        if(request.responseText != 0)
            console.log("Error in voting story - " + request.responseText);
        else
        {
            if(substitue_items)
                replace_vote_number(button, votes);

            replace_vote_symbol(button, votes);    
        }
    }

    let linktoexecute = "../database/votes/vote_story.php?story_id=" + button.parentNode.id 
        + "&vote=" + votes; 
    request.open("GET", linktoexecute, true);
    request.send();
}

function remove_story_vote(button, vote, extra_vote)
{
    let request = getNewXMLHttpRequest();

    request.onload = function()
    {
        if(request.responseText != 0)
            console.log("Error in removing upvote from story - " + request.responseText);
        else
        {
            //Execute Second Instruction
            if(extra_vote != 0)
            {
                vote_story(button, extra_vote, false);
                replace_vote_number(button, -vote + extra_vote);
            }
            else
                replace_vote_number(button, -vote);

            replace_vote_symbol(button, vote, true);
        }
    }

    let linktoexecute = "../database/votes/remove_story_vote.php?story_id=" + button.parentNode.id + "&vote=" + vote; 
    request.open("GET", linktoexecute, true);
    request.send();
}

function replace_vote_number(button, vote_to_add)
{
    let parentNode = button.parentNode;
    let n_points = parentNode.children[1];
    let updated_points = document.createTextNode(parseInt(n_points.firstChild.nodeValue) + vote_to_add);
    n_points.replaceChild(updated_points, n_points.firstChild);
}

function replace_vote_symbol(button, votes, remove = false)
{
    let parentNode = button.parentNode;
    let upvotePath, downvotePath;

    if(remove)
    {
        upvotePath = "../assets/like.png";
        downvotePath = "../assets/dislike.png";
    }
    else
    {
        upvotePath = "../assets/like_pressed.png";
        downvotePath = "../assets/dislike_pressed.png";
    }

    if(votes > 0)
        parentNode.children[0].setAttribute("src", upvotePath)
    else
        parentNode.children[2].setAttribute("src", downvotePath)
}


    