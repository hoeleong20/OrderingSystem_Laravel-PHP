<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Decorators\DecoratorFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use DOMXPath;
use XSLTProcessor;

// Author : Lim Jia Qing

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

        // Ensure each menu has a 'remarkable' field set
        $menus->each(function ($menu) {
            $menu->remarkable = $menu->remarkable ?? []; // Default to empty array if null
        });

        // Return the index view with the active menus
        return view('menus.index', compact('menus'));
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
     * Show the detail of a specific menu.
     * This will display the selected menu along with its available remarks.
     *
     * @param string $menu_code
     * @return \Illuminate\Http\Response
     */
    public function show($menu_code)
    {
        $menu = Menu::where('menu_code', $menu_code)->firstOrFail();

        // Get the remarkable field from the Menu model
        $remarks = $menu->remarkable; // This should be an array of remarks (e.g., 'No Veg', 'No Spicy', etc.)

        return view('menus.menuDetail', compact('menu', 'remarks'));
    }

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

    // Function to send sold-out menus to the supplier's Python service
    public function sendSoldOutMenus()
    {
        $soldOutMenus = Menu::where('status', 'soldOut')->pluck('name')->toArray();

        // Log the sold-out menus
        Log::info('Sending Sold Out Menus:', ['menus' => $soldOutMenus]);

        try {
            $response = Http::post('http://127.0.0.1:5000/check_availability', [
                'menu_names' => $soldOutMenus,
            ]);

            // Log the entire response
            Log::info('Response from Python Service:', ['response_body' => $response->body()]);

            $availableMenus = json_decode($response->getBody(), true);

            // Access the correct key ('available_menus')
            if (isset($availableMenus['available_menus'])) {
                $this->generateOrUpdateXML($availableMenus);  // Now process the available menus
            } else {
                Log::error('Available menus not found in the response.', ['response' => $availableMenus]);
                return redirect()->route('menus.adminMenu')->with('error', 'No available menus found.');
            }

            return redirect()->route('menus.adminMenu')->with('success', 'Menus processed successfully.');
        } catch (\Exception $e) {
            Log::error('Error sending sold out menus:', ['error' => $e->getMessage()]);
            return redirect()->route('menus.adminMenu')->with('error', 'An error occurred while processing menus.');
        }
    }

    // Function to generate or update the XML file with available menus
    private function generateOrUpdateXML($availableMenus)
    {
        // Define the file path where the XML will be stored
        $filePath = storage_path('app/available_menus.xml');

        // Load existing XML file if it exists, otherwise create a new XML structure
        $xml = file_exists($filePath) ? simplexml_load_file($filePath) : new \SimpleXMLElement('<menus/>');

        // Loop through available menus and append them to the XML
        foreach ($availableMenus['available_menus'] as $menuName) {
            // Escape special characters in menu names to avoid XPath issues
            $escapedMenuName = htmlspecialchars($menuName, ENT_QUOTES, 'UTF-8');

            // Check if the menu already exists in the XML to avoid duplicate entries
            $existingMenu = $xml->xpath("//menu[name[text()='{$escapedMenuName}']]");

            // If the menu doesn't exist, add it
            if (empty($existingMenu)) {
                $menuElement = $xml->addChild('menu');
                $menuElement->addChild('name', $escapedMenuName);
            }
        }

        // Save or update the XML file
        $xml->asXML($filePath);

        // Log to verify where the file is being saved
        Log::info('XML file saved at: ' . $filePath);
    }

    public function activatePage()
    {
        // Path to the XML and XSLT files
        $xmlFilePath = storage_path('app/available_menus.xml');
        $xslFilePath = storage_path('app/menu_transform.xsl');

        // Check if the XML or XSLT files exist
        if (!file_exists($xmlFilePath) || !file_exists($xslFilePath)) {
            return redirect()->back()->with('error', 'XML or XSLT file not found.');
        }

        // Load the XML file
        $xml = new \DOMDocument();
        $xml->load($xmlFilePath);

        // Load the XSLT file
        $xsl = new \DOMDocument();
        $xsl->load($xslFilePath);

        // Create a new XSLT processor
        $processor = new \XSLTProcessor();
        $processor->importStylesheet($xsl);  // Attach the XSLT stylesheet

        // Transform the XML into HTML using the XSLT processor
        $transformedHtml = $processor->transformToXml($xml);

        // Pass the transformed HTML to the Blade view
        return view('menus.activateMenu'/*, compact('transformedHtml')*/);
    }

    public function activateMenus()
    {
        $xmlPath = storage_path('app/available_menus.xml');

        // Load XML file
        if (file_exists($xmlPath)) {
            $xml = new DOMDocument;
            $xml->load($xmlPath);

            // Create an XPath object to query XML
            $xpath = new DOMXPath($xml);

            // Select all menu names from the XML file
            $menus = $xpath->query("//menu/name");

            foreach ($menus as $menu) {
                $menuName = $menu->nodeValue;

                // Update the menu status to 'active' in the database
                \App\Models\Menu::where('name', $menuName)->update(['status' => 'active']);
            }

            // Delete the XML file after activation
            if (file_exists($xmlPath)) {
                unlink($xmlPath);
            }

            // Redirect back with a success message
            return redirect()->route('menus.adminMenu')->with('success', 'Menus activated successfully, and XML file deleted.');
        } else {
            return redirect()->route('menus.adminMenu')->with('error', 'XML file not found.');
        }
    }
}
