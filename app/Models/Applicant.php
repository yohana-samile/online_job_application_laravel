<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Applicant extends Model {
        use HasFactory;
        protected $fillable = [
            'user_id', 'gender', 'nationality', 'cv_uploaded', 'job_seeker_cv'
        ];
        public function user(){
            return $this->hasOne(User::class);
        }
    }
