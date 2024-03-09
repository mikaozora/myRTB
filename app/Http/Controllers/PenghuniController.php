<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use FFI\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\fileExists;

class PenghuniController extends Controller
{
    public function index(Request $request)
    {
        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        return response()->view('dashboard.penghuni', [
            "title" => "User",
            "photoProfile" => $photoProfile
        ]);
    }

    public function search(Request $request)
    {

        if ($request->ajax()) {
            $query = $request->get('query');
            if ($query != '') {
                $users = User::query()->where('name', 'like', '%' . $query . '%')
                    ->orWhere('NIP', 'like', '%' . $query . '%')
                    ->paginate(8);
            } else {
                $users = User::query()->paginate(8);
            }
            return view('dashboard.penghuni.pagination', compact('users'));
        }
    }

    public function create(Request $request)
    {
        $nip = $request->input('NIP');
        $name = $request->input('name');
        $password = explode(" ", $name);
        $password = bcrypt($password[0]);
        $class = $request->input('class');
        $gender = $request->input('gender');
        $roomNum = $request->input('room_number');
        $phoneNum = $request->input('phone_number');
        $file = $request->file('photo');
        $photo = Carbon::now()->getTimestamp() . $file->getClientOriginalName();
        $path = env('UPLOAD_DIR');
        if ($file->move($path, $photo)) {
            try {
                $user = new User();
                $user->NIP = $nip;
                $user->name = $name;
                $user->password = $password;
                $user->class = $class;
                $user->room_number = $roomNum;
                $user->phone_number = $phoneNum;
                $user->photo = $photo;
                $user->gender = $gender;

                $room = User::query()->where('room_number', '=', $roomNum)->get();
                $isFull = $room->count();
                try{
                    if ($isFull >= 2){
                        return redirect()->action([PenghuniController::class, 'index'])->with([
                            "message" => "Room is full!",
                            "status" => "error"
                        ]);
                    }
                } catch (Exception $e) {
                    
                }

                $user->save();

                return redirect()->action([PenghuniController::class, 'index'])->with(
                    "message",
                    "Successfully added user data!"
                );
            } catch (QueryException $err) {
                if ($err->errorInfo[1] == 1062) {
                    return redirect()->action([PenghuniController::class, 'index'])->with([
                        "message" => "NIP has registered!",
                        "status" => "error"
                    ]);
                } else {
                    return redirect()->action([PenghuniController::class, 'index'])->with([
                        "message" => "Failed to add user data",
                        "status" => "error"
                    ]);
                }
            }
        }
    }

    public function update(Request $request, string $nip)
    {
        $name = $request->input('name');
        $class = $request->input('class');
        $gender = $request->input('gender');
        $roomNum = $request->input('room_number');
        $phoneNum = $request->input('phone_number');
        $file = $request->file('photo');

        $user = User::query()->find($nip);

        $room = User::query()->where('room_number', '=', $roomNum)->get();
        $isFull = $room->count();
        try{
            if ($isFull >= 2){
                return redirect()->action([PenghuniController::class, 'index'])->with([
                    "message" => "Room is full!",
                    "status" => "error"
                ]);
            }
        } catch (Exception $e) {
                    
        }

        if (isset($file)) {
            $img = "data/" . $user->photo;
            if (fileExists($img)) {
                @unlink($img);
            }
            $photo = Carbon::now()->getTimestamp() . $file->getClientOriginalName();
            $path = env('UPLOAD_DIR');
            if ($file->move($path, $photo)) {
                $user->fill([
                    "name" => $name,
                    "class" => $class,
                    "gender" => $gender,
                    "room_number" => $roomNum,
                    "phone_number" => $phoneNum,
                    "photo" => $photo
                ]);
                $user->save();
                return redirect()->action([PenghuniController::class, 'index'])->with(
                    "message",
                    "Successfully edited user data"
                );
            }
        }
        $user->fill([
            "name" => $name,
            "class" => $class,
            "gender" => $gender,
            "room_number" => $roomNum,
            "phone_number" => $phoneNum
        ]);
        $user->save();
        return redirect()->action([PenghuniController::class, 'index'])->with(
            "message",
            "Successfully edited user data"
        );
    }
    public function destroy(string $nip)
    {
        $user = User::query()->find($nip);
        $path = "data/";
        $img = $path . $user->photo;
        if (fileExists($img)) {
            @unlink($img);
        }
        $user->delete();
        return redirect()->action([PenghuniController::class, 'index'])->with(
            "message",
            "Successfully deleted user data"
        );
    }
}
