* DOCUMENTATION

** INSTALLATION
Extract content of this archive to your Magento directory.
It might be necessary to clear/refresh the Magento cache. ATTENTION:
The 'generate_meta' attribute must be added to the/a attribute set.
Besides, it must be manually transferred in the attribute management.

** USAGE
This module fills the meta-data of a product automatically with the
product name and categories. This functionality is enabled through
the creation of the new attribute (yes/no dropdowns). I.e. when the
user sets this dropdown on "yes", the metadata of the product are 
automatically read from the product names and category names. Besides,
if the multistore-environment is taken into consideration, different
"storeviews" can have different values. There is also a support for 
mass editing.

** FUNCTIONALITY
*** A: Adds "Generate Meta Data"  product attribute.
*** B: 	When this dropdown is set on "yes" the observer takes effect and
	fills the meta title with the product name, descripton and keywords
	with comma separated list of product names and category names. 
*** C: 	Also when this dropdown is set on "yes" upon the mass editing,
	the meta data are filled in.
*** D: Also the multistore environments are taken into consideration. The 
	category and product names are then entered according to the stove view.

** TECHNICAL
Via migrations script a 'generate_meta' product attribute is added.
This is a yes/no dropdown. 'catalog_product_save_after' event is
caught, which is initiated upon a simple product saving.
Here it is checked if the product attribute 'generate_meta' is
set on "yes". If it does this, the metafields are filled
respectively. For mass actions 
'controller_action_postdispatch_adminhtml_catalog_product_action_attribute_save'
event is caught. The product IDs are then taken from session and the
check is made if 'generate_meta' dropdown is set on "yes". Then for each
ID the product model is loaded and the values are filled and saved.

** PROBLEMS
For the time being, no problems are known.

* TESTCASES

** BASIC
*** A:  1. Check if 'generate_meta' attribute appears in the 
	   attribute management.
        2. Check if 'generate_meta' attribute created by the migrations
	   script is available in the attribute set. It should then appear
	   when one edits the product.
*** B: 	1. 	(1) Create a new product in backend via Catalog->Add Product
			(2) Specify at least the necessary attributes and a category.
			(3) The "Generate Meta Data" field (dropdown) should be set on "yes".
			(4) Select "Save & Continue Edit".
			(5) The meta-fields should now be filled with the category and name  
            information.
			(6) Change the product names and/or categories and set the dropdown 
			on "Yes" again.
			(7) The meta data should be updated respectively.
		2. 	(1) Repeat steps 1-5 in B.1, but in step 3 select "no".
			(2) Edit the last created product and set the dropdown on "yes".
			(3) After saving the meta data should be filled.
*** C:  1. 	(1) Repeat steps 1-5 in test case B several times, but select "no", 
             in step 3.
			(2) Make a mass-editing of products and set the dropdown
			on "yes". Click "save". 
			(3) Check the products separately, now they all should
            have appropriate meta data.
*** D:  1. Repeat the test case B but select a "Storeveiw". I.e.:
			(1) Go in backend to "Manage products".
			(2) Create a new product. When doing so, specify at least the 
			necessary attributes, web site and a category. Select
			"Save & Continue Edit".
			(3) Change the "Storeview" to "English".
			(4) Change the the product name and set the dropdown on
			"yes" again.
			(5) Select "Save & Continue Edit".
			(6) Check if the meta data were updated respectively.
			(7) Change the "StoreView" to "Default values". Check 
            if meta data have the default values again.
        2. Repeat the test case C with the "StoreView" selection,
			similary as in item D. 1. I.e.:
			(1) Repeat steps 1-5 in test case B several times, but in 
			step 3 select "no".
			(2) Change the "StoreView" to "English" and change names of a 
			couple of products in the editing.
			(3) Make a mass editing of the products in "StoreView"
			"English" and set the dropdown on "yes". Click "Save".
			(4) Check the products separately, they all now should 
			have the appropriate meta data. I.e. the values must be read and 
			saved with correct "StoreView" ("English").
    
** STRESS
*** A:  No meaningful test case is known
*** B:  No meaningful test case is known
*** C:  No meaningful test case is known
*** D:  Upon "Mass action" the products must all be loaded
        separately. This can negatively affect the performance. When 
		the dropdown "Generate Meta Data" is not set on "yes",
		the products are not loaded separtely.
