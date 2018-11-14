<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/11/5
 * Time: 11:01
 */

namespace App\Http\Controllers\System;


use App\Components\Common;
use App\Http\Controllers\AuthController;
use App\Rule;
use App\Components\Code;

class RuleController extends AuthController
{
    public function getTreeList()
    {
        $list = Rule::getInstance()->getList($this->request->all());
        $tree = Common::generateRuleTree($list, 0);

        return $this->sendJson([
            'list' => $tree,
            'auth' => [
                'canAdd'    => $this->canAdd(),
                'canEdit'   => $this->canEdit(),
                'canDelete' => $this->canDelete()
            ]
        ]);
    }

    public function getAllRoutes()
    {
        $routes = app()->routes->getRoutes();
        $data = [];
        foreach ($routes as $value) {
            if(!$value->uri || $value->uri === '/') {
                continue;
            }
            $data[] = $value->uri;
        }

        return $this->sendJson($data);
    }

    /**
     * 保存权限
     */
    public function save()
    {
        if(!$this->request->input('id')) {
            $rows = Rule::getInstance()->getRows(['name' => $this->request->input('name')]);
            if(!empty($rows)) {
                return $this->sendError(Code::RULE_EXIST);
            }
        }

        Rule::getInstance()->saveData($this->request->all());

        return $this->sendJson();
    }

    /**
     * 获取详情
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $rows = Rule::getInstance()->getRows(['id' => $this->request->input('id')]);
        return $this->sendJson($rows[0] ?? []);
    }

    /**
     * 获取路径详情
     */
    public function getPathInfo()
    {
        $path = $this->request->input('path');
        $list = Rule::getInstance()->getList();

        $newList = $curRow = [];
        foreach ($list as $row) {
            $newList[$row['id']] = $row;
            if($path === $row['name']) {
                $curRow = $row;
            }
        }

        $data[] = $curRow;
        while (isset($newList[$curRow['pid']])) {
            array_push($data, $newList[$curRow['pid']]);
            $curRow = $newList[$curRow['pid']];
        }

        $data = array_reverse($data);

        return $this->sendJson($data);
    }

}