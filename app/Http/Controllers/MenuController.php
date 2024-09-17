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
        return view('menus.index'/*, compact('menus')*/);
    }

    /**
     * Display the specified menu.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        $allMenus = Menu::all();
        return view('menus.adminMenu', ['allMenus' => $allMenus]);
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
        // Validate all field required
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'price' => 'required|decimal:0,2'
        ]);

        // Auto generate menu_code with format (A001-A999)
        $menuCode = $this->generateMenuCode();

        // Add menu_code to validatedData
        $validatedData['menu_code'] = $menuCode;

        // Store to database
        $newMenu = Menu::create($validatedData);

        return redirect()->route('menus.index')->with('success', 'Menu created successfully!');
    }

    private function generateMenuCode()
    {
        $lastMenu = Menu::latest()->first();

        if (!$lastMenu) {
            // If no previous menu exists, start with A001
            return 'A001';
        }

        // Extract the numeric part of the last menu code
        $lastNumber = substr($lastMenu->menu_code, 1);

        // Increment the number
        $newNumber = str_pad(intval($lastNumber) + 1, 3, '0', STR_PAD_LEFT);

        // Combine the prefix and the new number
        return 'A' . $newNumber;
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
