<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
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
                $buttons = '';
//                $buttons .= '<button
//                                id="updateUser"
//                                data-id="' . $row->id . '"
//                                data-toggle="modal"
//                                data-toggle="tooltip" data-placement="top" title="Επεξεργασία"
//                                data-original-title="Επεξεργασία"
//                                class="btn btn-outline-info btn-sm  mr-2 updateUserModal">
//                                <i class="fe fe-edit "><!-- --></i></button>&nbsp;';
//
                $buttons .= '<a href="' . route('users.edit', $row->id) . '"
                              class="btn btn-sm light btn-info"
                              data-toggle="tooltip"
                              data-placement="top"
                              title="Επεξεργασία">
                                Επεξεργασία
                           </a>';
//
//
                if($row->is_active == 0){
                    $buttons .= '   <form style="display: inline-block"
                                   action="' . route('users.activate', $row->id) . '"
                                   method="POST">
                                   <input type="hidden" name="_token" value="' . csrf_token() . '">
                                   <button type="submit"
                                           class="btn btn-sm light btn-success"
                                           onclick="return confirm(\'Είστε σίγουρος(η) για την ενεργοποίηση του χρήστη?\')">

                                        Ενεργοποίηση
                                   </button>
                                 </form> &nbsp;';
                }else{
                    $buttons .= '   <form style="display: inline-block"
                                   action="' . route('users.activate', $row->id) . '"
                                   method="POST">
                                   <input type="hidden" name="_token" value="' . csrf_token() . '">
                                   <button type="submit"

                                            class="btn btn-sm light btn-danger"
                                           onclick="return confirm(\'Είστε σίγουρος(η) για τη απενεργοποίηση του χρήστη?\')">

                                        Απενεργοποίηση
                                   </button>
                                 </form> &nbsp;';
                }





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

        return view('pages.admin.users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(User $user)
    {
        return view('pages.admin.users.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Toggle user's is_active attribute.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function toggle_is_active(User $user)
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
