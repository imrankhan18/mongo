console.log("hyy");
var options = document.getElementById("field");
function addField()
{
    console.log("hello");
    // var field = `<input type="date" >`;
    // document.getElementById("#field").innerHTML=field;
    var div = document.createElement("div");
    div.setAttribute("id", "options");
    var newField = document.createElement("input");
    newField.setAttribute("type", "date");
    newField.setAttribute("name", "fields");
    newField.setAttribute("class", "fields");
    newField.setAttribute("placeholder", "from date");
    div.appendChild(newField);
    var newField2 = document.createElement("input");
    newField2.setAttribute("type", "date");
    newField2.setAttribute("name", "value");
    newField2.setAttribute("class", "value");
    newField2.setAttribute("placeholder", "to date");
    div.appendChild(newField2);
    options.appendChild(div);
}