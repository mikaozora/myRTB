<?php

namespace App\Http\Controllers;

use App\Events\ChatForum;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use function PHPUnit\Framework\isNull;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
               
        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        $chats = Forum::join('users', 'forums.NIP', '=', 'users.NIP')
            ->select('forums.*', 'users.name', 'users.photo')
            ->orderBy('forums.created_at') 
            ->get();
        $date = Carbon::now()->locale('id_ID')->isoFormat('dddd, D MMMM YYYY');
        $forumcount = Forum::count();
        $lastChat = "";
        if($forumcount === 0){
            $lastChat = "null";
        }else{
            $lastChatt = Forum::orderBy('created_at', 'desc')->first();
            $lastChat = $lastChatt->created_at;
        }

        if($request->is('dashboard/*')){
            return response()->view('dashboard.forum', [
                "title" => "Forum",
                "datenow" => $date,
                "chats" => $chats,
                "lastChat" => $lastChat,
                "photoProfile" => $photoProfile,
                "lastChat" => $lastChat,
                // "NIP" => $NIP
            ]);
        }
        return response()->view('penghuni.forum', [
            "title" => "Forum",
            "datenow" => $date,
            "chats" => $chats,
            "lastChat" => $lastChat,
            "photoProfile" => $photoProfile,
            "lastChat" => $lastChat,
            // "NIP" => $NIP
        ]);
    }

    public function sendMessage(Request $request){
        $NIP = $request->session()->get('NIP');

        $user = User::query()->find($NIP);

        $name = $user->name;
        $photo = $user->photo;

        // $created_at = Carbon::now()->locale('id_ID');
        $created_at = Carbon::now()->setTimezone('Asia/Jakarta');

        $forum = new Forum();
        $forum->NIP = $NIP;

        $test = $request->get('photo');
        $file = $request->file('photo');
        $type = "";
        if(isset($file)){
            // echo "halo";    
            // $file = $request->file('photo');
            $originalName = $file->getClientOriginalName();

            if($file->move("forum", $originalName)){
                $forum->message = $originalName;
                $forum->type = "img";
                $type = "img";
            };
            $message = $originalName;
        }else if($request->input('message')){
            $message = $request->input('message');
            $forum->message = $message;
            $forum->type = "text";
            $type = "text";
        }

        event(new ChatForum($NIP,$name, $message, $created_at, $photo, $type));

        $forum->save();

        return["success"=>true, "foto"=>$file]; 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum)
    {
        //
    }
}
