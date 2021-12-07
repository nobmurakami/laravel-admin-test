<?php

namespace App\Admin\Actions\User;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class ImportUser extends Action
{
    public $name = 'CSVインポート';

    protected $selector = '.import-user';

    public function handle(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new UsersImport, $file);

        return $this->response()->success('インポートが完了しました！')->refresh();
    }

    public function form()
    {
        $this->file('file', 'ファイルを選択してください');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-info import-user"><i class="fa fa-upload"></i>&nbsp;&nbsp;$this->name</a>
HTML;
    }
}
