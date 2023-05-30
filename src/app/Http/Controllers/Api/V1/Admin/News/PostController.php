<?php

namespace App\Http\Controllers\Api\V1\Admin\News;
use App\Contracts\Admin\AdminContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PostController extends Controller
{
    /** @var AdminContract|AdminManager  */
    private $adminManager;

    /**
     * DepartmentController constructor.
     * @param AdminContract | AdminManager $adminManager
     */
    public function __construct(AdminContract $adminManager)
    {        // Dependency injection
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        $data = [];
        $sql = "select cpa_security.cpa_general.get_news(:p1, :p2) from dual";
        $data['news'] = DB::select($sql, ['p1' => $request->get('active_form'),
            'p2' => $request->get('active_to'),

        ]);

        $sql2 = "select cpa_security.cpa_general.get_news_status from dual";
        $data['status'] = DB::select($sql2);

        return $data;
    }

    /**
     * Save information
     *
     * @param Request $request
     * @return array[]
     */
    public function store(Request $request)
    {
        //dd($request->all());
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                "p_title" => $request->post("title"),
                "p_title_bn" => $request->post("title_bn"),
                "p_description" => $request->post("description"),
                "p_description_bn" => $request->post("description_bn"),
                "p_department_id" => null,
                "p_active_to" => $request->post("active_to"),
                "p_active_from" => $request->post("active_from"),
                "p_created_by" => Auth()->ID(),
                'p_attachment' => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                'p_attachment_file' => $request->post('attachment_filename'),
                'p_enabled_yn' => $request->post('enabled_yn'),
                'p_sort_order' => $request->post('sort_order'),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure('cpa_security.cpa_general.news_in', $params);
        } catch (\Exception $e) {
            return["params" => ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()]];
        }

        $data['params'] = $params;

        if ($status_code == 1) {
            $sql = "select cpa_security.cpa_general.get_news(:p1, :p2) from dual";
            $data['news'] = DB::select($sql, ['p1' => null,
                'p2' => null,
            ]);
        }

        return $data;
    }

    /**
     * Approved action
     *
     * @param $id
     * @return array
     */
    public function approved($id) {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_id" => $id,
                "p_update_by" => Auth()->ID(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure('cpa_security.cpa_general.news_approved', $params);
        } catch (\Exception $e) {
            return["params" => ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()]];
        }

        $data['params'] = $params;
        if ($status_code == 1) {
            $sql = "select cpa_security.cpa_general.get_news(:p1, :p2) from dual";
            $data['news'] = DB::select($sql, ['p1' => null,
                'p2' => null,
            ]);
        }

        return $data;
    }

    /**
     * Published action
     *
     * @param $id
     * @return array
     */
    public function published($id) {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_id" => $id,
                "p_update_by" => Auth()->ID(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure('cpa_security.cpa_general.news_published', $params);
        } catch (\Exception $e) {
            return["params" => ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()]];
        }

        $data['params'] = $params;
        if ($status_code == 1) {
            $sql = "select cpa_security.cpa_general.get_news(:p1, :p2) from dual";
            $data['news'] = DB::select($sql, ['p1' => null,
                'p2' => null,
            ]);
        }

        return $data;
    }

    public function update($id,Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                "p_id" => $request->post('news_id'),
                "p_title" => $request->post("title"),
                "p_title_bn" => $request->post("title_bn"),
                "p_description" => $request->post("description"),
                "p_description_bn" => $request->post("description_bn"),
                "p_department_id" => null,
                "p_active_to" => $request->post("active_to"),
                "p_active_from" => $request->post("active_from"),
                "p_created_by" => Auth()->ID(),
                'p_attachment' => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                'p_attachment_file' => $request->post('attachment_filename'),
                'p_enabled_yn' => $request->post('enabled_yn'),
                'p_sort_order' => $request->post('sort_order'),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure('cpa_security.cpa_general.news_upd', $params);
        } catch (\Exception $e) {
            return["params" => ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()]];
        }

        $data['params'] = $params;

        if ($status_code == 1) {
            $sql = "select cpa_security.cpa_general.get_news(:p1, :p2) from dual";
            $data['news'] = DB::select($sql, ['p1' => null,
                'p2' => null,
            ]);
        }
        return $data;
    }

    /**
     * Get Action news
     */
    public function activeNews() {
        $sql = "select cpa_security.cpa_general.get_active_news from dual";
        return DB::select($sql);
    }

    /**
     * Get Individual news
     *
     * @param $id
     * @return mixed
     */
    public function getNews($id) {
        $sql = "select cpa_security.cpa_general.get_news_one(:id) from dual";
        $news = DB::selectOne($sql,['id' => $id]);
        $news->description = nl2br($news->description);
        $news->description_bn = nl2br($news->description_bn);
        return ['news' => $news];
    }

    /**
     * Removing specific news
     *
     * @param $id
     */
    public function remove($id)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_id" => $id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure('cpa_security.cpa_general.news_del', $params);
        } catch (\Exception $e) {
            return["params" => ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()]];
        }

        $data['params'] = $params;
        if ($status_code == 1) {
            $sql = "select cpa_security.cpa_general.get_news(:p1, :p2) from dual";
            $data['news'] = DB::select($sql, ['p1' => null,
                'p2' => null,
            ]);
        }

        return $data;

    }

    public function downloadAttachment($news_id) {
        $sql = "select cpa_security.cpa_general.get_news_one(:id) from dual";
        $news = DB::selectOne($sql,['id' => $news_id]);

        if($news) {
            if($news->attachment_filename && $news->attachment_content) {
                $fileArr = explode('.', $news->attachment_filename);
                $content = $news->attachment_content;
               // echo $content; die();
                $contentType = $this->getContentType($fileArr[count($fileArr)-1]);
                $filename = $news->attachment_filename;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);
                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'attachment; filename="'.$filename.'"'
                ]);
            }
            die("No Attachment found!!");
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
