function setMetaByProduct(catJson) {
    productName = $("name");
    cats = eval("(" + catJson + ")");
    var categories = "";
    for(key in cats) {
        if(cats.hasOwnProperty(key) && cats[key] != '' && cats[key] != null){
            categories += "," + cats[key];
        }
    }
    
    
    tmp_field = document.getElementById('meta_title');
    if (tmp_field.value == "") {
        tmp_field.value = productName.value;
    }
    
    tmp_field = document.getElementById('meta_keyword');
    if (tmp_field.innerHTML == "") {
        tmp_field.innerHTML = productName.value + categories;
    }
    
    tmp_field = document.getElementById('meta_description');
    if (tmp_field.innerHTML == "") {
        tmp_field.innerHTML = productName.value + categories;
    }
    return true;
}

function getCategories(basedir, prod_id) {
    if(document.getElementById('meta_keyword').innerHTML == "" || document.getElementById('meta_description').innerHTML == "" ) {
        var url = basedir + "/admin/setmeta/index/id/" + prod_id;
        var response;
        new Ajax.Request(url, {
            method: 'get',
            asynchronous: false,
            onSuccess: function(nom,json){
                setMetaByProduct(nom.responseText,json)
            },
        });
    }
    return true;
}
