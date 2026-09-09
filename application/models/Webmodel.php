<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Webmodel extends CI_Model
{
    //Location List
    public function getLocationList($pageStatus = '')
    {
        $where = '';
        if ($pageStatus) {
            $where = "AND L.status = '$pageStatus'";
        }

        $sql = "SELECT L.* FROM location L WHERE L.delete_status = 0 $where ORDER BY L.location_name ASC";

        $res = $this->db->query($sql);
        return $res->result();
    }

    //All Active Location List
    public function getAllActiveLocations()
    {
        $sql = "SELECT * FROM location WHERE delete_status = 0 AND status = 'active' ORDER BY location_name ASC";

        $res = $this->db->query($sql);
        return $res->result();
    }

    //Location Info
    public function getLocationInfo($locationId = '')
    {
        if ($locationId) {
            $where = "WHERE L.id = $locationId";
        } else {
            $where = '';
        }
        $sql = "SELECT L.*, U.user_name AS createdBy, DATE_FORMAT(L.created_at, '%d/%m/%Y %h:%i %p') AS createdAt FROM location L LEFT JOIN users U ON L.created_by = U.id $where";

        $res = $this->db->query($sql);
        return $res->result();
    }

    //Save Location Data
    public function saveLocationData($locationId, $locationName, $feesAmount, $status)
    {
        $userId = $this->session->userdata('userid');

        if ($locationId > 0) {
            $data = array(
                'location_name' => $locationName,
                'fees_amount' => $feesAmount,
                'status' => $status,
                'updated_by' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', (int) $locationId);
            $this->db->update('location', $data);
        } else {
            $data = array(
                'location_name' => $locationName,
                'fees_amount' => $feesAmount,
                'status' => $status,
                'created_by' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('location', $data);
            return $this->db->insert_id();
        }
    }

    //Student List
    public function getStudentList($pageStatus = '', $locationId = '')
    {
        $where = '';
        if ($pageStatus) {
            $where .= " AND S.status = '$pageStatus'";
        }
        if ($locationId) {
            $where .= " AND S.location_id = '$locationId'";
        }

        $sql = "SELECT S.*, L.location_name FROM student S LEFT JOIN location L ON S.location_id = L.id WHERE S.delete_status = 0 $where ORDER BY S.student_code ASC";

        $res = $this->db->query($sql);
        return $res->result();
    }

    //All Student List
    public function getAllStudentList()
    {
        $sql = "SELECT S.*, L.location_name FROM student S LEFT JOIN location L ON S.location_id = L.id WHERE S.delete_status = 0 AND S.status = 'active' ORDER BY S.student_code ASC";

        $res = $this->db->query($sql);
        return $res->result();
    }

    //Student Info
    public function getStudentInfo($studentId = '')
    {
        if($studentId) {
            $where = "WHERE S.id = $studentId";
        } else {
            $where = '';
        }
        $sql = "SELECT S.*, L.location_name, U.user_name AS createdBy, DATE_FORMAT(S.created_at, '%d/%m/%Y %h:%i %p') AS createdAt FROM student S LEFT JOIN location L ON S.location_id = L.id LEFT JOIN users U ON S.created_by = U.id $where";

        $res = $this->db->query($sql);
        return $res->result();
    }

    //Check Student
    public function checkStudent($token, $class, $mobileNumber)
    {
        $sql = "SELECT * FROM student WHERE delete_status = 0 AND token = '" . $token . "' AND class = '" . $class . "' AND mobile_number = '" . $mobileNumber . "'";

        $res = $this->db->query($sql);
        return $res->num_rows();
    }

    //Save Student Form
    public function saveStudentData($token, $studentId, $studentCode, $studentName, $class, $aadharNumber, $joiningDate, $email, $mobileNumber, $parentName, $parentType, $address, $status, $locationId = null, $feesAmount = 0)
    {
        $userId = $this->session->userdata('userid');

        if ($studentId > 0) {
            $data = array(
                'token' => $token,
                'student_code' => $studentCode,
                'student_name' => $studentName,
                'class' => $class,
                'aadhar_number' => $aadharNumber,
                'joining_date' => $joiningDate,
                'email' => $email,
                'mobile_number' => $mobileNumber,
                'parent_name' => $parentName,
                'parent_type' => $parentType,
                'address' => $address,
                'location_id' => $locationId,
                'fees_amount' => $feesAmount,
                'status' => $status,
                'updated_by' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', (int) $studentId);
            $this->db->update('student', $data);
        } else {
            $data = array(
                'token' => $token,
                'student_code' => $studentCode,
                'student_name' => $studentName,
                'class' => $class,
                'aadhar_number' => $aadharNumber,
                'joining_date' => $joiningDate,
                'email' => $email,
                'mobile_number' => $mobileNumber,
                'parent_name' => $parentName,
                'parent_type' => $parentType,
                'address' => $address,
                'location_id' => $locationId,
                'fees_amount' => $feesAmount,
                'status' => $status,
                'created_by' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('student', $data);
            $this->db->insert_id();
        }
    }






    //Present Month List
    public function getPresentMonthList($year='')
    {
        if($year) {
            $whereYear = " AND DATE_FORMAT(present_date, '%Y') = '$year' ";
        }

        $sql = "SELECT *, LOWER(DATE_FORMAT(present_date, '%M')) AS month FROM attendance WHERE delete_status = 0 $whereYear GROUP BY DATE_FORMAT(present_date, '%M') ORDER BY FIELD(DATE_FORMAT(present_date, '%M'), 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'cctober', 'november', 'december')";
        
        $res = $this->db->query($sql);
        return $res->result();
    }
    
    // Attendance List
    public function getStudentAttendanceList($year = '', $month = '')
    {
        $wherePresent = '';
        $whereLeave = '';

        if ($year) {
            $wherePresent .= " AND YEAR(present_date) = '$year'";
            $whereLeave .= " AND YEAR(leave_date) = '$year'";
        }

        if ($month) {
            $wherePresent .= " AND MONTHNAME(present_date) = '$month'";
            $whereLeave .= " AND MONTHNAME(leave_date) = '$month'";
        }

        $sql = "
            SELECT 
                S.id AS student_id,
                S.student_name,
                S.class,
                COUNT(DISTINCT A.id) AS present_count,
                COUNT(DISTINCT LD.id) AS leave_count,
                TC.total_classes AS class_count
            FROM student S

            LEFT JOIN attendance A 
                ON A.student_id = S.id 
                AND A.delete_status = 0 
                $wherePresent

            LEFT JOIN leave_detail LD 
                ON LD.student_id = S.id 
                AND LD.delete_status = 0 
                $whereLeave

            CROSS JOIN (
                SELECT COUNT(DISTINCT present_date) AS total_classes
                FROM attendance
                WHERE delete_status = 0 $wherePresent
            ) TC

            WHERE S.delete_status = 0 AND S.status = 'active'
            GROUP BY S.id
            ORDER BY S.student_code ASC
        ";

        return $this->db->query($sql)->result();
    }
    
    //Student Class List
    public function getStudentClassList($year = '', $month = '')
    {
        $userId = $this->session->userdata('userid');
        $monthWhere = '';
        $yearWhere = '';

        if ($month) {
            $monthWhere = "AND LOWER(DATE_FORMAT(A.present_date, '%M')) = '$month'";
        }

        if ($year) {
            $yearWhere = "AND DATE_FORMAT(A.present_date, '%Y') = '$year'";
        }

        $sql = "SELECT A.*, S.student_name, S.class, DATE_FORMAT(A.present_date, '%d - %m - %Y') AS present_dateFormat, A.*, S.id as student_id FROM attendance A INNER JOIN student S ON S.id = A.student_id WHERE A.delete_status = 0 $monthWhere $yearWhere GROUP BY A.present_date ORDER BY A.present_date DESC";

        $res = $this->db->query($sql);
        return $res->result();
    }
    
    //Present List
    public function getStudentPresentList($year = '', $month = '', $studentId = '')
    {
        $userId = $this->session->userdata('userid');
        $studentWhere = '';
        $monthWhere = '';
        $yearWhere = '';
        
        if ($studentId) {
            $studentWhere = "AND A.student_id = '$studentId'";
        }

        if ($month) {
            $monthWhere = "AND LOWER(DATE_FORMAT(A.present_date, '%M')) = '$month'";
        }

        if ($year) {
            $yearWhere = "AND DATE_FORMAT(A.present_date, '%Y') = '$year'";
        }

        $sql = "SELECT A.*, S.student_name, S.class, DATE_FORMAT(A.present_date, '%d - %m - %Y') AS present_dateFormat, A.*, S.id as student_id FROM attendance A INNER JOIN student S ON S.id = A.student_id WHERE A.delete_status = 0 $studentWhere $monthWhere $yearWhere ORDER BY A.present_date DESC";

        $res = $this->db->query($sql);
        return $res->result();
    }
    
    //Attendance Month List
    public function getAttendanceMonthList($year='', $studentId='')
    {
        $wherestudentId = '';
        $whereYear = '';

        if($studentId) {
            $wherestudentId = " AND student_id = $studentId ";
        }

        if($year) {
            $whereYear = " AND DATE_FORMAT(present_date, '%Y') = '$year' ";
        }

        $sql = "SELECT *, LOWER(DATE_FORMAT(present_date, '%M')) AS month FROM attendance WHERE delete_status = 0 $wherestudentId $whereYear GROUP BY DATE_FORMAT(present_date, '%M') ORDER BY FIELD(DATE_FORMAT(present_date, '%M'), 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'cctober', 'november', 'december')";
        
        $res = $this->db->query($sql);
        return $res->result();
    }

    //Leave List
    public function getStudentLeaveList($year = '', $month = '', $studentId = '')
    {
        $this->db->select("LD.*, L.status, DATE_FORMAT(LD.leave_date, '%d - %m - %Y') AS leave_dateFormat");
        $this->db->from('leave_detail LD');
        $this->db->join('leave L', 'L.id = LD.leave_id');
        $this->db->where('LD.delete_status', 0);

        if (!empty($studentId)) {
            $this->db->where('LD.student_id', $studentId);
        }

        if (!empty($month)) {
            $this->db->where('MONTH(LD.leave_date)', date('m', strtotime($month)));
        }

        if (!empty($year)) {
            $this->db->where('YEAR(LD.leave_date)', $year);
        }

        $this->db->order_by('LD.leave_date', 'DESC');
        $this->db->order_by('LD.id', 'DESC');

        return $this->db->get()->result();
    }

    public function saveStudentAttendanceData($attendanceId, $presentDate, $studentId, $attendanceType)
    {
        // Check if studentId or attendanceType is empty and return false if so
        if (empty($attendanceType)) {
            return false;
        }

        $userId = $this->session->userdata('userid');
        $currentDateTime = date('Y-m-d H:i:s');

        $this->db->trans_start();

        $this->db->where('student_id', (int) $studentId);
        $this->db->where('present_date', $presentDate);
        $this->db->delete('attendance');

        if($attendanceType == 'present') {
            $itemPresentData = array(
                'present_date' => $presentDate,
                'student_id' => $studentId,
                'updated_by' => $userId,
                'updated_at' => $currentDateTime
            );

            // If new attendance, use created_by & created_at instead of updated_by
            if ($attendanceId == 0) {
                $itemPresentData['created_by'] = $userId;
                $itemPresentData['created_at'] = $currentDateTime;
            }

            $this->db->insert('attendance', $itemPresentData);
        } elseif($attendanceType == 'absent') {

            $this->db->where('student_id', (int) $studentId);
            $this->db->where('leave_date', $presentDate);
            $this->db->delete('leave_detail');
            
            $this->db->where('student_id', (int) $studentId);
            $this->db->where('leave_date', $presentDate);
            $this->db->delete('leave');

            // Insert new leave record
            $leaveData = array(
                'student_id' => $studentId,
                'leave_date' => $presentDate,
                'joining_date' => $presentDate,
                'reason' => 'Personal Leave',
                'leave_count' => '1',
                'status' => 'approved',
                'created_by' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('leave', $leaveData);
            $leaveEntryId = $this->db->insert_id();

            $leaveDetailData = array(
                'leave_id' => $leaveEntryId,
                'student_id' => $studentId,
                'leave_date' => $presentDate,
                'reason' => 'Personal Leave',
                'created_by' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('leave_detail', $leaveDetailData);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    
    public function getAttendanceStudentList($attendanceDate = '', $locationId = '')
    {
        $dateFilterAttendance = "";
        $dateFilterLeave = "";
        $locationWhere = "";

        if ($attendanceDate != '') {
            $dateFilterAttendance = " AND A.present_date = '" . $attendanceDate . "'";
            $dateFilterLeave = " AND LD.leave_date = '" . $attendanceDate . "'";
        }

        if ($locationId != '') {
            $locationWhere = " AND S.location_id = '" . $locationId . "'";
        }

        $sql = "SELECT S.*, L.location_name FROM student S LEFT JOIN location L ON S.location_id = L.id WHERE S.delete_status = 0 AND S.status = 'active' $locationWhere AND NOT EXISTS (SELECT 1 FROM attendance A WHERE A.student_id = S.id $dateFilterAttendance AND A.delete_status = 0) AND NOT EXISTS (SELECT 1 FROM leave_detail LD WHERE LD.student_id = S.id AND LD.delete_status = 0 $dateFilterLeave) ORDER BY S.student_code ASC";

        $res = $this->db->query($sql);
        return $res->result();
    }
    
    //Leave Info
    public function getStudentLeaveInfo($leaveId)
    {
        $sql = "SELECT L.*, S.student_name, S.class, S.student_code FROM `leave` L INNER JOIN student S ON S.id = L.student_id WHERE L.delete_status = 0  AND L.id = $leaveId";
        
        $res = $this->db->query($sql);
        return $res->result();
    }
    
    // Check Leave
    public function checkStudentLeave($studentName, $leaveDate, $joiningDate)
    {
        $sql = "SELECT * FROM leave_detail WHERE delete_status = 0 AND student_id = ? AND leave_date BETWEEN ? AND ?";
        
        $res = $this->db->query($sql, [$studentName, $leaveDate, $joiningDate]);
        return $res->num_rows();
    }
    
    //Save Leave Form
    public function saveStudentLeaveData($leaveId, $studentName, $leaveDate, $joiningDate, $leaveCount, $reason, $status)
    {
        $userId = $this->session->userdata('userid');
        
        // Convert dates to Y-m-d format
        $leaveDateObj = DateTime::createFromFormat('Y-m-d', $leaveDate);
        $joiningDateObj = DateTime::createFromFormat('Y-m-d', $joiningDate);
        
        if (!$leaveDateObj || !$joiningDateObj) {
            return false; // Invalid date format
        }

        $leaveDate = $leaveDateObj->format('Y-m-d');
        $joiningDate = $joiningDateObj->format('Y-m-d');

        // Calculate leave count
        $leaveCount = $joiningDateObj->diff($leaveDateObj)->days + 1;

        if ($leaveId > 0) {
            // Update existing leave record
            $data = array(
                'student_id' => $studentName,
                'leave_date' => $leaveDate,
                'joining_date' => $joiningDate,
                'reason' => $reason,
                'leave_count' => $leaveCount,
                'status' => $status,
                'updated_by' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', (int) $leaveId);
            $this->db->update('leave', $data);

            // Remove old leave details and insert new ones
            $this->db->where('leave_id', $leaveId);
            $this->db->delete('leave_detail');

            $this->insertLeaveDetails($leaveId, $studentName, $leaveDateObj, $joiningDateObj, $reason, $userId);
        } else {
            // Insert new leave record
            $data = array(
                'student_id' => $studentName,
                'leave_date' => $leaveDate,
                'joining_date' => $joiningDate,
                'reason' => $reason,
                'leave_count' => $leaveCount,
                'status' => $status,
                'created_by' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('leave', $data);
            $leaveEntryId = $this->db->insert_id();

            $this->insertLeaveDetails($leaveEntryId, $studentName, $leaveDateObj, $joiningDateObj, $reason, $userId);
        }
    }

    // Function to insert individual leave dates into leave_detail
    private function insertLeaveDetails($leaveId, $studentName, $leaveDateObj, $joiningDateObj, $reason, $userId)
    {
        $interval = new DateInterval('P1D'); // 1-day interval
        $dateRange = new DatePeriod($leaveDateObj, $interval, $joiningDateObj->modify('+1 day'));

        foreach ($dateRange as $date) {
            $leaveDetailData = array(
                'leave_id' => $leaveId,
                'student_id' => $studentName,
                'leave_date' => $date->format('Y-m-d'),
                'reason' => $reason,
                'created_by' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('leave_detail', $leaveDetailData);
        }
    }
    





    
    //Fees List
    public function getFeesList($pageStatus = '')
    {
        $sql = "SELECT S.id, S.student_name, S.class, S.student_code FROM student S WHERE S.delete_status = 0 ORDER BY S.student_code ASC";
        $res = $this->db->query($sql);
        return $res->result();
    }

    //Fees Info
    public function getFeesInfo($feesId = '')
    {
        if($feesId) {
            $where = " AND F.id = $feesId";
        } else {
            $where = '';
        }
        $sql = "SELECT F.*, F.id AS fees_id, S.*, U.user_name AS createdBy, DATE_FORMAT(F.created_at, '%d/%m/%Y %h:%i %p') AS createdAt 
                FROM fees F 
                INNER JOIN student S ON F.student_id = S.id
                LEFT JOIN users U ON F.created_by = U.id 
                WHERE F.delete_status = 0 $where";

        $res = $this->db->query($sql);
        return $res->result();
    }

    public function getFeesByStudent($studentId = null)
    {
        if ($studentId) {
            $sql = "SELECT * FROM fees WHERE student_id = ? AND delete_status = 0 ORDER BY payment_date DESC";
            $res = $this->db->query($sql, [$studentId]);
        } else {
            $sql = "SELECT * FROM fees WHERE delete_status = 0 ORDER BY payment_date DESC";
            $res = $this->db->query($sql);
        }
        return $res->result();
    }

    public function getFeesByYear($year)
    {
        $sql = "SELECT * FROM fees WHERE YEAR(payment_date) = ? AND delete_status = 0";
        $res = $this->db->query($sql, [$year]);
        return $res->result();
    }

    //Check Fees
    public function checkFeesByMonth($studentId, $month, $year, $excludeId = 0)
    {
        $sql = "SELECT * FROM fees WHERE delete_status = 0 AND student_id = ? AND month = ? AND year = ?";
        $params = [$studentId, $month, $year];

        if ($excludeId > 0) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $res = $this->db->query($sql, $params);
        return $res->num_rows();
    }

    //Save Fees Form
    public function saveFeesData($feesId, $studentId, $month, $year, $feeAmount, $paymentDate, $paymentMethod, $paymentStatus, $invoiceNumber = null)
    {
        $userId = $this->session->userdata('userid');

        $data = array(
            'student_id' => $studentId,
            'month' => $month,
            'year' => $year,
            'fee_amount' => $feeAmount,
            'payment_date' => $paymentDate,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
            'updated_by' => $userId,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($invoiceNumber != null) {
            $data['invoice_number'] = $invoiceNumber;
        }

        if ($feesId > 0) {
            $this->db->where('id', (int) $feesId);
            $this->db->update('fees', $data);
        } else {
            $data['created_by'] = $userId;
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('fees', $data);
        }
    }



    




    public function deleteRecord($recordId, $tableName = '')
    {
        $userId = $this->session->userdata('userid');

        $sql = "UPDATE $tableName SET delete_status = 1, updated_by = '" . $userId . "', updated_at = NOW() WHERE id =" . $recordId;
        $this->db->query($sql);
    }

    public function changeStatus($recordId, $tableName, $statusValue)
    {
        $userId = $this->session->userdata('userid');

        $sql = "UPDATE $tableName SET status = '$statusValue', updated_by = '" . $userId . "', updated_at = NOW() WHERE id =" . $recordId;

        $this->db->query($sql);
    }
    
    // Get Logged User Information 
    public function getUserInfo()
    {
        $userId = $this->session->userdata('userid');
        
        $sql = "SELECT * FROM users WHERE delete_status = 0 AND status='active' AND id='".$userId."'";
        $res = $this->db->query($sql);
        return $res->result();
    }
    
    public function checkOldPassword($userid, $oldPassword)
    {
        $mdOldPassword = md5($oldPassword);

        $sql = "SELECT * FROM users WHERE password = '" . $mdOldPassword . "' AND delete_status = 0 AND id = $userid";

        $res = $this->db->query($sql);
        return $res->num_rows();
    }

    // update Password
    public function passwordUpdate($userId, $newPassword)
    {
        $userPass = md5($newPassword);

        $data = array(
            'password' => $userPass,
            'updated_by' => $userId,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $userId);
        $this->db->update('users', $data);
    }

    public function getSettings()
    {
        return $this->db->get_where('general_settings', ['id' => 1])->row();
    }

    public function saveSettings($data)
    {
        $this->db->where('id', 1);
        $this->db->update('general_settings', $data);
        return true;
    }

    public function getDashboardAnalytics()
    {
        $month = date('F');
        $year = date('Y');
        $today = date('Y-m-d');

        // 1. Active Student Count
        $this->db->where('status', 'active');
        $this->db->where('delete_status', 0);
        $result['totalStudents'] = $this->db->count_all_results('student');

        // 2. Overall Payment Amount (All time paid)
        $this->db->select_sum('fee_amount');
        $this->db->where('year', $year);
        $this->db->where('payment_status', 'paid');
        $this->db->where('delete_status', 0);
        $res = $this->db->get('fees')->row();
        $result['totalPaid'] = $res->fee_amount ?? 0;

        // 3. Overall Class Count
        $this->db->distinct();
        $this->db->select('present_date');
        $this->db->where('delete_status', 0);
        $this->db->where('DATE_FORMAT(present_date, "%Y") = ', $year);
        $this->db->group_by('present_date');
        $query = $this->db->get('attendance');
        $result['classCount'] = $query->num_rows();

        return $result;
    }

    public function getRecentFees($year, $limit = 10)
    {
        $this->db->select('F.*, S.student_name, S.student_code');
        $this->db->from('fees F');
        $this->db->join('student S', 'F.student_id = S.id');
        $this->db->where('F.year', $year);
        $this->db->where('F.delete_status', 0);
        $this->db->order_by('F.id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function getRecentAttendance($month, $year, $limit = 10)
    {
        $this->db->select('A.*, S.student_name, S.student_code');
        $this->db->from('attendance A');
        $this->db->join('student S', 'A.student_id = S.id');
        $this->db->where('DATE_FORMAT(A.present_date, "%M") = ', $month);
        $this->db->where('DATE_FORMAT(A.present_date, "%Y") = ', $year);
        $this->db->where('A.delete_status', 0);
        $this->db->order_by('A.id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
?>