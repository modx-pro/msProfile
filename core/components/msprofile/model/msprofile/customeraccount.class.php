<?php

if (!class_exists('msPaymentInterface')) {
    require_once MODX_CORE_PATH . 'components/minishop2/model/minishop2/mspaymenthandler.class.php';
}

class CustomerAccount extends msPaymentHandler implements msPaymentInterface
{
    public $config;


    /**
     * @param msOrder $order
     *
     * @return bool
     */
    public function check(msOrder $order)
    {
        if ($user = $order->getOne('CustomerProfile')) {
            return $user->get('account') - $order->get('cost') >= 0;
        }

        return false;
    }


    /**
     * @param msOrder $order
     *
     * @return array|string
     */
    public function send(msOrder $order)
    {
        if ($order->get('status') > 1) {
            return $this->error('ms2_err_status_wrong');
        }
        if ($user = $order->getOne('CustomerProfile')) {
            if ($user->get('account') - $order->get('cost') >= 0) {
                $this->receive($order);

                return $this->success('', array('msorder' => $order->get('id')));
            }
        }

        return $this->error('ms2_profile_err_user');
    }


    /**
     * @param msOrder $order
     *
     * @return string
     */
    public function getPaymentLink(msOrder $order)
    {
        return '';
    }


    /**
     * @param msOrder $order
     * @param array $params
     *
     * @return bool
     */
    public function receive(msOrder $order, $params = array())
    {
        if ($user = $order->getOne('CustomerProfile')) {
            $user->set('account', $user->get('account') - $order->get('cost'));
            if ($user->save()) {
                $order->set('type', 1);
                $order->save();
                /** @var miniShop2 $miniShop2 */
                $miniShop2 = $this->modx->getService('miniShop2');
                $miniShop2->changeOrderStatus($order->get('id'), 2);

                return true;
            }
        }

        return false;
    }

}