<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class InstallerController extends Controller
{

	public function __construct()
	{
		$this->middleware('installer');
	}

    public function show()
    {
    	return view('installer.index');
    }

    public function update(Request $request)
    {
    	$validator = Validator::make($request->all(), [
		    'host' => 'required|max:255',
            'user' => 'required|max:255',
            'password' => 'required|max:255',
            'database' => 'required|max:255',

		    'main_login' => 'required|max:255',
            'main_name' => 'required|max:255',
            'main_email' => 'required|email|max:255',
            'main_password' => 'required|max:255|confirmed',
            'main_phone_number' => 'digits_between:7,11',

            'mail_driver' => 'required|max:255',
            'mail_host' => 'required|max:255',
            'mail_port' => 'required|digits_between:4,20',
            'mail_username' => 'required|max:255',
            'mail_password' => 'required|max:255',
    	]);

        if ($validator->fails()) {
            return back()->withInput();
        }


        $env_update = $this->changeEnv([
            'DB_DATABASE'   => $request->database,
            'DB_USERNAME'   => $request->user,
            'DB_PASSWORD'   => $request->password,
            'DB_HOST'       => $request->host,

			'MAIL_DRIVER' => $request->mail_driver,
			'MAIL_HOST' => $request->mail_host,
			'MAIL_PORT' => $request->mail_port,
			'MAIL_USERNAME' => $request->mail_username,
			'MAIL_PASSWORD' => $request->mail_password,
			'MAIL_ENCRYPTION' => $request->mail_encryption,

        ]);

      	Artisan::call('config:cache');
		Artisan::call('migrate');


		sleep(15);

        $employee = new Employee;

        $employee->username = $request->main_login;
        $employee->name = $request->main_name;
        $employee->email = $request->main_email;
        $employee->password = Hash::make($request->main_password);
        $employee->phone_number = $request->main_phone_number;
        $employee->level = 7;

        $employee->save();



		return redirect('/');
    }

	protected function changeEnv($data = array()){
        if(count($data) > 0){

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);
            
            return true;
        } else {
            return false;
        }
	}
}
