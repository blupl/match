<?php namespace Blupl\Match\Http\Handlers;

use Orchestra\Foundation\Match\MenuHandler;
use Orchestra\Contracts\Authorization\Authorization;

class FranchiseMenuHandler extends MenuHandler
{
    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id'    => 'match',
        'title' => 'Match',
        'link'  => 'orchestra::venue',
        'icon'  => null,
    ];

    /**
     * Get position.
     *
     * @return string
     */
    public function getPositionAttribute()
    {
        return $this->handler->has('extensions') ? '^:extensions' : '>:home';
    }

    /**
     * Check whether the menu should be displayed.
     *
     * @param  \Orchestra\Contracts\Authorization\Authorization  $acl
     *
     * @return bool
     */
    public function authorize(Authorization $acl)
    {
        return ($acl->can('manage roles') || $acl->can('manage acl'));
    }
}