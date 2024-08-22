<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Query;
use App\Models\QueryItinerary;
use App\Models\Reports\AttendanceReport;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function notes()
    {
        $queries = Query::with('client', 'agent', 'corporate', 'leadSource', 'destination', 'note')->get();
        return response()->json($queries, 200);
    }

    public function storeNotes(Request $request)
    {
        Note::create($request->all());
        return response()->json('success', 201);
    }

    public function transactions()
    {
        $transactions = Transaction::with('queries', 'queries.client', 'queries.team')->get();
        return response()->json($transactions, 200);
    }

    public function storeTransactions(Request $request)
    {
        Transaction::create($request->all());
        return response()->json('success', 201);
    }

    public function throwQuery()
    {
        if (request('query') == 'travelreport') {
            // return $filter;
            $data = Query::with('client', 'agent', 'corporate', 'leadSource', 'destination', 'package')->get();
            $packages = [];
            foreach ($data as $item) {
                if (!count($item->package) == 0)
                    $packages[] = $item;
            }
            return response()->json($packages, 200);
        } elseif (request('query') == 'notes') {
            $data = Query::with('client', 'agent', 'corporate', 'leadSource', 'destination', 'note')->get();
            $notes = [];
            foreach ($data as $item) {
                if (!count($item->note) == 0)
                    $notes[] = $item;
            }
            return response()->json($notes, 200);

        } else if (request('query') == 'attandancesreport') {
            $attendence_reports =  AttendanceReport::all();
            return response()->json($attendence_reports, 200);
            
        } elseif(request('query') == 'collectreport'){
            $transactions = Transaction::with('queries', 'queries.client', 'queries.team')->get();
            return response()->json($transactions, 200);
        }

        // return [$request ,request()];

        //     return  view('livewire.ideas-index', ['ideas' => Idea::with('user', 'catagory', 'status')
        //     ->when($this->status && $this->status !== 'All', function ($query) use ($statuses) {
        //     return $query->where('status_id', $statuses->get($this->status));
        //     })
        //     ->when($this->catagory && $this->catagory !== 'All Catagories', function ($query) use ($catagories) {
        //         return $query->where('catagory_id', $catagories->pluck('id','name')->get($this->catagory));
        //     })
        //     ->when($this->filter && $this->filter == "Top Voted", function ($query)  {
        //         return $query->orderByDesc('votes_count');
        //     })
        //     ->when($this->filter && $this->filter === 'My Ideas', function ($query)  {
        //         return $query->where('user_id',auth()->id());
        //     })

        //     ->when($this->filter && $this->filter == "Spam Ideas", function ($query)  {
        //         return $query->where('spam_reports','>',0)->orderByDesc('spam_reports');
        //     })
        //     ->when(strlen($this->search) >= 3, function ($query) {
        //         return $query->where('title', 'like', '%'.$this->search.'%');
        //     })
        //     ->addSelect([
        //         'voted_by_user' => Vote::select('id')
        //             ->where('user_id', auth()->id())
        //             ->whereColumn('idea_id', 'ideas.id')
        //     ])
        //     ->withCount('votes')
        //     ->orderBy('id', 'desc')
        //     ->simplePaginate(Idea::PAGINATION_COUNT),
        //     'catagories' => $catagories
        // ]);        


    }
}
