<?php
class Common {
    public function errorPage()
    {
        $this->output->set_status_header('404');
        
        $this->load->view("settings/header");
        $this->load->view("settings/error");
        $this->load->view("settings/footer");
    }

	// File Upload Common Function
	public function fileUpload($filesArray, $uploadDir, $allowTypes) {
		$uploadedFiles = array();
	
		// for ($i = 0; $i < count($filesArray['name']); $i++) {
			$fileName = basename($filesArray['name']);
			$fileName = $this->imageRename($fileName);
			$targetFilePath = $uploadDir . $fileName;
		
			$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
		
			if (in_array($fileType, $allowTypes)) {
				if (move_uploaded_file($filesArray['tmp_name'], $targetFilePath)) {
					$uploadedFiles[] = $uploadDir . $fileName;
				} else {
					$data['message'] = 'Sorry, there was an error uploading your file.';
				}
			} else {
				$data['message'] = 'Sorry, only PDF, Doc, and docs files are allowed to upload.';
			}
		//   }
		return $uploadedFiles;
	}
    
    public function imageRename($fileName)
    {
    	$currentDate = date('ymdHis');
    	$extension   = pathinfo($fileName, PATHINFO_EXTENSION);
		$fileName    = pathinfo($fileName, PATHINFO_FILENAME);
		$newFilename = str_replace(' ', '', strtolower($fileName));
		$newFilename = $newFilename.$currentDate;
		$newFilename = $newFilename . "." . $extension;
		return $newFilename;
    }
}
?>