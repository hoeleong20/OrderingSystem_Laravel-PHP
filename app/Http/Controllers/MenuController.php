<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Remark;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of all menus.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$menus = Menu::all();       //problem!!!
        return view('menus.menu'/*, compact('menus')*/);
    }

    /**
     * Show the form for creating a new menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$remarks = Remark::all();
        return view('menus.create'/*, compact('remarks')*/);
    }

    /**
     * Store a newly created menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = Menu::create([
            'menu_code' => $request->menu_code,
            'name' => $request->name,
            'desc' => $request->desc,
            'price' => $request->price,
        ]);

        // Attach remarks to the menu
        $menu->remarks()->sync($request->remarks);

        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    /**
     * Display the specified menu.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified menu.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $remarks = Remark::all();
        return view('menus.edit', compact('menu', 'remarks'));
    }

    /**
     * Update the specified menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $menu->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'price' => $request->price,
        ]);

        // Update remarks associated with the menu
        $menu->remarks()->sync($request->remarks);

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified menu from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully.');
    }
}
