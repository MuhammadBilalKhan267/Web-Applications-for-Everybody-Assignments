
function addpos() {
    
    if (rank > 9){
        alert("Max number of positions (9) reached!");
        return;
    }
    var content = `
        <div id="position`+rank+`">
            <p>Year: <input type="text" name="year`+rank+`" value="">
            <input type="button" value="-" onclick="$('#position`+rank+`').remove();return false;"></p>
            <textarea name="desc`+rank+`" rows="8" cols="80"></textarea>
        </div>
    `;

    $('#positions').append(content);
    rank++;
}
function addedu() {
    
    if (rank_edu > 9){
        alert("Max number of fields (9) reached!");
        return;
    }
    var content = `
        <div id="education`+rank_edu+`">
            <p>Year: <input type="text" name="edu_year`+rank_edu+`" value="">
            <input type="button" value="-" onclick="$('#education`+rank_edu+`').remove();return false;"></p>
            <p>School: <input type="text" size="80" name="edu_school`+rank_edu+`" class="school" value=""></p>
        </div>
    `;

    $('#education').append(content);
    rank_edu++;
    

}