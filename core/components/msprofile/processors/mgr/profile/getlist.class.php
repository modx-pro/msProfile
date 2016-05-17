<?php

class msCustomerProfileGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'msCustomerProfile';
    public $classKey = 'msCustomerProfile';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    public $languageTopics = array('minishop2:manager');


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->groupby($this->classKey . '.id');
        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));

        $c->innerJoin('modUser', 'User', $this->classKey . '.id = User.id');
        $c->select('User.username');
        $c->innerJoin('modUserProfile', 'UserProfile', $this->classKey . '.id = UserProfile.internalKey');
        $c->select('UserProfile.fullname');
        $c->leftJoin('modUser', 'Referrer', $this->classKey . '.referrer_id = Referrer.id');
        $c->select('Referrer.username as referrer_username');
        $c->leftJoin('modUserProfile', 'ReferrerProfile',
            $this->classKey . '.referrer_id = ReferrerProfile.internalKey'
        );
        $c->select('ReferrerProfile.fullname as referrer_fullname');

        $c->leftJoin($this->classKey, 'Referrals', $this->classKey . '.id = Referrals.referrer_id');
        $c->select('COUNT(Referrals.id) as referrals');

        if ($query = $this->getProperty('query')) {
            if (is_numeric($query)) {
                $c->where(array(
                    $this->classKey . '.id' => $query,
                ));
            } else {
                $c->where(array(
                    'User.username:LIKE' => "%{$query}%",
                    'OR:UserProfile.fullname:LIKE' => "%{$query}%",
                ));
            }
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $data = $object->toArray();
        if (empty($data['fullname'])) {
            $data['fullname'] = $data['username'];
        }
        if (empty($data['referrer_fullname'])) {
            $data['referrer_fullname'] = $data['referrer_username'];
        }

        $data['actions'] = array(
            array(
                'cls' => '',
                'icon' => 'icon icon-edit',
                'title' => $this->modx->lexicon('ms2_menu_update'),
                'action' => 'updateProfile',
                'button' => true,
                'menu' => true,
            ),
        );

        return $data;
    }

}

return 'msCustomerProfileGetListProcessor';