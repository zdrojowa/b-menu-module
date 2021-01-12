<?php

namespace Selene\Modules\MenuModule\Http\Controller;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Selene\Modules\DashboardModule\ZdrojowaTable;
use Selene\Modules\MenuModule\Http\Requests\MenuStoreRequest;
use Selene\Modules\MenuModule\Http\Requests\MenuUpdateRequest;
use Selene\Modules\MenuModule\Models\Menu;

/**
 * Class MenuModuleController
 * @package Selene\Modules\MenuModule\Http\Controller
 */
class MenuModuleController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('MenuModule::list.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('MenuModule::add.index');
    }

    /**
     * @param MenuStoreRequest $request
     * @param Menu $menu
     *
     * @return RedirectResponse
     */
    public function store(MenuStoreRequest $request, Menu $menu)
    {
        $request->merge(['structure' => json_decode($request->structure)]);
        $menu->create($request->all());
        $request->session()->flash('alert-success', 'Menu zostało pomyślnie utworzone');

        return redirect()->route('MenuModule::menu.create');
    }

    /**
     * @param Menu $menu
     *
     * @return Factory|View
     */
    public function edit(Menu $menu)
    {
        return view('MenuModule::edit.index', ['menu' => $menu]);
    }

    /**
     * @param MenuUpdateRequest $request
     * @param Menu $menu
     *
     * @return RedirectResponse
     */
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $request->merge(['structure' => json_decode($request->structure)]);
        $menu->update($request->all());
        $request->session()->flash('alert-success', 'Menu zostało pomyślnie zaktualizowane');

        return redirect()->route('MenuModule::menu.edit', ['menu' => $menu]);
    }

    /**
     * @param Menu $menu
     *
     * @throws Exception
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function ajax(Request $request)
    {
        return ZdrojowaTable::response(Menu::query(), $request);
    }

}
