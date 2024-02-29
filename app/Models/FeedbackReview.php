<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackReview extends Model
{
    use HasFactory;

    public function by_user()
    {
        return $this->BelongsTo(User::class, 'by_user_id');
    }

    public function for_user()
    {
        return $this->BelongsTo(User::class, 'user_id');
    }
}
