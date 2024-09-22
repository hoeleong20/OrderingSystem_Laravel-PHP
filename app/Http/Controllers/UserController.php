<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use DOMDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function showUsers(Request $request)
    {
        // Connect to the database and retrieve users
        $users = DB::table('users')
        ->select('id','name','usertype', 'email', 'last_login')
        ->get();


        // Create a new DOMDocument instance
        $dom = new DOMDocument('1.0', 'UTF-8');

        // Root element <users>
        $root = $dom->createElement('users');
        $dom->appendChild($root);

        // Loop through each user and add it to the XML
        foreach ($users as $userData) {
            $lastLogin = Carbon::parse($userData->last_login);
            $userData->difference_in_days = floor($lastLogin->diffInDays(Carbon::now()));


            $user = $dom->createElement('user');
            $root->appendChild($user);

            // Create the user-related elements
            $id = $dom->createElement('id', $userData->id);
            $user->appendChild($id);

            $name = $dom->createElement('name', $userData->name);
            $user->appendChild($name);

            $usertype = $dom->createElement('usertype', $userData->usertype);
            $user->appendChild($usertype);

            $email = $dom->createElement('email', $userData->email);
            $user->appendChild($email);

            $lastLogin = $dom->createElement('last_login', $userData->last_login);
            $user->appendChild($lastLogin);

            $dayDifference = $dom->createElement('difference_in_days', $userData->difference_in_days);
            $user->appendChild($dayDifference);
        }


        $userFilter = $request->query('userFilter', 'user');

        $xsl = new DOMDocument;
        $xsl->load(resource_path('views/xslt/userListStyle.xsl'));

        $proc = new \XSLTProcessor;
        $proc->importStylesheet($xsl);

        $proc->setParameter('', 'userFilter', $userFilter);

        $xmlString = $proc->transformtoXML($dom);

        $xmlString = str_replace(['routePlaceHolder','csrfPlaceHolder'],[route('admin.deleteUser'), csrf_token()],
        $xmlString);


        // Pass the XML string to the Blade view
        return view('admin.adminUserList', ['transformedXML' => $xmlString]);
    }


    public function deleteUser(Request $request)
        {
            // Get the user's email from the request
            $email = $request->input('email');
        
            // Find the user by email and delete
            DB::table('users')->where('email', $email)->delete();
        
            // Redirect back to the users list after deletion
            return redirect()->route('admin.userList')->with('success', 'User deleted successfully.');
        }
}
