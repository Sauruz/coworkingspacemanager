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
            . $this->db->prefix . "csm_plans.id AS plan_id, "
            . $this->db->prefix . "csm_plans.name as plan_name, "
            . $this->db->prefix . "csm_workplaces.id AS workplace_id, "
            . $this->db->prefix . "csm_workplaces.name AS workplace_name, "
            . $this->db->prefix . "csm_workplaces.capacity AS workplace_capacity, "
            . "SUM((SELECT count(*) FROM " . $this->db->prefix . "csm_memberships WHERE plan_start <= CURDATE() AND plan_id = " . $this->db->prefix . "csm_plans.id)) AS memberships_count, "
            . "ROUND((SUM((SELECT count(*) FROM " . $this->db->prefix . "csm_memberships WHERE plan_start <= CURDATE() AND plan_id = " . $this->db->prefix . "csm_plans.id)) / " . $this->db->prefix . "csm_workplaces.capacity) * 100) AS percentage "
            . "FROM " . $this->db->prefix . "csm_plans "
            . "RIGHT JOIN " . $this->db->prefix . "csm_workplaces "
            . "ON " . $this->db->prefix . "csm_plans.workplace_id = " . $this->db->prefix . "csm_workplaces.id "
            . "GROUP BY workplace_id", ARRAY_A);
    }


}

?>
