<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Application extends Model {
        use HasFactory;
        protected $fillable = [
            'job_id', 'user_id', 'date_applied', 'status', 'interview_date'
        ];
        public function jobs(){
            return $this->belongsTo(Job::class);
        }
        public function users(){
            return $this->belongsTo(User::class);
        }
    }
