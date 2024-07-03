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
    use Illuminate\Support\Facades\Auth;

    class JobApplication extends Controller {
        public function applicant(){
            $user = Auth::user()->id;
            $applicants = DB::select("SELECT * FROM users, applicants WHERE applicants.user_id = users.id and applicants.user_id = '$user' ");
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
                'pdf_description' => 'nullable|mimes:pdf',
            ]);

            $pdf_path = null;
            if ($request->hasFile('pdf_description')) {
                $originalFileName = $request->file('pdf_description')->getClientOriginalName();
                $pdf_path = 'pdf_descriptions/' . $originalFileName;
                $request->file('pdf_description')->move(public_path('pdf_descriptions'), $originalFileName); // Store the file in the public folder
            }

            $company = Auth::user()->id;
            $post_job = Job::create([
                'jobTitle' => $validateData['jobTitle'],
                'jobDiscription' => $validateData['jobDiscription'],
                'jobSalary' => $validateData['jobSalary'],
                'datePosted' => $validateData['datePosted'],
                'endOfApllication' => $validateData['endOfApllication'],
                'pdf_description' => $pdf_path,
                'user_id' => $company,
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
            $cv_path = 'cv/' . $originalFileName;
            $request->file('job_seeker_cv')->move(public_path('cv'), $originalFileName); // Store the file in the public folder

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

        public function jobApplication(){
            $applications = DB::select("SELECT users.name, applications.date_applied, applications.id, applications.status as application_status, applications.interview_date, applicants.job_seeker_cv, jobs.jobTitle FROM applications, users, applicants, jobs WHERE applicants.user_id = users.id AND applications.user_id = users.id AND applications.job_id = jobs.id ");
            return view('jobApplication', compact('applications'));
        }

        // deny_this_application
        public function deny_this_application(Request $request, $id){
            $update = Application::findOrFail($id);
            $update->update(['status' => 'deny']);
            if ($update) {
                return redirect()->back()->with('success', 'Application Denied');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail Try Again!');
            }
        }

        // invite_for_interview
        public function invite_for_interview(Request $request, $id){
            $update = Application::findOrFail($id);
            $interview_date = $request->input('interview_date');
            $update->update(['status' => 'accepted', 'interview_date' => $interview_date]);
            if ($update) {
                return redirect()->back()->with('success', 'Application Accepted, Interview Date Set');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail Try Again!');
            }
        }

        // interview_invitation
        public function interview_invitation($id){
            $application_id = Application::findOrFail($id);
            return view('interview_invitation', compact('application_id'));
        }

        // store_interview_date
        public function store_interview_date(Request $request){
            $data = $request->validate([
                'id' => 'required',
                'interview_date' => 'required',
                'status' => 'required',
            ]);
            $update = Application::findOrFail($data['id']);
            $update->update(['status' => 'accepted', 'interview_date' => $data['interview_date']]);
            if ($update) {
                return redirect()->back()->with('success', 'Application Accepted, Interview Date Set');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail Try Again!');
            }
        }

        // jobs
        public function jobPosted(){
            $jobs = Job::get();
            return view('jobPosted', compact('jobs'));
        }

        // extend_job_application
        public function extend_job_application($id){
            $job_id = Job::findOrFail($id);
            return view('extend_job_application', compact('job_id'));
        }

        // store_extended_job_application
        public function store_extended_job_application(Request $request){
            $data = $request->validate([
                'id' => 'required',
                'endOfApllication' => 'required',
            ]);
            $update = Job::findOrFail($data['id']);
            $update->update(['status' => 'extended', 'endOfApllication' => $data['endOfApllication']]);
            if ($update) {
                return redirect()->back()->with('success', 'Application Extended Successfully');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail Try Again!');
            }
        }

        // close_job_application
        public function close_job_application(Request $request, $id){
            $update = Job::findOrFail($id);
            $update->update(['status' => 'closed']);
            if ($update) {
                return redirect()->back()->with('success', 'Application Closed Successfully');
            }
            else{
                return redirect()->back()->withErrors('error', 'Fail Try Again!');
            }
        }

        // my_application
        public function my_application(){
            $user = Auth::user()->id;
            $my_applications = DB::select("SELECT applications.date_applied, applications.id, applications.status as application_status, applications.interview_date, applicants.job_seeker_cv, jobs.jobTitle FROM
                applications, users, applicants, jobs WHERE
                applicants.user_id = users.id AND
                applications.user_id = users.id AND
                applications.job_id = jobs.id AND
                applications.user_id = '$user'
            ");
            return view('my_application', compact('my_applications'));
        }
    }
