<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController as BaseAdminController;
use Encore\Admin\Layout\Content;

abstract class AdminController extends BaseAdminController
{
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
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? __('admin.list'))
            ->breadcrumb(
                ['text' => $this->title()]
            )
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['show'] ?? __('admin.show'))
            ->breadcrumb(
                ['text' => $this->title(), 'url' => 'users'],
                ['text' => $id],
            )
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? __('admin.edit'))
            ->breadcrumb(
                ['text' => $this->title(), 'url' => 'users'],
                ['text' => $id],
                ['text' => $this->description['edit'] ?? __('admin.edit')],
            )
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? __('admin.create'))
            ->breadcrumb(
                ['text' => $this->title(), 'url' => 'users'],
                ['text' => $this->description['create'] ?? __('admin.create')],
            )
            ->body($this->form());
    }
}
