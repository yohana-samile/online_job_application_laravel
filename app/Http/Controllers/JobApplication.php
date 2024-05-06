<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Job;
    use App\Models\Applicant;
    use App\Models\Application;
    use Illuminate\Support\Facades\Validator;
    use DB;
    use Illuminate\Http\File;
    use Illuminate\Support\Facades\Storage;

    class JobApplication extends Controller {
        public function applicant(){
            $applicants = DB::select("SELECT * FROM users, applicants, applicant_profiles WHERE applicants.user_id = users.id AND applicant_profiles.user_id = users.id ");
            return view('users/applicant', [
                'applicants' => $applicants,
            ]);
        }

        public function  store_job(Request $request){
            $validateData = $request->validate([
                'jobTitle' => 'required',
                'jobDiscription' => 'nullable',
                'jobSalary' => 'nullable',
                'datePosted' => 'required',
                'endOfApllication' => 'required',
                'pdf_description' => 'nullable',
            ]);

            $post_job = Job::create([
                'jobTitle' => $validateData['jobTitle'],
                'jobDiscription' => $validateData['jobDiscription'],
                'jobSalary' => $validateData['jobSalary'],
                'datePosted' => $validateData['datePosted'],
                'endOfApllication' => $validateData['endOfApllication'],
                'pdf_description' => $validateData['pdf_description'],
            ]);

            if ($post_job) {
                return redirect()->back()->with('success', 'Job successfully posted!');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail Try Again!');
            }
        }

        public function complite_registration(Request $request){
            $validateData = $request->validate([
                'gender' => 'required',
                'nationality' => 'required',
                'user_id' => 'required',
                'job_seeker_cv' => 'required|mimes:pdf',
            ]);

            $originalFileName = $request->file('job_seeker_cv')->getClientOriginalName();
            $cv_path = $request->file('job_seeker_cv')->storeAs('public/cv/', $originalFileName);
            // $cv_path = $request->file('job_seeker_cv')->storeAs('public/cv');
            $complite_profile = Applicant::create([
                'gender' => $validateData['gender'],
                'nationality' => $validateData['nationality'],
                'user_id' => $validateData['user_id'],
                'cv_uploaded' => true,
                'job_seeker_cv' => $cv_path
            ]);

            if ($complite_profile) {
                return redirect()->back()->with('success', 'Regstration Complite');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail Try Again!');
            }
        }

        public function apply_for_a_job(Request $request){
            $validateData = $request->validate([
                'date_applied' => 'required',
                'job_id' => 'required',
                'user_id' => 'required',
            ]);

            $complite_profile = Application::create([
                'date_applied' => $validateData['date_applied'],
                'job_id' => $validateData['job_id'],
                'user_id' => $validateData['user_id'],
            ]);

            if ($complite_profile) {
                return redirect()->back()->with('success', 'Your Application Sent Successfuly, check for application page in left sidebar');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail Try Again!');
            }
        }
}
