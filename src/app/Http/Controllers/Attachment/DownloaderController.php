<?php

namespace App\Http\Controllers\Attachment;

use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Pmis\Employee\EmpNomineeTemp;
use App\Entities\Pmis\Employee\EmpProfCertificateTemp;
use App\Entities\Pmis\Employee\EmpTrainingTemp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DownloaderController extends Controller
{
    /** application/msword, application/pdf, image/png, image/jpg, image/jpeg */
    public function basicInfoAuthDoc(Request $request, $id)
    {
        $employeeTemp = EmployeeTemp::find($id);

        if($employeeTemp) {
            if($employeeTemp->auth_document && $employeeTemp->auth_document_type && $employeeTemp->auth_document_name) {
                $content = $employeeTemp->auth_document;
                $contentType = $this->getContentType($employeeTemp->auth_document_type);
                $filename = $employeeTemp->auth_document_name;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);

                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'inline; filename="'.$filename.'"'
                ]);
            }
        }
    }

    public function nomineeAuthDoc(Request $request, $id)
    {
        $nomineeTemp = EmpNomineeTemp::find($id);

        if($nomineeTemp) {
            if($nomineeTemp->nominee_auth_id_photo && $nomineeTemp->nominee_auth_id_photo_name && $nomineeTemp->nominee_auth_id_photo_type) {
                $content = $nomineeTemp->nominee_auth_id_photo;
                $contentType = $this->getContentType($nomineeTemp->nominee_auth_id_photo_type);
                $filename = $nomineeTemp->nominee_auth_id_photo_name;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);

                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'inline; filename="'.$filename.'"'
                ]);
            }
        }
    }

    public function trainingAuthDoc(Request $request, $id)
    {
        $trainingTemp = EmpTrainingTemp::find($id);
        if($trainingTemp) {
            if($trainingTemp->training_report_document && $trainingTemp->training_report_document_name && $trainingTemp->training_report_document_type) {
                $content = $trainingTemp->training_report_document;
                $contentType = $this->getContentType($trainingTemp->training_report_document_type);
                $filename = $trainingTemp->training_report_document_name;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);

                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'inline; filename="'.$filename.'"'
                ]);
            }
        }
    }

    public function profCertAuthDoc(Request $request, $id)
    {
        $profCertTemp = EmpProfCertificateTemp::find($id);

        if($profCertTemp) {
            if($profCertTemp->certificate_document && $profCertTemp->certificate_document_name && $profCertTemp->certificate_document_type) {
                $content = $profCertTemp->certificate_document;
                $contentType = $this->getContentType($profCertTemp->certificate_document_type);
                $filename = $profCertTemp->certificate_document_name;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);

                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'inline; filename="'.$filename.'"'
                ]);
            }
        }
    }

    private $fileTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'png' => 'image/png',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpeg',
    ];

    private function getContentType($fileType)
    {
        $contentType = $this->fileTypes[$fileType];

        if($contentType) {
            return $contentType;
        }

        return '';
    }
}
