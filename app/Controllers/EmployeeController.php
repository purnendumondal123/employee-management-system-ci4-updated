<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    /*
    |--------------------------------------------------------------------------
    | Employee List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('employees/index');
    }

    /*
    |--------------------------------------------------------------------------
    | Create Employee
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('employees/create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Employee
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $rules = [

            'employee_code' => 'required|min_length[3]|max_length[20]|is_unique[employees.employee_code]',

            'first_name' => 'required|min_length[2]|max_length[50]',

            'last_name' => 'required|min_length[2]|max_length[50]',

            'email' => 'required|valid_email|is_unique[employees.email]',

            'mobile' => 'required|min_length[10]|max_length[15]',

            'password' => 'required|min_length[6]',

            'confirm_password' => 'required|matches[password]',

            'role' => 'required|in_list[admin,employee]',

            'status' => 'required|in_list[active,inactive]',

            'department' => 'required|max_length[100]',

            'designation' => 'required|max_length[100]',

            'salary' => 'required|decimal',

            'joining_date' => 'required|valid_date',

        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [

            'employee_code' => trim($this->request->getPost('employee_code')),

            'first_name' => trim($this->request->getPost('first_name')),

            'last_name' => trim($this->request->getPost('last_name')),

            'email' => trim($this->request->getPost('email')),

            'mobile' => trim($this->request->getPost('mobile')),

            'password' => $this->request->getPost('password'),

            'role' => $this->request->getPost('role'),

            'status' => $this->request->getPost('status'),

            'department' => trim($this->request->getPost('department')),

            'designation' => trim($this->request->getPost('designation')),

            'salary' => $this->request->getPost('salary'),

            'joining_date' => $this->request->getPost('joining_date'),

            // Admin creates the account,
            // so email verification is not required.
            'email_verified' => 1,

            'created_by' => session()->get('id'),

        ];

        if (!$this->employeeModel->insert($data)) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to create employee.');
        }

        return redirect()->to('/employees')
            ->with('success', 'Employee created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Employee
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $employee = $this->employeeModel->find($id);

        if (!$employee) {
            return redirect()->to('/employees')
                ->with('error', 'Employee not found.');
        }

        $data['employee'] = $employee;

        return view('employees/edit', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Employee
    |--------------------------------------------------------------------------
    */

    public function update($id)
    {
        $employee = $this->employeeModel->find($id);

        if (!$employee) {

            return redirect()->to('/employees')
                ->with('error', 'Employee not found.');
        }

        $rules = [

            'employee_code' => 'required|min_length[3]|max_length[20]|is_unique[employees.employee_code,id,' . $id . ']',

            'firstname' => 'required|min_length[2]|max_length[50]',

            'lastname' => 'required|min_length[2]|max_length[50]',

            'email' => 'required|valid_email|is_unique[employees.email,id,' . $id . ']',

            'mobile' => 'required|min_length[10]|max_length[15]',

            'department'   => 'permit_empty|max_length[100]',

            'designation'  => 'permit_empty|max_length[100]',

            'salary'       => 'permit_empty|decimal',

            'joining_date' => 'permit_empty|valid_date',

            'role' => 'required',

            'status' => 'required',

        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $data = [

            'employee_code' => $this->request->getPost('employee_code'),

            'first_name' => $this->request->getPost('firstname'),

            'last_name' => $this->request->getPost('lastname'),

            'email' => $this->request->getPost('email'),

            'mobile' => $this->request->getPost('mobile'),

            'department' => $this->request->getPost('department'),

            'designation' => $this->request->getPost('designation'),

            'salary' => $this->request->getPost('salary'),

            'joining_date' => $this->request->getPost('joining_date'),

            'role' => $this->request->getPost('role'),

            'status' => $this->request->getPost('status'),

            'updated_by' => session()->get('id'),

        ];

        $this->employeeModel->update($id, $data);

        return redirect()->to('/employees')
            ->with('success', 'Employee updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Employee
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $employee = $this->employeeModel->find($id);

        if (!$employee) {

            return redirect()->to('/employees')
                ->with('error', 'Employee not found.');
        }

        // he not delete her Account
        if ($employee['id'] == session()->get('id')) {

            return redirect()->to('/employees')
                ->with('error', 'You cannot delete your own account.');
        }

        $this->employeeModel->delete($id);

        return redirect()->to('/employees')
            ->with('success', 'Employee deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | DataTable
    |--------------------------------------------------------------------------
    */

    public function datatable()
    {
        $request = service('request');

        $builder = $this->employeeModel->builder();


        // Total records
        $recordsTotal = $builder->countAllResults(false);


        // Search
        $search = $request->getPost('search')['value'] ?? '';

        if (!empty($search)) {

            $builder->groupStart()
                ->like('employee_code', $search)
                ->orLike('first_name', $search)
                ->orLike('last_name', $search)
                ->orLike('email', $search)
                ->orLike('mobile', $search)
                ->groupEnd();
        }


        // Filtered records
        $recordsFiltered = $builder->countAllResults(false);


        $builder->where('deleted_at IS NULL');
        // Order
        $builder->orderBy('id', 'DESC');


        // Pagination
        $start  = (int)$request->getPost('start');
        $length = (int)$request->getPost('length');


        $employees = $builder
            ->limit($length, $start)
            ->get()
            ->getResultArray();



        $data = [];

        $sl = $start + 1;


        foreach ($employees as $employee) {

            $status = ($employee['status'] == 'active')
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';



            $action = '
            <div class="btn-group" role="group">
            
                <a href="' . site_url('employees/edit/' . $employee['id']) . '"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>
            
                <form action="' . site_url('employees/delete/' . $employee['id']) . '"
                      method="post"
                      class="d-inline">
            
                    ' . csrf_field() . '
            
                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm(\'Are you sure?\')">
                        Delete
                    </button>
            
                </form>
            
            </div>
            ';



            $data[] = [

                $sl++,

                esc($employee['employee_code']),

                esc($employee['first_name'] . ' ' . $employee['last_name']),

                esc($employee['email']),

                esc($employee['mobile']),

                $status,

                $action

            ];
        }



        return $this->response->setJSON([

            "draw" => intval($request->getPost('draw')),

            "recordsTotal" => $recordsTotal,

            "recordsFiltered" => $recordsFiltered,

            "data" => $data

        ]);
    }

    public function exportCsv()
    {
        // die("HELLO EXPORT");
        
        $employees = $this->employeeModel
            ->where('deleted_at', null)
            ->findAll();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="employees.csv"');

        $output = fopen('php://output', 'w');

        fputcsv($output, [
            'SL No',
            'Employee Code',
            'Name',
            'Email',
            'Mobile',
            'Status'
        ]);

        $sl = 1;

        foreach ($employees as $employee) {

            fputcsv($output, [

                $sl++,

                $employee['employee_code'],

                $employee['first_name'] . ' ' . $employee['last_name'],

                $employee['email'],

                $employee['mobile'],

                ucfirst($employee['status'])

            ]);
        }

        fclose($output);
        exit;
    }
}
