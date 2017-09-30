/**
 * Created by Nick on 9/30/17.
 */
function getCharacters(id){
    var link = "groups/getCharacters.php?group_id=" + encodeURIComponent(id);
    $.getJSON(link, function(data){
        if(data.results == 0){
            window.location = "error.php?message=" + encodeURIComponent(data.error);
        }
        var html = "";
        for(var i = 0; i < data.results.length; i++){
            html = html + "<option value='"+data.results[i].id+"_"+data.results[i].character_id
                +"'>"+ data.results[i].character+" (" +data.results[i].tag +")</option>";
        }
        document.getElementById('winner').innerHTML = html;
        document.getElementById('loser').innerHTML = html;
    });
}

