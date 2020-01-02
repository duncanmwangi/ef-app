<?php
use App\User;
function USstatesSelect($name='state',$selected_state="",$css_class="",$includeEmptyOption=true){
	$states = [
		'AL'=>"Alabama",  
		'AK'=>"Alaska",  
		'AZ'=>"Arizona",  
		'AR'=>"Arkansas",  
		'CA'=>"California",  
		'CO'=>"Colorado",  
		'CT'=>"Connecticut",  
		'DE'=>"Delaware",  
		'DC'=>"District Of Columbia",  
		'FL'=>"Florida",  
		'GA'=>"Georgia",  
		'HI'=>"Hawaii",  
		'ID'=>"Idaho",  
		'IL'=>"Illinois",  
		'IN'=>"Indiana",  
		'IA'=>"Iowa",  
		'KS'=>"Kansas",  
		'KY'=>"Kentucky",  
		'LA'=>"Louisiana",  
		'ME'=>"Maine",  
		'MD'=>"Maryland",  
		'MA'=>"Massachusetts",  
		'MI'=>"Michigan",  
		'MN'=>"Minnesota",  
		'MS'=>"Mississippi",  
		'MO'=>"Missouri",  
		'MT'=>"Montana",
		'NE'=>"Nebraska",
		'NV'=>"Nevada",
		'NH'=>"New Hampshire",
		'NJ'=>"New Jersey",
		'NM'=>"New Mexico",
		'NY'=>"New York",
		'NC'=>"North Carolina",
		'ND'=>"North Dakota",
		'OH'=>"Ohio",  
		'OK'=>"Oklahoma",  
		'OR'=>"Oregon",  
		'PA'=>"Pennsylvania",  
		'RI'=>"Rhode Island",  
		'SC'=>"South Carolina",  
		'SD'=>"South Dakota",
		'TN'=>"Tennessee",  
		'TX'=>"Texas",  
		'UT'=>"Utah",  
		'VT'=>"Vermont",  
		'VA'=>"Virginia",  
		'WA'=>"Washington",  
		'WV'=>"West Virginia",  
		'WI'=>"Wisconsin",  
		'WY'=>"Wyoming"
	];

	$html = '<select name="'.$name.'" class="'.$css_class.'">';
	
	if($includeEmptyOption) $html.='<option value="">Select State</option>';

	foreach ($states as $key => $value) {
		$selected = $key==$selected_state?'selected="selected"':'';
		$html.='<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
	}
	$html.='</select>';
	return $html;

}


function get_fundmanagers($regionalFundManagerID=0){
	$rfm = User::find($regionalFundManagerID);
	if(!$rfm) return false;
	return $rfm->fundManagers;
}

function editButton($link="#",$text="Edit",$buttonClasses="",$iconClasses = "lnr-pencil")
{
	return '<a href="'.$link.'"><button class="btn-icon btn btn-primary btn-xs mx-0 my-0 '.$buttonClasses.'"><i class="btn-icon-wrapper '.$iconClasses.'"> </i>'.$text.'</button></a>';
}

function deleteButton($link="#",$text="Delete",$buttonClasses="",$iconClasses = "lnr-trash")
{
	return '<form class="delete-form" method="POST" action="'.$link.'"> '.csrf_field().method_field('DELETE').'<button type="submit" class="btn-icon btn btn-danger btn-xs mx-0 my-0 '.$buttonClasses.'"><i class="btn-icon-wrapper '.$iconClasses.'"> </i>'.$text.'</button> </form>';
}

function formatDate($d,$format = 'm - d -Y'){
	return $d->format($format);
}

function formatDateTime($d,$format = 'm - d -Y h:i:s A'){
	return $d->format($format);
}

function moneyFormat($amount=0){
	return number_format($amount,2);
}

// function currentDate(){
// 	formatDate(now());
// }
// function now(){
// 	return formatDateTime(Carbon::now());
// }