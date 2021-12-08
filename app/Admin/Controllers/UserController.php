<?php

namespace App\Admin\Controllers;

use App\Models\User;
//use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\User\ImportUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ユーザー';

    /**
     * Set description for following 4 action pages.
     *
     * @var array
     */
    protected $description = [
        'index'  => '一覧',
        'show'   => '詳細',
        'edit'   => '編集',
        'create' => '新規作成',
    ];

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('profile.birth_date', __('Birth date'))->sortable();
        $grid->column('profile.age', __('Age'));

        $genderOptions = [
             0 => '',
             1 => __('Male'),
             2 => __('Female'),
             9 => __('Other'),
        ];
        $grid->column('profile.gender', __('Gender'))
             ->using($genderOptions);

        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->filter(function ($filter) {
            $filter->expand();
            $filter->disableIdFilter();
            $filter->like('name', __('Name'));
            $filter->like('email', __('Email'));
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new ImportUser());
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->display('id', 'ID');
        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->date('profile.birth_date', __('Birth date'))
             ->format('YYYY-MM-DD');

        $genderOptions = [
             0 => '',
             1 => __('Male'),
             2 => __('Female'),
             9 => __('Other'),
        ];
        $form->select('profile.gender', __('Gender'))
             ->options($genderOptions);

        $form->datetime('email_verified_at', __('Email verified at'))
             ->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->ignore('remember_token');

        $form->saving(function (Form $form) {
            $modelPwd = $form->model()->password;

            if (filled($form->password) && Hash::check($form->password, $modelPwd) === false) {
                $form->password = Hash::make($form->password);
            } else {
                $form->password = $modelPwd;
            }
        });

        return $form;
    }
}
