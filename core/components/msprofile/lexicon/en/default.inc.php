<?php

include_once 'setting.inc.php';

$_lang['msprofile'] = 'Profiles buyers';
$_lang['msprofile_intro_msg'] = 'Please note that a customer profile is created the first time the transactions of purchase or Deposit. If the user only has registered and has done nothing - his profile will not be here.';

$_lang['msprofile_btn_update'] = 'Edit';
$_lang['msprofile_btn_remove'] = 'Delete';

$_lang['ms2_profile_customer'] = 'Customer';
$_lang['ms2_profile_fullname'] = 'Customer';
$_lang['ms2_profile_referrer_fullname'] = 'Referrer';
$_lang['ms2_profile_referrer_id'] = 'ID referrer';
$_lang['ms2_profile_referrer_code'] = 'Referral code';
$_lang['ms2_profile_account'] = 'Balance sheet';
$_lang['ms2_profile_spent'] = 'Spent';
$_lang['ms2_profile_createdon'] = 'creation date';

$_lang['ms2_profile_operations'] = 'Operations';
$_lang['ms2_profile_referrals'] = 'Referrals';

$_lang['ms2_profile_operation_payment'] = 'Payment';
$_lang['ms2_profile_operation_sum'] = 'Amount';
$_lang['ms2_profile_operation_status'] = 'Status';
$_lang['ms2_profile_operation_createdon'] = 'Created';
$_lang['ms2_profile_operation_updatedon'] = 'updated';
$_lang['ms2_profile_operation_new'] = 'Add operation to the amount';

$_lang['ms2_profile_enter_sum'] = 'Enter the amount';
$_lang['ms2_profile_select_payment'] = 'Select payment method';
$_lang['ms2_profile_pay'] = 'to Pay';
$_lang['ms2_profile_charge'] = 'Replenishment';


$_lang['ms2_profile_err_operation_user_id'] = 'You have not specified the id of the buyer';
$_lang['ms2_profile_err_operation_sum'] = 'you Must specify the transaction amount';
$_lang['ms2_profile_err_auth'] = 'You must be logged in to recharge';
$_lang['ms2_profile_err_payments'] = 'there are No available methods Deposit';
$_lang['ms2_profile_err_min_sum'] = 'Amount should be not less than [[+min_sum]]';
$_lang['ms2_profile_err_max_sum'] = 'the Amount should be no more than [[+max_sum]]';
$_lang['ms2_profile_err_payment'] = 'You did not choose your preferred Deposit method';
$_lang['ms2_profile_err_form'] = 'Please correct the errors in the form';
$_lang['ms2_profile_err_balance'] = 'Insufficient funds';
$_lang['ms2_profile_err_user'] = 'cannot get the user profile';