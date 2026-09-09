<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
      $this->load->library('common');
      $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
      $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
      $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
      $this->output->set_header('Pragma: no-cache');
      if (($this->session->userdata('userid') == null) || ($this->session->userdata('userid') == "")) {
        redirect(base_url() . 'login');
      }
  
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
    }

    // Location Master Methods //
    public function location_list($pageStatus = '')
    {
        $data["menu_status"] = 'location';
        $data['activeLink'] = $pageStatus;

        $data['locationList'] = $this->webmodel->getLocationList($pageStatus);

        $this->load->view('settings/header', $data);
        $this->load->view('location/location-list', $data);
        $this->load->view('settings/footer');
    }

    public function location_add()
    {
        $data["menu_status"] = 'location';
        $data['formTitle'] = "Add Location";
        $data['locationId'] = '';
        $data['locationName'] = '';
        $data['feesAmount'] = '';
        $data['status'] = 'active';

        $this->load->view('settings/header', $data);
        $this->load->view('location/location-form', $data);
        $this->load->view('settings/footer');
    }

    public function location_edit($locationId)
    {
        $data["menu_status"] = 'location';
        $data['formTitle'] = "Edit Location";

        $locationInfo = $this->webmodel->getLocationInfo($locationId);
        foreach ($locationInfo as $row) {
            $data['locationId'] = $row->id;
            $data['locationName'] = $row->location_name;
            $data['feesAmount'] = $row->fees_amount;
            $data['status'] = $row->status;
        }

        $this->load->view('settings/header', $data);
        $this->load->view('settings/location-form', $data);
        $this->load->view('settings/footer');
    }

    public function locationFormSave()
    {
        $locationId = $this->input->post('location_id');
        $locationName = $this->input->post('location_name');
        $feesAmount = $this->input->post('fees_amount');
        $status = $this->input->post('status');

        if (empty($locationName)) {
            $data["isError"] = TRUE;
            $data["message"] = "Please Enter Location Name";
            echo json_encode($data);
            return;
        }

        $this->webmodel->saveLocationData($locationId, $locationName, $feesAmount, $status);

        $data["isError"] = FALSE;
        if ($locationId > 0) {
            $data["message"] = "Location Updated Successfully";
        } else {
            $data["message"] = "Location Created Successfully";
        }

        echo json_encode($data);
        return;
    }

    public function getLocationDetail()
    {
        $locationId = $this->input->post('locationId');

        $locationData = $this->webmodel->getLocationInfo($locationId);
        $data = array();
        foreach ($locationData as $row) {
            $data['locationId'] = $row->id;
            $data['locationName'] = $row->location_name;
            $data['feesAmount'] = $row->fees_amount;
            $data['status'] = $row->status;
            $data['createdBy'] = $row->createdBy;
            $data['createdAt'] = $row->createdAt;
        }
        echo json_encode($data);
    }

    // Student Methods //
    public function student_list($pageStatus = '')
    {
        $locationId = $this->input->get('location_id');
        $data["menu_status"] = 'student';
        $data['activeLink'] = $pageStatus;
        $data['selectedLocationId'] = $locationId;

        $data['locationList'] = $this->webmodel->getAllActiveLocations();
        $data['studentList'] = $this->webmodel->getStudentList($pageStatus, $locationId);

        $this->load->view('settings/header', $data);
        $this->load->view('student/student-list', $data);
        $this->load->view('settings/footer');
    }

    public function student_add()
    {
        $data["menu_status"] = 'student';
        $data['formTitle'] = "Add Student";
        $data['locationList'] = $this->webmodel->getAllActiveLocations();

        $year = date('Y');
        $this->db->select_max('id');
        $query  = $this->db->get('student');
        $result = $query->row_array();
        $maxID = $result['id'] ?? 0;
        $miNumberId = sprintf("%04d", $maxID + 1);
        $miNumber = $year . '/' . $miNumberId;

        $data['studentCode'] = $miNumber;
        $data['locationId'] = '';
        $data['feesAmount'] = '';

        $this->load->view('settings/header', $data);
        $this->load->view('student/student-form', $data);
        $this->load->view('settings/footer');
    }

    public function student_edit($studentId)
    {
        $data["menu_status"] = 'student';
        $data['formTitle'] = "Edit Student";
        $data['locationList'] = $this->webmodel->getAllActiveLocations();

        $studentInfo = $this->webmodel->getStudentInfo($studentId);
        foreach ($studentInfo as $row) {
            $data['studentId'] = $row->id;
            $data['token'] = $row->token;
            $data['studentCode'] = $row->student_code;
            $data['studentName'] = $row->student_name;
            $data['class'] = $row->class;
            $data['aadharNumber'] = $row->aadhar_number;
            $data['joiningDate'] = $row->joining_date;
            $data['email'] = $row->email;
            $data['mobileNumber'] = $row->mobile_number;
            $data['parentName'] = $row->parent_name;
            $data['parentType'] = $row->parent_type;
            $data['address'] = $row->address;
            $data['locationId'] = $row->location_id;
            $data['feesAmount'] = $row->fees_amount;
            $data['status'] = $row->status;
        }
        
        $this->load->view('settings/header', $data);
        $this->load->view('student/student-form', $data);
        $this->load->view('settings/footer');
    }
    
    public function getStudentDetail()
    {
        $studentId = $this->input->post('studentId');
    
        $studentData = $this->webmodel->getStudentInfo($studentId);
        foreach ($studentData as $row) {
            $data['studentCode'] = $row->student_code;
            $data['studentName'] = $row->student_name;
            $data['class'] = $row->class;
            $data['aadharNumber'] = $row->aadhar_number;
            $data['joiningDate'] = $row->joining_date;
            $data['email'] = $row->email;
            $data['mobileNumber'] = $row->mobile_number;
            $data['parentName'] = $row->parent_name;
            $data['parentType'] = $row->parent_type;
            $data['address'] = $row->address;
            $data['locationId'] = $row->location_id;
            $data['locationName'] = $row->location_name;
            $data['feesAmount'] = $row->fees_amount;
            $data['status'] = $row->status;
            $data['createdBy'] = $row->createdBy;
            $data['createdAt'] = $row->createdAt;
        }
        echo json_encode($data);
    }

    // Student Save Form
    public function studentFormSave()
    {
        $token = $this->input->post('token');
        $studentId = $this->input->post('student_id');
        $studentCode = $this->input->post('student_code');
        $studentName = $this->input->post('student_name');
        $class = $this->input->post('class');
        $aadharNumber = $this->input->post('aadhar_number');
        $joiningDate = $this->input->post('joining_date');
        $email = $this->input->post('email');
        $mobileNumber = $this->input->post('mobile_number');
        $parentName = $this->input->post('parent_name');
        $parentType = $this->input->post('parent_type');
        $address = $this->input->post('address');
        $locationId = $this->input->post('location_id');
        $feesAmount = $this->input->post('fees_amount');
        $status = $this->input->post('status');

        if ($studentId < 0 || $studentId == '') {
            $checkExists = $this->webmodel->checkStudent($token, $class, $mobileNumber);
            if ($checkExists > 0) {
                $data["isError"] = TRUE;
                $data["message"] = "Student Already Exists";
                echo json_encode($data);
                return;
            }
        }

        $this->webmodel->saveStudentData($token, $studentId, $studentCode, $studentName, $class, $aadharNumber, $joiningDate, $email, $mobileNumber, $parentName, $parentType, $address, $status, $locationId, $feesAmount);
        
        $data["isError"] = FALSE;
        if ($studentId > 0) {
            $data["message"] = "Student Updated";
        } else {
            $data["message"] = "Student Created";
        }

        echo json_encode($data);
        return;
    }





    public function attendance_list($year = '', $month = '')
    {
        $year = ($year != '') ? $year : date('Y');
        $month = ($month != '') ? $month : 'all';

        $data["menu_status"] = 'attendance';
        $data["year"] = $year;
        $data["month"] = $month;

        $data['presentMonthList'] = $this->webmodel->getPresentMonthList($year);

        // When 'all' is selected, pass empty month to get overall counts
        $filterMonth = ($month == 'all') ? '' : $month;
        $data['studentAttendanceList'] = $this->webmodel->getStudentAttendanceList($year, $filterMonth);

        $this->load->view('settings/header', $data);
        $this->load->view('attendance/attendance-list', $data);
        $this->load->view('settings/footer');
    }

    public function attendance_view($year = '', $month = '', $studentId = '')
    {
        $data["menu_status"] = 'attendance';
        $data['year'] = $year;
        $data['month'] = $month;

        $userName = $this->session->userdata('username');
        $userId = $this->session->userdata('userid');

        $data['attendanceMonthList'] = $this->webmodel->getAttendanceMonthList($year, $studentId);
        
        // When 'all' is selected, pass empty month to get overall counts for the student
        $filterMonth = ($month == 'all') ? '' : $month;
        $data['studentClassList'] = $this->webmodel->getStudentClassList($year, $filterMonth);
        $data['studentPresentList'] = $this->webmodel->getStudentPresentList($year, $filterMonth, $studentId);
        $data['studentLeaveList'] = $this->webmodel->getStudentLeaveList($year, $filterMonth, $studentId);
        
        $studentInfo = $this->webmodel->getStudentInfo($studentId);
        foreach ($studentInfo as $row) {
            $data['studentId'] = $row->id;
            $data['studentName'] = $row->student_name;
            $data['class'] = $row->class;
            $data['status'] = $row->status;
            $data['deleteStatus'] = $row->delete_status;
        }

        $this->load->view('settings/header', $data);
        $this->load->view('attendance/attendance-view', $data);
        $this->load->view('settings/footer');
    }

    public function present_add($year = '', $month = '')
    {
        $data["menu_status"] = 'attendance';
        $data["year"] = $year;
        $data["month"] = $month;
        
        $userName = $this->session->userdata('username');
        $userId = $this->session->userdata('userid');

        $data['formTitle'] = "Add Present";

        $data['locationList'] = $this->webmodel->getAllActiveLocations();
        $data['studentList'] = $this->webmodel->getStudentList('active');

        $this->load->view('settings/header', $data);
        $this->load->view('attendance/present-form', $data);
        $this->load->view('settings/footer');
    }

    // Attendance Save Form
    public function studentAttendanceSaveForm()
    {
        $attendanceId = $this->input->post('attendance_id');
        $presentDate = $this->input->post('present_date');
        $studentIds = $this->input->post('student_id');
        $attendanceTypes = $this->input->post('attendance_type');

        // Loop through each Stock Report and save Material data
        foreach ($studentIds as $index => $studentId) {
            $attendanceType = isset($attendanceTypes[$index]) ? $attendanceTypes[$index] : '';
            $this->webmodel->saveStudentAttendanceData($attendanceId, $presentDate, $studentId, $attendanceType);
        }

        $data["isError"] = FALSE;
        if ($attendanceId > 0) {
            $data["message"] = "Attendance Updated";
        } else {
            $data["message"] = "Attendance Created";
        }

        echo json_encode($data);
        return;
    }

    public function attendanceStudentList()
    {
        $attendanceDate = $this->input->post('attendanceDate');
        $locationId = $this->input->post('locationId');
        $data = $this->webmodel->getAttendanceStudentList($attendanceDate, $locationId);
        echo json_encode($data);
    }

    public function leave_add($year = '', $month = '', $studentId = '')
    {
        $data["menu_status"] = 'attendance';
        $data["year"] = $year;
        $data["month"] = $month;
        
        $userName = $this->session->userdata('username');
        $userId = $this->session->userdata('userid');

        $data['formTitle'] = "Add Leave";
        $data['studentDropdown'] = $this->webmodel->getStudentList('active');

        if ($studentId != '') {
            $studentInfo = $this->webmodel->getStudentInfo($studentId);
            foreach ($studentInfo as $row) {
                $data['studentId'] = $row->id;
                $data['student_name'] = $row->student_name;
                $data['class'] = $row->class;
                $data['studentCode'] = $row->student_code;
            }
        }
        
        $this->load->view('settings/header', $data);
        $this->load->view('attendance/leave-add', $data);
        $this->load->view('settings/footer');
    }

    public function leave_edit($leaveId)
    {
        $data["menu_status"] = 'attendance';
        
        $userName = $this->session->userdata('username');
        $userId = $this->session->userdata('userid');
        
        $data['formTitle'] = "Edit Leave";
        $data['studentDropdown'] = $this->webmodel->getStudentList('active');

        $studentLeaveInfo = $this->webmodel->getStudentLeaveInfo($leaveId);
        foreach ($studentLeaveInfo as $row) {
            $data['leaveId'] = $row->id;
            $data['studentId'] = $row->student_id;
            $data['class'] = $row->class;
            $data['studentCode'] = $row->student_code;
            $data['leaveDate'] = $row->leave_date;
            $data['joiningDate'] = $row->joining_date;
            $data['reason'] = $row->reason;
            $data['leaveCount'] = $row->leave_count;
            $data['status'] = $row->status;
        }
        
        $this->load->view('settings/header', $data);
        $this->load->view('attendance/leave-add', $data);
        $this->load->view('settings/footer');
    }

    // Leave Save Form //
    public function studentLeaveFormSave()
    {
        $leaveId = $this->input->post('leave_id');
        $studentName = $this->input->post('student_name');
        $leaveDate = $this->input->post('leave_date');
        $joiningDate = $this->input->post('joining_date');
        $reason = $this->input->post('reason');
        $leaveCount = $this->input->post('leave_count');
        $status = $this->input->post('status') ?? '';
        
        if ($leaveId < 0 || $leaveId == '') {
            $checkExists = $this->webmodel->checkStudentLeave($studentName, $leaveDate, $joiningDate);
            if ($checkExists > 0) {
                $data["isError"] = TRUE;
                $data["message"] = "Date Already Exists";
                echo json_encode($data);
                return;
            }
        }

        $this->webmodel->saveStudentLeaveData($leaveId, $studentName, $leaveDate, $joiningDate, $leaveCount, $reason, $status);
        
        $data["isError"] = FALSE;
        if ($leaveId > 0) {
            $data["message"] = "Leave Updated";
        } else {
            $data["message"] = "Leave Created";
        }

        echo json_encode($data);
        return;
    }
    public function studentDetail()
    {
        $studentId 	= $this->input->post('studentId');
        $data 	= $this->webmodel->getStudentInfo($studentId);
        echo json_encode($data); 
    }



    


    public function fees_list($year = '')
    {
        $data["menu_status"] = 'fees';
        $year = ($year != '') ? $year : date('Y');
        $data['year'] = $year;

        $students = $this->webmodel->getAllStudentList();
        $allFees = $this->webmodel->getFeesByYear($year);

        $feesMatrix = [];
        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

        foreach ($students as $student) {
            $studentFees = [];
            foreach ($months as $m) {
                $studentFees[$m] = null;
            }

            foreach ($allFees as $fee) {
                if ($fee->student_id == $student->id && $fee->year == $year) {
                    $feeMonth = strtolower($fee->month);
                    $studentFees[$feeMonth] = $fee;
                }
            }

            $feesMatrix[] = (object)[
                'id' => $student->id,
                'student_name' => $student->student_name,
                'class' => $student->class,
                'joining_date' => $student->joining_date,
                'fees_amount' => $student->fees_amount,
                'months' => $studentFees
            ];
        }

        $data['feesList'] = $feesMatrix;
        $data['monthList'] = $months;

        $this->load->view('settings/header', $data);
        $this->load->view('fees/fees-list', $data);
        $this->load->view('settings/footer');
    }

    public function fees_add($year = '', $studentId = '')
    {
        $data["menu_status"] = 'fees';
        $data['formTitle'] = "Add Fees";

        $year = ($year != '') ? $year : date('Y');
        
        $this->db->select_max('id');
        $query  = $this->db->get('fees');
        $result = $query->row_array();
        $maxID = $result['id'] ?? 0;
        $miNumberId = sprintf("%04d", $maxID + 1);
        $miNumber = $year . '/' . $miNumberId;

        if($studentId != '') {
            $studentInfo = $this->webmodel->getStudentInfo($studentId);
            foreach ($studentInfo as $row) {
                $data['studentId'] = $row->id;
                $data['studentCode'] = $row->student_code;
                $data['studentName'] = $row->student_name;
                $data['class'] = $row->class;
                $data['feeAmount'] = $row->fees_amount;
            }
        }

        $data['studentDropdown'] = $this->webmodel->getStudentList('active');
        $data['year'] = $year;

        $this->load->view('settings/header', $data);
        $this->load->view('fees/fees-form', $data);
        $this->load->view('settings/footer');
    }

    public function fees_edit($feesId)
    {
        $data["menu_status"] = 'fees';
        $data['formTitle'] = "Edit Fees";

        $data['studentDropdown'] = $this->webmodel->getStudentList('active');

        $feesInfo = $this->webmodel->getFeesInfo($feesId);
        foreach ($feesInfo as $row) {
            $data['studentId'] = $row->student_id;
            $data['studentCode'] = $row->student_code;
            $data['studentName'] = $row->student_name;
            $data['class'] = $row->class;
            $data['feeAmount'] = $row->fee_amount;
            $data['paymentDate'] = $row->payment_date;
            $data['paymentMethod'] = $row->payment_method;
            $data['paymentStatus'] = $row->payment_status;
        }
        
        $this->load->view('settings/header', $data);
        $this->load->view('fees/fees-form', $data);
        $this->load->view('settings/footer');
    }

    public function fees_view($year = '', $studentId = '')
    {
        $data["menu_status"] = 'fees';
        $year = ($year != '') ? $year : date('Y');
        $data['selectedYear'] = $year;

        $studentInfo = $this->webmodel->getStudentInfo($studentId);
        foreach ($studentInfo as $row) {
            $data['studentId'] = $row->id;
            $data['studentCode'] = $row->student_code;
            $data['studentName'] = $row->student_name;
            $data['studentClass'] = $row->class;
            $data['joiningDate'] = $row->joining_date;
            $data['aadharNumber'] = $row->aadhar_number;
            $data['parentName'] = $row->parent_name;
            $data['parentType'] = $row->parent_type;
            $data['mobileNumber'] = $row->mobile_number;
            $data['email'] = $row->email;
            $data['address'] = $row->address;
            $data['locationName'] = $row->location_name;
            $data['feesAmount'] = $row->fees_amount;
            $data['status'] = $row->status;
            $data['deleteStatus'] = $row->delete_status;
        }

        // Calculate Monthly Fees for the selected Year
        $joiningDate = $data['joiningDate'] ? $data['joiningDate'] : date('Y-m-d');
        $joiningYear = date('Y', strtotime($joiningDate));
        
        $startYearDate = $year . '-01-01';
        $endYearDate = $year . '-12-31';

        // Start from either joining date (if in selected year) or Jan 1st of selected year
        if ($joiningYear == $year) {
            $start = new DateTime($joiningDate);
        } else if ($joiningYear < $year) {
            $start = new DateTime($startYearDate);
        } else {
            // Student hasn't joined yet in this year
            $start = null;
        }

        if ($start) {
            $start->modify('first day of this month');
            
            // End date is Dec 31st of selected year OR current month if selected year is current year
            $limitDate = new DateTime($endYearDate);
            if ($year == date('Y')) {
                $limitDate = new DateTime();
            }
            $limitDate->modify('first day of next month');

            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $limitDate);
        } else {
            $period = [];
        }

        $actualPayments = $this->webmodel->getFeesByStudent($studentId);
        $paymentsByMonth = [];
        foreach ($actualPayments as $p) {
            $paymentsByMonth[strtolower($p->month)] = $p;
        }

        $feesList = [];
        $overallPaidAmount = 0;
        $overallUnPaidAmount = 0;

        $defaultStudentFee = ($studentInfo && isset($studentInfo[0]->fees_amount) && $studentInfo[0]->fees_amount > 0) ? $studentInfo[0]->fees_amount : 0;

        foreach ($period as $dt) {
            $monthName = strtolower($dt->format("F"));
            $yearStr = $dt->format("Y");
            
            $foundPayment = null;
            foreach ($actualPayments as $payment) {
                if (strtolower($payment->month) == strtolower($monthName) && $payment->year == $year) {
                    $foundPayment = $payment;
                    break;
                }
            }

            if ($foundPayment) {
                $feesList[] = (object)[
                    'id' => $foundPayment->id,
                    'payment_date' => $foundPayment->payment_date,
                    'fee_amount' => $foundPayment->fee_amount,
                    'payment_method' => $foundPayment->payment_method,
                    'payment_status' => $foundPayment->payment_status,
                    'status' => $foundPayment->payment_status,
                    'month' => ucfirst($monthName) . ' ' . $yearStr,
                    'month_name' => ucfirst($monthName)
                ];
                if ($foundPayment->payment_status == 'paid') {
                    $overallPaidAmount += $foundPayment->fee_amount;
                } else {
                    $overallUnPaidAmount += $foundPayment->fee_amount;
                }
            } else {
                $feesList[] = (object)[
                    'id' => 0,
                    'payment_date' => '-',
                    'fee_amount' => $defaultStudentFee,
                    'payment_method' => '-',
                    'payment_status' => 'unpaid',
                    'status' => 'unpaid',
                    'month' => ucfirst($monthName) . ' ' . $yearStr,
                    'month_name' => ucfirst($monthName)
                ];
                $overallUnPaidAmount += $defaultStudentFee;
            }
        }

        $data['feesList'] = array_reverse($feesList);
        $data['overallPaidAmount'] = $overallPaidAmount;
        $data['overallUnPaidAmount'] = $overallUnPaidAmount;
        
        $this->load->view('settings/header', $data);
        $this->load->view('fees/fees-view', $data);
        $this->load->view('settings/footer');
    }
    
    public function getFeesDetail()
    {
        $feesId = $this->input->post('feesId');
        $studentId = $this->input->post('studentId');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
    
        if ($feesId > 0) {
            $feesData = $this->webmodel->getFeesInfo($feesId);
            foreach ($feesData as $row) {
                $data['feesId'] = $row->fees_id;
                $data['year'] = $row->year;
                $data['month'] = $row->month;
                $data['studentId'] = $row->student_id;
                $data['studentCode'] = $row->student_code;
                $data['studentName'] = $row->student_name;
                $data['class'] = $row->class;
                $data['joiningDate'] = $row->joining_date;
                $data['aadharCard'] = $row->aadhar_number;
                $data['parentName'] = $row->parent_name;
                $data['parentType'] = $row->parent_type;
                $data['mobileNumber'] = $row->mobile_number;
                $data['email'] = $row->email;
                $data['address'] = $row->address;
                $data['feeAmount'] = $row->fee_amount;
                $data['paymentDate'] = $row->payment_date;
                $data['paymentMethod'] = $row->payment_method;
                $data['paymentStatus'] = $row->payment_status;
                $data['invoiceNumber'] = $row->invoice_number;
            }
        } else {
            $studentInfo = $this->webmodel->getStudentInfo($studentId);
            foreach ($studentInfo as $row) {
                $data['feesId'] = 0;
                $data['year'] = $year;
                $data['month'] = $month;
                $data['studentId'] = $row->id;
                $data['studentCode'] = $row->student_code;
                $data['studentName'] = $row->student_name;
                $data['class'] = $row->class;
                $data['joiningDate'] = $row->joining_date;
                $data['aadharCard'] = $row->aadhar_number;
                $data['parentName'] = $row->parent_name;
                $data['parentType'] = $row->parent_type;
                $data['mobileNumber'] = $row->mobile_number;
                $data['email'] = $row->email;
                $data['address'] = $row->address;
                $data['feeAmount'] = $row->fees_amount;
                $data['paymentDate'] = null;
                $data['paymentMethod'] = null;
                $data['paymentStatus'] = null;
            }
        }
        echo json_encode($data);
    }

    public function fees_invoice($feesId)
    {
        $feesData = $this->webmodel->getFeesInfo($feesId);
        if (empty($feesData)) {
            redirect(base_url() . 'fees-list/' . date('Y'));
        }

        $row = $feesData[0];
        $data['feesId'] = $row->fees_id;
        $data['month'] = $row->month;
        $data['year'] = $row->year;
        $data['studentCode'] = $row->student_code;
        $data['studentName'] = $row->student_name;
        $data['studentClass'] = $row->class;
        $data['parentName'] = $row->parent_name;
        $data['mobileNumber'] = $row->mobile_number;
        $data['email'] = $row->email;
        $data['address'] = $row->address;
        $data['amount'] = $row->fee_amount;
        $data['paymentDate'] = $row->payment_date;
        $data['paymentMethod'] = $row->payment_method;
        $data['invoiceNumber'] = $row->invoice_number;
        
        $data['settings'] = $this->webmodel->getSettings();

        $this->load->view('fees/fees-invoice', $data);
    }

    public function general_settings()
    {
        $data["menu_status"] = 'general-settings';
        $data['settings'] = $this->webmodel->getSettings();
        
        $this->load->view('settings/header', $data);
        $this->load->view('settings/general-settings', $data);
        $this->load->view('settings/footer');
    }

    public function saveGeneralSettings()
    {
        $data = array(
            'company_name' => $this->input->post('company_name'),
            'company_email' => $this->input->post('company_email'),
            'company_phone' => $this->input->post('company_phone'),
            'company_address' => $this->input->post('company_address'),
        );

        // Handle Logo Upload
        if (!empty($_FILES['company_logo']['name'])) {
            $config['upload_path']   = './uploads/images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('company_logo')) {
                $uploadData = $this->upload->data();
                $data['company_logo'] = $uploadData['file_name'];
            }
        }

        $this->webmodel->saveSettings($data);
        
        $res['isError'] = false;
        $res['message'] = 'Settings Updated Successfully';
        echo json_encode($res);
    }

    // Fees Save Form
    public function feesFormSave()
    {
        $feesId = $this->input->post('fees_id');
        $studentId = $this->input->post('student_id');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $feeAmount = $this->input->post('fee_amount');
        $paymentDate = $this->input->post('payment_date');
        $paymentMethod = $this->input->post('payment_method');
        $paymentStatus = $this->input->post('payment_status');

        // Validate student_id is not empty
        if (empty($studentId) || $studentId == 0) {
            $data["isError"] = TRUE;
            $data["message"] = "Please select a student";
            echo json_encode($data);
            return;
        }

        // Check duplicate: same student + month + year (exclude current record on update)
        $checkExists = $this->webmodel->checkFeesByMonth($studentId, $month, $year, $feesId);
        if ($checkExists > 0) {
            $data["isError"] = TRUE;
            $data["message"] = "Fees for this month already exists";
            echo json_encode($data);
            return;
        }

        $invoiceNumber = null;
        if ($feesId == 0) {

            // Generate Invoice Number: YEAR/MONTH_SHORT/0000X
            $monthShort = strtoupper(date('M', strtotime($month)));
            $this->db->select_max('id');
            $res = $this->db->get('fees')->row();
            $maxId = $res->id ?? 0;
            $nextId = sprintf("%05d", $maxId + 1);
            $invoiceNumber = $year . '/' . $monthShort . '/' . $nextId;
        }

        $this->webmodel->saveFeesData($feesId, $studentId, $month, $year, $feeAmount, $paymentDate, $paymentMethod, $paymentStatus, $invoiceNumber);
        
        $data["isError"] = FALSE;
        if ($feesId > 0) {
            $data["message"] = "Fees Updated";
        } else {
            $data["message"] = "Fees Created";
        }

        echo json_encode($data);
        return;
    }





    
    public function index()
    {
        $userId = $this->session->userdata('userid');
        $userName = $this->session->userdata('username');

        $data["menu_status"] = 'dashboard';
        $data['analytics'] = $this->webmodel->getDashboardAnalytics();
        
        $year = date('Y');
        $month = date('F');
        
        $data['year'] = $year;
        $data['month'] = $month;

        $students = $this->webmodel->getAllStudentList();
        $allFees = $this->webmodel->getFeesByYear($year);

        $feesMatrix = [];
        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

        foreach ($students as $student) {
            $studentFees = [];
            foreach ($months as $m) {
                $studentFees[$m] = null;
            }

            foreach ($allFees as $fee) {
                if ($fee->student_id == $student->id && $fee->year == $year) {
                    $feeMonth = strtolower($fee->month);
                    $studentFees[$feeMonth] = $fee;
                }
            }

            $feesMatrix[] = (object)[
                'id' => $student->id,
                'student_name' => $student->student_name,
                'class' => $student->class,
                'joining_date' => $student->joining_date,
                'fees_amount' => $student->fees_amount,
                'months' => $studentFees,
                'student_code' => $student->student_code
            ];
        }

        $data['feesList'] = $feesMatrix;
        $data['monthList'] = $months;

        
        $data['presentMonthList'] = $this->webmodel->getPresentMonthList($year);
        $data['studentAttendanceList'] = $this->webmodel->getStudentAttendanceList($year, $month);

        $this->load->view('settings/header', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('settings/footer');
    }

    public function error()
    {
        $this->load->view('settings/header_link', $data);
        $this->load->view('settings/error');
        $this->load->view('settings/footer');
    }

    public function access_denied()
    {
        $this->load->view('settings/header_link');
        $this->load->view('settings/no_permission');
        $this->load->view('settings/footer');
    }

    public function change_password()
    {
        $data["menu_status"] = 'change-password';
        
        $userInfo = $this->webmodel->getUserInfo();
        foreach ($userInfo as $row) {
            $data['username']     = $row->user_name;
            $data['loginCode']    = $row->login_code;
            $data['mobile']       = $row->mobile_number;
            $data['email']       = $row->email;
        }

        $this->load->view('settings/header', $data);
        $this->load->view('settings/change_password', $data);
        $this->load->view('settings/footer');
    }

    public function profile()
    {
        $data["menu_status"] = 'profile';

        $userInfo = $this->webmodel->getUserInfo();
        foreach ($userInfo as $row) {
            $data['username']     = $row->user_name;
            $data['loginCode']    = $row->login_code;
            $data['mobile']       = $row->mobile_number;
            $data['email']       = $row->email;
        }
        
        $this->load->view('settings/header', $data);
        $this->load->view('settings/profile', $data);
        $this->load->view('settings/footer');
    }
    
    // Change Password Form 
    public function changePassword()
    {
        $userid       = $this->session->userdata('userid');
        $oldPassword   = $this->input->post('old_password');
        $newPassword   = $this->input->post('new_password');

        // Validate old password
        $checkExists = $this->webmodel->checkOldPassword($userid, $oldPassword);
        if (!$checkExists) {
            $data["isError"] = TRUE;
            $data["message"] = "Incorrect Old Password";
            echo json_encode($data);
            return;
        }

        if ($oldPassword !== $newPassword){
            $this->webmodel->passwordUpdate($userid, $newPassword);
            $data["isError"] = FALSE;
            $data["message"] = "Password Updated Successfully";
        }else{
            $data["isError"] = TRUE;
            $data["message"] = "New Password and Old Password Same";
        }
        echo json_encode($data);
        return;
    }

    // Record Delete
    public function deleteRecord()
    {
        $recordId = $this->input->post("fieldId");
        $tableName = $this->input->post("tableName");

        $this->webmodel->deleteRecord($recordId, $tableName);
        
        if ($recordId > 0) {
            $data["isError"] = FALSE;
            $data["message"] = "Record Removed Successfully.";
        } else {
            $data["isError"] = TRUE;
            $data["message"] = "Record not deleted";
        }

        echo json_encode($data);
    }

    // Change Status
    public function changeStatus()
    {
        $recordId = $this->input->post("fieldId");
        $tableName = $this->input->post("tableName");
        $statusValue = $this->input->post("statusValue");

        $this->webmodel->changeStatus($recordId, $tableName, $statusValue);
        
        if ($recordId > 0) {
            $data["isError"] = FALSE;
            $data["message"] = "Status Changed Successfully.";
        } else {
            $data["isError"] = TRUE;
            $data["message"] = "Status Not Changed";
        }

        echo json_encode($data);
    }
    
    public function logout()
    {
        $userData = array();
        $this->session->set_userdata($userData);
        $this->session->sess_destroy();
        $this->load->helper('cookie');
        delete_cookie('ci_spacemanagement');
        redirect(base_url() . 'login');
    }
}