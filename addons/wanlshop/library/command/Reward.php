<?php

namespace addons\wanlshop\library\command;

//use addons\wanlshop\library\Oper;
//use addons\wanlshop\model\commission\Level as LevelModel;
//use addons\wanlshop\model\commission\Order as OrderModel;
//use addons\wanlshop\model\commission\Reward as RewardModel;
//use addons\wanlshop\library\commission\Agent;
//use addons\wanlshop\library\commission\Log;
use app\admin\model\wanlshop\Order as OrderModel;
use app\admin\model\wanlshop\OrderGoods as OrderGoods;
use app\admin\model\wanlshop\Reward as RewardModel;
use app\common\model\User as UserModel;
use app\admin\model\wanlshop\Auth as Authshop;


/**
 * 结算奖金
 */
class Reward
{
    // 分销订单业绩状态 table: commission_order, field: commission_order_status
    const COMMISSION_ORDER_STATUS_NO = 0;  // 不计入
    const COMMISSION_ORDER_STATUS_YES = 1;  // 已计入
    const COMMISSION_ORDER_STATUS_BACK = -1;  // 已退回
    const COMMISSION_ORDER_STATUS_CANCEL = -2;  // 已取消
    // 分销订单佣金处理状态 table: commission_order, field: commission_reward_status
    // 分销佣金状态  table: commission_reward, field: status
    const COMMISSION_REWARD_STATUS_WAITING = 0;  // 未结算、待入账
    const COMMISSION_REWARD_STATUS_ACCOUNTED = 1;  // 已结算、已入账
    const COMMISSION_REWARD_STATUS_BACK = -1;  // 已退回
    const COMMISSION_REWARD_STATUS_CANCEL = -2;  // 已取消
    protected $oper = null;
    public $commissionLevel = 3;    // 分销层级

    /**
     * 执行奖金计划,直接派发佣金
     * 
     * @param string    $event                     分佣的事件
     * @param mixed     $commissionOrder|$commissionOrderId           分销订单 
     * @param array     $oper                      操作人
     */
    public function __construct($oper = null)
    {
//        if($oper) {
//            $this->oper = $oper;
//        }else {
//            $this->oper = Oper::set();
//        }
    }


    /**
     * 执行分销计划,递归往上分佣
     *
     * @param object    $commissionOrder           分销订单
     * @param object    $currentAgent              当前待分佣的分销商 默认自购开始算
     * @param int       $currentCommissionLevel    当前分佣层级 直推（自购）开始算
     */
    public function runCommissionPlan($commissionOrder, $currentAgent = null, $currentCommissionLevel = 1)
    {
//        if ($this->commissionLevel < $currentCommissionLevel) {
//            return true;
//        }
//        // 当前层级为1且分销订单是内购订单 则当前层级为购买人自己
//        if ($currentCommissionLevel === 1) {
//            $currentAgent = new Agent($commissionOrder->agent_id);
//        }

        if ($currentAgent) {
            // 防止重复添加佣金
            $commissionReward = RewardModel::get([
                'commission_order_id' => $commissionOrder->id,
            ]);
            if (!$commissionReward) {


               $orderdetail= OrderGoods::where(['order_id' => $commissionOrder['id']])->find();
                $config = get_addon_config('wanlshop');

                $currentCommissionLevelRule = $config['retail'];
                $currentCommissionLevelRule['level']=$currentCommissionLevel;
                if ($currentCommissionLevelRule) {
                    $commission =$this-> caculateGoodsCommission($currentCommissionLevelRule, $orderdetail['wholesale_price'], $orderdetail['number']);
                    if ($commission > 0) {
                        $commissionRewardParams = [
                            'order_id' => $commissionOrder->id,
                            'order_item_id' => $commissionOrder->wholesale_id,
                            'buyer_id' => $commissionOrder->user_id,      // 购买人
                            'commission_order_id' =>1,   // 分销订单ID
                            'agent_id' => $currentAgent,           // 待分佣分销商ID
                            'type' => 'money',                               // 奖金类型
                            'commission' => $commission,                     // 佣金
                            'status' => 0,                              // 佣金状态
                            'original_commission' => $commission,            // 原始佣金
                            'commission_level' => $currentCommissionLevel,   // 分佣层级
                            'commission_rules' => json_encode($currentCommissionLevelRule),   // 分佣层级
                            'agent_level' => 1              // 分佣时分销商等级
                        ];
                        $commissionReward = RewardModel::create($commissionRewardParams);

                    }
                }
            }

            // 递归执行下一次
            $currentCommissionLevel++;
            // 超出分销层级
            if ($this->commissionLevel < $currentCommissionLevel) {
                return true;
            }

            $parentAgentId =$current_agent=Authshop::where(['user_id' => $currentAgent])->field('invitation')->find();

            // 执行下一级分销任务
            if ($parentAgentId) {

                $this->runCommissionPlan($commissionOrder, $parentAgentId['invitation'], $currentCommissionLevel);
            } else {
                return true;
            }
        }
    }




    public function runCommisisonRewardlist($event, $commissionOrder)
    {

        $commissionOrder = OrderModel::where(['state' => 4])->select();

        // 未找到分销订单
        if (!$commissionOrder) {
            return false;
        }

        foreach ($commissionOrder as $key=>$val) {

            // 已经操作过了
            if ($val['commission_reward_status'] !== 0) {
                return false;
            }

//        $commissionEvent = $commissionOrder['commission_event'];
//
//        // 不满足分佣事件
//        if ($commissionEvent !== $event && $event !== 'admin') {
//            return false;
//        }



            // 防止重复添加佣金
            $commissionRewards = RewardModel::all([
                'commission_order_id' => $val['id'],
                'status' => 0,
            ]);
            $current_agent=Authshop::where(['id' => $val['shop_id']])->field('invitation')->find();

            $this->runCommissionPlan($val,$current_agent['invitation'],1);


            // 添加分销商收益、余额添加钱包、更新分销佣金结算状态、提醒分销商到账
            if ($commissionRewards) {
                foreach ($commissionRewards as $commissionReward) {
                    $this->runCommisisonReward($event, $commissionReward);
                }
                return true;
            }
            return false;

            }
    }


    /**
     * 计算对应规则分销佣金
     *
     * @param int $commissionRule      分销规则
     * @param int $amount              结算价格
     * @param int $goodsNum            购买数量
     */
    public function caculateGoodsCommission($commissionRule, $amount, $goodsNum = 1)
    {
        $commission = 0;
        if (isset($commissionRule['child'.$commissionRule['level']]) && $commissionRule['child'.$commissionRule['level']]> 0) {
            $commission = round($amount * $commissionRule['child'.$commissionRule['level']] * 0.01, 2);
        }
            $commission = $commission * $goodsNum;

        return number_format($commission, 2, '.', '');
    }


    /**
     * 执行奖金计划,直接派发佣金
     * 
     * @param mixed     $commisisonReward|$commisisonRewardId           奖金记录 
     * @param array     $oper                      操作人
     */
    public function runCommisisonReward($event, $commissionReward)
    {
        if (is_numeric($commissionReward)) {
            $commissionReward = RewardModel::get($commissionReward);
        }

        // 未找到奖金记录
        if (!$commissionReward) {
            return false;
        }

        if ($commissionReward->status == self::COMMISSION_REWARD_STATUS_WAITING) {
            $rewardAgent = new Agent($commissionReward->agent_id);
            if ($rewardAgent && $rewardAgent->isAgentAvaliable()) {
                $rewardAgent->agent->setInc('total_income', $commissionReward->commission);
                UserModel::money($commissionReward->commission, $commissionReward->agent_id,  'commission_income', $commissionReward->id, '', $commissionReward);
                $commissionReward->status = self::COMMISSION_REWARD_STATUS_ACCOUNTED;
                $commissionReward->save();
                Log::write($rewardAgent->user->id, 'reward', [
                    'action' => $event,
                    'reward' => $commissionReward
                ]);
                return true;
            }
        }
        return false;
    }



}
