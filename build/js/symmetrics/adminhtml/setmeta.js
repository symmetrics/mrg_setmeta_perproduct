/*
 * @category Symmetrics
 * @package Symmetrics_SetMeta
 * @author symmetrics gmbh <info@symmetrics.de>, Eric Reiche <er@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

var requestDone = false;

/*
 * Takes JSON data as parameter and make a
 * comma seperated list (csl) of this values
 * by iterating the array entries (categories in this case).
 * Appends this CSL to the product name and write it
 * to the meta information fields, if they are empty.
 */
function setMetaByProduct(catJson, whichOne, param) {
	productName = $('name');
	cats = eval('(' + catJson + ')');
	var categories = '';
	for(key in cats) {
	    if(cats.hasOwnProperty(key)){
	    	categories += ',' + cats[key];
	    }
	}
	
	tmp_field = document.getElementById('meta_title');
	if(tmp_field.value == '') {
		tmp_field.value = productName.value;
	}
	
	tmp_field = document.getElementById('meta_keyword');
	if(tmp_field.innerHTML == '') {
		tmp_field.innerHTML = productName.value + categories;
	}
	
	tmp_field = document.getElementById('meta_description');
	if(tmp_field.innerHTML == '') {
		tmp_field.innerHTML = productName.value + categories;
	}
	if(whichOne == 1) {
		productForm.submit();
	}
	else {
		saveAndContinueEdit(param);
	}
}

/*
 * This function is called when the save button is clicked.
 * It fires an ajax request to get the categories for the product in JSON format. 
 * When the request completes, it calls setMetaByProduct()
 */
function getCategories(basepath, prod_id, whichOne, param) {
	if(document.getElementById('meta_keyword').innerHTML == '' || document.getElementById('meta_description').innerHTML == '' ) {
		var url = basepath + '/admin/setmeta/index/id/' + prod_id;
		var response;
		new Ajax.Request(url, {
			method: 'get',
			asynchronous: false,
			onSuccess: function(nom,json){
				setMetaByProduct(nom.responseText, whichOne, param)
			},
		});
	}
}