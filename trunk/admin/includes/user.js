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
