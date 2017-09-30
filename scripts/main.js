/**
 * Created by Nick on 9/30/17.
 */
function validString(name, type){
    $(document).ready(function(){
        if(name == ""){
            document.getElementById('error').innerHTML = "<div class='panel panel-danger'>" +
                "<div class='panel-heading'>Error:</div><div class='panel-body'>" +
                "You must input a username</div></div>";
        } else {
            var hasBadChar = false;
            for (var i = 0; i < name.length; i++) {
                hasBadChar = hasBadChar || (name.charAt(i) == " ");
                hasBadChar = hasBadChar || ((name.charAt(i).toUpperCase() === name.charAt(i)) && (isAlphabetic(name.charAt(i))));
            }
            if (hasBadChar) {
                document.getElementById('error').innerHTML = "<div class='panel panel-danger'>" +
                    "<div class='panel-heading'>Error:</div><div class='panel-body'>" +
                    "Usernames must have no capitals or spaces</div></div>";
            } else {
                document.getElementById('type').value = type;
                document.getElementById('tagForm').submit();
            }
        }
    });
}
function isAlphabetic(char){
    return char == "a" ||
        char == "b" ||
        char == "c" ||
        char == "d" ||
        char == "e" ||
        char == "f" ||
        char == "g" ||
        char == "h" ||
        char == "i" ||
        char == "j" ||
        char == "k" ||
        char == "l" ||
        char == "m" ||
        char == "n" ||
        char == "o" ||
        char == "p" ||
        char == "q" ||
        char == "r" ||
        char == "s" ||
        char == "t" ||
        char == "u" ||
        char == "v" ||
        char == "w" ||
        char == "x" ||
        char == "y" ||
        char == "z";
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}