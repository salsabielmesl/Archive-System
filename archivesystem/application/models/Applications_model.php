<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class Applications_model extends CI_Model
{
    protected $table = 'applications';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Insert a new application (platform) record
     *
     * @param array $data
     * @return int|bool Inserted ID or false
     */
    public function insert_application(array $data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Get all applications (platforms) by mobile_id
     * Returns platform name instead of platform_id
     *
     * @param int $mobile_id
     * @return array
     */
    public function get_by_mobile($mobile_id)
    {
        return $this->db
            ->select('
                applications.id,
                applications.mobile_id,
                applications.platform_id,
                platforms.app_platform AS platform_name,
                applications.platform_email,
                applications.platform_password
            ')
            ->from('applications')
            ->join('platforms', 'platforms.id = applications.platform_id', 'left')
            ->where('applications.mobile_id', $mobile_id)
            ->get()
            ->result();
    }

    /**
     * Delete all applications by mobile_id
     *
     * @param int $mobile_id
     * @return bool
     */
    public function delete_by_mobile($mobile_id)
    {
        return $this->db->where('mobile_id', $mobile_id)
                        ->delete($this->table);
    }

    /**
     * Delete a single application by its ID
     *
     * @param int $application_id
     * @return bool
     */
    public function delete_by_id($application_id)
    {
        return $this->db->where('id', $application_id)
                        ->delete($this->table);
    }

    /**
     * Update an existing application/platform
     *
     * @param int $application_id
     * @param array $data
     * @return bool
     */
    public function update_application($application_id, array $data)
    {
        return $this->db->where('id', $application_id)
                        ->update($this->table, $data);
    }

    /**
     * Get a single application/platform by ID
     *
     * @param int $application_id
     * @return object|null
     */
    public function get_by_id($application_id)
    {
        return $this->db->where('id', $application_id)
                        ->get($this->table)
                        ->row();
    }

    /**
     * Get all platforms for dropdown
     *
     * @return array
     */
    public function get_all_platforms()
    {
        return $this->db->select('id, app_platform')
                        ->from('platforms')
                        ->order_by('app_platform', 'ASC')
                        ->get()
                        ->result();
    }
}
