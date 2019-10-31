<?php

namespace App\Services;

use App\Models\Config\ImportConfig;

class ImportColumn
{
    /**
     * 读取导入的字段信息，以及字段对应关系.
     *
     * @param int $role_id 上传数据分表类型
     *
     * @return \Illuminate\Support\Collection
     */
    public function getImportConfig($role_id)
    {
        $excel_db_columns = ImportConfig::where('role_id', $role_id)
                            ->pluck('excel_column', 'db_column');

        return $excel_db_columns;
    }
}
