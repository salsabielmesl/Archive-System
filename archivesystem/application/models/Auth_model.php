<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    /**
     * Attempt login for a user
     *
     * @param string $username
     * @param string $password
     * @return object|false
     */
    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() === 1) {
            $user = $query->row();

            // Verify password hash
            if (password_verify($password, $user->password)) {
                return $user; // returns user object including id, username, role
            }
        }

        return false;
    }

    /**
     * Optional: create new user with hashed password
     */
    public function create_user($username, $password, $role = 'web')
    {
        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => $role
        ];

        return $this->db->insert('users', $data);
    }
}
