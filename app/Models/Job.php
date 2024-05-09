<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Job extends Model {
        use HasFactory;
        protected $fillable = [
            'jobTitle', 'jobDiscription', 'jobSalary', 'datePosted', 'endOfApllication', 'status', 'pdf_description', 'user_id'
        ];

        // user_id act as company id
        public function user() {
            return $this->belongsTo(User::class);
        }
    }
