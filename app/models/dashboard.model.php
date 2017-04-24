<?php

class CsmDashboard
{

    public $db;
    public $gump;

    function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        /**
         * Use gump library to validate input
         * https://github.com/Wixel/GUMP
         */
        $this->gump = new GUMP();
        $this->members = new CsmMember();
    }

    /**
     * Count users
     * @return mixed
     */
    public function countUsers()
    {
        return $this->db->get_var("SELECT COUNT(*) FROM " . $this->db->prefix . "users");
    }

    /**
     * Count active users
     * @return int
     */
    public function countActiveUsers()
    {
        $active = 0;
        $all = $this->members->all();
        foreach ($all as $k => $v) {
            if ((strtotime($v['plan_start']) <= time()) && (strtotime($v['plan_end']) > time())) {
                $active += 1;
            }
        }
        return $active;
    }

    /**
     * @return mixed
     */
    public function countPaymentsToReceive()
    {
        return $this->db->get_var("SELECT COUNT(*) FROM " . $this->db->prefix . "csm_memberships WHERE payment = 0");
    }

    /**
     * Get capacity of today
     * @return mixed
     */
    public function capacity()
    {
        return $this->db->get_results("SELECT "
            . "wp_csm_plans.id AS plan_id, "
            . "wp_csm_plans.name as plan_name, "
            . "wp_csm_workplaces.id AS workplace_id, "
            . "wp_csm_workplaces.name AS workplace_name, "
            . "wp_csm_workplaces.capacity AS workplace_capacity, "
            . "SUM((SELECT count(*) FROM wp_csm_memberships WHERE plan_start <= CURDATE() AND plan_id = wp_csm_plans.id)) AS memberships_count, "
            . "ROUND((SUM((SELECT count(*) FROM wp_csm_memberships WHERE plan_start <= CURDATE() AND plan_id = wp_csm_plans.id)) / wp_csm_workplaces.capacity) * 100) AS percentage "
            . "FROM wp_csm_plans "
            . "RIGHT JOIN wp_csm_workplaces "
            . "ON wp_csm_plans.workplace_id = wp_csm_workplaces.id "
            . "GROUP BY workplace_id", ARRAY_A);
    }


}

?>
