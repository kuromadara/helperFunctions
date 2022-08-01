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
