 /**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Symmetrics
 * @package   Symmetrics_SetMeta
 * @author    Symmetrics GmbH <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @copyright 2010 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

function setMetaByProduct(catJson) {
    productName = $("name");
    cats = eval("(" + catJson + ")");
    var categories = "";
    for(key in cats) {
        if(cats.hasOwnProperty(key) && cats[key] != '' && cats[key] != null){
            categories += "," + cats[key];
        }
    }
    
    
    tmp_field = $('meta_title');
    if (tmp_field.value == "") {
        tmp_field.value = productName.value;
    }
    
    tmp_field = $('meta_keyword');
    if (tmp_field.innerHTML == "") {
        tmp_field.innerHTML = productName.value + categories;
    }
    
    tmp_field = $('meta_description');
    if (tmp_field.innerHTML == "") {
        tmp_field.innerHTML = productName.value + categories;
    }
    return true;
}

function getCategories(prod_id) {
    if($('meta_keyword').innerHTML == "" || $('meta_description').innerHTML == "" ) {
        var url = BASE_URL + "setmeta/index/id/" + prod_id;
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