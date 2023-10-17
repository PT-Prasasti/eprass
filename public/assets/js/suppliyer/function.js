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

function toRupiah(str)
{
    if (typeof str !== "string") {        
        str = String(str);
    }
    str = str.replace(/\./g, "");
    str = str.replace(/(\d)(?=(\d{3})+$)/g, "$1.");
    return str;
}

function parseNumberWithCommas(valueWithCommas) {
    // Remove commas from the input string
    valueWithCommas = String(valueWithCommas);
    var valueWithoutCommas = valueWithCommas.replace(/,/g, '');

    // Attempt to parse the modified string as a number
    var parsedValue = parseFloat(valueWithoutCommas);

    // Check if the parsing was successful
    if (!isNaN(parsedValue)) {
        return parsedValue;
    } else {
        // Return an error message or value when parsing fails
        return "Unable to parse the value.";
    }
}

function formatRupiah(number) {
    // Check if the input is a valid number
    console.log("le number", number);
    number  = number.replace("Rp ", "");
    number = number.replace(/\./g, "");
    console.log("le number replace", number);
    if (isNaN(number)) {
        return 0;
    }

    // Format the number as Rupiah
    const formatted = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(number);

    return formatted;
}

  

function numericonly(e)
{
    var key = e.which || e.keyCode
    if (key < 48 || key > 57) {
      e.preventDefault();
      return false;
    }
}