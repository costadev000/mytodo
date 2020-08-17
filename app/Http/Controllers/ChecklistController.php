<?php
namespace App\Http\Controllers;

use App\Checklist;

class ChecklistController extends BaseController
{
    public function __construct()
    {
        $this->classe = Checklist::class;
    }
    
}
