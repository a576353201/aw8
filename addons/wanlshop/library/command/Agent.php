<?php

namespace addons\wanlshop\library\command;

use app\admin\model\wanlshop\Config;
use app\admin\model\wanlshop\Reward as RewardModel;
use app\common\model\User as UserModel;

/**
 * 分销商业务
 */
class Agent
{

    public $user;     // 商城用户
    public $agent;    // 分销商用户
    public $_config;    // 分销设置
    public $parentAgentId;

    // 分销商状态 AGENT_STATUS
    const AGENT_STATUS_NORMAL = 'normal';       // 正常 
    const AGENT_STATUS_PENDING = 'pending';     // 审核中 不分佣、不打款、没有团队信息
    const AGENT_STATUS_FREEZE = 'freeze';       // 冻结 正常记录分佣、不打款，记录业绩和团队信息 冻结解除后立即打款
    const AGENT_STATUS_FORBIDDEN = 'forbidden'; // 禁用 不分佣、不记录业绩和团队信息
    const AGENT_STATUS_NEEDINFO = 'needinfo';   // 需要完善表单资料 临时状态
    const AGENT_STATUS_REJECT = 'reject';       // 审核驳回, 重新修改   临时状态
    const AGENT_STATUS_NULL = NULL;             // 未满足成为分销商条件

    // 完善资料状态 INFO_STATUS
    const INFO_STATUS_REJECT = -1;  // 资料驳回
    const INFO_STATUS_NONE = 0;  // 未完善资料
    const INFO_STATUS_COMPLETED = 1;     // 已完善
    const INFO_STATUS_NULL = null;     // 无需完善资料

    // 分销商升级锁 UPGRADE_LOCK
    const UPGRADE_LOCK_OPEN = 1;  // 禁止分销商升级
    const UPGRADE_LOCK_CLOSE = 0;  // 允许分销商升级

    /**
     * 构造函数
     * 
     * @param int      $user_id     用户ID
     */
    public function __construct($user_id)
    {
        $this->user = UserModel::where('id', $user_id)->find();
        $this->agent = UserModel::where('id', $user_id)->find();
        $this->_config = new Config();
    }


}
