<?php
/**
 * 流程处理相关.
 *
 * Created by PhpStorm.
 * User: LiLing
 * Date: 2019/1/9
 * Time: 10:18
 */

namespace App\Services;

use App\Models\WorkFlow\WorkFlow;
use App\Models\WorkFlow\WorkFlowLog;
use Auth;

class WorkFlowProcess
{
    /**
     * 流程处理.
     *
     * @param $wf_id
     * @param $action
     * @param $content
     *
     * @throws \Exception
     *
     * @return array
     */
    public function workflowProcess($wf_id, $action, $content): array
    {
        /**
         *    $statuscode   $action
         *          0           -1      删除流程
         *          0            1      发布流程
         *          1            1      部门审核.
         */
        $workflow = WorkFlow::find($wf_id);
        $status = $workflow->statusCode;

        if (-1 === $action) {
            if (0 === $status) { //删除
                $workflow->delete();

                return ['message' => '流程已删除!', 'code' => 201];
            }      // 退回
            $workflow->statusCode = 0;
        } elseif (1 === $action) {   // 办理
            ++$workflow->statusCode;
        } else {    // 异常参数
            return ['message' => '错误参数@', 'code' => 500];
        }

        $workflow->save();
        $workflow_action = $this->getWorkFlowsAction($status, $action);
        WorkFlowLog::create([
            'wf_id' => $wf_id,
            'user_id' => Auth::id(),
            'action' => $workflow_action,
            'content' => $content,
        ]);

        return ['message' => '流程办理成功！', 'code' => 200];
    }

    /**
     * 根据当前流程状态值，输出对应的操作.
     *
     * @param $statusCode
     * @param $action
     *
     * @return string
     */
    protected function getWorkFlowsAction($statusCode, $action): string
    {
        if (-1 === $action) {
            return '退回';
        }
        switch ($statusCode) {
                case 0: return '发起';
                case 1: return '部门审核';
                case 2: return '会计审核';
                case 3: return '财务审核';
                default: return '已完成';
            }
    }
}
