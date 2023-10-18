function localset(key, val)
{
    json = JSON.stringify(val);
    console.log("local set " + key + " : ", val);
    window.localStorage.setItem(key, json);
}

function localget(key)
{
    obj = window.localStorage.getItem(key);
    json = JSON.parse(obj);
    console.log("local get " + key + " : ", json);
    return json;
}

function randomstring(length = 6) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let randomString = '';

    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        randomString += characters.charAt(randomIndex);
    }

    return randomString;
}