<?php

namespace Modules\FeeManagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use \App\Models\User;
use \Modules\Setups\Entities\Department;
use \Modules\Setups\Entities\Course;
use \Modules\Setups\Entities\UserCourse;
use \Modules\Setups\Entities\UserDepartment;
use DB, DataTables;

class UserCoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        request()->merge([
            'anyPermissionArray' => [
                'user-courses', 'update-user-courses'
            ],
            'allPermissionArray' => []
        ]);
        $this->middleware('check_permission');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (request()->ajax() && request()->has('draw')) {
            return DataTables::of(User::role('Student'))
                ->addIndexColumn()
                
                ->addColumn('student', function($user){
                    return $user->first_name.' '.$user->last_name;
                })
                ->filterColumn('student', function($query, $keyword){
                    return $query->where(function($query) use($keyword){
                        return $query->where('first_name', 'LIKE', '%'.$keyword.'%')
                                     ->orWhere('last_name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orderColumn('student', function ($query, $order) {
                    return $query->orderBy('first_name', $order);
                })

                ->addColumn('department', function($user){
                    return $user->departments->pluck('department.name')->implode(', ');
                })
                ->filterColumn('department', function($query, $keyword){
                    return $query->whereHas('departments.department', function($query) use($keyword){
                        return $query->where('name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orderColumn('department', function ($query, $order) {
                    return pleaseSortMe($query, $order, UserDepartment::select('departments.name')
                        ->join('departments', 'departments.id', '=', 'user_departments.department_id')
                        ->whereColumn('user_departments.', 'users.id')
                        ->take(1)
                    );
                })

                ->addColumn('courses', function($user){
                    return $user->courses->pluck('course.name')->implode(', ');
                })
                ->filterColumn('courses', function($query, $keyword){
                    return $query->whereHas('courses.course', function($query) use($keyword){
                        return $query->where('code', 'LIKE', '%'.$keyword.'%')
                                     ->orWhere('name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orderColumn('courses', function ($query, $order) {
                    return pleaseSortMe($query, $order, UserCourse::select('courses.name')
                        ->join('courses', 'courses.id', '=', 'user_courses.course_id')
                        ->whereColumn('user_courses.', 'users.id')
                        ->take(1)
                    );
                })

                ->addColumn('options', function($user){
                    return view('feemanagement::courses.button', [
                        'user' => $user
                    ]);
                })
                ->rawColumns(['options'])
                ->toJson();
        }
        return view('feemanagement::courses.index', [
            'headerColumns' => headerColumns('user-courses')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('feemanagement::courses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('feemanagement::courses.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'user' => User::findOrFail($id),
            'courses' => Course::orderBy('code', 'asc')->get(),
            'departments' => Department::orderBy('code', 'asc')->get(),
        ];
        return view('feemanagement::courses.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'courses' => 'required',
            'courses.*' => 'required',
            'department_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            UserDepartment::updateOrCreate([
                'user_id' => $user->id,
                'department_id' => $request->department_id
            ], [
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            foreach($request->courses as $key => $course_id){
                UserCourse::updateOrCreate([
                    'user_id' => $user->id,
                    'course_id' => $course_id
                ], [
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            UserCourse::where('user_id', $user->id)->whereNotIn('course_id', $request->courses)->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "User Courses Has been updated."
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        
    }
}
