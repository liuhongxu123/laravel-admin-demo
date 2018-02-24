<?php

namespace App\Admin\Controllers\World;

use App\Models\World\City;
use App\Models\World\Country;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CountryController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('国家');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Country');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('国家');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Country::class, function (Grid $grid) {

            $grid->Code('国家编码')->sortable();

            $grid->Name('名称')->editable();
            $grid->Continent('陆地')->editable('select', array_combine(Country::$continents, Country::$continents));
            $grid->Region('区域');
            $grid->SurfaceArea('面积');
            $grid->IndepYear('独立年');
            $grid->Population('人口');
            $grid->LifeExpectancy('平均寿命');
            $grid->city()->Name('首都');

            $grid->column('语言');

            $grid->rows(function (Grid\Row $row) {

                $row->column('语言', "<a href='/demo/world/language?CountryCode={$row->Code}'>languages</a>");

            });

            $grid->filter(function ($filter) {
                $filter->like('Name');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Country::class, function (Form $form) {

            $form->display('Code', 'Code');

            $form->text('Name','名称');
            $form->select('Continent','陆地')->options(array_combine(Country::$continents, Country::$continents));
            $form->text('Region','区域');
            $form->decimal('SurfaceArea','面积');
            $form->date('IndepYear','独立年')->format('YYYY');
            $form->text('Population','人口');
            $form->decimal('LifeExpectancy','平均寿命');
            $form->text('GNP','国民生产总值');
            $form->text('GNPOld');
            $form->text('LocalName');
            $form->textarea('GovernmentForm');
            $form->text('HeadOfState');

            $form->select('Capital')->options(function ($id) {

                return City::options($id);

            })->ajax('/demo/api/world/cities');

            $form->text('Code2');
        });
    }
}

