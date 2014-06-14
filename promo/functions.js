//--Employee block--

function employee_block (section){
	if(document.getElementById('eb_title_'+section).className=="css_ep_title css_active"){
		document.getElementById('eb_title_'+section).className="css_ep_title";
		document.getElementById('eb_block_'+section).className="css_ep_block";
	}

	else {
		document.getElementById('eb_title_'+section).className="css_ep_title css_active";
		document.getElementById('eb_block_'+section).className="css_ep_block css_active";
	}
}