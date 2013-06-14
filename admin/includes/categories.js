function enableHeadCategories() {
	if (document.addCategoryForm.subCategory.checked == true) {
		document.addCategoryForm.headCategory.disabled = false;
	}
	else {
		document.addCategoryForm.headCategory.disabled = true;
	}	

}
