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

