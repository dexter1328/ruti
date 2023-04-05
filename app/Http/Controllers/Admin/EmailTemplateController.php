<?php

namespace App\Http\Controllers\Admin;

use App\EmailTemplate;
use App\Traits\Permission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailTemplateController extends Controller
{
    use Permission;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        // check for permission
        $this->middleware(function ($request, $next) {
            if(!$this->hasPermission(Auth::user())){
                return redirect('admin/home');
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.email_template.index', [
            'templates' => EmailTemplate::paginate()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EmailTemplate $email_template
     * @return Application|Factory|View
     */
    public function edit(EmailTemplate $email_template)
    {
        return view('admin.email_template.edit', [
            'template' => $email_template
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  EmailTemplate $email_template
     * @return RedirectResponse
     */
    public function update(Request $request, EmailTemplate $email_template)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ]);

        $email_template->update($data);

        return redirect()
            ->route('admin.email_template.index')
            ->with('success', 'Email template updated successfully');
    }

}
