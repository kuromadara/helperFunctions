/*
 * Route
 * example - 127.0.0.1:8000/emp-login/20220801/1575
 */



 Route::get('emp-login/{date}/{code}', function ($date, $code) {
    // dd($code);
    if ($date !== date("Ymd")) {
        abort(404);
    }
    $user     = \App\Models\User::where("username", $code)->first();
    $employee = $user->employee;
    $employee->load(["designation", "department"]);
    auth()->login($user);
    setEmployeeSession(request(), $employee);
    return redirect("/");
});


/**
 * The employee session is to be set
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Employee  $employee
 * @return mixed
 */
function setEmployeeSession($request, $employee = null)
{
    if ($employee) {
        $request->session()->put('access_user', $employee->toArray());
        $request->session()->put('auth_user_obj', $employee);
    }
    return $request;
}
