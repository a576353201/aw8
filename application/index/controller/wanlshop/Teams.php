<?php
// 2020年2月17日21:41:44
namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;
use app\common\model\User;
use think\Db;

/**
 * 附件管理
 *
 * @icon fa fa-circle-o
 * @remark 主要用於管理上传到又拍雲的数据或上传至本服务的上传数据
 */
class Teams extends Wanlshop
{

    /**
     * @var \app\common\model\Reward
     */
    protected $model = null;
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    public function _initialize()

    {

        parent::_initialize();

        $this->model = model('Reward');


    }

    

    /**

     * 查看

     */

    public function index()

    {


        //设置过濾方法

        $this->request->filter(['strip_tags']);

        if ($this->request->isAjax()) {

            $mimetypeQuery = [];

            $filter = $this->request->request('filter');

            $filterArr = (array)json_decode($filter, true);

            if (isset($filterArr['mimetype']) && preg_match("/[]\,|\*]/", $filterArr['mimetype'])) {

                $this->request->get(['filter' => json_encode(array_diff_key($filterArr, ['mimetype' => '']))]);

                $mimetypeQuery = function ($query) use ($filterArr) {

                    $mimetypeArr = explode(',', $filterArr['mimetype']);

                    foreach ($mimetypeArr as $index => $item) {

                        if (stripos($item, "/*") !== false) {

                            $query->whereOr('mimetype', 'like', str_replace("/*", "/", $item) . '%');

                        } else {

                            $query->whereOr('mimetype', 'like', '%' . $item . '%');

                        }

                    }

                };

            }

    

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();



            $total = $this->model

                ->where('1=1')

//                ->where($where)
//
//                ->order($sort, $order)

                ->count();

    
//
//            $list = $this->model
//                ->select();

            $join = [

                ['fa_wanlshop_commission_reward r','o.id=r.order_id'],
                ['fa_wanlshop_order_goods g','o.id=g.order_id'],


            ];
            $list =  Db::table('fa_wanlshop_order')->alias('o')->join($join)->limit($offset, $limit)->select();

            $cdnurl = preg_replace("/\/(\w+)\.php$/i", '', $this->request->root());

            foreach ($list as $k => &$v) {

               $v['summoney'] =$v['number']*$v['price'];
                $userinfo= User::where('id', $v['user_id'])->field('nickname')->find();
                $v['nickname'] = $userinfo->nickname;

            }

            unset($v);

            $result = array("total" => $total, "rows" => $list);

    

            return json($result);

        }

        return $this->view->fetch();

    }

    

    /**

     * 选择附件

     */

    public function select()

    {

        if ($this->request->isAjax()) {

            return $this->index();

        }

        return $this->view->fetch();

    }

    

    /**

     * 刪除附件

     * @param array $ids

     */

    public function del($ids = "")

    {

        if ($ids) {

            \think\Hook::add('upload_delete', function ($params) {

                $attachmentFile = ROOT_PATH . '/public' . $params['url'];

                if (is_file($attachmentFile)) {

                    @unlink($attachmentFile);

                }

            });

            $attachmentlist = $this->model->where('id', 'in', $ids)->select();

            foreach ($attachmentlist as $attachment) {

                \think\Hook::listen("upload_delete", $attachment);

                $attachment->delete();

            }

            $this->success();

        }

        $this->error(__('Parameter %s can not be empty', 'ids'));

    }
}
