<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LAttachmentType;
use Illuminate\Database\Eloquent\Model;

class EmpAttachment extends Model
{
    protected $table = 'emp_attachments';
    protected $primaryKey = 'attachment_id';
    public $sequence = 'SEQ_ATTACHMENT_ID';
    protected $fillable = [ 'attachment_type_id',
        'filename'  ,
        'file_content' ,
        'filesystem_yn',
        'file_path' ,
        'active_yn' ,
        'filesize' ,
        'emp_id'  ,
        'title' ,
        'title_bn' ,
        'file_extension' ,
        'emp_code',
        'insert_date',
        'insert_by'];

    public $timestamps = false;

    public function attachment_type()
    {
        return $this->belongsTo(LAttachmentType::class, 'attachment_type_id');
    }

}
