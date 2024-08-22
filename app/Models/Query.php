<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function destination(){
        return $this->belongsTo(Destination::class,'destination_id');
    }

    public function leadSource(){
        return $this->belongsTo(LeadSource::class,'lead_source_id');
    }

    public function team(){
        return $this->belongsTo(Team::class,'team_id');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id','id');
    }

    public function agent(){
        return $this->belongsTo(Agent::class,'agent_id');
    }

    public function corporate(){
        return $this->belongsTo(Corporate::class,'corporate_id');
    }

    public function note(){
        return $this->hasMany(Note::class,'query_id','id');
    }

    public function status(){
        return $this->belongsTo(QueryStatus::class,'query_status_id','id');
    }

    public function package(){
        return $this->hasMany(QueryItinerary::class,'query_id','id');
    }

}
