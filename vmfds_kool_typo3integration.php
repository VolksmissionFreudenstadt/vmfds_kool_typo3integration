<?php

// HOOK: extend group form

function my_form_vmfds_kool_typo3integration_ko_groups($data, $mode, $id, $additional_data) {
	if ($mode=='edit') {
		$group = db_select_data('ko_groups','WHERE id='.$id,'*','','',TRUE);
	}
	$group['vmfds_kool_typo3integration_usergroup'] ? $group['vmfds_kool_typo3integration_usergroup'] : '_'; 
	
	$section = array(
		'titel' => 'typo3 Integration',
		'state' => 'closed',
		'colspan' => 2,
	);
	
	$section['row'] = array(
		0 => array(
			'inputs' => array(
				0 => array(
					'desc' => 'Zugeh&ouml;rige Benutzergruppe in typo3:',
					'type' => 'select',
					'name' => 'sel_typo3_usergroup',
					'params' => array('size' => 7),
					'values' => array('_'),
					'descs' => array(''),
					'value' => $group['vmfds_kool_typo3integration_usergroup'],
				), 
			),
		)
	);
	
	
	
	// get categories select:
	$cats = db_select_data('usrdb_vmfredbb_t6.fe_groups','','*','','',FALSE,TRUE);
	foreach ($cats as $cat) {
		$section['row'][0]['inputs'][0]['values'][] = $cat['uid'];
		$section['row'][0]['inputs'][0]['descs'][] = $cat['title'];
	}
		
	$data[] = $section;
}

// HOOK: save new group

function my_action_handler_add_vmfds_kool_typo3integration_submit_new_group() {
	$typo3 = format_userinput($_POST['sel_typo3_usergroup'], 'intlist');
	if ($typo3=='_') $typo3=''; 
	db_update_data('ko_groups',
				   'WHERE id='.sprintf('%06d',$GLOBALS['new_id']), 
				   array(
				   		'vmfds_kool_typo3integration_usergroup' => $typo3,
				   ));
}

// HOOK: save edited group

function my_action_handler_add_vmfds_kool_typo3integration_submit_edit_group() {
	$typo3 = format_userinput($_POST['sel_typo3_usergroup'], 'intlist');
	if ($typo3=='_') $typo3=''; 
	$id = format_userinput($_POST['id'], 'uint');
	db_update_data('ko_groups',
				   'WHERE id='.sprintf('%06d',$id), 
				   array(
				   		'vmfds_kool_typo3integration_usergroup' => $typo3,
				   ));
}
