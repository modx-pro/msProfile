<?php

$properties = array();

$tmp = array(
	'tplForm' => array(
		'type' => 'textfield',
		'value' => 'tpl.msProfile.charge.form',
	),
	'tplPayment' => array(
		'type' => 'textfield',
		'value' => 'tpl.msProfile.charge.payment',
	),
	'tplOrder' => array(
		'type' => 'textfield',
		'value' => 'tpl.msOrder.success',
	),
	'payments' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'sortby' => array(
		'type' => 'textfield',
		'value' => 'order',
	),
	'sortdir' => array(
		'type' => 'list',
		'options' => array(
			array('text' => 'ASC', 'value' => 'ASC'),
			array('text' => 'DESC', 'value' => 'DESC'),
		),
		'value' => 'ASC'
	),
	'limit' => array(
		'type' => 'numberfield',
		'value' => 0,
	),
	'outputSeparator' => array(
		'type' => 'textfield',
		'value' => "\n",
	),
	'minSum' => array(
		'type' => 'numberfield',
		'value' => 200,
	),
	'maxSum' => array(
		'type' => 'numberfield',
		'value' => 0,
	),
	'showInactive' => array(
		'type' => 'combo-boolean',
		'value' => true,
	)
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;