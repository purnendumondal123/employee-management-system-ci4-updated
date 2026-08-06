<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;

class ProfileController extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    public function index()
    {
        $id = session()->get('id'); // logged-in user id

        $data['user'] = $this->employeeModel->find($id);

        return view('profile/index', $data);
    }

    public function update()
    {
        // dd($this->request->getPost());
        $id = session()->get('id');

        $rules = [

            'first_name' => 'required|min_length[2]|max_length[50]',

            'last_name' => 'required|min_length[2]|max_length[50]',

            'mobile' => 'required|numeric|exact_length[10]',

            'dob' => 'required|valid_date[Y-m-d]',

            'address' => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {

            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $dob = $this->request->getPost('dob');

        $today = new \DateTime();
        $birthDate = new \DateTime($dob);
        $age = $today->diff($birthDate)->y;

        if ($age < 18) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => [
                    'dob' => 'Employee must be at least 18 years old.'
                ]
            ]);
        }

        $data = [

            'first_name' => $this->request->getPost('first_name'),

            'last_name' => $this->request->getPost('last_name'),

            'mobile' => $this->request->getPost('mobile'),

            'dob' => $this->request->getPost('dob'),

            'address' => $this->request->getPost('address'),

        ];

        $this->employeeModel->update($id, $data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Profile updated successfully.'
        ]);
    }

    public function uploadPhoto()
    {
        $id = session()->get('id');

        $rules = [

            'profile_photo' => [

                'rules' => 'uploaded[profile_photo]|is_image[profile_photo]|mime_in[profile_photo,image/jpg,image/jpeg,image/png]|max_size[profile_photo,3072]',

                'errors' => [

                    'uploaded' => 'Please select a photo.',

                    'is_image' => 'Only image files are allowed.',

                    'mime_in' => 'Only JPG, JPEG and PNG images are allowed.',

                    'max_size' => 'Image size must not exceed 3 MB.'

                ]

            ]

        ];

        if (!$this->validate($rules)) {

            return $this->response->setJSON([

                'status' => false,

                'errors' => [

                    'profile_photo' => $this->validator->getError('profile_photo')

                ]

            ]);
        }

        $file = $this->request->getFile('profile_photo');

        $newName = $file->getRandomName();

        $file->move(FCPATH . 'uploads/profile', $newName);

        $this->employeeModel->update($id, [

            'profile_photo' => $newName

        ]);

        return $this->response->setJSON([

            'status' => true,

            'message' => 'Profile photo updated successfully.',

            'image' => base_url('uploads/profile/' . $newName)

        ]);
    }
}
