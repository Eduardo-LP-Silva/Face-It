function validateInput(string) 
{
    return string.match(/[&<>"'\/]/g);
}

function validate_channel()
{
    let channel_name = document.querySelector("#channel_name").value;
    let channel_description = document.querySelector("#channel_description").value;

    if(validateInput(channel_name) != null || validateInput(channel_description) != null)
    {
        alert('Invalid Input');
        return false;
    }
    

    return true;
}

function get_new_channel_name()
{
    return document.querySelector("#channel_name").value;
}