<?php

include_once 'setting.inc.php';

$_lang['msprofile'] = 'Профили покупателей';
$_lang['msprofile_intro_msg'] = 'Обратите внимание, что профиль покупателя создаётся при первой операции покупки или пополнение счета. Если пользователь только зарегистрировался и еще ничего не сделал - его профиля здесь не будет.';

$_lang['msprofile_btn_update'] = 'Изменить';
$_lang['msprofile_btn_remove'] = 'Удалить';

$_lang['ms2_profile_customer'] = 'Покупатель';
$_lang['ms2_profile_fullname'] = 'Покупатель';
$_lang['ms2_profile_referrer_fullname'] = 'Реферер';
$_lang['ms2_profile_referrer_id'] = 'ID реферера';
$_lang['ms2_profile_referrer_code'] = 'Реферальный код';
$_lang['ms2_profile_account'] = 'Баланс';
$_lang['ms2_profile_spent'] = 'Потрачено';
$_lang['ms2_profile_createdon'] = 'Дата создания';

$_lang['ms2_profile_operations'] = 'Операции';
$_lang['ms2_profile_referrals'] = 'Рефералы';

$_lang['ms2_profile_operation_payment'] = 'Оплата';
$_lang['ms2_profile_operation_sum'] = 'Сумма';
$_lang['ms2_profile_operation_status'] = 'Статус';
$_lang['ms2_profile_operation_createdon'] = 'Создано';
$_lang['ms2_profile_operation_updatedon'] = 'Обновлено';
$_lang['ms2_profile_operation_new'] = 'Добавить операцию на сумму';

$_lang['ms2_profile_enter_sum'] = 'Укажите сумму';
$_lang['ms2_profile_select_payment'] = 'Выберите метод оплаты';
$_lang['ms2_profile_pay'] = 'Оплатить';
$_lang['ms2_profile_charge'] = 'Пополнение счета';


$_lang['ms2_profile_err_operation_user_id'] = 'Вы не указали id покупателя';
$_lang['ms2_profile_err_operation_sum'] = 'Нужно указать сумму операции';
$_lang['ms2_profile_err_auth'] = 'Вы должны быть авторизованы для пополнения баланса';
$_lang['ms2_profile_err_payments'] = 'Нет доступных методов пополнения счета';
$_lang['ms2_profile_err_min_sum'] = 'Сумма должна быть не меньше [[+min_sum]]';
$_lang['ms2_profile_err_max_sum'] = 'Сумма должна быть не больше [[+max_sum]]';
$_lang['ms2_profile_err_payment'] = 'Вы не выбрали метод пополнения счета';
$_lang['ms2_profile_err_form'] = 'Пожалуйста, исправьте ошибки в форме';
$_lang['ms2_profile_err_balance'] = 'Недостаточно средств на счете';
$_lang['ms2_profile_err_user'] = 'Не могу получить профиль пользователя';