<?php namespace Blupl\Match\Http\Controllers\Admin;

use Blupl\Match\Model\Match;
use Illuminate\Support\Facades\Input;
use Blupl\Match\Processor\Match as MatchProcessor;
use Orchestra\Foundation\Http\Controllers\AdminController;

class HomeController extends AdminController
{

    public function __construct(MatchProcessor $processor)
    {
        $this->processor = $processor;

        parent::__construct();
    }

    protected function setupFilters()
    {
        $this->beforeFilter('control.csrf', ['only' => 'delete']);
    }

    /**
     * Get landing page.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->processor->index($this);
    }

    public function indexSucceed(array $data)
    {
        set_meta('title', 'blupl/match::title.match');

        return view('blupl/match::index', $data);
    }


    /**
     * Show a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function show($match)
    {
        return $this->edit($match);
    }

    /**
     * Create a new role.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->processor->create($this);
    }

    /**
     * Edit the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
     public function edit($match)
     {
        return $this->processor->edit($this, $match);
     }

    /**
     * Create the role.
     *
     * @return mixed
     */
     public function store()
     {
        return $this->processor->store($this, Input::all());
     }

    /**
     * Update the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function update($match)
    {
        return $this->processor->update($this, Input::all(), $match);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed;
     */
    public function delete($match)
    {
        return $this->destroy($match);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function destroy($match)
    {
        return $this->processor->destroy($this, $match);
    }


    /**
     * Response when create role page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function createSucceed(array $data)
    {
        set_meta('title', trans('blupl/match::title.match.create'));

        return view('blupl/match::edit', $data);
    }

    /**
     * Response when edit role page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function editSucceed(array $data)
    {
        set_meta('title', trans('blupl/match::title.match.update'));

        return view('blupl/match::edit', $data);
    }

    /**
     * Response when storing role failed on validation.
     *
     * @param  object  $validation
     *
     * @return mixed
     */
     public function storeValidationFailed($validation)
     {
        return $this->redirectWithErrors(handles('orchestra::match/reporter/create'), $validation);
     }

    /**
     * Response when storing role failed.
     *
     * @param  array  $error
     *
     * @return mixed
     */
     public function storeFailed(array $error)
     {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(handles('orchestra::match/reporter'), $message);
     }

    /**
     * Response when storing user succeed.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
     public function storeSucceed(match $match)
     {
        $message = trans('blupl/match::response.match.create', [
            'name' => $match->getAttribute('name')
        ]);

            return $this->redirectWithMessage(handles('orchestra::match/reporter'), $message);
     }

    /**
     * Response when updating role failed on validation.
     *
     * @param  object  $validation
     * @param  int     $id
     *
     * @return mixed
     */
     public function updateValidationFailed($validation, $id)
     {
        return $this->redirectWithErrors(handles("orchestra::match/reporter/{$id}/edit"), $validation);
     }

    /**
     * Response when updating role failed.
     *
     * @param  array  $errors
     *
     * @return mixed
     */
     public function updateFailed(array $errors)
     {
        $message = trans('orchestra/foundation::response.db-failed', $errors);

        return $this->redirectWithMessage(handles('orchestra::match/reporter'), $message);
     }

    /**
     * Response when updating role succeed.
     */
    public function updateSucceed(match $match)
    {
        $message = trans('orchestra/control::response.roles.update', [
            'name' => $match->getAttribute('name')
        ]);

        return $this->redirectWithMessage(handles('orchestra::match'), $message);
    }

    /**
     * Response when deleting role failed.
     *
     * @param  array  $error
     *
     * @return mixed
     */
    public function destroyFailed(array $error)
    {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(handles('orchestra::match'), $message);
    }

    /**
     * Response when updating role succeed.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
    public function destroySucceed(match $match)
    {
        $message = trans('orchestra/control::response.roles.delete', [
            'name' => $match->getAttribute('name')
        ]);

   ;     return $this->redirectWithMessage(handles('orchestra::match'), $message);
    }

    /**
     * Response when user verification failed.
     *
     * @return mixed
     */
    public function userVerificationFailed()
    {
        return $this->suspend(500);
    }

}