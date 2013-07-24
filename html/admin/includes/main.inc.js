function confirmUserDelete() {

        var agree = confirm("Are you sure you wish to delete this user account?");
        if (agree)
                return true;
        else
                return false;
}

function confirmChangeGroup() {
        var agree = confirm("Are you sure you wish to change the group memeber for this user account?");
        if (agree)
                return true;
        else
                return false;

}

function confirmRemove() {

        var agree = confirm("Are you sure you wish to remove this podcast?");
        if (agree)
                return true;
        else
                return false;
}

function confirmApprove() {
        var agree = confirm("Are you sure you wish to approve this podcast?");
        if (agree)
                return true;
        else
                return false;

}

function confirmUnapprove() {
        var agree = confirm("Are you sure you wish to unapprove this podcast?");
        if (agree)
                return true;
        else
                return false;

}

function enableHeadCategories() {
        if (document.addCategoryForm.subCategory.checked == true) {
                document.addCategoryForm.headCategory.disabled = false;
        }
        else {
                document.addCategoryForm.headCategory.disabled = true;
        }

}

function enablePodcastUpload() {
	if (document.addPodcastForm.upload_file.checked == true) {
		document.addPodcastForm.file.disabled = false;
	}
	else {
		document.addPodcastForm.file.disabled = true;
	}
}

function enableUserForm() {
	if (document.addUserForm.admin.checked == false) {
                document.addUserForm.school_class.disabled = false;
                document.addUserForm.section.disabled = false;
                document.addUserForm.ta.disabled = false;
	} else if (document.addUserForm.admin.checked == true) {
                document.addUserForm.school_class.disabled = true;
                document.addUserForm.section.disabled = true;
                document.addUserForm.ta.disabled = true;
        }

}

