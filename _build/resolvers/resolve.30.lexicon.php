<?php
/**
 * Resolve overwriting chunks
 *
 * @var xPDOObject $object
 * @var array $options
 */

if ($object->xpdo) {
	/* @var modX $modx */
	$modx =& $object->xpdo;

	$entries = array(
		'ru' => array(
			//'ms2_orders' => 'Заказы и профили',
			'ms2_orders_desc' => 'Управление заказами и профили пользователей',
		),
		'en' => array(
			//'ms2_orders' => 'Orders and profiles',
			'ms2_orders_desc' => 'Order management and user profiles',
		),
		'de' => array(
			//'ms2_orders' => 'Bestellungen und profile',
			//'ms2_orders_desc' => 'Order-management-und Benutzer-profile',
		),
		'fr' => array(
			//'ms2_orders' => 'Les commandes et les profils',
			'ms2_orders_desc' => 'La gestion des commandes et des profils d\'utilisateur',
		),
		'lt' => array(
			//'ms2_orders' => 'Pasūtījumi un profili',
			'ms2_orders_desc' => 'Lai vadības un lietotāju profilus',
		),
	);

	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:
			foreach ($entries as $lang => $values) {
				foreach ($values as $key => $value) {
					if (!$modx->getCount('modLexiconEntry', array('name' => $key, 'language' => $lang))) {
						$tmp = $modx->newObject('modLexiconEntry', array(
							'name' => $key,
							'topic' => 'default',
							'namespace' => 'minishop2',
							'language' => $lang,
							'value' => $value
						));
						$tmp->save();
					}
				}
			}
			break;

		case xPDOTransport::ACTION_UNINSTALL:
			foreach ($entries as $lang => $values) {
				foreach ($values as $key => $value) {
					if ($tmp = $modx->getObject('modLexiconEntry', array('name' => $key, 'language' => $lang, 'value' => $value))) {
						$tmp->remove();
					}
				}
			}
			break;
	}
}
return true;