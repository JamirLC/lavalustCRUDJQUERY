<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class user_control extends Controller
{
    public function read()
    {
        if ($this->io->is_ajax()) {
            $data = $this->user_model->read();
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            $data['users'] = $this->user_model->read();
            $this->call->view('users/read', $data);
        }
    }

    public function create()
    {
        if ($this->io->is_ajax()) {
            $lastname = $this->io->post('lname');
            $firstname = $this->io->post('fname');
            $email = $this->io->post('email');
            $gender = $this->io->post('gender');
            $address = $this->io->post('address');

            if ($this->user_model->create($lastname, $firstname, $email, $gender, $address)) {
                echo json_encode(['status' => 'success', 'message' => 'User created successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create user.']);
            }
        }
    }

    public function update($id)
    {
        if ($this->io->is_ajax()) {
            $lastname = $this->io->post('lname');
            $firstname = $this->io->post('fname');
            $email = $this->io->post('email');
            $gender = $this->io->post('gender');
            $address = $this->io->post('address');

            if ($this->user_model->update($lastname, $firstname, $email, $gender, $address, $id)) {
                echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update user.']);
            }
        } else {
            $data['user'] = $this->user_model->get1($id);
            $this->call->view('users/update', $data);
        }
    }

    public function delete($id)
    {
        if ($this->io->is_ajax()) {
            if ($this->user_model->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete user.']);
            }
        }
    }
}
