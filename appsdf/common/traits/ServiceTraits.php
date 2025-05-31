<?php

namespace app\common\traits;

use app\common\enum\CodeEnum;
use app\common\exception\ApiException;
use app\common\types\QueryParams;
use Exception;
use think\Db;

trait ServiceTraits
{
    /**
     * 分页查询
     *
     * @param array $args
     * @return array
     */
    public function getPage(QueryParams $queryParams): array
    {
        $pageData = $this->dao->getPage($queryParams);
        method_exists($this, 'handlePage') && $this->handlePage($pageData);
        return $pageData;
    }

    /**
     * 列表查询
     *
     * @param array $args
     * @return array
     */

    public function getList(QueryParams $queryParams): array
    {
        $listData = $this->dao->getList($queryParams);
        method_exists($this, 'handleList') && $this->handleList($listData);
        return $listData;
    }

    /**
     * 详情查询
     *
     * @param integer $id
     * @return array|null
     */
    public function find(int $id)
    {
        $detail = $this->dao->findById($id);
        method_exists($this, 'handleDetail') && $this->handleDetail($detail);
        return $detail;
    }

    public function create(array $data)
    {
        if (isset($data['id'])) unset($data['id']);
        Db::startTrans();
        try {
            method_exists($this, 'handleCreate') && $this->handleCreate($data);
            $result = $this->dao->create($data);
            if (!$result || empty($result['id'])) {
                Db::rollback();
                throw new ApiException(CodeEnum::OPERATION_FAILED, "创建失败");
            }
            method_exists($this, 'handleCreateAfter') && $this->handleCreateAfter($result);
            Db::commit();
            return $result;
        } catch (Exception $th) {
            Db::rollback();
            throw new ApiException(CodeEnum::OPERATION_FAILED, $th->getMessage());
        }
    }

    public function update(int $id, array $data)
    {
        Db::startTrans();
        try {
            method_exists($this, 'handleUpdate') && $this->handleUpdate($data);
            $result = $this->dao->update($id, $data);
            if (!$result) {
                Db::rollback();
                throw new ApiException(CodeEnum::OPERATION_FAILED, "更新失败");
            }
            method_exists($this, 'handleUpdateAfter') && $this->handleUpdateAfter($data);
            Db::commit();
            return $result;
        } catch (Exception $th) {
            Db::rollback();
            throw new ApiException(CodeEnum::OPERATION_FAILED, $th->getMessage());
        }
    }
    public function changeStatus(int $id, int $status)
    {
        Db::startTrans();
        try {
            method_exists($this, 'handleChangeStatus') && $this->handleChangeStatus($id);
            $result = $this->dao->changeStatus($id, $status);
            if (!$result) {
                Db::rollback();
                throw new ApiException(CodeEnum::OPERATION_FAILED, "改变状态失败");
            }
            method_exists($this, 'handleChangeStatusAfter') && $this->handleChangeStatusAfter($id);
            Db::commit();
            return $result;
        } catch (Exception $th) {
            Db::rollback();
            throw new ApiException(CodeEnum::OPERATION_FAILED, $th->getMessage());
        }
    }

    /**
     * 删除数据
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        Db::startTrans();
        try {
            method_exists($this, 'handleDelete') && $this->handleDelete($id);
            $result = $this->dao->delete($id);
            if (!$result) {
                Db::rollback();
                throw new ApiException(CodeEnum::OPERATION_FAILED, "删除失败");
            }
            method_exists($this, 'handleDeleteAfter') && $this->handleDeleteAfter($id);
            Db::commit();
            return $result;
        } catch (Exception $th) {
            Db::rollback();
            throw new ApiException(CodeEnum::OPERATION_FAILED, $th->getMessage());
        }
    }
}
