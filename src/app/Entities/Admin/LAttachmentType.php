<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LAttachmentType extends Model
{
    protected $table = "l_attachment_types";
    protected $primaryKey = 'attachment_type_id';
    public function attachments()
    {
        return $this->hasMany(\EmpAttachment::class,'attachment_type_id');
    }
}
