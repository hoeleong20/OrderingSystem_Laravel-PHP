<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Remark;
use App\Decorators\DecoratorFactory;
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
        // Retrieve only active menus
        $menus = Menu::where('status', 'active')->get();
        $remarks = DecoratorFactory::getAvailableRemarks();

        // Ensure each menu has a 'remarkable' field set
        $menus->each(function ($menu) {
            $menu->remarkable = $menu->remarkable ?? []; // Default to empty array if null
        });

        // Return the index view with the active menus
        return view('menus.index', compact('menus', 'remarks'));
    }

    /**
     * Display the specified menu.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        $menus = Menu::all();
        $remarks = DecoratorFactory::getAvailableRemarks(); // Assuming this function exists

        $menus->each(function ($menu) {
            $menu->remarkable = $menu->remarkable ?? []; // Default to empty array if null
        });

        return view('menus.adminMenu', compact('menus', 'remarks'));
    }

    /**
     * Show the form for creating a new menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'price' => 'required|numeric',
            'remarks' => 'nullable|array', // Ensure remarks are an array
        ]);

        // Convert selected remarks to JSON for storage
        $remarkable = $request->input('remarks', []); // Defaults to an empty array if no remarks selected

        $menu = Menu::create([
            'menu_code' => $this->generateMenuCode(),
            'name' => $validatedData['name'],
            'desc' => $validatedData['desc'],
            'price' => $validatedData['price'],
            'status' => 'active',
            'remarkable' => $remarkable, // Store array of selected remarkable tags
        ]);

        return redirect()->route('menus.adminMenu')->with('success', 'Menu created successfully!');
    }

    /**
     * Generate the next available menu_code.
     *
     * @return string
     */
    private function generateMenuCode()
    {
        // Find the menu with the highest numeric part of the menu_code
        $lastMenu = Menu::where('menu_code', 'like', 'A%')
            ->orderByRaw('CAST(SUBSTRING(menu_code, 2) AS UNSIGNED) DESC')
            ->first();

        if (!$lastMenu) {
            // If no previous menu exists, start with A001
            return 'A001';
        }

        // Extract the numeric part of the last menu code
        $lastNumber = substr($lastMenu->menu_code, 1);

        // Increment the number
        $newNumber = str_pad(intval($lastNumber) + 1, 3, '0', STR_PAD_LEFT);

        // Combine the prefix 'A' and the new number
        return 'A' . $newNumber;
    }

    /**
     * Display the specified menu.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu) {}

    /**
     * Show the form for editing the specified menu.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu) {}

    /**
     * Update the specified menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menuCode)
    {
        // Validate input, including the status field
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|string|in:active,soldOut,archived', // Ensure status is a valid value
            'remarks' => 'nullable|array',
        ]);

        // Find the menu by its menu_code
        $menu = Menu::where('menu_code', $menuCode)->firstOrFail();

        // Update the menu
        $menu->update([
            'name' => $validatedData['name'],
            'desc' => $validatedData['desc'],
            'price' => $validatedData['price'],
            'status' => $validatedData['status'], // Ensure status is being updated
            'remarkable' => $request->input('remarks', []), // Default to empty array if no remarks
        ]);

        return redirect()->route('menus.adminMenu')->with('success', 'Menu updated successfully!');
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
