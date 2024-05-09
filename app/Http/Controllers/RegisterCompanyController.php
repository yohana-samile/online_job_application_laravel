<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use DB;

    class RegisterCompanyController extends Controller {
        // register company
        public function companies(){
            $companies = DB::select("SELECT * FROM users WHERE role_id  = 2 ");
            return view('companies', compact('companies'));
        }
        public function register_new_company(){
            return view('register_new_company');
        }
        public function  store_company(Request $request){
            $validateData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role_id' => ['required', 'integer'],
            ]);

            $register_company = User::create([
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'role_id' => $validateData['role_id'],
                'password' => Hash::make($validateData['password']),
            ]);

            if ($register_company) {
                return redirect()->back()->with('success', 'Company Registered Successfully!');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail To Register Company, Try Again!');
            }
        }
    }
