document.addEventListener('DOMContentLoaded', (event) => {
    console.log('DOM fully loaded and parsed');
    var locations = document.getElementById("endPos");
    locations.addEventListener("change", function() {
        if(locations.value == "other")
        {
            document.getElementById("otherAddress").style.display="flex";
            document.getElementById("street_number").required = true;
            document.getElementById("street_name").required = true;
            document.getElementById("city").required = true;
            document.getElementById("province").required = true;
        }
        else{
             document.getElementById("otherAddress").style.display="none";
             document.getElementById("street_number").required = false;
            document.getElementById("street_name").required = false;
            document.getElementById("city").required = false;
            document.getElementById("province").required = false;
        }
    });
});