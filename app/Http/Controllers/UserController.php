<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('pages.admin.users.index');
    }

    /**
     * Return data for datatable
     *
     * @return Response
     */
    public function datatables(Request $request)
    {
        //Query the Users
        $users = User::query();

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('avatar', function ($row) {
                return '
                     <div>
                         <img class="rounded-circle avatar-xs" src="'. URL::asset($row->avatar). '"
                          alt="'.$row->name.'">
                     </div>
                ';
            })
//            ->addColumn('roles', function ($row) {
//                $roles = '';
//                foreach ($row->roles()->pluck('name') as $role) {
//                    $roles .= '<span style=" font-weight: bold" class="badge badge-light ">' . $role . '</span>';
//                }
//                return $roles;
//            })
            ->addColumn('status', function ($row){
                if($row->is_active == '1'){
                    return '<span class="badge badge-pill bg-success">Ενεργός</span>';
                }else{
                    return '<span class="badge badge-pill bg-danger">Ανενεργός</span> <span>από '.$row->deactivated_at->format('Y-m-d H:i:s').'</span>';
                }
            })

            ->addColumn('action2', function ($row) {

                $buttons  = $this->editButtonToHtml(route('users.edit',$row->id));
                $buttons .= $this->showButtonToHtml(route('users.show',$row->id));
                $buttons .= $this->activeInactiveButtonToHtml($row,route('users.activate',$row->id));







                return $buttons;
            })
            ->rawColumns(['roles', 'action2','status', 'avatar'])
            ->make(true);

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        Log::info('entered');

        return view('pages.admin.users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        if (request()->has('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
        }

        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => Hash::make($request['password']),
            'dob'      => date('Y-m-d', strtotime($request['dob'])),
            'avatar'   => "/images/" . $avatarName,
        ]);

        return redirect()->route('users.index')->with('success','User has been saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(User $user)
    {
       return view('pages.admin.users.show')->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return view('pages.admin.users.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $avatarName = '';
        if (request()->has('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
        }

        $user = $user->update([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => Hash::make($request['password']),
            'dob'      => date('Y-m-d', strtotime($request['dob'])),
            'avatar'   => $avatarName != '' ? "/images/" . $avatarName : $user->avatar,
        ]);

        return redirect()->route('users.index')->with('success','User has been saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->with('success','User has been deleted');
    }

    /**
     * Toggle user's is_active attribute.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function toggle_is_active(User $user): RedirectResponse
    {
        $user->is_active = !$user->is_active;
        $user->update();

        if($user->is_active){
            $user->deactivated_at = null;
            $user->update();
            return redirect()->route('users.index')
                ->with('success', 'Ο χρήστης ενεργοποιήθηκε!');
        }else{
            $user->deactivated_at = now();
            $user->update();
            return redirect()->route('users.index')
                ->with('success', 'Ο χρήστης απενεργοποιήθηκε!');
        }
    }
}
