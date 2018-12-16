function validateInput(string) 
{
    return string.match(/[&<>"'\/]/g);
}

function validate_profile_settings()
{
    let avatar = document.querySelector(".group:nth-child(1) > input:nth-child(2)").value;

    if(avatar && !avatar.match(/\.(jpeg|jpg|gif|png)$/))
    {
        alert("Link provided does not link to an image");
        return false;
    }

    let pw = document.querySelector(".group:nth-child(2) > input:nth-child(1)").value;

    if(validateInput(pw))
    {
        alert('Invalid Password');
        return false;
    }

    let email = document.querySelector(".group:nth-child(3) > input:nth-child(1)").value;

    if(validateInput(email))
    {
        alert('Invalid Email');
        return false;
    }
    
    let description = document.querySelector(".group:nth-child(4) > input:nth-child(1)").value;

    if(validateInput(description))
    {
        alert('Invalid Description')
        return false;
    }
    
    return true;
}